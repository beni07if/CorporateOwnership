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
    </div><!-- End Page Title -->

    <section class="section faq">
      <div class="container">
        <div class="section-title">
          <h2>Frequently Asked Questions</h2>
        </div>

        <div class="row">
          <div class="col-lg-12">

            <!-- F.A.Q Group 1 -->
            <div class="card">
              <div class="card-body">

                <div class="accordion accordion-flush" id="faq-group-1">

                  <div class="accordion-item">
                    <h2 class="accordion-header">
                      <button class="accordion-button collapsed" data-bs-target="#faqsOne-1" type="button" data-bs-toggle="collapse">
                        Apa itu Corporate Profile?
                      </button>
                    </h2>
                    <div id="faqsOne-1" class="accordion-collapse collapse" data-bs-parent="#faq-group-1">
                      <div class="accordion-body">
                      Corporate Profile adalah platform digital yang dikembangkan untuk menyajikan informasi mengenai sebuah perusahaan yang meliputi profil perusahaan, struktur kepemilikan saham, individu ownership dan sustainability risk assessment dari perusahaan tersebut.
                      </div>
                    </div>
                  </div>

                  <div class="accordion-item">
                    <h2 class="accordion-header">
                      <button class="accordion-button collapsed" data-bs-target="#faqsOne-2" type="button" data-bs-toggle="collapse">
                      Apa saja kelebihan dari Corporate Profile?
                      </button>
                    </h2>
                    <div id="faqsOne-2" class="accordion-collapse collapse" data-bs-parent="#faq-group-1">
                      <div class="accordion-body">
                      Corporate profil menyajikan informasi yang faktual dan komprehensif mengenai 
                      <ul>
                        <li>Profil perusahaan</li>
                        <li>Struktur kepemilikan saham</li>
                        <li>Shareholder / Individual ownership</li>
                        <li>Sustainability Risk Assessment (SRA)</li>
                      </ul>
                      </div>
                    </div>
                  </div>

                  <div class="accordion-item">
                    <h2 class="accordion-header">
                      <button class="accordion-button collapsed" data-bs-target="#faqsOne-3" type="button" data-bs-toggle="collapse">
                      Apa perbedaan antara Corporate Profile dan website perusahaan lainnya?
                      </button>
                    </h2>
                    <div id="faqsOne-3" class="accordion-collapse collapse" data-bs-parent="#faq-group-1">
                      <div class="accordion-body">
                      Corporate Profile fokus pada menyajikan informasi spesifik struktur kepemilikan perusahaan, individual ownership serta penilaian SRA. Sementara website perusahaan lain tidak menampilkan informasi tersebut.
                      </div>
                    </div>
                  </div>

                  <div class="accordion-item">
                    <h2 class="accordion-header">
                      <button class="accordion-button collapsed" data-bs-target="#faqsOne-4" type="button" data-bs-toggle="collapse">
                      Bagaimana cara mengakses Corporate Profile sebuah perusahaan?
                      </button>
                    </h2>
                    <div id="faqsOne-4" class="accordion-collapse collapse" data-bs-parent="#faq-group-1">
                      <div class="accordion-body">
                      Anda dapat mengakses Corporate Profile perusahaan dengan mengunjungi website resmi perusahaan tersebut. Untuk mengakses fitur utama dari website ini anda dapat mengklik menu Feature. Untuk mengakses fitur ini anda harus login terlebih dahulu. Jika Anda belum memiliki akun, Anda dapat menghubungi tim kami di helpdesk@earthqualizer.org.
                      </div>
                    </div>
                  </div>

                  <div class="accordion-item">
                    <h2 class="accordion-header">
                      <button class="accordion-button collapsed" data-bs-target="#faqsOne-5" type="button" data-bs-toggle="collapse">
                      Apakah Corporate Profile tersedia untuk semua sektor industri?
                      </button>
                    </h2>
                    <div id="faqsOne-5" class="accordion-collapse collapse" data-bs-parent="#faq-group-1">
                      <div class="accordion-body">
                      Untuk saat ini mayoritas perusahaan yang masuk dalam corporate profil adalah yang bergerak di industri kelapa sawit, dan sebagian yang lain dari industri ekstraksi lainnya.
                      </div>
                    </div>
                  </div>

                  <div class="accordion-item">
                    <h2 class="accordion-header">
                      <button class="accordion-button collapsed" data-bs-target="#faqsOne-6" type="button" data-bs-toggle="collapse">
                      Bagaimana cara menemukan informasi lebih lanjut tentang sebuah perusahaan melalui Corporate Profile?
                      </button>
                    </h2>
                    <div id="faqsOne-6" class="accordion-collapse collapse" data-bs-parent="#faq-group-1">
                      <div class="accordion-body">
                      Untuk informasi lebih lanjut Anda dapat menghubungi tim kami di helpdesk@earthqualizer.org.
                      </div>
                    </div>
                  </div>

                  <div class="accordion-item">
                    <h2 class="accordion-header">
                      <button class="accordion-button collapsed" data-bs-target="#faqsOne-7" type="button" data-bs-toggle="collapse">
                      Apa itu SRA?
                      </button>
                    </h2>
                    <div id="faqsOne-7" class="accordion-collapse collapse" data-bs-parent="#faq-group-1">
                      <div class="accordion-body">
                      Sustainability Risk Assessment (SRA) adalah penilaian sistematis berbasis grup untuk mengidentifikasi, analisis, dan mengelola risiko yang berdampak pada keberlanjutan dari perusahaan.
                      </div>
                    </div>
                  </div>

                  <div class="accordion-item">
                    <h2 class="accordion-header">
                      <button class="accordion-button collapsed" data-bs-target="#faqsOne-8" type="button" data-bs-toggle="collapse">
                      Apa Metode yang digunakan dalam SRA?
                      </button>
                    </h2>
                    <div id="faqsOne-8" class="accordion-collapse collapse" data-bs-parent="#faq-group-1">
                      <div class="accordion-body">
                      ..
                      </div>
                    </div>
                  </div>

                  <div class="accordion-item">
                    <h2 class="accordion-header">
                      <button class="accordion-button collapsed" data-bs-target="#faqsOne-9" type="button" data-bs-toggle="collapse">
                      Apa manfaat dari SRA?
                      </button>
                    </h2>
                    <div id="faqsOne-9" class="accordion-collapse collapse" data-bs-parent="#faq-group-1">
                      <div class="accordion-body">
                      ..
                      </div>
                    </div>
                  </div>

                  <div class="accordion-item">
                    <h2 class="accordion-header">
                      <button class="accordion-button collapsed" data-bs-target="#faqsOne-10" type="button" data-bs-toggle="collapse">
                      Jika berlangganan, informasi apa saja yang kami dapatkan?
                      </button>
                    </h2>
                    <div id="faqsOne-10" class="accordion-collapse collapse" data-bs-parent="#faq-group-1">
                      <div class="accordion-body">
                      ..
                      </div>
                    </div>
                  </div>

                </div>

              </div>
            </div><!-- End F.A.Q Group 1 -->

          </div>

        </div>
      </div>
    </section>

</main><!-- End #main -->
@endsection
