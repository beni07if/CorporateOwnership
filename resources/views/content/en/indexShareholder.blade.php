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
            @if(count($shareholderNames)>0)
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
                                    <h4>{{ ucwords(strtolower($shareholderNames[0]->shareholder_name)) }} Shares Ownership</h4>
                                @endif
                            @endforeach
                            <form action="{{ route('searchFunctionShareholder') }}" method="GET" class="d-flex">
                                <input type="text" class="form-control me-2" name="query" placeholder="Search other Shareholders">
                                <button type="submit" class="btn btn-info">Search</button>
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
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>Number of Shares</th>
                                        <th>Total of Shares</th>
                                        <th>Percentage of Shares</th>
                                        <th>Company Name</th>
                                        <th>Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($shareholderNames as $subs)
                                        @if($subs->percentage_of_shares !== '0.00%' && $subs->percentage_of_shares !== '0%')
                                            <tr>
                                                <!-- <td>{{ $loop->iteration }}</td> -->
                                                <td>{{ $subs->shareholder_name }}</td>
                                                <td>{{ $subs->position }}</td>
                                                <td>{{ $subs->number_of_shares }}</td>
                                                <td>{{ $subs->total_of_shares }}</td>
                                                <td>{{ $subs->percentage_of_shares }}</td>
                                                <td>
                                                    <form action="{{ route('subsidiaryShow') }}" method="POST" style="text-align:left;">
                                                        @csrf
                                                        <input type="hidden" name="subsidiary" value="{{ $subs->company_name }}">
                                                        <button type="submit" class="btn btn-link">{{ $subs->company_name }}</button>
                                                    </form>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $subs->id }}">
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
                    {{-- <a href="{{ url()->previous() }}">
                        <span>Return to previous page</span>
                    </a> --}}
                </div>
            </div>
            @else
            <div class="row" style="box-shadow: rgba(44, 73, 100, 0.08) 0px 2px 15px 0px;">
                <div class="col-xl-8 col-lg-6 es d-flex flex-column align-items-stretch justify-content-center py-5 px-lg-5">
                    <div class="container" style="padding-top:50px;">
                        <h5 class="text-muted">To get information from this shareholder please contact Us at <span style="color: #0AA7C4;">helpdesk@earthqualizer.org</span></h5>
                        <!-- <p class="fst-italic">A group company is a collection of individual companies or subsidiaries that are controlled by a single parent company. The parent company, often referred to as the holding company or the group, typically holds a majority stake or controlling the subsidiary companies. The information about Group Company can be used to identify the subsidiary under.</p> -->
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 es d-flex flex-column align-items-stretch py-5 px-lg-5" style="background-color: #F5F5F5;">
                    <div class="blog sidebar">

                    <h5 class="card-title description">Company Profile Access</h5>
                    </div><!-- End sidebar -->
                    <!-- <a href="#appointment" class="appointment-btn" style="justify-content: center; align-items:center; text-align:center;">Buy</a> -->
                    <div class="line"></div>
                    <div class="report-benefit">
                        <p>If the data You're looking for is not found, You can contact us via email at helpdesk@earthqualizer.org.</p>
                        <p>We will process your request within 3x24 hours.</p>
                        <div class="line"></div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </section><!-- End About Section -->

    <!-- Leaflet JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.js" integrity="sha384-dRnG3QipUv9zvMAkW8XVg+heW0jhvccrGM6yDNC4uK+xmqvBnp+0xuL50PYs10n/" crossorigin=""></script>

</main><!-- End #main -->

