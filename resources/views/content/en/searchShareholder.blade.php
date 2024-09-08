@extends('layout.app')

@section('styleMaps')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.css" />
@endsection

@section('content')
<main id="main">
<!-- ======= Doctors Section ======= -->
<section id="doctors" class="doctors">
    <div class="container">
        <div class="section-title">
            <h2>Shareholdings</h2>
            <P>Search results from "{{$shareholder}}"</P>
        </div>
        <div class="row pb-3">
            <form action="{{ route('searchFunctionShareholder') }}" method="GET" class="d-flex ms-auto" style="width: 33%;">
                <input type="text" class="form-control me-2" name="shareholder_name" placeholder="Search for other shareholder">
                <button type="submit" class="btn btn-info">Search</button>
            </form>
        </div>
        <div class="row">
            @if($shareholderNames->isNotEmpty())
                @foreach($shareholderNames as $subs)
                <div class="col-lg-6 mb-4">
                    <div class="member d-flex flex-column align-items-start card">
                        <div class="pic">
                            <img src="assets/img/doctors/doctors-1.jpg" class="img-fluid" alt="">
                        </div>
                        <div class="member-info flex-fill d-flex flex-column justify-content-between">
                            <div class="d-flex align-items-center mb-1">
                                <form action="{{ route('shareholderShow') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    {{-- <h4 style="margin-right: 10px;">
                                        <input type="submit" name="group_name" value="{{ $subs->group_name }}" 
                                            style="background-color: transparent; border: none; font-weight:bold; color: #106587; cursor: pointer; 
                                                    transition: color 0.3s;" 
                                            onmouseover="this.style.color='#007BFF'" onmouseout="this.style.color='inherit'">
                                    </h4> --}}
                                    
                                    <input type="hidden" name="shareholder_name" value="{{ $subs->shareholder_name }}">
                                    <input type="hidden" name="date_of_birth" value="{{ $subs->date_of_birth }}"> <!-- Add date of birth -->
                                    <h4 class="card-title mb-0 pt-2"> <!-- mb-0 to remove extra margin -->
                                        <input type="hidden" name="subsidiary" value="{{ $subs->shareholder_name }}">
                                        <button type="submit" style="background: none; border: none; font-weight:bold; color: #106587; font-size:17px; color: #117b99; cursor: pointer; font-weight: bold; transition: color 0.3s;" 
                                                onmouseover="this.style.color='#007BFF';" onmouseout="this.style.color='#012970';">
                                            {!! nl2br(e($subs->shareholder_name)) !!}
                                        </button>
                                    </h4>
                                </form>
                            </div>
                            <p class="mb-1 pl-2">Date of birth: {{ $subs->date_of_birth ?? '' }}</p> <!-- Add mb-1 to reduce the gap between lines -->
                            <p class="mb-1 pl-2">Address: {{ $subs->address ?? '' }}</p> <!-- Add mb-1 to reduce the gap between lines -->
                            
                            <div style="display: inline;">
                                <p class="pl-2" style="display: inline; vertical-align: middle;">Share ownership in the company </p>
                                <form action="{{ route('subsidiaryShow') }}" method="POST" style="display: inline; vertical-align: middle;">
                                    @csrf
                                    <input type="hidden" name="subsidiary" value="{{ $subs->company_name }}">
                                    <button type="submit" style="background: none; border: none; font-size:15px; color: #82bfd9; cursor: pointer; font-weight: bold; display: inline; vertical-align: middle; transition: color 0.3s;" 
                                            onmouseover="this.style.color='#007BFF';" onmouseout="this.style.color='#012970';">
                                        {!! nl2br(e($subs->company_name)) !!}
                                    </button>
                                </form>
                            </div>
                            
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="col-12">
                    <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                        <h4 class="alert-heading">Data Not Found</h4>
                        <p>Data not found, please enter the correct keywords.</p>
                        <hr>
                        <p class="mb-0">Please contact us for more information at <i><b>helpdesk@earthqualizer.org</b></i></p>
                    </div>
                </div>
            @endif
            {{-- <a href="{{ url()->previous() }}">
                <span>Return to previous page</span>
            </a> --}}

            <!-- Pagination -->
            @if($shareholderNames->hasPages())
                <div class="pagination-wrapper d-flex justify-content-center mt-4">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <!-- Previous Page Link -->
                            @if ($shareholderNames->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $shareholderNames->previousPageUrl() }}" rel="prev">&laquo;</a></li>
                            @endif

                            <!-- Pagination Elements -->
                            @php
                                $currentPage = $shareholderNames->currentPage();
                                $lastPage = $shareholderNames->lastPage();
                                $startPage = max(1, $currentPage - 2); // Start 2 pages before the current
                                $endPage = min($lastPage, $currentPage + 2); // End 2 pages after the current
                            @endphp

                            <!-- First Page Link if current page is greater than 3 -->
                            @if($startPage > 1)
                                <li class="page-item"><a class="page-link" href="{{ $shareholderNames->url(1) }}">1</a></li>
                                @if($startPage > 2)
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                @endif
                            @endif

                            <!-- Page Links -->
                            @for ($page = $startPage; $page <= $endPage; $page++)
                                @if ($page == $currentPage)
                                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $shareholderNames->url($page) }}">{{ $page }}</a></li>
                                @endif
                            @endfor

                            <!-- Last Page Link if current page is not close to the last -->
                            @if($endPage < $lastPage)
                                @if($endPage < $lastPage - 1)
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                @endif
                                <li class="page-item"><a class="page-link" href="{{ $shareholderNames->url($lastPage) }}">{{ $lastPage }}</a></li>
                            @endif

                            <!-- Next Page Link -->
                            @if ($shareholderNames->hasMorePages())
                                <li class="page-item"><a class="page-link" href="{{ $shareholderNames->nextPageUrl() }}" rel="next">&raquo;</a></li>
                            @else
                                <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                            @endif
                        </ul>
                    </nav>
                </div>
            @endif
        </div>
    </div>
    
</section><!-- End Doctors Section -->
    <!-- Leaflet JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.js" integrity="sha384-dRnG3QipUv9zvMAkW8XVg+heW0jhvccrGM6yDNC4uK+xmqvBnp+0xuL50PYs10n/" crossorigin=""></script>

</main><!-- End #main -->
@endsection

