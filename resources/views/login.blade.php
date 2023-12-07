<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/logo-disdikpora.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('img/logo-disdikpora.png') }}">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="{{ asset('css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/nucleo-svg.css') }}" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="{{ asset('css/nucleo-svg.css') }}" rel="stylesheet" />
    <link id="pagestyle" href="{{ asset('css/soft-ui-dashboard.css?v=1.0.7') }}" rel="stylesheet" />
    <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>
</head>

<body>
    <div class="container position-sticky z-index-sticky top-0">
        <div class="row">
            <div class="col-12">
                <!-- Navbar -->
                <nav
                    class="navbar navbar-expand-lg blur blur-rounded top-0 z-index-3 shadow position-absolute my-3 py-2 start-0 end-0 mx-4">
                    <div class="container-fluid pe-0 text-center">
                        <p class="fs-5 m-0 mx-auto text-dark text-bold">Dinas Pendidikan Kepemudaan dan Olahraga
                            Buleleng
                            <br>
                            <span class="text-primary">Sistem Perpustakaan Dokumen</span>
                        </p>
                    </div>
                </nav>
                <!-- End Navbar -->
            </div>
        </div>
    </div>

    <main class="main-content  mt-0">
        <section>
            <div class="page-header min-vh-75">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
                            <div class="card card-plain mt-8">
                                <div class="card-header pb-0 text-left bg-transparent">
                                    <h3 class="font-weight-bolder text-primary text-gradient">Selamat Datang</h3>
                                    <p class="mb-0">Masukkan username dan password untuk melanjutkan</p>
                                </div>
                                <div class="card-body">
                                    @include('sweetalert::alert')
                                    <form role="form" method="POST" action="{{ route('login.authenticate') }}">
                                        @csrf
                                        @method('POST')
                                        <label>Username</label>
                                        <div class="mb-3">
                                            <input name="username" type="text" class="form-control" autofocus
                                                required autocomplete="off">
                                        </div>
                                        <label>Password</label>
                                        <div class="mb-3">
                                            <input name="password" type="password" class="form-control"
                                                aria-label="Password" aria-describedby="password-addon" required>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn bg-gradient-primary w-100 mt-4 mb-0">Sign
                                                in</button>
                                        </div>
                                    </form>
                                </div>

                                <div class="py-5"></div>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                                <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6"
                                    style="background-image:url('{{ asset('img/curved-images/curved6.jpg') }}')"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script src="{{ asset('js/core/popper.min.js') }}"></script>
    <script src="{{ asset('js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="{{ asset('js/plugins/chartjs.min.js') }}"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="{{ asset('js/soft-ui-dashboard.min.js?v=1.0.7') }}"></script>
</body>

</html>
