@extends('layout.app')

@section('headstyle')
<!-- Favicons -->
<link href="{{asset('template/Flexstart/assets/img/favicon.png') }}" rel="icon">
<link href="{{asset('template/Flexstart/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

<!-- Vendor CSS Files -->
<link href="{{asset('template/Flexstart/assets/vendor/aos/aos.css')}}" rel="stylesheet">
<link rel="icon" href="{!! asset('img/logo/new-logo-5/png/logo-icon.png') !!}"/>

<!-- Template Main CSS File -->
<!-- <link href="{{asset('template/Flexstart/assets/css/style.css')}}" rel="stylesheet"> -->

 <!-- Favicons -->
  <!-- Template Main CSS File -->
  <link href="{{ asset('template/SoftLand/assets/css/style.css') }}" rel="stylesheet">
  <!-- end SoftLand -->

@endsection

@section('carousel')
<!-- ======= Hero Section ======= -->
<section id="hero" class="d-flex align-items-center">
    <div class="container">
        @foreach($landingPages as $landingPage)
        <h1 style="text-align:center;">{!!$landingPage->tagline!!}</h1>
        @endforeach
        <!-- <h2>Discover and Analyze Global Corporate Profile Structures for Strategic Insights</h2> -->
        <!-- <a href="#about" hidden class="btn-get-started scrollto">Search</a> -->
        <!-- <section id="hero" class="d-flex align-items-center"> -->
        <!-- <div class="container"> -->
        <form id="search-form">
            <label for="search-input" class="visually-hidden">Search</label>
            <div class="input-group">
                <!-- <input type="text" id="search-input" class="form-control" placeholder="Find group and subsidiary profile...">
                <button type="submit" class="btn btn-primary">Search</button> -->
            </div>
        </form>
        <!-- </div> -->
        <!-- </section> -->
    </div>
</section><!-- End Hero -->
@endsection

