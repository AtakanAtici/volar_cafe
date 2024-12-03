@extends('layouts.client')

@section('title', 'Ürünler - ' . $dealer->name)

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
<h4 class="fw-bold py-3 mb-4 text-center">{{ $dealer->name }} Şubesine Ait Ürünler</h4>

<!-- Oturum Mesajı -->
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Kapat"></button>
    </div>
@endif

<div class="container">
    <div class="row justify-content-center">
        @foreach ($products as $product)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card product-card shadow-sm">
                    <div class="card-header bg-dark text-white text-center">
                        <h5 class="m-0">{{ $product->name }}</h5>
                    </div>
                    <div class="image-container p-3 text-center">
                        @if($product->getFirstMediaUrl('cover'))
                            <img src="{{ $product->getFirstMediaUrl('cover') }}" class="rounded img-fluid"
                                alt="{{ $product->name }}" style="max-height: 200px; object-fit: cover;">
                        @else
                            @if($dealer->id == 1)
                                <img src="/img/logo1.png" class="rounded img-fluid" alt="Varsayılan Resim"
                                    style="max-height: 200px; object-fit: cover;">
                            @else
                            <img src="/img/logo2.jpeg" class="rounded img-fluid" alt="Varsayılan Resim"
                            style="max-height: 200px; object-fit: cover;">
                            @endif

                        @endif
                    </div>
                    <div class="card-body text-center">
                        <p class="card-text text-muted">{{ number_format($product->price, 2) }} ₺</p>
                        <button class="btn btn-outline-success w-100" data-bs-toggle="modal" data-bs-target="#orderModal"
                            onclick="setProductData({{ $product->id }}, '{{ $product->name }}')">
                            <i class="fa-solid fa-cart-plus"></i> &nbsp; Sipariş Ver
                        </button>
                    </div>
                    <div class="card-footer bg-light text-muted text-center small">
                        {{ $product->description}}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Sipariş Modal -->
<div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderModalLabel">Sipariş Ver</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
            </div>
            <form action="{{ route('order.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="product_id" name="product_id">
                    <p id="product_name" class="fw-bold"></p>
                    
                    <!-- Adet -->
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Adet</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" min="1" value="1" required>
                    </div>

                    <!-- İçecek Seçimi -->
                    <div class="mb-3">
                        <label for="drink" class="form-label">İçecek Seçimi</label>
                        <select class="form-select select2" id="drink" name="drink" required>
                            <option value="0" selected>İçecek istemiyorum...</option>
                            @foreach ($drinks as $drink )
                                <option value="{{$drink->id}}">{{$drink->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Açıklama -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Açıklama</label>
                        <textarea class="form-control" id="description" name="description" rows="3"
                            placeholder="Sipariş için bir açıklama ekleyebilirsiniz"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-primary">Siparişi Onayla</button>
                </div>
            </form>
        </div>
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