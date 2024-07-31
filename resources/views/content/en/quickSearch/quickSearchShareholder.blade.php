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
                                <h4 class="title mb-0">List of Shareholder</h4>
                                <form action="{{ route('searchFunctionQuickShareholder') }}" method="GET" class="d-flex">
                                    <input type="text" class="form-control me-2" name="shareholder_name" placeholder="Search other shareholder">
                                    <button type="submit" class="btn btn-info">Search</button>
                                </form>
                            </th>
                        </thead>
                        <form action="{{ route('shareholderShow') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                                @if($shareholder->isNotEmpty())
                                    @foreach($shareholder->chunk(2) as $pair)  <!-- Chunk the groups into pairs -->
                                        <tr>
                                            @foreach($pair as $subs)
                                                <td>
                                                    <h4><input type="submit" name="shareholder" value="{{ $subs->shareholder_name}}" style="background-color: transparent; border: none; color: inherit; ursor: pointer;"></h4>
                                                    <span class="pl-2">{{ $subs->company_name }}</span>
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

                    <nav aria-label="Pagination Navigation">
                        <ul class="pagination justify-content-center">

                            {{-- Previous Page Link --}}
                            @unless($shareholder->onFirstPage())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $shareholder->previousPageUrl() }}" rel="prev" aria-label="Previous">@lang('pagination.previous')</a>
                                </li>
                            @else
                                <li class="page-item disabled" aria-disabled="true" aria-label="Previous">
                                    <span class="page-link" aria-hidden="true">@lang('pagination.previous')</span>
                                </li>
                            @endunless

                            {{-- Pagination Elements --}}
                            @for ($page = max(1, $shareholder->currentPage() - 5); $page <= min($shareholder->lastPage(), $shareholder->currentPage() + 5); $page++)
                                @if ($page == $shareholder->currentPage())
                                    <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $shareholder->url($page) }}">{{ $page }}</a></li>
                                @endif
                            @endfor

                            {{-- Next Page Link --}}
                            @unless($shareholder->hasMorePages())
                                <li class="page-item disabled" aria-disabled="true" aria-label="Next">
                                    <span class="page-link" aria-hidden="true">@lang('pagination.next')</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $shareholder->nextPageUrl() }}" rel="next" aria-label="Next">@lang('pagination.next')</a>
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

