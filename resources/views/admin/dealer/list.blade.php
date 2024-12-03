@extends('layouts.admin')

@section('title', 'Bayiler Listesi')

@section('content')
    <h4 class="fw-bold py-3 mb-4">Bayiler</h4>

    <div class="card">
        <div class="card-header">
            <h5>Bayiler Listesi</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Bayi Adı</th>
                        <th>Oluşturulma Tarihi</th>
                        <th>Ürünleri Göster</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dealers as $dealer)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $dealer->name }}</td>
                            <td>{{ $dealer->created_at->format('d-m-Y H:i') }}</td>
                            <td>
                                <a href="{{ route('dealer.products', $dealer->id) }}" class="btn btn-primary btn-sm">
                                    Ürünleri Göster
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Hiç bayi bulunamadı.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
