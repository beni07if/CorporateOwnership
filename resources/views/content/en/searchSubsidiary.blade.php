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
            <h2>Company</h2>
            <p>Search results for "{{ $query }}"</p>
        </div>
        <div class="row pb-3 justify-content-center">
            <form action="{{ route('searchFunctionSubsidiary') }}" method="GET" class="d-flex" style="width: 33%; background-color: #f8f9fa; border-radius: 10px; padding: 15px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                <input type="text" class="form-control me-2" name="subsidiary_name" placeholder="Search for other subsidiary company" style="border: 1px solid #007bff; border-radius: 5px;">
                <button type="submit" class="btn btn-info" style="border-radius: 5px; transition: background-color 0.3s;">
                    Search
                </button>
            </form>
        </div>
        
        <div class="row">
            @if($companyOwnerships->isNotEmpty())
            @foreach($companyOwnerships as $subs)
            <div class="col-lg-6 mb-4">
                <div class="member d-flex flex-column align-items-start card">
                    <div class="pic">
                        <img src="{{ asset('assets/img/doctors/doctors-1.jpg') }}" class="img-fluid" alt="">
                    </div>
                    <div class="member-info flex-fill d-flex flex-column justify-content-between">
                        <div class="d-flex align-items-center mb-2">
                            <form action="{{ route('subsidiaryShow') }}" method="POST">
                                @csrf
                                <h4 style="margin-right: 10px;">
                                    <input type="submit" name="subsidiary" value="{{ $subs->company_name }}" 
                                        style="background-color: transparent; border: none; font-weight:bold; color: #106587; cursor: pointer; 
                                                transition: color 0.3s;" 
                                        onmouseover="this.style.color='#007BFF'" onmouseout="this.style.color='inherit'">
                                </h4>
                            </form>
                        </div>
                        <p>Location: {{ $subs->country_operation ?? 'N/A' }}, {{ $subs->province ?? '' }}</p>
                        <p>Address: {{ $subs->registered_address ?? 'N/A' }}</p>
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
        </div>
    
        <!-- Pagination -->
        @if($companyOwnerships->hasPages())
        <div class="pagination-wrapper d-flex justify-content-center mt-4">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <!-- Previous Page Link -->
                    @if ($companyOwnerships->onFirstPage())
                        <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $companyOwnerships->previousPageUrl() }}" rel="prev">&laquo;</a></li>
                    @endif

                    <!-- Pagination Elements -->
                    @php
                        $currentPage = $companyOwnerships->currentPage();
                        $lastPage = $companyOwnerships->lastPage();
                        $startPage = max(1, $currentPage - 2); // Start 2 pages before the current
                        $endPage = min($lastPage, $currentPage + 2); // End 2 pages after the current
                    @endphp

                    <!-- First Page Link if current page is greater than 3 -->
                    @if($startPage > 1)
                        <li class="page-item"><a class="page-link" href="{{ $companyOwnerships->url(1) }}">1</a></li>
                        @if($startPage > 2)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif
                    @endif

                    <!-- Page Links -->
                    @for ($page = $startPage; $page <= $endPage; $page++)
                        @if ($page == $currentPage)
                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $companyOwnerships->url($page) }}">{{ $page }}</a></li>
                        @endif
                    @endfor

                    <!-- Last Page Link if current page is not close to the last -->
                    @if($endPage < $lastPage)
                        @if($endPage < $lastPage - 1)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif
                        <li class="page-item"><a class="page-link" href="{{ $companyOwnerships->url($lastPage) }}">{{ $lastPage }}</a></li>
                    @endif

                    <!-- Next Page Link -->
                    @if ($companyOwnerships->hasMorePages())
                        <li class="page-item"><a class="page-link" href="{{ $companyOwnerships->nextPageUrl() }}" rel="next">&raquo;</a></li>
                    @else
                        <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                    @endif
                </ul>
                <!-- Information about the total results -->
                {{-- <p class="mt-3">Showing {{ $companyOwnerships->firstItem() }} to {{ $companyOwnerships->lastItem() }} 
                    of {{ $companyOwnerships->total() }} results
                </p> --}}
            </nav>
        </div>
        @endif
        
    </div>
    
</section><!-- End Doctors Section -->

    <!-- Leaflet JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.js" integrity="sha384-dRnG3QipUv9zvMAkW8XVg+heW0jhvccrGM6yDNC4uK+xmqvBnp+0xuL50PYs10n/" crossorigin=""></script>

</main><!-- End #main -->
@endsection

