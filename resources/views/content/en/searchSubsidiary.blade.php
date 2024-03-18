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
                                <h4 class="title mb-0">List of Subsidiaries</h4>
                                <form action="{{ route('searchFunctionSubsidiary') }}" method="GET" class="d-flex">
                                    <input type="text" class="form-control me-2" name="query" placeholder="Search other subsidiaries">
                                    <button type="submit" class="btn btn-info">Search</button>
                                </form>
                            </th>
                        </thead>
                        <form action="{{ route('subsidiaryShow') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if($consolidations->isEmpty())
                                <p>No results found.</p>
                            @else
                                @foreach($consolidations as $subs)
                                    <tr>
                                        <td>
                                            <input type="submit" name="subsidiary" value="{{ $subs->subsidiary }}" class="btn btn-light">
                                        </td>
                                        <td>
                                            <!-- Periksa apakah $companyOwnership ada dan tidak kosong -->
                                            @if(isset($companyOwnership) && $companyOwnership->isNotEmpty())
                                                <input type="submit" name="subsidiary" value="Nama Perusahaan: {{ $companyOwnership->first()->company_name }}" class="btn btn-light">
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </form>

                    </table>

                    <nav aria-label="Pagination Navigation">
                        <ul class="pagination justify-content-center">

                            {{-- Previous Page Link --}}
                            @unless($consolidations->onFirstPage())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $consolidations->previousPageUrl() }}" rel="prev" aria-label="Previous">@lang('pagination.previous')</a>
                                </li>
                            @else
                                <li class="page-item disabled" aria-disabled="true" aria-label="Previous">
                                    <span class="page-link" aria-hidden="true">@lang('pagination.previous')</span>
                                </li>
                            @endunless

                            {{-- Pagination Elements --}}
                            @for ($page = max(1, $consolidations->currentPage() - 5); $page <= min($consolidations->lastPage(), $consolidations->currentPage() + 5); $page++)
                                @if ($page == $consolidations->currentPage())
                                    <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $consolidations->url($page) }}">{{ $page }}</a></li>
                                @endif
                            @endfor

                            {{-- Next Page Link --}}
                            @unless($consolidations->hasMorePages())
                                <li class="page-item disabled" aria-disabled="true" aria-label="Next">
                                    <span class="page-link" aria-hidden="true">@lang('pagination.next')</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $consolidations->nextPageUrl() }}" rel="next" aria-label="Next">@lang('pagination.next')</a>
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

