@extends('layout.app')

@section('headstyle')
  <!-- Favicons -->
  <link href="{{asset('template/Flexstart/assets/img/favicon.png') }}" rel="icon">
  <link href="{{asset('template/Flexstart/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
    rel="stylesheet">

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

    <section class="section faq">
    <div class="container">
      <div class="section-title">
      <h2>Frequently Asked Questions</h2>
      </div>

      <div class="row">
      <div class="col-lg-12">

        @if($faqs->isEmpty())
      <p class="text-center">No FAQs available.</p>
    @else
    <!-- F.A.Q Group 1 -->
    <div class="card">
    <div class="card-body">
      <div class="accordion accordion-flush" id="faq-group-1">

      @foreach ($faqs as $faq)
      <div class="accordion-item">
      <h2 class="accordion-header">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
      data-bs-target="#faq-{{ $loop->index }}">
      {{ $faq->question ?? 'No question available' }}
      </button>
      </h2>
      <div id="faq-{{ $loop->index }}" class="accordion-collapse collapse" data-bs-parent="#faq-group-1">
      <div class="accordion-body">
      {!! $faq->answer ?? 'No answer available' !!}
      </div>
      </div>
      </div>
    @endforeach

      </div>
    </div>
    </div><!-- End F.A.Q Group 1 -->
  @endif

      </div>
      </div>
    </div>
    </section>

  </main><!-- End #main -->
@endsection