@extends('layouts.admin')

@section('title', 'Dashboard')

@section('css')
<style>
    .new-order {
        background-color: #4caf50 !important; /* Daha koyu yeşil */
        color: white; /* Yazı rengi */
        font-weight: bold; /* Kalın yazı */
    }
</style>

@endsection

@section('content')
<h4 class="fw-bold py-3 mb-4">Siparişler</h4>

<!-- Liste Son Güncelleme Tarihi -->
<div class="mb-2">
    <span id="last-updated" class="text-muted">Son Güncelleme: -</span>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered table-hover text-center" id="orders-table">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Kullanıcı</th>
                    <th>Ürün</th>
                    <th>İçecek</th>
                    <th>Adet</th>
                    <th>Fiyat</th>
                    <th>Not</th>
                    <th>Durum</th>
                    <th>Oluşturulma Tarihi</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="orders-list">
                <!-- Dinamik Sipariş Listesi -->
            </tbody>
        </table>
        <div class="modal fade" id="userDetailsModal" tabindex="-1" aria-labelledby="userDetailsModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="userDetailsModalLabel">Kullanıcı Detayları</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                    </div>
                    <div class="modal-body">
                        <ul id="userDetails" class="list-group">
                            <!-- Kullanıcı detayları JS ile doldurulacak -->
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bildirim Sesi -->
<audio id="notification-sound" src="/img/sound.mp3" preload="auto"></audio>
</div>
@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ordersList = document.getElementById('orders-list');
    const lastUpdated = document.getElementById('last-updated');
    const notificationSound = document.getElementById('notification-sound');
    let previousOrderCount = 0; // Daha önceki sipariş sayısı

    // Sipariş listesini güncelleyen fonksiyon
    function fetchOrders() {
        fetch('{{ route('orders.fetch') }}')
            .then(response => response.json())
            .then(data => {
                let html = '';

                data.forEach(order => {
                    // Sipariş durumuna göre satır rengi belirle
                    let rowClass = '';
                    if (order.status === 'bekliyor') {
                        rowClass = 'table-warning'; // Sarı
                    } else if (order.status === 'onaylandı') {
                        rowClass = 'table-light'; // Hafif gri
                    } else if (order.status === 'hazır') {
                        rowClass = 'bg-success text-white'; // Açık yeşil
                    } else if (order.status === 'teslim edildi') {
                        rowClass = 'table-success'; // Daha koyu yeşil
                    }

                    html += `
                    <tr class="${rowClass}">
                        <td>${order.id}</td>
                        <td>${order.user ? order.user.name : 'Kullanıcı Yok'}</td>
                        <td>${order.product ? order.product.name : '-'}</td>
                        <td>${order.drink ? order.drink.name : '-'}</td>
                        <td>${order.quantity}</td>
                        <td>${Number(order.price).toFixed(2)} ₺</td>
                        <td title="${order.description ?? ''}">
                            ${order.description ? order.description.substring(0, 10) + (order.description.length > 10 ? '...' : '') : '-'}
                        </td>
                        <td>
                            <form action="/orders/${order.id}/update-status" method="POST" class="status-form" id="status-form-${order.id}">
                                <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
                                <select name="status" class="form-select status-select" data-order-id="${order.id}">
                                    <option value="bekliyor" ${order.status === 'bekliyor' ? 'selected' : ''}>Bekliyor</option>
                                    <option value="onaylandı" ${order.status === 'onaylandı' ? 'selected' : ''}>Onaylandı</option>
                                    <option value="hazır" ${order.status === 'hazır' ? 'selected' : ''}>Hazır</option>
                                    <option value="teslim edildi" ${order.status === 'teslim edildi' ? 'selected' : ''}>Teslim Edildi</option>
                                </select>
                            </form>
                        </td>
                        <td>${new Date(order.created_at).toLocaleString()}</td>
                        <td>
                            <button class="btn btn-info btn-sm user-details-btn" data-user='${JSON.stringify(order.user)}'>
                                Detay
                            </button>
                        </td>
                    </tr>
                    `;
                });

                // Yeni sipariş varsa ses oynat
                if (data.length > previousOrderCount) {
                    notificationSound.play();
                }

                previousOrderCount = data.length; // Sipariş sayısını güncelle
                ordersList.innerHTML = html;

                // Güncelleme zamanını yazdır
                const now = new Date();
                lastUpdated.textContent = `Son Güncelleme: ${now.toLocaleDateString()} ${now.toLocaleTimeString()}`;
            })
            .catch(error => console.error('Siparişler alınırken hata oluştu:', error));
    }

    // İlk yükleme
    fetchOrders();

    // 5 saniyede bir siparişleri güncelle
    setInterval(fetchOrders, 5000);

    // Durum değişikliği için olay dinleyicisi
    document.addEventListener('change', function (event) {
        if (event.target && event.target.classList.contains('status-select')) {
            const select = event.target;
            const orderId = select.getAttribute('data-order-id');
            const form = document.querySelector(`#status-form-${orderId}`);
            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json'
                }
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Durum güncellenemedi.');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        alert('Durum başarıyla güncellendi.');
                    } else {
                        alert('Durum güncellenirken bir hata oluştu.');
                    }
                })
                .catch(error => {
                    console.error('Hata oluştu:', error);
                    alert('Durum güncellenirken bir hata oluştu.');
                });
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const userDetailsModal = new bootstrap.Modal(document.getElementById('userDetailsModal'));
    const userDetailsList = document.getElementById('userDetails');

    document.getElementById('orders-list').addEventListener('click', function (e) {
        if (e.target.classList.contains('user-details-btn')) {
            const userData = JSON.parse(e.target.getAttribute('data-user'));

            if (userData) {
                userDetailsList.innerHTML = `
                    <li class="list-group-item"><strong>Adı ve Soyadı:</strong> ${userData.name || 'Belirtilmemiş'}</li>
                    <li class="list-group-item"><strong>E-posta:</strong> ${userData.email || 'Belirtilmemiş'}</li>
                    <li class="list-group-item"><strong>Telefon:</strong> ${userData.phone || 'Belirtilmemiş'}</li>
                    <li class="list-group-item"><strong>Personel Numarası:</strong> ${userData.personnel_number || 'Belirtilmemiş'}</li>
                    <li class="list-group-item"><strong>Oda Numarası:</strong> ${userData.room_number || 'Belirtilmemiş'}</li>
                    <li class="list-group-item"><strong>Dahili Telefon:</strong> ${userData.internal_phone || 'Belirtilmemiş'}</li>
                    <li class="list-group-item"><strong>Kayıt Tarihi:</strong> ${new Date(userData.created_at).toLocaleString()}</li><`
                ;
                userDetailsModal.show();
            } else {
                alert('Kullanıcı bilgileri mevcut değil.');
            }
        }
    });
});
</script>
@endsection