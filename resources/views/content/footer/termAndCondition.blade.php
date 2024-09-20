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

    <!-- ======= Services Section ======= -->
    <section id="services" class="services">
      <div class="container">

        <div class="section-title">
          @foreach($termAndCondition as $term)
            <h2>{!!$term->title!!}</h2>
          @endforeach
        </div>
        <div class="text-justify">
          @foreach($termAndCondition as $term)
            {!!$term->description!!}
            {!!$term->agreement!!} <br>
            {!!$term->description2!!}
          @endforeach
        </div>

      </div>
    </section><!-- End Services Section -->

</main><!-- End #main -->
@endsection
