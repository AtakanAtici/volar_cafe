@extends('layouts.admin')

@section('title', 'Ürünler')

@section('content')
<h4 class="fw-bold py-3 mb-4">Tüm Ürünler</h4>

<!-- Ürün Ekle Butonu -->
<div class="mb-4">
    <a href="{{ route('products.create') }}" class="btn btn-success">+ Ürün Ekle</a>
</div>

<!-- Bayi Filtresi -->
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('products.all') }}" method="GET">
            <div class="row">
                <div class="col-md-4">
                    <label for="dealer_id" class="form-label">Bayi Seç</label>
                    <select name="dealer_id" id="dealer_id" class="form-control">
                        <option value="">Tüm Bayiler</option>
                        @foreach ($dealers as $dealer)
                            <option value="{{ $dealer->id }}" {{ request('dealer_id') == $dealer->id ? 'selected' : '' }}>
                                {{ $dealer->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 align-self-end">
                    <button type="submit" class="btn btn-primary">Filtrele</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Ürünler Tablosu -->
<div class="card">
    <div class="card-header">
        <h5>Ürünler Listesi</h5>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover text-center">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Ürün Adı</th>
                    <th>Bayi</th>
                    <th>Fiyat</th>
                    <th>Açıklama</th>
                    <th>Kapak Fotoğrafı</th>
                    <th>Diğer Fotoğraflar</th>
                    <th>Oluşturulma Tarihi</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->dealer->name ?? 'Bayi Yok' }}</td>
                        <td>{{ number_format($product->price, 2) }} ₺</td>
                        <td>{{ $product->description }}</td>
                        <td>
                            @if($product->getFirstMediaUrl('cover'))
                                <img src="{{ $product->getFirstMediaUrl('cover') }}" alt="Kapak Fotoğrafı" class="img-thumbnail"
                                    width="100">
                            @else
                                <span>Kapak Fotoğrafı Yok</span>
                            @endif
                        </td>

                        </td>
                        <td>
                            @foreach ($product->getMedia('images') as $media)
                                <img src="{{ $media->getUrl() }}" alt="Fotoğraf" class="img-thumbnail" width="50">
                            @endforeach
                        </td>
                        <td>{{ $product->created_at->format('d-m-Y H:i') }}</td>
                        <td>
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Güncelle</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Hiç ürün bulunamadı.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection