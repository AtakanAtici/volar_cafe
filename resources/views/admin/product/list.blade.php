@extends('layouts.admin')

@section('title', 'Bayi Ürünleri')

@section('content')
    <h4 class="fw-bold py-3 mb-4">{{ $dealer->name }} Bayisine Ait Ürünler</h4>

    <div class="card">
        <div class="card-header">
            <h5>Ürünler Listesi</h5>
        </div>
        <div class="card-body">
            @if ($dealer->products->count() > 0)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Ürün Adı</th>
                            <th>Fiyat</th>
                            <th>Açıklama</th>
                            <th>Kapak Fotoğrafı</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dealer->products as $product)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ number_format($product->price, 2) }} ₺</td>
                                <td>{{ $product->description }}</td>
                                <td>
                                    <img src="{{ asset($product->cover_image) }}" alt="Kapak Fotoğrafı" width="100">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-center">Bu bayiye ait ürün bulunamadı.</p>
            @endif
        </div>
    </div>
@endsection
