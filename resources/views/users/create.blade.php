@extends('layouts.admin')

@section('title', 'Ürün Ekle')

@section('content')
<h4 class="fw-bold py-3 mb-4">Ürün Ekle</h4>

<div class="card">
    <div class="card-body">
        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Ürün Adı -->
            <div class="mb-3">
                <label for="name" class="form-label">Personel Adı</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Telefon</label>
                <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone') }}" required>
                @error('phone')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <!-- Bayiler -->
            <div class="mb-3">
                <label for="dealer_ids" class="form-label">Bayi</label>
                <select id="dealer_ids" name="dealer_id" class="form-control select2" required>
                    @foreach ($dealers as $dealer)
                        <option value="{{ $dealer->id }}">
                            {{ $dealer->name }}
                        </option>
                    @endforeach
                </select>
                @error('dealer_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3 form-password-toggle">
                <label class="form-label" for="password">Şifre</label>
                <div class="input-group input-group-merge">
                    <input type="password" id="password" class="form-control" name="password"
                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                        aria-describedby="password" />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Kaydet</button>
        </form>
    </div>
</div>
@endsection

@section('js')
<link rel="stylesheet" href="../../assets/vendor/libs/select2/select2.css" />

<script src="../../assets/vendor/libs/jquery/jquery.js"></script>
<script src="../../assets/vendor/libs/popper/popper.js"></script>
<script src="../../assets/vendor/js/bootstrap.js"></script>
<script src="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

<script src="../../assets/vendor/libs/select2/select2.js"></script>

<!-- Select2 için Başlatma -->
<script>
    $(document).ready(function () {
        $('#dealer_ids').select2({
            placeholder: "Bayileri Seçin",
            allowClear: true
        });
    });
</script>
@endsection