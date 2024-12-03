@extends('layouts.client')

@section('title', 'Siparişlerim ')

@section('css')
<style>
    .product-card {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
    }

    .product-card .card-body {
        flex-grow: 1;
    }

    .product-card .image-container img {
        max-height: 200px;
        object-fit: cover;
    }

    .product-card .card-footer {
        font-size: 0.9rem;
    }
</style>
<link rel="stylesheet" href="../../assets/vendor/libs/select2/select2.css" />

    <script src="../../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../../assets/vendor/libs/popper/popper.js"></script>
    <script src="../../assets/vendor/js/bootstrap.js"></script>
    <script src="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="../../assets/vendor/libs/select2/select2.js"></script>


@endsection

@section('content')
<h4 class="fw-bold py-3 mb-4 text-center">Siparişlerim</h4>

<!-- Oturum Mesajı -->
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Kapat"></button>
    </div>
@endif

<div class="">
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th style="width:100%">Ürün Adı</th>
                    <th>Resim</th>
                    <th>Fiyat</th>
                    <th>Açıklama</th>
                    <th>Not</th>
                    <th>Sipariş Tarihi</th>
                    <th>Durum</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td class="text-nowrap">{{ $product->product->name }}</td>
                        <td class="text-center">
                            @if($product->product->getFirstMediaUrl('cover'))
                                <img src="{{ $product->product->getFirstMediaUrl('cover') }}" alt="{{ $product->name }}" style="max-height: 50px; object-fit: cover;">
                            @else
                                @if($product->product->dealer_id == 1)
                                    <img src="/img/logo1.png" alt="Varsayılan Resim" style="max-height: 50px; object-fit: cover;">
                                @else
                                    <img src="/img/logo2.jpeg" alt="Varsayılan Resim" style="max-height: 50px; object-fit: cover;">
                                @endif
                            @endif
                        </td>
                        <td class="text-nowrap">{{ number_format($product->price, 2) }} ₺</td>
                        <td>{{ $product->product->description }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ Carbon\Carbon::parse($product->created_at)->format('d.m.Y h:i') }}</td>
                        <td>{{ $product->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection


@section('js')
<script>
    function setProductData(productId, productName) {
        document.getElementById('product_id').value = productId;
        document.getElementById('product_name').innerText = productName;
    }


    setTimeout(function () {
        let alert = document.querySelector('.alert');
        if (alert) {
            alert.style.transition = "opacity 0.5s ease";
            alert.style.opacity = 0;
            setTimeout(() => alert.remove(), 500);
        }
    }, 3000); // 3 saniye sonra mesaj kaybolur
</script>
@endsection