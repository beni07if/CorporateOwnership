@extends('layout.app')

@section('headstyle')
<!-- Favicons -->
<link href="{{asset('template/Flexstart/assets/img/favicon.png') }}" rel="icon">
<link href="{{asset('template/Flexstart/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

<!-- Vendor CSS Files -->
<link href="{{asset('template/Flexstart/assets/vendor/aos/aos.css')}}" rel="stylesheet">

<!-- Template Main CSS File -->
<!-- <link href="{{asset('template/Flexstart/assets/css/style.css')}}" rel="stylesheet"> -->

 <!-- Favicons -->
  <!-- Template Main CSS File -->
  <link href="{{ asset('template/SoftLand/assets/css/style.css') }}" rel="stylesheet">
  <!-- end SoftLand -->

@endsection

@section('carousel')

@endsection

@section('content')
<main id="main">
    <!-- Blog Page Title & Breadcrumbs -->
    <div data-aos="fade" class="page-title">
      <div class="heading">
        <div class="container">
          <div class="row d-flex justify-content-center text-center">
            <div class="col-lg-8">
              <h1>Blog</h1>
              <p class="mb-0">Odio et unde deleniti. Deserunt numquam exercitationem. Officiis quo odio sint voluptas consequatur ut a odio voluptatem. Sit dolorum debitis veritatis natus dolores. Quasi ratione sint. Sit quaerat ipsum dolorem.</p>
            </div>
          </div>
        </div>
      </div>
      <nav class="breadcrumbs">
        <div class="container">
          <ol>
            <li><a href="index.html">Home</a></li>
            <li class="current">Blog</li>
          </ol>
        </div>
      </nav>
    </div><!-- End Page Title -->

    <!-- ======= Departments Section ======= -->
    <section id="departments" class="departments">
        <div class="container">

            <div class="section-title">
                <h2>Search for Company</h2>
                <!-- <p>Explore datasets of thousands of companies and their worldwide shareholding networks!</p> -->
            </div>
            <!-- <div id="mapid" style="height: 500px;"></div> -->

            <div class="row">
                <div class="col-lg-3">
                    <ul class="nav nav-tabs flex-column">
                        <li class="nav-item">
                            <!-- <a class="nav-link active show" data-bs-toggle="tab" href="#tabs-search-subsidiaries">Company</a> -->
                        </li>
                    </ul>
                </div>
                
                <div class="col-lg-9 mt-4 mt-lg-0">
                    <div class="tab-content">
                        <div class="tab-pane active show" id="tabs-search-subsidiaries">
                            <div class="row">
                                <div class="col-lg-8 details order-2 order-lg-1">
                                    <!-- <h3>Company</h3> -->
                                    <!-- <p class="fst-italic">A group company is a collection of individual companies or subsidiaries that are controlled by a single parent company. The parent company, often referred to as the holding company or the group, typically holds a majority stake or controlling the subsidiary companies. The information about Group Company can be used to identify the subsidiary under.</p> -->
                                    
                                    <div class="container">
                                        <form action="{{ route('searchFunctionSubsidiary') }}" method="GET" class="d-flex">
                                            <input type="text" class="form-control me-2" name="query" placeholder="Company name">
                                            <button type="submit" class="btn btn-info">Search</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-lg-4 text-center order-1 order-lg-2">
                                    <img src="assets/img/departments-1.jpg" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="section-title" style="padding-top: 70px;">
                <h2>CHAT WITH US</h2>
            </div>
            <iframe src="https://www.chatbase.co/chatbot-iframe/VRXUJ-HRD1JcdZQIduOLV" width="100%" height="700" frameborder="0"></iframe> -->
        </div>
    </section><!-- End Departments Section -->

</main><!-- End #main -->
@endsection

<script>
    $(document).ready(function() {
        // group 
        $(".chatbox form .group").submit(function(e) {
            e.preventDefault();
            sendMessage2();
        });

        function sendMessage2() {
            var group_name = $("#group_name").val();
            var message = "<div class='response-group user'>" + group_name + "</div>";
            $("#response-group").append(message);

            $.ajax({
                url: "/eq-subsidiary-en",
                type: "POST",
                dataType: "json",
                data: {
                    message: group_name,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response2) {
                    var message = "<div class='response-group bot'>" + response2.message + "</div>";
                    $("#response-group").append(message);
                }
            });

            $("#group_name").val("");
        }
        // end group


        // subsidiary 
        $(".chatbox form").submit(function(e) {
            e.preventDefault();
            sendMessage();
        });

        function sendMessage() {
            var subsidiary = $("#subsidiary").val();
            var message = "<div class='response user'>" + subsidiary + "</div>";
            $("#response").append(message);

            $.ajax({
                url: "/eq-subsidiary-en",
                type: "POST",
                dataType: "json",
                data: {
                    message: subsidiary,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    var message = "<div class='response bot'>" + response.message + "</div>";
                    $("#response").append(message);
                }
            });

            $("#subsidiary").val("");
        }
        // end 


        // nav 
        // Ambil semua link navigasi
        const navLinks = document.querySelectorAll('.nav-link');

        // Tambahkan event listener pada setiap link navigasi
        navLinks.forEach(link => {
            link.addEventListener('click', e => {
                e.preventDefault(); // Hentikan aksi default link navigasi

                // Ambil id tab pane yang sesuai dengan link navigasi yang ditekan
                const tabId = link.getAttribute('href');

                // Hapus class active dari semua link navigasi
                navLinks.forEach(link => {
                    link.classList.remove('active');
                });

                // Tambahkan class active pada link navigasi yang ditekannnn
                link.classList.add('active');

                // Sembunyikan semua tab pane
                const tabPanes = document.querySelectorAll('.tab.pane');
                tabPanes.forEach(pane => {
                    pane.style.display = 'none';
                });

                // Tampilkan tab pane yang sesuai dengan link navigasi yang ditekan
                const tabPane = document.querySelector(tabId);
                tabPane.style.display = 'block';
            });
        });

        var nav = document.querySelector('nav');
        nav.classList.add('active');
        // end nav 
    });

    // end nav 
</script>

<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>

<!-- <script
src='//fw-cdn.com/10921532/3683145.js'
chat='true'>
</script> -->

<script
src='//fw-cdn.com/10921532/3683145.js'
chat='true'
widgetId='6b8436d0-ab38-43ab-868d-d5b103918e69'>
</script>