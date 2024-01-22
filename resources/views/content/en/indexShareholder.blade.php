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

            @if(!$shareholderNames->isEmpty() && $shareholderNames[0]->position && $shareholderNames[0]->position !== '-')
                <div class="row" style="box-shadow: rgba(44, 73, 100, 0.08) 0px 2px 15px 0px; pd-top:30px;">
            @endif
                <div class="col-lg-12">
                    <div class="member d-flex align-items-start p-4 p-mt-5">
                        <div class="pic"><img src="{{asset('img/EqQ.png')}}" class="img-fluid" alt=""></div>
                        <div class="member-info">
                            @if(!$shareholderNames->isEmpty())
                                @if($shareholderNames[0]->position && $shareholderNames[0]->position !== '-')
                                    <h4>{{ ucwords(strtolower($shareholderNames[0]->shareholder_name)) }}</h4>
                                    <span>{{ ucwords(strtolower($shareholderNames[0]->position)) }}</span>
                                    <p>
                                        {{ ucwords(strtolower($shareholderNames[0]->shareholder_name)) }} is a 
                                        <!-- {{ $shareholderNames[0]->country_of_registered_address }}  -->
                                        businessperson 
                                        who has held leadership positions, including
                                        @if($shareholderNames->unique('company_name')->count() > 1)
                                            @foreach($shareholderNames->unique('company_name') as $subs)
                                                {{ ucwords(strtolower($subs->position)) }} at {{ $subs->company_name }}@if($loop->last), and currently is
                                                @elseif($loop->iteration < $shareholderNames->unique('company_name')->count()), @else and @endif
                                            @endforeach
                                        @endif
                                        {{ ucwords(strtolower($shareholderNames->unique('company_name')->last()->position)) }} at {{ $shareholderNames->unique('company_name')->last()->company_name }}.
                                    </p>
                                @else
                                    <!-- <p>No results found.</p> -->
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            @if(!$shareholderNames->isEmpty() && $shareholderNames[0]->position && $shareholderNames[0]->position !== '-')
                </div>
            @endif

            <div class="row" style="box-shadow: rgba(44, 73, 100, 0.08) 0px 2px 15px 0px;">
                <div class="col-xl-12 col-lg-6 icon-boxes d-flex flex-column align-items-stretch justify-content-center py-5 px-lg-5">
                    
                    <table class="table table-hover">
                    <thead>
                        <th class="d-flex justify-content-between align-items-center">
                            @foreach($shareholderNames as $subs)
                                @if($loop->first)
                                    <h4>Ownership of shares from {{ ucwords(strtolower($shareholderNames[0]->shareholder_name)) }}</h4>
                                @endif
                            @endforeach

                            <form action="{{ route('searchFunctionShareholder') }}" method="GET" class="d-flex">
                                <input type="text" class="form-control me-2" name="query" placeholder="Search other Shareholders">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </form>
                        </th>
                    </thead>

                        @if($shareholderNames->isEmpty())
                            <p>No results found.</p>
                            @else
                            <table class="table">
                                <thead>
                                    <tr>
                                        <!-- <th>No</th> -->
                                        <th>Shareholder Name</th>
                                        <th>Identification Number</th>
                                        <th>Nationality</th>
                                        <th>Number of Shares</th>
                                        <th>Currency</th>
                                        <th>Address Change</th>
                                        <th>Source of Address</th>
                                        <th>Address</th>
                                        <th>Company Name</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($shareholderNames as $subs)
                                        @if($subs->percentage_of_shares !== '0.00%' && $subs->percentage_of_shares !== '0%')
                                            <tr>
                                                <!-- <td>{{ $loop->iteration }}</td> -->
                                                <td>{{ $subs->shareholder_name }}</td>
                                                <td>{{ $subs->company_number }}</td>
                                                <td>{{ $subs->country_of_business_address }}</td>
                                                <td>{{ $subs->percentage_of_shares }}</td>
                                                <td>{{ $subs->currency }}</td>
                                                <td>{{ $subs->incorporation_date }}</td>
                                                <td>{{ $subs->country_of_registered_address }}</td>
                                                <td>{{ $subs->address }}</td>
                                                <td>
                                                    <form action="{{ route('subsidiaryShow') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="subsidiary" value="{{ $subs->company_name }}">
                                                        <button type="submit" class="btn btn-link">{{ $subs->company_name }}</button>
                                                    </form>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                        Details
                                                    </button>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>

                            </table>
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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Ownership of shares from &nbsp; @foreach($shareholderNames as $subs)
                                @if($loop->first)
                                    <h4 class="title mb-0"> {{ $subs->shareholder_name }}</h4>
                                @endif
                            @endforeach</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <div class="card" style="width: 100%;">
                <div class="card-body row">
                @foreach($shareholderNames as $subs)
                    <div class="col-6">
                        <h6 class="card-title text-muted">Shareholder Name</h6>
                        <p class="card-text">{{ $subs->shareholder_name }}</p>
                        <h6 class="card-title text-muted">Date of Birth</h6>
                        <p class="card-text">...</p>
                        <h6 class="card-title text-muted">IC Passport Comp Number</h6>
                        <p class="card-text">...</p>
                        <h6 class="card-title text-muted">Position</h6>
                        <p class="card-text">...</p>
                        <h6 class="card-title text-muted">Number of Shares</h6>
                        <p class="card-text">...</p>
                        <h6 class="card-title text-muted">Currency</h6>
                        <p class="card-text">...</p>
                        <h6 class="card-title text-muted">Company Name</h6>
                        <p class="card-text">...</p>
                        <h6 class="card-title text-muted">Company Type</h6>
                        <p class="card-text">...</p>
                        <h6 class="card-title text-muted">Company Number</h6>
                        <p class="card-text">...</p>
                        <h6 class="card-title text-muted">Incorporation Date</h6>
                        <p class="card-text">...</p>
                    </div>
                    <div class="col-6">
                        <h6 class="card-title text-muted">Date Company Number</h6>
                        <p class="card-text">...</p>
                        <h6 class="card-title text-muted">Change Company Number</h6>
                        <p class="card-text">...</p>
                        <h6 class="card-title text-muted">Date Change Company Number</h6>
                        <p class="card-text">...</p>
                        <h6 class="card-title text-muted">Registered Address</h6>
                        <p class="card-text">...</p>
                        <h6 class="card-title text-muted">Country of Registered Address</h6>
                        <p class="card-text">...</p>
                        <h6 class="card-title text-muted">Business Address</h6>
                        <p class="card-text">...</p>
                        <h6 class="card-title text-muted">Country of Business Address</h6>
                        <p class="card-text">...</p>
                        <h6 class="card-title text-muted">Nature of Business</h6>
                        <p class="card-text">...</p>
                        <h6 class="card-title text-muted">Taxpayer Identification Number</h6>
                        <p class="card-text">...</p>
                        <h6 class="card-title text-muted">Data Source</h6>
                        <p class="card-text">...</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>
</div>
@endsection

