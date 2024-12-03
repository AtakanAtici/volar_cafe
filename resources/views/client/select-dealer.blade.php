@extends('layouts.client')

@section('title', 'Şube Seçimi')

@section('content')
<h4 class="fw-bold py-3 mb-4 text-center">Sipariş Vermek için Şube Seçin</h4>

<div class="row justify-content-center">
    @foreach ($dealers as $dealer)
        <div class="col-lg-6 col-md-6 col-12 d-flex align-items-stretch mb-4">
            <div class="card h-100 text-center w-100" style="cursor: pointer;"
                onclick="window.location='{{ route('client.products', $dealer->id) }}'">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    @if($dealer->id == 1)
                        <div class="app-brand justify-content-center">
                            <img src='/img/logo1.png' class="img-fluid" />
                        </div>
                    @else
                        <div class="app-brand justify-content-center">
                            <img src='/img/logo2.jpeg' class="img-fluid" />
                        </div>
                    @endif

                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
