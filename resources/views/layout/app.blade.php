<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Corporate Profile</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Leaflet CSS -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.css" integrity="sha384-JjZo+iNM2+TbLZF4Vp/06+C2C7jJUm/n5+Z4arGtYQmYTlYw0tF4J9CC5LwXKLf" crossorigin=""> -->

    <!-- Favicons -->
    <link href="{{ asset('template/Medilab/assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('template/Medilab/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('template/Medilab/assets/vendor/animate.css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template/Medilab/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template/Medilab/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('template/Medilab/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template/Medilab/assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template/Medilab/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template/Medilab/assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('template/Medilab/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- <link href="{{ asset('template/Medilab/assets/vendor/aos/aos.css') }}" rel="stylesheet"> -->
    <!-- <link href="{{ asset('template/Medilab/assets/css/style.css') }}" rel="stylesheet"> -->

    <!-- Template Main CSS File -->
    <link href="{{ asset('template/Medilab/assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('template/Medilab/assets/css/styleFlexstate.css') }}" rel="stylesheet">
    <!-- <link href="{{ asset('css/style.css') }}" rel="stylesheet"> -->

    <!-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" /> -->
    <!-- Make sure you put this AFTER Leaflet's CSS -->

    @yield('styleMaps')

    @yield('headstyle')

    <style>
        #map {
            width: 100%;
            height: 400px;
        }
    </style>


    <!-- =======================================================
  * Template Name: Medilab - v4.6.0
  * Template URL: https://bootstrapmade.com/medilab-free-medical-bootstrap-theme/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <!-- ======= Top Bar ======= -->
    <div id="topbar" class="d-flex align-items-center fixed-top" style="background-color: #F0F8FF;">
        <div class="container d-flex justify-content-between">
            <div class="contact-info d-flex align-items-center">
                <i class="bi bi-english"></i><b>English</b>
                <i class="bi bi-indonesia"></i> <a href="#">Indonesia</a>
            </div>
            <!-- <div class="d-none d-lg-flex social-links align-items-center">
                <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></i></a>
            </div> -->
        </div>
    </div>

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top" style="background-color: #F0F8FF;">
        <div class="container d-flex align-items-center">

            <h1 class="logo me-auto"><a href="{{route('corporateProfileEn')}}">ID Corporate</a></h1>
            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <a href="index.html" class="logo me-auto"><img src="img/log/assetso.png" alt="" class="img-fluid"></a>-->

            <nav id="navbar" class="navbar order-last order-lg-0">
                <ul>
                    <li><a class="" href="{{route('corporateProfileEn')}}">Home</a></li>
                    <li><a class="" href="#pricing">Pricing</a></li>
                    <li><a class="" href="#about">About</a></li>
                    <!-- <li><a class="nav-link scrollto" href="#services">Services</a></li>
                    <li><a class="nav-link scrollto" href="#departments">Departments</a></li>
                    <li><a class="nav-link scrollto" href="#doctors">Doctors</a></li> -->
                    <!-- <li class="dropdown"><a href="#"><span>Drop Down</span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                            <li><a href="#">Drop Down 1</a></li>
                            <li class="dropdown"><a href="#"><span>Deep Drop Down</span> <i class="bi bi-chevron-right"></i></a>
                                <ul>
                                    <li><a href="#">Deep Drop Down 1</a></li>
                                    <li><a href="#">Deep Drop Down 2</a></li>
                                    <li><a href="#">Deep Drop Down 3</a></li>
                                    <li><a href="#">Deep Drop Down 4</a></li>
                                    <li><a href="#">Deep Drop Down 5</a></li>
                                </ul>
                            </li>
                            <li><a href="#">Drop Down 2</a></li>
                            <li><a href="#">Drop Down 3</a></li>
                            <li><a href="#">Drop Down 4</a></li>
                        </ul>
                    </li> -->
                    <li><a class="" href="#contact">Contact</a></li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->

            <!-- <a href="#appointment" class="appointment-btn scrollto"><span class="d-none d-md-inline">Make an</span> Appointment</a> -->

        </div>
    </header><!-- End Header -->

    @yield('carousel')

    @yield('content')

    <!-- ======= Footer ======= -->
    <footer id="footer">

        <div class="footer-top">
            <div class="container">
                <div class="row">

                    <div class="col-lg-5 col-md-6 footer-contact">
                        <h3>Inovasi Digital</h3>
                        <p>
                            Jl. Tangkuban Prahu No. 8, Babakan<br>
                            Central Bogor District, Bogor City, West Java 16128 <br><br>
                            <strong>Phone:</strong> +62 898 2950 531<br>
                            <strong>Email:</strong> beni@inovasidigital.asia<br>
                        </p>
                    </div>

                    <!-- <div class="col-lg-2 col-md-6 footer-links">
                        <h4>Useful Links</h4>
                        <ul>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Home</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">About us</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Services</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Privacy policy</a></li>
                        </ul>
                    </div> -->

                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Our Services</h4>
                        <ul>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Subsidiary</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Group</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Shareholder</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-4 col-md-6 footer-newsletter">
                        <h4>Corporate Profile</h4>
                        <p>Find thousands of palm oil companies and their shareholdings around the world</p>
                        <!-- <form action="" method="post">
                            <input type="email" name="email"><input type="submit" value="Subscribe">
                        </form> -->
                    </div>

                </div>
            </div>
        </div>

        <div class="container d-md-flex py-4">

            <div class="me-md-auto text-center text-md-start">
                <!-- <div class="copyright">
                    &copy; Copyright <strong><span>Medilab</span></strong>. All Rights Reserved
                </div> -->
                <div class="credits">
                    <!-- All the links in the footer should remain intact. -->
                    <!-- You can delete the links only if you purchased the pro version. -->
                    <!-- Licensing information: https://bootstrapmade.com/license/ -->
                    <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/medilab-free-medical-bootstrap-theme/ -->
                    <!-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> -->
                </div>
            </div>
            <div class="social-links text-center text-md-right pt-3 pt-md-0">
                <!-- <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a> -->
                <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                <!-- <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a> -->
                <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
            </div>
        </div>
    </footer><!-- End Footer -->

    <!-- <div id="preloader"></div> -->
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('template/Medilab/assets/vendor/bootstrap/js/bootstrap.bundle.min')}}.js"></script>
    <!-- <script src="{{ asset('template/Medilab/assets/vendor/glightbox/js/glightbox.min')}}.js"></script> -->
    <script src="{{ asset('template/Medilab/assets/vendor/php-email-form/validate')}}.js"></script>
    <script src="{{ asset('template/Medilab/assets/vendor/purecounter/purecounter')}}.js"></script>
    <script src="{{ asset('template/Medilab/assets/vendor/swiper/swiper-bundle.min')}}.js"></script>

    <!-- Template Main JS File -->
    <!-- <script src="{{ asset('template/Medilab/assets/js/main/assets.js') }}"></script> -->
    <script src="{{ asset('template/Medilab/assets/js/main.js') }}"></script>

    <script>
        const subsidiaryBtn = document.getElementById('subsidiary-btn');
        const groupBtn = document.getElementById('group-btn');
        const ownershipBtn = document.getElementById('ownership-btn');

        const searchForm = document.getElementById('search-form');
        const searchInput = document.getElementById('search-input');

        subsidiaryBtn.addEventListener('click', () => {
            searchForm.addEventListener('submit', (event) => {
                event.preventDefault();
                const searchValue = searchInput.value.toLowerCase();
                // Cari hasil search pada kategori subsidiary
                // Tampilkan hasil search pada card
            });
        });

        groupBtn.addEventListener('click', () => {
            searchForm.addEventListener('submit', (event) => {
                event.preventDefault();
                const searchValue = searchInput.value.toLowerCase();
                // Cari hasil search pada kategori group
                // Tampilkan hasil search pada card
            });
        });

        ownershipBtn.addEventListener('click', () => {
            searchForm.addEventListener('submit', (event) => {
                event.preventDefault();
                const searchValue = searchInput.value.toLowerCase();
                // Cari hasil search pada kategori ownership
                // Tampilkan hasil search pada card
            });
        });
    </script>

    <script>
        window.chatbaseConfig = {
            chatbotId: "VRXUJ-HRD1JcdZQIduOLV",
        }
    </script>
    <script src="https://www.chatbase.co/embed.min.js" id="VRXUJ-HRD1JcdZQIduOLV" defer>
    </script>

    <!-- <script src="//code.tidio.co/carbtvyc0k1qdzokypuyityetfilftms.js" async></script> -->

    <!-- <script src='//fw-cdn.com/7785646/3277539.js' chat='true'>
    </script> -->

    @yield('mapsLeaflet')

</body>

</html>