@extends('layouts.admin')

@section('title', 'Ürün Ekle')

@section('content')
<h4 class="fw-bold py-3 mb-4">Ürün Ekle</h4>

<div class="card">
    <div class="card-body">
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Ürün Adı -->
            <div class="mb-3">
                <label for="name" class="form-label">Ürün Adı</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Fiyat -->
            <div class="mb-3">
                <label for="price" class="form-label">Fiyat</label>
                <input type="number" step="0.01" id="price" name="price" class="form-control" value="{{ old('price') }}" required>
                @error('price')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Kapak Fotoğrafı -->
            <div class="mb-3">
                <label for="cover_image" class="form-label">Kapak Fotoğrafı</label>
                <input type="file" id="cover_image" name="cover_image" class="form-control" required>
                @error('cover_image')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Açıklama -->
            <div class="mb-3">
                <label for="description" class="form-label">Açıklama</label>
                <textarea id="description" name="description" class="form-control">{{ old('description') }}</textarea>
                @error('description')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Bayiler -->
            <div class="mb-3">
                <label for="dealer_ids" class="form-label">Bayiler</label>
                <select id="dealer_ids" name="dealer_ids[]" class="form-control select2" multiple required>
                    @foreach ($dealers as $dealer)
                        <option value="{{ $dealer->id }}" {{ in_array($dealer->id, old('dealer_ids', [])) ? 'selected' : '' }}>
                            {{ $dealer->name }}
                        </option>
                    @endforeach
                </select>
                @error('dealer_ids')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Çoklu Fotoğraf Yükleme -->
            <div class="mb-3">
                <label for="photos" class="form-label">Ek Fotoğraflar</label>
                <input type="file" id="photos" name="photos[]" class="form-control" multiple>
                @error('photos')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
                @error('photos.*')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
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
        $(document).ready(function() {
            $('#dealer_ids').select2({
                placeholder: "Bayileri Seçin",
                allowClear: true
            });
        });
    </script>
@endsection
