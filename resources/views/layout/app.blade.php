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

    <script src="{{ asset('js/pdfjs-dist/build/pdf.js') }}"></script>
    <script
    src='//fw-cdn.com/10921532/3683145.js'
    chat='true'>
    </script>

    @yield('styleMaps')

    @yield('headstyle')

    <style>
        #header {
  background: rgba(240, 248, 255, 0); /* Transparan penuh */
  transition: background-color 0.5s; /* Efek transisi */
  z-index: 997;
  padding: 15px 0;
  box-shadow: 0px 2px 15px rgba(25, 119, 204, 0.1);
  position: fixed;
  width: 100%;
  top: 0;
}
    .header-solid {
      background: #fff !important; /* Warna putih */
    }

        #map {
            width: 100%;
            height: 400px;
        }

        .descriptions {
        display: inline-block;
        padding: 5px 5px;
        font-size: 16px;
        background-color: #f0f0f0;
        border: none;
        border-radius: 4px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: background-color 0.5s ease, transform 0.5s ease;
        }

        .descriptions:hover {
            background-color: #e0e0e0;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .descriptions:active {
            background-color: #d0d0d0;
            transform: translateY(1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header-map p {
            padding-top: 50px;
            display: inline-block;
            margin: 0;
        }


        /* .icon-box {
            text-align: center;
        }

        .icon {
            margin-bottom: 10px;
        }

        .title {
            margin-bottom: 15px;
            font-size: 18px;
        } */

        /* .card {
            width: 300px;
            margin: 0 auto;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        } */

        .card-body {
            padding: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .descriptions {
            display: block;
            width: 100%;
            background-color: #F5F5F5;
            color: #696969;
            padding: 8px 15px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            text-align: left;
        }

            /* Gaya CSS untuk elemen input */
        .description {
            border: none;
            font-weight: bold;
            padding-top: -50px;
        }

        /* Efek hover: mengubah warna background menjadi abu-abu */
        form .text-muted:hover {
            background-color: #dcdcdc; /* Warna abu-abu pada hover */
        }

        .text-muted {
            border: none;
            background-color: transparent;
            transition: background-color 0.3s; /* Efek transisi ketika hover */
            padding-bottom: 20px;
        }

        ul {
        list-style: none; /* Menghilangkan simbol list (bulat kecil) */
        padding: 0; /* Menghapus padding default untuk ul */
        margin: 0; /* Menghapus margin default untuk ul */
    }

    ul li {
        margin-bottom: 10px; /* Memberi jarak antara setiap elemen li */
    }

    /* Tambahkan gaya lain sesuai kebutuhan Anda */

    </style>

</head>

<body>

    <!-- ======= Top Bar ======= -->
    <!-- <div id="topbar" class="d-flex align-items-center fixed-top" style="background-color: #F0F8FF;">
        <div class="container d-flex justify-content-between">
            <div class="contact-info d-flex align-items-center">
                <i class="bi bi-english"></i><b>English</b>
                <i class="bi bi-indonesia"></i> <a href="#">Indonesia</a>
            </div>
        </div>
    </div> -->

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top" >
        <div class="container d-flex align-items-center">

            <!-- <h1 class="logo me-auto"><a href="{{route('corporateProfileEn')}}">ID Corporate</a></h1> -->
            <!-- Uncomment below if you prefer to use an image logo -->
            <a href="{{route('corporateProfileEn')}}" class="logo me-auto"><img src="{{asset('img/logo/new-logo3/png2/logo3.png')}}" alt="" class="img-fluid"></a>

            <nav id="navbar" class="navbar order-last order-lg-0">
                <ul>
                    <li><a class="" href="{{route('corporateProfileEn')}}#why-us">Home</a></li>
                    <li><a class="" href="#departments">Search</a></li>
                    <li><a class="" href="#services">Dataset</a></li>
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
                    <li><a class="" href="#footer">Contact</a></li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->

            <!-- <a href="#appointment" class="appointment-btn scrollto"><span class="d-none d-md-inline">Make an</span> Appointment</a> -->

        </div>
    </header><!-- End Header -->

    @yield('carousel')

    @yield('content')

    @include('sweetalert::alert')


    <!-- ======= Footer ======= -->
    <footer id="footer">

        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <a href="{{route('corporateProfileEn')}}" class="logo me-auto"><img src="{{asset('img/logo/new-logo3/png2/logo3.png')}}" alt="" class="img-fluid" style="height:30px; width: auto;"></a>
                    <div class="col-lg-4 col-md-3 footer-newsletter">
                        <h4></h4>
                        <ul>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Privacy and Policy</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Terms of Service</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-4 col-md-3 footer-newsletter">
                        <h4>Contact Us</h4>
                        <ul>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Jl. Anggrek No.6, Pontianak City, West Kalimantan</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">info@corporateownership.com</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">+628982950531</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-4 col-md-3 footer-newsletter">
                        <h4>Useful Links</h4>
                        <ul>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">FAQ (Frequently Asked Questions)</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">User Guides</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Blog</a></li>
                        </ul>
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
    <script src="{{ asset('template/NiceAdmin/assets/vendor/chart.js/chart.umd.js')}}"></script>

    <!-- Template Main JS File -->
    <!-- <script src="{{ asset('template/Medilab/assets/js/main/assets.js') }}"></script> -->
    <script src="{{ asset('template/Medilab/assets/js/main.js') }}"></script>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
      var header = document.getElementById("header");

      window.addEventListener("scroll", function() {
        // Jika halaman di-scroll ke bawah, tambahkan kelas untuk mengubah latar belakang menjadi putih
        if (window.scrollY > 0) {
          header.classList.add("header-solid");
        } 
        // Jika halaman di-scroll kembali ke atas, hapus kelas untuk mengembalikan latar belakang transparan
        else {
          header.classList.remove("header-solid");
        }
      });
    });
  </script>

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

        <!-- tambahan -->
    <!-- Template Main JS File -->
    <!-- <script src="assets/js/main.js"></script> -->
        <!-- end tambahan  -->

    <!-- <script> ini chatbot toogle
        window.chatbaseConfig = {
            chatbotId: "VRXUJ-HRD1JcdZQIduOLV",
        }
    </script>
    <script src="https://www.chatbase.co/embed.min.js" id="VRXUJ-HRD1JcdZQIduOLV" defer>
    </script> -->

    <!-- <script src="//code.tidio.co/carbtvyc0k1qdzokypuyityetfilftms.js" async></script>

    <script src='//fw-cdn.com/7785646/3277539.js' chat='true'>
    </script> -->

    @yield('mapsLeaflet')

</body>

</html>