<!-- Modal -->
@foreach($shareholderNames as $subs)
<div class="modal fade" id="exampleModal{{$subs->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel"> 
                    <h4 class="title mb-0"> {{ $subs->shareholder_name }} - <i>{{ $subs->company_name }}</i></h4>
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <p class="small fst-italic">The following is share ownership information from {{ $subs->shareholder_name }} at {{ $subs->company_name }}</p>
                    <div class="col-12">
                        <div class="tab-content pt-2">
                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 label ">Name</div>
                                    <div class="col-lg-8 col-md-8">: {{ $subs->shareholder_name }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 label ">Date of Birth</div>
                                    <div class="col-lg-8 col-md-8">: {{ $subs->date_of_birth }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 label ">IC Passport Comp Number</div>
                                    <div class="col-lg-8 col-md-8">: {{ $subs->ic_passport_comp_number }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 label ">Address</div>
                                    <div class="col-lg-8 col-md-8">: {{ $subs->address }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 label ">Position</div>
                                    <div class="col-lg-8 col-md-8">: {{ $subs->position }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 label ">Number of Shares</div>
                                    <div class="col-lg-8 col-md-8">: {{ $subs->number_of_shares }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 label ">Total of Shares</div>
                                    <div class="col-lg-8 col-md-8">: {{ $subs->total_of_shares }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 label ">Percentage of Shares</div>
                                    <div class="col-lg-8 col-md-8">: {{ $subs->percentage_of_shares }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 label ">Currency</div>
                                    <div class="col-lg-8 col-md-8">: {{ $subs->currency }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 label ">Company Name</div>
                                    <div class="col-lg-8 col-md-8">: {{ $subs->company_name }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 label ">Data Source</div>
                                    <div class="col-lg-8 col-md-8">: {{ $subs->data_source }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 label ">Data Update</div>
                                    <div class="col-lg-8 col-md-8">: {{ $subs->data_update }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-0">
                        <div class="tab-content pt-2">
                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                <div class="row">
                                    <div class="col-lg-6 col-md-4 label ">Date Company Number</div>
                                    <div class="col-lg-6 col-md-8">{{ $subs->date_company_number }}</div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                
                </div>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info">Save changes</button>
            </div> -->
        </div>
    </div>
</div>
@endforeach

<!-- Modal -->
<div class="modal fade" id="exampleModalOld" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Ownership of shares from &nbsp; 
            @foreach($shareholderNames as $subs)
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
                        <h6 class="card-title description text-muted">Shareholder Name</h6>
                        <p class="card-text">{{ $subs->shareholder_name }}</p>
                        <h6 class="card-title description text-muted">Date of Birth</h6>
                        <p class="card-text">{{ $subs->date_of_birth }}</p>
                        <h6 class="card-title description text-muted">IC Passport Comp Number</h6>
                        <p class="card-text">{{ $subs->ic_passport_comp_number }}</p>
                        <h6 class="card-title description text-muted">Position</h6>
                        <p class="card-text">{{ $subs->position }}</p>
                        <h6 class="card-title description text-muted">Number of Shares</h6>
                        <p class="card-text">{{ $subs->number_of_shares }}</p>
                        <h6 class="card-title description text-muted">Currency</h6>
                        <p class="card-text">{{ $subs->currency }}</p>
                        <h6 class="card-title description text-muted">Company Name</h6>
                        <p class="card-text">{{ $subs->company_name }}</p>
                        <h6 class="card-title description text-muted">Company Type</h6>
                        <p class="card-text">{{ $subs->company_type }}</p>
                        <h6 class="card-title description text-muted">Company Number</h6>
                        <p class="card-text">{{ $subs->company_number }}</p>
                        <h6 class="card-title description text-muted">Incorporation Date</h6>
                        <p class="card-text">{{ $subs->incorporation_date }}</p>
                    </div>
                    <div class="col-6">
                        <h6 class="card-title description text-muted">Date Company Number</h6>
                        <p class="card-text">{{ $subs->date_company_number }}</p>
                        <h6 class="card-title description text-muted">Change Company Number</h6>
                        <p class="card-text">{{ $subs->change_company_number }}</p>
                        <h6 class="card-title description text-muted">Date Change Company Number</h6>
                        <p class="card-text">{{ $subs->date_change_company_number }}</p>
                        <h6 class="card-title description text-muted">Registered Address</h6>
                        <p class="card-text">{{ $subs->registered_address }}</p>
                        <h6 class="card-title description text-muted">Country of Registered Address</h6>
                        <p class="card-text">{{ $subs->country_of_registered_address }}</p>
                        <h6 class="card-title description text-muted">Business Address</h6>
                        <p class="card-text">{{ $subs->business_address }}</p>
                        <h6 class="card-title description text-muted">Country of Business Address</h6>
                        <p class="card-text">{{ $subs->country_of_business_address}}</p>
                        <h6 class="card-title description text-muted">Nature of Business</h6>
                        <p class="card-text">{{ $subs->narute_of_business }}</p>
                        <h6 class="card-title description text-muted">Taxpayer Identification Number</h6>
                        <p class="card-text">{{ $subs->taxpayer_identification_number }}</p>
                        <h6 class="card-title description text-muted">Data Source</h6>
                        <p class="card-text">{{ $subs->data_source }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-info">Save changes</button>
      </div> -->
    </div>
  </div>
</div>
@endsection

