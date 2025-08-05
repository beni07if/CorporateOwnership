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
        <style>
        .custom-faq-container {
        margin: 20px 0;
        }

        .custom-faq-item {
        border-bottom: 1px solid #ddd;
        padding: 10px 0;
        }

        .custom-faq-question {
        cursor: pointer;
        font-weight: bold;
        margin: 0;
        position: relative;
        }

        .custom-faq-question::after {
        content: '+';
        position: absolute;
        right: 0;
        font-weight: normal;
        }

        .custom-faq-question.open::after {
        content: '-';
        }

        .custom-faq-answer {
        display: none;
        margin-top: 8px;
        color: #555;
        }

        .custom-faq-answer.show {
        display: block;
        }
        </style>

        <div class="custom-faq-container">
        @foreach ($faqs as $faq)
      <div class="custom-faq-item">
        <p class="custom-faq-question" onclick="toggleFaqAnswer({{ $loop->index }})"
        id="custom-faq-question-{{ $loop->index }}">
        {!! $faq->question ?? 'No question available' !!}
        </p>
        <div class="custom-faq-answer" id="custom-faq-answer-{{ $loop->index }}">
        {!! $faq->answer ?? 'No answer available' !!}
        </div>
      </div>
      @endforeach
        </div>

        <script>
        function toggleFaqAnswer(index) {
        var question = document.getElementById("custom-faq-question-" + index);
        var answer = document.getElementById("custom-faq-answer-" + index);

        // Toggle class for visual state
        question.classList.toggle("open");
        answer.classList.toggle("show");
        }
        </script>
      @endif

      </div>
      </div>
    </div>
    </section>

  </main><!-- End #main -->
@endsection