@extends('layout.app')

@section('styleMaps')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.css" />
@endsection

@section('content')
<main id="main">

    <!-- ======= About Section ======= -->
    <section id="about" class="about">
        <!-- <div class="container-fluid"> -->
        <div class="container">
            <div class="breadcrumbs" style="padding-left: 40px; background-color:white;">
                <!-- <ol style="color:#4682B4;">
                    <li><a href="#" style="color:#4682B4;">Home</a></li>
                    <li><a href="#" style="color:#4682B4;">Indonesia</a></li>
                    <li><a href="#" style="color:#4682B4;">Corporate Profile</a></li>
                    <li><a href="#" style="color:#4682B4;">Subsidiary</a></li>
                </ol> -->
                <!-- <h2 style="color:#4682B4;">Subsidiary</h2> -->
            </div>

            <div class="row" style="box-shadow: rgba(44, 73, 100, 0.08) 0px 2px 15px 0px;">
                <div class="col-xl-12 col-lg-6 icon-boxes d-flex flex-column align-items-stretch justify-content-center py-5 px-lg-5">
                    
                    <table class="table table-hover">
                        <thead>
                            <th class="d-flex justify-content-between align-items-center">
                                <!-- @foreach($shareholderNames as $subs)
                                    @if($loop->first)
                                        <h4 class="title mb-0">Ownership of shares from {{ $subs->shareholder_name }}</h4>
                                    @endif
                                @endforeach
                                <form action="{{ route('searchFunctionShareholder') }}" method="GET" class="d-flex">
                                    <input type="text" class="form-control me-2" name="query" placeholder="Search other Shareholders">
                                    <button type="submit" class="btn btn-info">Search</button>
                                </form> -->

                                <h4 class="title mb-0">LIST OF SHAREHOLDERS</h4>
                                <form action="{{ route('searchFunctionShareholder') }}" method="GET" class="d-flex">
                                    <input type="text" class="form-control me-2" name="query" placeholder="Search other subsidiaries">
                                    <button type="submit" class="btn btn-info">Search</button>
                                </form>
                            </th>
                        </thead>
                        @if($shareholderNames->isNotEmpty())
                        <table class="table">
                                <thead>
                                    <tr>
                                        <th>Shareholder Name</th>
                                        <th>Company Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($shareholderNames as $subs)
                                        <tr>
                                            <td>
                                                <form action="{{ route('shareholderShow') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="shareholder_name" value="{{ $subs->shareholder_name }}">
                                                    <button type="submit" class="btn btn-light">{{ $subs->shareholder_name }} </button>
                                                </form>
                                            </td>
                                            <td>
                                                <form action="{{ route('subsidiaryShow') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="subsidiary" value="{{ $subs->company_name }}">
                                                    <button type="submit" class="btn btn-light">{{ $subs->company_name }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                        <tr>
                            <td colspan="2">
                            <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                                <h4 class="alert-heading">Data Not Found</h4>
                                <p>Data not found, please enter the correct keywords.</p>
                                <hr>
                                <p class="mb-0">Please contact Us for more information at <i><b>helpdesk@earthqualizer.org</b></i></p>
                                <!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
                            </div>
                            </td>
                        </tr>
                        @endif

                    </table>

                    <nav aria-label="Pagination Navigation">
                        <ul class="pagination justify-content-center">

                            {{-- Previous Page Link --}}
                            @unless($shareholderNames->onFirstPage())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $shareholderNames->previousPageUrl() }}" rel="prev" aria-label="Previous">@lang('pagination.previous')</a>
                                </li>
                            @else
                                <li class="page-item disabled" aria-disabled="true" aria-label="Previous">
                                    <span class="page-link" aria-hidden="true">@lang('pagination.previous')</span>
                                </li>
                            @endunless

                            {{-- Pagination Elements --}}
                            @for ($page = max(1, $shareholderNames->currentPage() - 5); $page <= min($shareholderNames->lastPage(), $shareholderNames->currentPage() + 5); $page++)
                                @if ($page == $shareholderNames->currentPage())
                                    <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $shareholderNames->url($page) }}">{{ $page }}</a></li>
                                @endif
                            @endfor

                            {{-- Next Page Link --}}
                            @unless($shareholderNames->hasMorePages())
                                <li class="page-item disabled" aria-disabled="true" aria-label="Next">
                                    <span class="page-link" aria-hidden="true">@lang('pagination.next')</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $shareholderNames->nextPageUrl() }}" rel="next" aria-label="Next">@lang('pagination.next')</a>
                                </li>
                            @endunless

                        </ul>
                    </nav>

                </div>
            </div>

        </div>
    </section><!-- End About Section -->

    <!-- Leaflet JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.js" integrity="sha384-dRnG3QipUv9zvMAkW8XVg+heW0jhvccrGM6yDNC4uK+xmqvBnp+0xuL50PYs10n/" crossorigin=""></script>

</main><!-- End #main -->
@endsection

