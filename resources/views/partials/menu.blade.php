<aside id="layout-menu" class="layout-menu-horizontal menu-horizontal menu bg-menu-theme flex-grow-0">
    <div class="container-xxl d-flex h-100">
        <ul class="menu-inner py-1">
            <li class="menu-item active">
                <a href="{{ route('admin.dashboard') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-home-circle"></i>
                    <div>Siparişler</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{route('dealer.list')}}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-detail"></i>
                    <div>Bayiler</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{route('drink.list')}}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-detail"></i>
                    <div>İçecekler</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('products.all') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-list-ul"></i>
                    <div>Tüm Ürünler</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('users.all') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-list-ul"></i>
                    <div>Kullanıcılar</div>
                </a>
            </li>

        </ul>
    </div>
</aside>