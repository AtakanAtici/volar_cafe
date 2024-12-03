<nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme w-100" id="layout-navbar">
    <div class="container-xxl w-100">
        <!-- Sağ Taraf -->
        <div class="navbar-nav-right d-flex align-items-center ms-auto w-100">
            <!-- Kullanıcı Bilgileri -->
            <div class="row w-100">
                @if(!auth()->user()->is_admin)
                    <div class="col-md-6">
                        <a href="{{route('my.orders')}}" type="submit" class="dropdown-item float-right">
                            <i class="bx bx-cart me-2"></i> Siparişlerim
                        </a>
                    </div>
                @endif
            </div>
            <div class="col-md-6">

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item">
                        <i class="bx bx-power-off me-2"></i> Çıkış Yap
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>