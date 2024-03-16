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
                    <li><a href="#" style="color:#4682B4;">Group</a></li>
                </ol> -->
                <!-- <h2 style="color:#4682B4;">Subsidiary</h2> -->
            </div>

            <div class="row" style="box-shadow: rgba(44, 73, 100, 0.08) 0px 2px 15px 0px;">
                <div class="col-xl-12 col-lg-6 icon-boxes d-flex flex-column align-items-stretch justify-content-center py-5 px-lg-5">

                    <table class="table table-hover">
                        <thead>
                            <th class="d-flex justify-content-between align-items-center">
                                <h4 class="title mb-0">List of Groups</h4>
                                <form action="{{ route('searchFunctionGroup2') }}" method="GET" class="d-flex">
                                    <input type="text" class="form-control me-2" name="group_name" placeholder="Search other groups">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </form>
                            </th>
                        </thead>

                        <form action="{{ route('sraShow') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if($sras->isEmpty())
                            <p>No results found.</p>
                            @else
                            @foreach($sras as $subs)
                            <tr>
                                <td>
                                    <input type="submit" name="group_name" value="{{ $subs->group_name }}" class="btn btn-light">
                                    <!-- <a href="subsidiaryShow" name="subsidiary" >{{ $subs->subsidiary }}</a> -->
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </form>
                    </table>

                    <nav aria-label="Pagination Navigation">
                        <ul class="pagination justify-content-center">

                            {{-- Previous Page Link --}}
                            @unless($sras->onFirstPage())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $sras->previousPageUrl() }}" rel="prev" aria-label="Previous">@lang('pagination.previous')</a>
                                </li>
                            @else
                                <li class="page-item disabled" aria-disabled="true" aria-label="Previous">
                                    <span class="page-link" aria-hidden="true">@lang('pagination.previous')</span>
                                </li>
                            @endunless

                            {{-- Pagination Elements --}}
                            @for ($page = max(1, $sras->currentPage() - 5); $page <= min($sras->lastPage(), $sras->currentPage() + 5); $page++)
                                @if ($page == $sras->currentPage())
                                    <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $sras->url($page) }}">{{ $page }}</a></li>
                                @endif
                            @endfor

                            {{-- Next Page Link --}}
                            @unless($sras->hasMorePages())
                                <li class="page-item disabled" aria-disabled="true" aria-label="Next">
                                    <span class="page-link" aria-hidden="true">@lang('pagination.next')</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $sras->nextPageUrl() }}" rel="next" aria-label="Next">@lang('pagination.next')</a>
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

