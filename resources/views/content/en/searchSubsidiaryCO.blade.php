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
                    
                    <table class="table">
                        <thead>
                            <th class="d-flex justify-content-between align-items-center">
                                <h4 class="title mb-0">Search Result for Company</h4>
                                <form action="{{ route('searchFunctionSubsidiary') }}" method="GET" class="d-flex">
                                    <input type="text" class="form-control me-2" name="query" placeholder="Search other subsidiaries">
                                    <button type="submit" class="btn btn-info">Search</button>
                                </form>
                            </th>
                        </thead>

                        <form action="{{ route('subsidiaryShow') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                                @if($companyOwnerships->isNotEmpty())
                                    @foreach($companyOwnerships->chunk(2) as $pair)  <!-- Chunk the companyOwnerships into pairs -->
                                        <tr>
                                            @foreach($pair as $subs)
                                                <td>
                                                    <h4><input type="submit" name="subsidiary" value="{{ $subs->company_name }}" style="background-color: transparent; border: none; color: inherit; cursor: pointer; transition: color 0.3s;" onmouseover="this.style.color='#007BFF'" onmouseout="this.style.color='inherit'"></h4>
                                                    <span class="pl-2">{{ $subs->country_of_registered_address }}</span>
                                                    <p class="pl-2">{{ $subs->registered_address }}</p>
                                                </td>
                                            @endforeach
                                            <!-- Fill in empty cells if there is an odd number of entries -->
                                            @if(count($pair) == 1)
                                                <td></td>
                                            @endif
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="2">
                                            <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                                                <h4 class="alert-heading">Data Not Found</h4>
                                                <p>Data not found, please enter the correct keywords.</p>
                                                <hr>
                                                <p class="mb-0">Please contact Us for more information at <i><b>helpdesk@earthqualizer.org</b></i></p>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                        </form>
                    </table>
                    {{-- <a href="{{ url()->previous() }}">
                        <span>Return to previous page</span>
                    </a> --}}

                    <nav aria-label="Pagination Navigation">
                        <ul class="pagination justify-content-center">

                            {{-- Previous Page Link --}}
                            @unless($companyOwnerships->onFirstPage())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $companyOwnerships->previousPageUrl() }}" rel="prev" aria-label="Previous">@lang('pagination.previous')</a>
                                </li>
                            @else
                                <li class="page-item disabled" aria-disabled="true" aria-label="Previous">
                                    <span class="page-link" aria-hidden="true">@lang('pagination.previous')</span>
                                </li>
                            @endunless

                            {{-- Pagination Elements --}}
                            @for ($page = max(1, $companyOwnerships->currentPage() - 5); $page <= min($companyOwnerships->lastPage(), $companyOwnerships->currentPage() + 5); $page++)
                                @if ($page == $companyOwnerships->currentPage())
                                    <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $companyOwnerships->url($page) }}">{{ $page }}</a></li>
                                @endif
                            @endfor

                            {{-- Next Page Link --}}
                            @unless($companyOwnerships->hasMorePages())
                                <li class="page-item disabled" aria-disabled="true" aria-label="Next">
                                    <span class="page-link" aria-hidden="true">@lang('pagination.next')</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $companyOwnerships->nextPageUrl() }}" rel="next" aria-label="Next">@lang('pagination.next')</a>
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
