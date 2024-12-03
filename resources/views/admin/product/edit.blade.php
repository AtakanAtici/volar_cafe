@extends('layouts.admin')

@section('title', 'Ürün Güncelle')

@section('content')
<h4 class="fw-bold py-3 mb-4">Ürün Güncelle</h4>

<div class="card">
    <div class="card-body">
        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Ürün Adı -->
            <div class="mb-3">
                <label for="name" class="form-label">Ürün Adı</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $product->name) }}"
                    required>
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Fiyat -->
            <div class="mb-3">
                <label for="price" class="form-label">Fiyat</label>
                <input type="number" step="0.01" id="price" name="price" class="form-control"
                    value="{{ old('price', $product->price) }}" required>
                @error('price')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Kapak Fotoğrafı -->
            <div class="mb-3">
                <label for="cover_image" class="form-label">Kapak Fotoğrafı</label>
                <input type="file" id="cover_image" name="cover_image" class="form-control">
                @if($product->getFirstMediaUrl('images'))
                    <img src="{{ $product->getFirstMediaUrl('images') }}" alt="Kapak Fotoğrafı" class="img-thumbnail mt-2"
                        width="150">
                @endif
                @error('cover_image')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Açıklama -->
            <div class="mb-3">
                <label for="description" class="form-label">Açıklama</label>
                <textarea id="description" name="description"
                    class="form-control">{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Bayiler -->
            <div class="mb-3">
                <label for="dealer_id" class="form-label">Bayiler</label>
                <select id="dealer_id" name="dealer_id" class="form-control select2" required>
                    @foreach ($dealers as $dealer)
                        <option value="{{ $dealer->id }}" {{ old('dealer_id', $product->dealer_id) == $dealer->id ? 'selected' : '' }}>
                            {{ $dealer->name }}
                        </option>
                    @endforeach
                </select>
                @error('dealer_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Mevcut Fotoğraflar -->
            <div class="mb-3">
                <label class="form-label">Mevcut Fotoğraflar</label>
                <div class="d-flex flex-wrap gap-2">
                    @foreach ($product->getMedia('images') as $media)
                        <div class="position-relative">
                            <img src="{{ $media->getUrl() }}" alt="Fotoğraf" class="img-thumbnail" width="150">
                            <button type="button" class="btn btn-danger btn-sm position-absolute"
                                style="top: 5px; right: 5px;" onclick="deleteImage({{ $media->id }})">X</button>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Yeni Fotoğraflar Ekle -->
            <div class="mb-3">
                <label for="photos" class="form-label">Yeni Fotoğraflar</label>
                <input type="file" id="photos" name="photos[]" class="form-control" multiple>
            </div>

            <button type="submit" class="btn btn-primary">Güncelle</button>
        </form>
    </div>
</div>
@endsection

@section('js')
<script>
    function deleteImage(mediaId) {
        if (confirm('Bu fotoğrafı silmek istediğinize emin misiniz?')) {
            fetch(`/admin/products/media/${mediaId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
                .then(response => {
                    if (response.ok) {
                        alert('Fotoğraf başarıyla silindi.');
                        location.reload(); // Sayfayı yenileyerek güncel durumu göster
                    } else {
                        alert('Fotoğraf silinirken bir hata oluştu.');
                    }
                });
        }
    }

</script>
@endsection
