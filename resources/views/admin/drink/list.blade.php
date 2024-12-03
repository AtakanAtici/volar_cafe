@extends('layouts.admin')

@section('title', 'İçecekler')

@section('content')
<h4 class="fw-bold py-3 mb-4">İÇECEKLER</h4>

<div class="card">
    <div class="card-body">
        <div class="card-header d-flex justify-content-end">
            <!-- Ekle Butonu -->
            <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#addDrinkModal">
                <i class="fa fa-plus"></i> Ekle
            </button>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>İçecek</th>
                    <th>Sipariş Verilebilir</th>
                    <th>Oluşturulma Tarihi</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($drinks as $drink)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $drink->name }}</td>
                        <td>
                        <span class="badge bg-{{$drink->is_active ? "success" : "danger"}}">
                        {{ $drink->is_active ? "EVET" : "HAYIR" }}
                        </span>
                        </td>
                        <td>{{ $drink->created_at->format('d-m-Y H:i') }}</td>
                        <td>
                            <!-- Düzenle Butonu -->
                            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" 
                                data-bs-target="#editDrinkModal" 
                                onclick="setEditData({{ $drink->id }}, '{{ $drink->name }}', {{ $drink->is_active }})">
                                <i class="fa fa-edit"></i> Düzenle
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Hiç içecek bulunamadı.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- İçecek Ekle Modal -->
<div class="modal fade" id="addDrinkModal" tabindex="-1" aria-labelledby="addDrinkModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDrinkModalLabel">İçecek Ekle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
            </div>
            <form action="{{ route('drink.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- İçecek Adı -->
                    <div class="mb-3">
                        <label for="name" class="form-label">İçecek Adı</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="İçecek adı giriniz" required>
                    </div>
                    
                    <!-- Sipariş Alınabilir Mi? -->
                    <div class="mb-3">
                        <label for="is_available" class="form-label">Sipariş Alınabilir Mi?</label>
                        <select class="form-select" id="is_available" name="is_active" required>
                            <option value="1" selected>Evet</option>
                            <option value="0">Hayır</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                    <button type="submit" class="btn btn-primary">Ekle</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- İçecek Düzenle Modal -->
<div class="modal fade" id="editDrinkModal" tabindex="-1" aria-labelledby="editDrinkModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDrinkModalLabel">İçecek Düzenle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
            </div>
            <form id="editDrinkForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <!-- İçecek Adı -->
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">İçecek Adı</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    
                    <!-- Sipariş Alınabilir Mi? -->
                    <div class="mb-3">
                        <label for="edit_is_available" class="form-label">Sipariş Alınabilir Mi?</label>
                        <select class="form-select" id="edit_is_available" name="is_active" required>
                            <option value="1">Evet</option>
                            <option value="0">Hayır</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                    <button type="submit" class="btn btn-primary">Güncelle</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    function setEditData(id, name, isAvailable) {
        // Düzenleme Modalındaki Formun Action URL'sini Ayarla
        const form = document.getElementById('editDrinkForm');
        form.action = `/drink/${id}`;

        // Mevcut Verileri Inputlara Doldur
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_is_available').value = isAvailable ? '1' : '0';
    }
</script>
@endsection
