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
                                <h4 class="title mb-0">LIST OF SUBSIDIARY</h4>
                                <form action="{{ route('searchFunctionSubsidiary') }}" method="GET" class="d-flex">
                                    <input type="text" class="form-control me-2" name="query" placeholder="Search other subsidiaries">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </form>
                            </th>
                        </thead>
                        <form action="{{ route('otherCompanyShow') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if($otherCompanies->isEmpty())
                                <p>No results found.</p>
                            @else
                                @foreach($otherCompanies as $subs)
                                    <tr>
                                        <td>
                                            <input type="submit" name="badan_hukum" value="{{ $subs->badan_hukum }}" class="btn btn-light">
                                        </td>
                                        <td>
                                            <!-- Periksa apakah $companyOwnership ada dan tidak kosong -->
                                            @if(isset($companyOwnership) && $companyOwnership->isNotEmpty())
                                                <input type="submit" name="badan_hukum" value="Nama Perusahaan: {{ $companyOwnership->first()->badan_hukum }}" class="btn btn-light">
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </form>
                    </table>
                    <i class="text-muted">*Note: Data source from Berita Negara</i>

                    <nav aria-label="Pagination Navigation">
                        <ul class="pagination justify-content-center">

                            {{-- Previous Page Link --}}
                            @unless($otherCompanies->onFirstPage())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $otherCompanies->previousPageUrl() }}" rel="prev" aria-label="Previous">@lang('pagination.previous')</a>
                                </li>
                            @else
                                <li class="page-item disabled" aria-disabled="true" aria-label="Previous">
                                    <span class="page-link" aria-hidden="true">@lang('pagination.previous')</span>
                                </li>
                            @endunless

                            {{-- Pagination Elements --}}
                            @for ($page = max(1, $otherCompanies->currentPage() - 5); $page <= min($otherCompanies->lastPage(), $otherCompanies->currentPage() + 5); $page++)
                                @if ($page == $otherCompanies->currentPage())
                                    <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $otherCompanies->url($page) }}">{{ $page }}</a></li>
                                @endif
                            @endfor

                            {{-- Next Page Link --}}
                            @unless($otherCompanies->hasMorePages())
                                <li class="page-item disabled" aria-disabled="true" aria-label="Next">
                                    <span class="page-link" aria-hidden="true">@lang('pagination.next')</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $otherCompanies->nextPageUrl() }}" rel="next" aria-label="Next">@lang('pagination.next')</a>
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