@section('content')
<main id="main">

    <!-- ======= Why Us Sectionss ======= -->
    <section id="why-us" class="why-us">
        <div class="container">
            <div class="row">
                @foreach($landingPages as $landingPage)
                <div class="col-lg-4 d-flex align-items-stretch">
                    <div class="content">
                        <h3 style="color:#ffffff;">{!!$landingPage->title_short_definition!!}</h3>
                        <p>
                            {!!$landingPage->short_definition!!}
                        </p>
                    </div>
                </div>
                <div class="col-lg-8 d-flex align-items-stretch">
                    <div class="icon-boxes d-flex flex-column justify-content-center">
                        <div class="row">
                            <div class="col-xl-4 d-flex align-items-stretch">
                                <div class="icon-box mt-4 mt-xl-0">
                                    <i class="ri-database-line"></i>
                                    <h4>{!!$landingPage->title_of_data1!!}</h4>
                                    <h2>{!!$landingPage->number_of_data1!!} +</h2>
                                    <p>{!!$landingPage->tag_of_data1!!}</p>
                                    <!-- <p>There are thousands of groups along with their subsidiaries, shareholders and other important information.</p> -->
                                </div>
                            </div>
                            <div class="col-xl-4 d-flex align-items-stretch">
                                <div class="icon-box mt-4 mt-xl-0">
                                    <i class="ri-building-fill"></i>
                                    <h4>{!!$landingPage->title_of_data2!!}</h4>
                                    <h2>{!!$landingPage->number_of_data2!!} +</h2>
                                    <p>{!!$landingPage->tag_of_data2!!}</p>
                                    <!-- <p>There are tens of thousands of subsidiaries along with their location, shareholder, and other important information.</p> -->
                                </div>
                            </div>
                            <div class="col-xl-4 d-flex align-items-stretch">
                                <div class="icon-box mt-4 mt-xl-0">
                                    <i class="ri-admin-line"></i>
                                    <h4>{!!$landingPage->title_of_data3!!}</h4>
                                    <h2>{!!$landingPage->number_of_data3!!} +</h2>
                                    <p>{!!$landingPage->tag_of_data3!!}</p>
                                    <!-- <p>There are tens of thousands of shareholders and their shareholdings in several companies</p> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- End Why Us Section -->

    <!-- ======= Why Us Section ======= -->
    <section id="why-us2" class="why-us2 section-bg" hidden>
      <div class="container" >

        <div class="row">

          <div class="col-lg-7 d-flex flex-column justify-content-center align-items-stretch  order-2 order-lg-1">

            <div class="content">
              <h3><strong>Corporate Profile</strong></h3>
              <p>
              Corporate Profile InovasiDigital dirancang untuk memberikan Anda akses mudah dan transparan ke data kepemilikan perusahaan kami. Temukan informasi mendalam mengenai pemegang saham utama, struktur grup, serta hubungan strategis yang membantu kami memimpin inovasi di industri digital.
              </p>
            </div>

            <!-- <div class="accordion-list">
              <ul>
                <li>
                  <a data-bs-toggle="collapse" class="collapse" data-bs-target="#accordion-list-1"><span>01</span> Non consectetur a erat nam at lectus urna duis? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                  <div id="accordion-list-1" class="collapse show" data-bs-parent=".accordion-list">
                    <p>
                      Feugiat pretium nibh ipsum consequat. Tempus iaculis urna id volutpat lacus laoreet non curabitur gravida. Venenatis lectus magna fringilla urna porttitor rhoncus dolor purus non.
                    </p>
                  </div>
                </li>
              </ul>
            </div> -->

          </div>

          <!-- <div class="col-lg-5 align-items-stretch order-1 order-lg-2 img" style='background-image: url("asset/img/perusahaan-multinasional.png");' data-aos="zoom-in" data-aos-delay="150">&nbsp;</div> -->
          <div class="col-lg-5 align-items-stretch order-1 order-lg-2 img">
          <img src="{{ asset('img/perusahaan-multinasional.png')}}" class="img-fluid" alt="">
          </div>
        </div>

      </div>
    </section><!-- End Why Us Section -->
    
    <!-- ======= Departments Section ======= -->
    <section id="departments" class="departments">
        <div class="container">

            <div class="section-title">
                <h2>Corporate Profile</h2>
                {{-- <p>Explore datasets of thousands of companies and their worldwide shareholding networks!</p> --}}
            </div>
            <!-- <div id="mapid" style="height: 500px;"></div> -->

            <div class="row">
                <div class="col-lg-3">
                    <ul class="nav nav-tabs flex-column">
                        <li class="nav-item">
                            <a class="nav-link " data-bs-toggle="tab" href="#tabs-search-groups">Group</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active show" data-bs-toggle="tab" href="#tabs-search-subsidiaries">Company</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#tabs-search-shareholders">Shareholder</a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#tabs-search-sra">SRA</a>
                        </li> --}}
                    </ul>
                </div>
                
                <div class="col-lg-9 mt-4 mt-lg-0">
                    <div class="tab-content">
                        <div class="tab-pane " id="tabs-search-groups">
                            <div class="row">
                                <div class="col-lg-8 details order-2 order-lg-1">
                                    <h3>Group</h3>
                                    <!-- <p class="fst-italic">A group company is a collection of individual companies or subsidiaries that are controlled by a single parent company. The parent company, often referred to as the holding company or the group, typically holds a majority stake or controlling the subsidiary companies. The information about Group Company can be used to identify the subsidiary under.</p> -->
                                    
                                    <div class="container">
                                        <form action="{{ route('searchFunctionGroup') }}" method="GET" class="d-flex">
                                            <input type="text" class="form-control me-2" name="group_name" placeholder="Group name">
                                            <button type="submit" class="btn btn-info">Search</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-lg-4 text-center order-1 order-lg-2">
                                    <img src="assets/img/departments-1.jpg" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane active show" id="tabs-search-subsidiaries">
                            <div class="row">
                                <div class="col-lg-8 details order-2 order-lg-1">
                                    <h3>Company</h3>
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
                        <div class="tab-pane" id="tabs-search-shareholders">
                            <div class="row">
                                <div class="col-lg-8 details order-2 order-lg-1">
                                    <h3>Shareholder</h3>
                                    <!-- <p class="fst-italic">Shareholders are the owners of a corporation and have a financial interest in the company's performance and profitability. Shareholders can be individual or entities. The information about company’s shareholders can be used to identify the people responsible and rule the company.</p> -->
                                    <!-- <p class="fst-italic">Shareholders are the owners of a corporation and have a financial interest in the company's performance and profitability. Shareholders can be individual or entities. Find people/companies who own shares in several companies.</p> -->
                                    <div class="container">
                                        <form id="search-form" action="{{ route('searchFunctionShareholder') }}" method="GET" class="d-flex">
                                            <label for="search-input" class="visually-hidden">Search</label>
                                            <div class="input-group">
                                                <input type="text" id="search-input" name="shareholder_name" class="form-control" placeholder="Shareholder name">
                                                <button type="submit" class="btn btn-info">Search</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-lg-4 text-center order-1 order-lg-2">
                                    <img src="assets/img/departments-3.jpg" alt="" class="img-fluid">
                                </div>
                            </div>                                   
                        </div>
                        <div class="tab-pane" id="tabs-search-sra">                                                                         
                            <div class="row">                                               
                                <div class="col-lg-8 details order-2 order-lg-1">
                                    <h3>Sustainability Risk Analysis (SRA)</h3>
                                    <!-- <p class="fst-italic">Shareholders are the owners of a corporation and have a financial interest in the company's performance and profitability. Shareholders can be individual or entities. The information about company’s shareholders can be used to identify the people responsible and rule the company.</p> -->
                                    <!-- <p class="fst-italic">Shareholders are the owners of a corporation and have a financial interest in the company's performance and profitability. Shareholders can be individual or entities. Find people/companies who own shares in several companies.</p> -->
                                    <div class="container">
                                        <form id="search-form" action="{{ route('searchFunctionSRA') }}" method="GET" class="d-flex">
                                            <label for="search-input" class="visually-hidden">Search</label>
                                            <div class="input-group">
                                                <input type="text" id="search-input" name="group_name" class="form-control" placeholder="Group name">
                                                <button type="submit" class="btn btn-info">Search</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-lg-4 text-center order-1 order-lg-2">
                                    <img src="assets/img/departments-3.jpg" alt="" class="img-fluid">
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
    </section><!-- End Departments Sections -->

    <!-- ======= About Section ======= -->
    <section id="counts" class="counts">
        <div class="container-fluid">
            <div class="row">
                @foreach($landingPages as $landingPage)
                <div class="col-xl-6 col-lg-6 video-box d-flex justify-content-center align-items-stretch position-relative">
                    <!-- Correct the path using the storage helper -->
                    <img src="{{ asset('storage/' . $landingPage->image_corporate_profile) }}" class="img-fluid shadow" alt="Corporate Profile Image">
                </div>
    
                <div class="col-xl-6 col-lg-6 icon-boxes d-flex flex-column align-items-stretch justify-content-center py-5 px-lg-5">
                    <h3>{!! $landingPage->title_corporate_profile !!}</h3>
                    <p>{!! $landingPage->definition_corporate_profile !!}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    
    <!-- End About Section -->

    <!-- ======= About Section ======= -->
    <section id="about2" class="about2">
      <div class="container">
        @foreach($landingPages as $landingPage)
        <div class="section-title">
            <h2>Key Features</h2>
            <!-- <p>Naration</p> -->
        </div>

        <div class="row align-items-center">
        <div class="col-lg-7 align-items-stretch order-1 order-lg-2 img">
            <img src="{{ asset('storage/' . $landingPage->key_feature_image1) }}" class="img-fluid shadow" alt="">
            <p class="text-muted"><i style="font-size:10px;">*Group ownership structure figure</i></p>
        </div>
        <div class="col-lg-5 pt-4 pt-lg-0 d-flex flex-column justify-content-center">
            <h4>{!!$landingPage->key_feature_title1!!}</h4>
            <p>
                {!!$landingPage->key_feature_desc1!!}
            </p>
        </div>
        </div><br><br><br>

        <div class="row">
            <div class="col-lg-7">
                <img src="{{ asset('storage/' . $landingPage->key_feature_image2) }}" class="img-fluid shadow" alt="">
                <p class="text-muted"><i style="font-size:10px;">*Corporate profile dataset</i></p>
            </div>
            <div class="col-lg-7" hidden>
                <div class="row">
                    <div class="col-md-6">
                        <i class="bx bx-receipt" style="vertical-align: middle;"></i>
                        <p style="display: inline;">Company Name</p>
                    </div>
                    <div class="col-md-6">
                        <i class="bx bx-receipt" style="vertical-align: middle;"></i>
                        <p style="display: inline;">Group</p>
                    </div>
                    <div class="col-md-6">
                        <i class="bx bx-receipt" style="vertical-align: middle;"></i>
                        <p style="display: inline;">Shareholders</p>
                    </div>
                    <div class="col-md-6">
                        <i class="bx bx-receipt" style="vertical-align: middle;"></i>
                        <p style="display: inline;">Activity</p>
                    </div>
                    <div class="col-md-6">
                        <i class="bx bx-receipt" style="vertical-align: middle;"></i>
                        <p style="display: inline;">Status Operation</p>
                    </div>
                    <div class="col-md-6">
                        <i class="bx bx-receipt" style="vertical-align: middle;"></i>
                        <p style="display: inline;">Certification</p>
                    </div>
                    <div class="col-md-6">
                        <i class="bx bx-receipt" style="vertical-align: middle;"></i>
                        <p style="display: inline;">Address</p>
                    </div>
                    <div class="col-md-6">
                        <i class="bx bx-receipt" style="vertical-align: middle;"></i>
                        <p style="display: inline;">Other information</p>
                    </div>
                    <p class="text-muted"><i style="font-size:10px;">*Corporate profile dataset</i></p>
                </div>
            </div>
            <div class="col-lg-5 pt-4 pt-lg-0 d-flex flex-column justify-content-center">
                <h4>{!!$landingPage->key_feature_title2!!}</h4>
                <p>
                    {!!$landingPage->key_feature_desc2!!}
                </p>
            </div>
        </div><br><br><br>

        <div class="row">
          <div class="col-lg-7 align-items-stretch order-1 order-lg-2 img">
            <img src="{{ asset('storage/' . $landingPage->key_feature_image3) }}" class="img-fluid shadow" alt="">
            <p class="text-muted"><i style="font-size:10px;">*Share ownership for Individual/company</i></p>
          </div>
          <div class="col-lg-5 pt-4 pt-lg-0 d-flex flex-column justify-content-center">
            <h4>{!!$landingPage->key_feature_title3!!}</h4>
            <p>
                {!!$landingPage->key_feature_desc3!!}
            </p>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-7">
            <img src="{{ asset('storage/' . $landingPage->key_feature_image4) }}" class="img-fluid shadow" alt="">
            <p class="text-muted"><i style="font-size:10px;">*Summary of sustainability risk assessment</i></p>
          </div>
          <div class="col-lg-5 pt-4 pt-lg-0 d-flex flex-column justify-content-center">
            <h4>{!!$landingPage->key_feature_title4!!}</h4>
            <p>
                {!!$landingPage->key_feature_desc4!!}
            </p>
            <br>
          </div>
        </div>
        @endforeach
      </div>
    </section><!-- End About Section -->

    <!-- <div>
        <form action="{{ route('search') }}" method="GET">
            <input type="text" name="keyword" placeholder="Search...">
            <button type="submit">Search</button>
        </form>
    </div> -->

    <!-- ======= Counts Section ======= -->
    <section id="counts" class="counts" hidden>
      <div class="container">
        <div class="section-title">
          <h2>Corporate Profile DATASET</h2>
          <!-- <p>Naration</p> -->
        </div>

        <div class="row">

          <div class="col-lg-3 col-md-6">
            <div class="count-box">
              <i class="fas fa-hospital"></i>
              <h5><a href="">Group</a></h5>
              <p>Group</p>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 mt-5 mt-md-0">
            <div class="count-box">
              <i class="far fa-hospital"></i>
              <h5><a href="">Company Structure</a></h5>
              <p>Company Structure</p>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 mt-5 mt-lg-0">
            <div class="count-box">
              <i class="fas fa-user"></i>
              <h5><a href="">Shareholder</a></h5>
              <p>Shareholder</p>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 mt-5 mt-lg-0">
            <div class="count-box">
              <i class="fas fa-award"></i>
              <h5><a href="">Notarial Act</a></h5>
              <p>Notarial Act</p>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Counts Section -->

    <!-- ======= Services Section ======= -->
    <section id="services" class="services" hidden>
      <div class="container">

        <div class="section-title">
          <h2>Corporate Profile DATASET</h2>
          <!-- <p>Naration</p> -->
        </div>

        <div class="row">

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch mt-4">
            <div class="icon-box">
              <div class="icon"><i class="ri-database-line"></i></div>
              <h4><a href="">Group</a></h4>
              <p>Group</p>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch mt-4">
            <div class="icon-box">
              <div class="icon"><i class="ri-admin-line"></i></div>
              <h4><a href="">Shareholder</a></h4>
              <p>Shareholder of Companies</p>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch mt-4">
            <div class="icon-box">
              <div class="icon"><i class="ri-apps-line"></i></div>
              <h4><a href="">Company Structure</a></h4>
              <p>Company structure ownership</p>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch mt-4">
            <div class="icon-box">
              <div class="icon"><i class="ri-file-pdf-line"></i></div>
              <h4><a href="">Notarial Act</a></h4>
              <p>Notarial act of company</p>
            </div>
          </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-3 col-md-6 d-flex align-items-stretch mt-4">
            <div class="icon-box">
              <div class="icon"><i class="ri-phone-find-line"></i></div>
              <h4><a href="">Other dataset</a></h4>
            </div>
          </div>
        </div>

      </div>
    </section><!-- End Services Section -->

    <!-- ======= About Sections ======= -->
    <section id="about" class="about" hidden>
        <div class="container">

            <div class="row">
                <div class="col-xl-12 col-lg-12 icon-boxes d-flex flex-column align-items-stretch justify-content-center py-5 px-lg-5">
                    <h3 style="text-align: center;">Corporate Profile DATASET</h3>
                    <!-- <p style="text-align: center;">Company information.</p> -->

                    <div class="row">
                        <div class="col-md-4">
                            <div class="icon-box">
                                <div class="icon"><i class="bx bx-atom"></i></div>
                                <h4 class="title"><a href="">Company name</a></h4>
                                <p class="description">Company name</p>
                            </div>
                            <div class="icon-box">
                                <div class="icon"><i class="bx bx-atom"></i></div>
                                <h4 class="title"><a href="">Group</a></h4>
                                <p class="description">Group</p>
                            </div>
                            <div class="icon-box">
                                <div class="icon"><i class="bx bx-atom"></i></div>
                                <h4 class="title"><a href="">Shareholders</a></h4>
                                <p class="description">Shareholder of company</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="icon-box">
                                <div class="icon"><i class="bx bx-atom"></i></div>
                                <h4 class="title"><a href="">Activity</a></h4>
                                <p class="description">Main activity</p>
                            </div>
                            <div class="icon-box">
                                <div class="icon"><i class="bx bx-atom"></i></div>
                                <h4 class="title"><a href="">Location</a></h4>
                                <p class="description">Latitude Longitude</p>
                            </div>
                            <div class="icon-box">
                                <div class="icon"><i class="bx bx-atom"></i></div>
                                <h4 class="title"><a href="">Company structure</a></h4>
                                <p class="description">Company structure ownerships</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="icon-box">
                                <div class="icon"><i class="bx bx-atom"></i></div>
                                <h4 class="title"><a href="">Status operation</a></h4>
                                <p class="description">Active or Non active</p>
                            </div>
                            <div class="icon-box">
                                <div class="icon"><i class="bx bx-gift"></i></div>
                                <h4 class="title"><a href="">Planted & Facility</a></h4>
                                <p class="description">Planted area (hectare)</p>
                            </div>
                            <div class="icon-box">
                                <div class="icon"><i class="bx bx-atom"></i></div>
                                <h4 class="title"><a href="">Etc</a></h4>
                                <p class="description">Others information</p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </section><!-- End About Section -->

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