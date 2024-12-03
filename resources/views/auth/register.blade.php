<!DOCTYPE html>

<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="../../assets/" data-template="horizontal-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Hesap Oluşturun</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="../../assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="../../assets/vendor/fonts/fontawesome.css" />
    <link rel="stylesheet" href="../../assets/vendor/fonts/flag-icons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../../assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../../assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/typeahead-js/typeahead.css" />
    <!-- Vendor -->
    <link rel="stylesheet" href="../../assets/vendor/libs/formvalidation/dist/css/formValidation.min.css" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="../../assets/vendor/css/pages/page-auth.css" />
    <!-- Helpers -->
    <script src="../../assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="../../assets/vendor/js/template-customizer.js"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../../assets/js/config.js"></script>
</head>

<body>
    <!-- Content -->

    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Register Card -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center">
                            <img src='/img/logo1.png' width="180px" />
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-2">Sipariş Vermeye Başlayın 🚀</h4>
                        <p class="mb-4">Uzaktan sipariş verebilmek için hesap oluşturun!</p>
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form id="formAuthentication" class="mb-3" action="{{route('register.post')}}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="username" class="form-label">*Adınız & Soyadınız</label>
                                <input type="text" class="form-control" id="name" name="name"
                                value="{{ old('name') }}"
                                    placeholder="Adınızı ve soyadınızı giriniz" autofocus required />
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">*E-posta Adresiniz</label>
                                <input type="text" class="form-control" id="email" name="email"
                                value="{{ old('email') }}"
                                    placeholder="E-posta adresinizi giriniz" required />
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">*Telefon Numaranız</label>
                                <input type="text" class="form-control" id="phone" name="phone"
                                value="{{ old('phone') }}"
                                    placeholder="Telefon Numaranızı Giriniz" required />
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Personel Numaranız</label>
                                <input type="text" class="form-control" id="personnel_number" name="personnel_number"
                                value="{{ old('personnel_number') }}"
                                    placeholder="Personel Numaranızı Giriniz" />
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">*Oda Numaranız</label>
                                <input type="text" class="form-control" id="room_number" name="room_number"
                                value="{{ old('room_number') }}"
                                    placeholder="Oda Numaranızı Giriniz" required />
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">*Dahili Telefon Numaranız</label>
                                <input type="text" class="form-control" id="internal_phone_number"
                                    name="internel_phone_number" placeholder="Dahili Telefon Numaranızı Giriniz"
                                    value="{{ old('internal_phone') }}"
                                    required />
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <label class="form-label" for="password">Şifreniz</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>
                            <button class="btn btn-primary d-grid w-100">🚀 Kayıt İşlemini Tamamla</button>
                        </form>

                        <p class="text-center">
                            <span>Zaten Hesabınız Var mı?</span>
                            <a href="{{route('login.show')}}">
                                <span>Giriş Yap</span>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="../../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../../assets/vendor/libs/popper/popper.js"></script>
    <script src="../../assets/vendor/js/bootstrap.js"></script>
    <script src="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="../../assets/vendor/libs/hammer/hammer.js"></script>
    <script src="../../assets/vendor/libs/i18n/i18n.js"></script>
    <script src="../../assets/vendor/libs/typeahead-js/typeahead.js"></script>

    <script src="../../assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="../../assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js"></script>
    <script src="../../assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js"></script>
    <script src="../../assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js"></script>

    <!-- Main JS -->
    <script src="../../assets/js/main.js"></script>

</body>

</html>