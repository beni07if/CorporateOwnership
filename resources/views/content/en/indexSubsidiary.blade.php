@extends('layout.app')

@section('styleMaps')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.css" />
@endsection

@section('content')
    <main id="main">

        <section class="section profile">
            <div class="row">
                <div class="section-title">
                    @foreach($consolidations->pluck('subsidiary')->unique() as $subs)
                        <h2 class="card-title">{{$subs}}</h2>
                    @endforeach
                </div>
                <div class="col-xl-12">

                    <div style="display: flex; justify-content: center; align-items: center;">
                        <form action="{{ route('searchFunctionSubsidiary') }}" method="GET" class="d-flex"
                            style="width: 50%; background-color: #f8f9fa; border-radius: 10px; padding: 15px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                            <input type="text" class="form-control me-2" name="subsidiary"
                                placeholder="Search for other company"
                                style="border: 1px solid #007bff; border-radius: 5px;">
                            <button type="submit" class="btn btn-info"
                                style="border-radius: 5px; transition: background-color 0.3s;">
                                Search
                            </button>
                        </form>
                    </div>

                    <div class="card">
                        @if(count($consolidations) > 0)
                            <div class="card-body">

                                <div class="d-flex justify-content-between">
                                    <nav>
                                        @foreach($consolidations->pluck('subsidiary')->unique() as $subs)
                                            <h5 class="card-title me-3">{{ $subs }}</h5>
                                        @endforeach
                                    </nav>
                                    <nav class="zoom-in">
                                        @if($consolidations->isNotEmpty())
                                            @foreach($consolidations->pluck('subsidiary')->unique() as $subs)
                                                <form action="{{ route('subsidiaryShowNotarialDeed') }}" target="_blank" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="d-flex align-items-center">
                                                        <h5 class="card-title mb-0">
                                                            <button type="submit" name="subsidiary" value="{{ $subs }}" style="background-color: transparent; border: none; font-weight: bold; color: #106587; cursor: pointer; 
                                                                        transition: color 0.3s;"
                                                                onmouseover="this.style.color='#007BFF'"
                                                                onmouseout="this.style.color='inherit'">
                                                                Notary Act
                                                            </button>
                                                        </h5>
                                                        <span class="badge bg-info text-dark" style="margin-top: 20px;">
                                                            <i class="bi-file-earmark-pdf me-1"></i> pdf
                                                        </span>
                                                    </div>
                                                </form>
                                            @endforeach
                                        @endif
                                    </nav>

                                    <nav>
                                        <h5 class="card-title">RSPO Certified</h5>
                                        @foreach($consolidations->pluck('rspo_certified')->unique() as $rspo_certified)
                                            <span class="badge bg-info text-dark">
                                                <i class="bi bi-check-circle me-1"></i>
                                                {{ $rspo_certified }}
                                            </span>
                                        @endforeach
                                    </nav>
                                </div>
                            </div>
                        @endif
                    </div><br>

                    <div class="card">
                        <div class="card-body pt-3">
                            <div class="tab-content pt-2">
                                @if($companyOwnership->isNotEmpty())
                                                            {{-- @if ($consolidations->isNotEmpty()) --}}
                                                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                                                <div class="alert alert-light border-light alert-dismissible fade show bg-opacity-50"
                                                                    role="alert">
                                                                    <div class="d-flex justify-content-between flex-wrap">
                                                                        <div class="d-flex flex-wrap">
                                                                            <h5 class="card-title me-3">General Information</h5>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-lg-6 col-md-6">
                                                                            <div class="row">
                                                                                <div class="col-lg-6 col-md-4 label">Company Name</div>
                                                                                @foreach($companyOwnership->pluck('company_name')->unique() as $company_name)
                                                                                    @if($company_name)
                                                                                        <div class="col-lg-6 col-md-8">: {!! nl2br(e($company_name)) !!}</div>
                                                                                    @else
                                                                                        <div class="col-lg-6 col-md-8">: -</div>
                                                                                    @endif
                                                                                @endforeach
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-lg-6 col-md-4 label">Company Type</div>
                                                                                <div class="col-lg-6 col-md-8">
                                                                                    @php
                                                                                        $addresses = $companyOwnership->pluck('company_type')->unique()->filter(); // Hanya ambil yang unik dan tidak null
                                                                                    @endphp

                                                                                    @if($addresses->isEmpty())
                                                                                        : -
                                                                                    @else
                                                                                        :
                                                                                        @foreach($addresses as $company_type)
                                                                                            {!! nl2br(e($company_type)) !!} <br>
                                                                                        @endforeach
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-lg-6 col-md-4 label">Group</div>
                                                                                {{-- @if(auth()->check() && in_array(auth()->user()->user_level,
                                                                                ['Standard', 'Premium']))
                                                                                @foreach($consolidations->pluck('group_name')->unique() as $group_name)
                                                                                @if($group_name)
                                                                                <div class="col-lg-3 col-md-8">: {!! nl2br(e($group_name)) !!}</div>
                                                                                @else
                                                                                <div class="col-lg-6 col-md-8">: -</div>
                                                                                @endif
                                                                                @endforeach
                                                                                @endif --}}
                                                                                @foreach($consolidations->pluck('group_name')->unique() as $group_name)
                                                                                    @if($group_name)
                                                                                        <div class="col-lg-6 col-md-8">: {!! nl2br(e($group_name)) !!}</div>
                                                                                    @else
                                                                                        <div class="col-lg-6 col-md-8">: -</div>
                                                                                    @endif
                                                                                @endforeach
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-lg-6 col-md-4 label">Nature of Business</div>
                                                                                <div class="col-lg-6 col-md-8">
                                                                                    @php
                                                                                        $addresses = $companyOwnership->pluck('nature_of_business')->unique()->filter(); // Hanya ambil yang unik dan tidak null
                                                                                    @endphp

                                                                                    @if($addresses->isEmpty())
                                                                                        : -
                                                                                    @else
                                                                                        :
                                                                                        @foreach($addresses as $nature_of_business)
                                                                                            {!! nl2br(e($nature_of_business)) !!} <br>
                                                                                        @endforeach
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-lg-6 col-md-6">
                                                                            <div class="row">
                                                                                <div class="col-lg-6 col-md-4 label">Country of Business Address</div>
                                                                                <div class="col-lg-6 col-md-8">
                                                                                    @php
                                                                                        $addresses = $companyOwnership->pluck('country_of_business_address')->unique()->filter(); // Hanya ambil yang unik dan tidak null
                                                                                    @endphp

                                                                                    @if($addresses->isEmpty())
                                                                                        : -
                                                                                    @else
                                                                                        :
                                                                                        @foreach($addresses as $country_of_business_address)
                                                                                            {!! nl2br(e($country_of_business_address)) !!} <br>
                                                                                        @endforeach
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-lg-6 col-md-4 label">Business Address</div>
                                                                                <div class="col-lg-6 col-md-8">
                                                                                    @php
                                                                                        $addresses = $companyOwnership->pluck('business_address')->unique()->filter(); // Hanya ambil yang unik dan tidak null
                                                                                    @endphp

                                                                                    @if($addresses->isEmpty())
                                                                                        : -
                                                                                    @else
                                                                                        :
                                                                                        @foreach($addresses as $business_address)
                                                                                            {!! nl2br(e($business_address)) !!} <br>
                                                                                        @endforeach
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-lg-6 col-md-4 label">Principal Activity</div>
                                                                                <div class="col-lg-6 col-md-8">
                                                                                    @if($consolidations->pluck('principal_activities')->unique()->isNotEmpty())
                                                                                        @foreach($consolidations->pluck('principal_activities')->unique() as $principal_activity)
                                                                                            <div>
                                                                                                @if($principal_activity)
                                                                                                    : {!! nl2br(e($principal_activity)) !!}
                                                                                                @else
                                                                                                    -
                                                                                                @endif
                                                                                            </div>
                                                                                        @endforeach
                                                                                    @else
                                                                                        <div>-</div>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-lg-6 col-md-4 label">Country Operation</div>
                                                                                @foreach($consolidations->pluck('country_operation')->unique() as $country_operation)
                                                                                    @if($country_operation)
                                                                                        <div class="col-lg-3 col-md-8">: {!! nl2br(e($country_operation)) !!}
                                                                                        </div>
                                                                                    @else
                                                                                        <div class="col-lg-6 col-md-8">: -</div>
                                                                                    @endif
                                                                                @endforeach
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <hr>

                                                                <div class="d-flex justify-content-between flex-wrap">
                                                                    <div class="d-flex flex-wrap">
                                                                        <h5 class="card-title me-3">Registration Details</h5>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-md-6">
                                                                        <div class="row">
                                                                            <div class="col-lg-6 col-md-4 label">Incorporation Date</div>
                                                                            <div class="col-lg-6 col-md-8">
                                                                                @php
                                                                                    $addresses = $companyOwnership->pluck('incorporation_date')->unique()->filter(); // Hanya ambil yang unik dan tidak null
                                                                                @endphp

                                                                                @if($addresses->isEmpty())
                                                                                    : -
                                                                                @else
                                                                                    :
                                                                                    @foreach($addresses as $incorporation_date)
                                                                                        {!! nl2br(e($incorporation_date)) !!} <br>
                                                                                    @endforeach
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-lg-6 col-md-4 label">Taxpayer Identification Number</div>
                                                                            <div class="col-lg-6 col-md-8">
                                                                                @php
                                                                                    $addresses = $companyOwnership->pluck('taxpayer_identification_number')->unique()->filter(); // Hanya ambil yang unik dan tidak null
                                                                                @endphp

                                                                                @if($addresses->isEmpty())
                                                                                    : -
                                                                                @else
                                                                                    :
                                                                                    @foreach($addresses as $taxpayer_identification_number)
                                                                                        {!! nl2br(e($taxpayer_identification_number)) !!} <br>
                                                                                    @endforeach
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-lg-6 col-md-4 label">Company Number</div>
                                                                            <div class="col-lg-6 col-md-8">
                                                                                @php
                                                                                    $addresses = $companyOwnership->pluck('company_number')->unique()->filter(); // Hanya ambil yang unik dan tidak null
                                                                                @endphp

                                                                                @if($addresses->isEmpty())
                                                                                    : -
                                                                                @else
                                                                                    :
                                                                                    @foreach($addresses as $company_number)
                                                                                        {!! nl2br(e($company_number)) !!} <br>
                                                                                    @endforeach
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-lg-6 col-md-4 label">Date Company Number</div>
                                                                            <div class="col-lg-6 col-md-8">
                                                                                @php
                                                                                    $addresses = $companyOwnership->pluck('date_company_number')->unique()->filter(); // Hanya ambil yang unik dan tidak null
                                                                                @endphp

                                                                                @if($addresses->isEmpty())
                                                                                    : -
                                                                                @else
                                                                                    :
                                                                                    @foreach($addresses as $date_company_number)
                                                                                        {!! nl2br(e($date_company_number)) !!} <br>
                                                                                    @endforeach
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-lg-6 col-md-6">
                                                                        <div class="row">
                                                                            <div class="col-lg-6 col-md-4 label">Change Company Number</div>
                                                                            <div class="col-lg-6 col-md-8">
                                                                                @php
                                                                                    $addresses = $companyOwnership->pluck('change_company_number')->unique()->filter(); // Hanya ambil yang unik dan tidak null
                                                                                @endphp

                                                                                @if($addresses->isEmpty())
                                                                                    : -
                                                                                @else
                                                                                    :
                                                                                    @foreach($addresses as $change_company_number)
                                                                                        {!! nl2br(e($change_company_number)) !!} <br>
                                                                                    @endforeach
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-lg-6 col-md-4 label">Date Change Company Number</div>
                                                                            <div class="col-lg-6 col-md-8">
                                                                                @php
                                                                                    $addresses = $companyOwnership->pluck('date_change_company_number')->unique()->filter(); // Hanya ambil yang unik dan tidak null
                                                                                @endphp

                                                                                @if($addresses->isEmpty())
                                                                                    : -
                                                                                @else
                                                                                    :
                                                                                    @foreach($addresses as $date_change_company_number)
                                                                                        {!! nl2br(e($date_change_company_number)) !!} <br>
                                                                                    @endforeach
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-lg-6 col-md-4 label">Country of Registered Address</div>
                                                                            <div class="col-lg-6 col-md-8">
                                                                                @php
                                                                                    $addresses = $companyOwnership->pluck('country_of_registered_address')->unique()->filter(); // Hanya ambil yang unik dan tidak null
                                                                                @endphp

                                                                                @if($addresses->isEmpty())
                                                                                    : -
                                                                                @else
                                                                                    :
                                                                                    @foreach($addresses as $country_of_registered_address)
                                                                                        {!! nl2br(e($country_of_registered_address)) !!} <br>
                                                                                    @endforeach
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-lg-6 col-md-4 label">Registered Address</div>
                                                                            <div class="col-lg-6 col-md-8">
                                                                                @php
                                                                                    $addresses = $companyOwnership->pluck('registered_address')->unique()->filter(); // Hanya ambil yang unik dan tidak null
                                                                                @endphp

                                                                                @if($addresses->isEmpty())
                                                                                    : -
                                                                                @else
                                                                                    :
                                                                                    @foreach($addresses as $registered_address)
                                                                                        {!! nl2br(e($registered_address)) !!} <br>
                                                                                    @endforeach
                                                                                @endif
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <hr>

                                                                <div class="d-flex justify-content-between flex-wrap">
                                                                    <div class="d-flex flex-wrap">
                                                                        <h5 class="card-title me-3">Certification</h5>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-md-6">
                                                                        <div class="row">
                                                                            <div class="col-lg-6 col-md-4 label">RSPO Certified</div>
                                                                            @foreach($consolidations->pluck('rspo_certified')->unique() as $rspo_certified)
                                                                                @if($rspo_certified)
                                                                                    <div class="col-lg-3 col-md-8">: {!! nl2br(e($rspo_certified)) !!}</div>
                                                                                @else
                                                                                    <div class="col-lg-6 col-md-8">: -</div>
                                                                                @endif
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 col-md-6">
                                                                        <div class="row">
                                                                            <div class="col-lg-6 col-md-4 label">Other Certification</div>
                                                                            @foreach($consolidations->pluck('other_certification')->unique() as $other_certification)
                                                                                @if($other_certification)
                                                                                    <div class="col-lg-3 col-md-8">: {!! nl2br(e($other_certification)) !!}
                                                                                    </div>
                                                                                @else
                                                                                    <div class="col-lg-6 col-md-8">: -</div>
                                                                                @endif
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <hr>

                                                                <div class="d-flex justify-content-between flex-wrap">
                                                                    <div class="d-flex flex-wrap">
                                                                        <h5 class="card-title me-3">Shareholders/Management</h5>
                                                                    </div>
                                                                </div>
                                                                {{-- <div class="row" hidden>
                                                                    <div class="col-lg-3 col-md-4 label">Shareholder</div>
                                                                    <div class="col-lg-9 col-md-8">

                                                                        <form action="{{ route('shareholderShowByCompany') }}" method="POST">
                                                                            @csrf
                                                                            @foreach($consolidations->pluck('shareholder_subsidiary')->flatten()->unique()
                                                                            as $shareholder)
                                                                            @php
                                                                            $shareholders = explode(',', $shareholder);
                                                                            @endphp

                                                                            @if(count($shareholders) > 1)
                                                                            @foreach($shareholders as $key => $shareholder)
                                                                            @php
                                                                            preg_match('/^(.*?)\s*\((.*?)\)$/', $shareholder, $matches);
                                                                            $name = trim($matches[1]);
                                                                            $ownership = trim($matches[2]);
                                                                            @endphp
                                                                            <div>
                                                                                <button type="submit" name="shareholder_name" value="{{ $name }}"
                                                                                    class="text-muted">
                                                                                    <p>{{ $key + 1 }}) {{ $name }} ({{ $ownership }})</p>
                                                                                </button>
                                                                            </div>
                                                                            @endforeach
                                                                            @else
                                                                            <div>
                                                                                <button type="submit" name="shareholder_name" value="{{ $shareholder }}"
                                                                                    class="text-muted">
                                                                                    <p>{{ $shareholder }}</p>
                                                                                </button>
                                                                            </div>
                                                                            @endif
                                                                            @endforeach
                                                                        </form>
                                                                    </div>
                                                                </div> --}}

                                                                <div class="row">
                                                                    <div class="col-lg-3 col-md-6">
                                                                        <div class="row">
                                                                            <div class="col-lg-12 col-md-4 label">Shareholder Name</div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-3 col-md-6">
                                                                        <div class="row">
                                                                            <div class="col-lg-12 col-md-4 label">Position</div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-md-6">
                                                                        <div class="row">
                                                                            <div class="col-lg-12 col-md-4 label">Percentage of Shares</div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-md-6">
                                                                        <div class="row">
                                                                            <div class="col-lg-12 col-md-4 label">Number of Shares</div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-md-6">
                                                                        <div class="row">
                                                                            <div class="col-lg-12 col-md-4 label">Currency</div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- Shareholders Column -->
                                                                    <div class="col-lg-12">
                                                                        <div class="row">
                                                                            <div class="col-lg-12 col-md-8">
                                                                                @if(count($companyOwnership) > 0)
                                                                                                                        @foreach($companyOwnership as $ownership)
                                                                                                                                                                @php
                                                                                                                                                                    $shareholderNames = explode("\n", e($ownership->shareholder_name));
                                                                                                                                                                    $position = $ownership->position;
                                                                                                                                                                    $percentage = $ownership->percentage_of_shares;
                                                                                                                                                                    $numberShare = $ownership->number_of_shares;
                                                                                                                                                                    $currency = $ownership->currency; // Ensure currency is set correctly
                                                                                                                                                                @endphp
                                                                                                                                                                @foreach($shareholderNames as $shareholder)
                                                                                                                                                                    <div class="row">
                                                                                                                                                                        <!-- Shareholder Name -->
                                                                                                                                                                        <div class="col-lg-3 col-md-4 pl-lg-4">
                                                                                                                                                                            <form action="{{ route('searchFunctionShareholder') }}"
                                                                                                                                                                                method="GET" style="display:inline;">
                                                                                                                                                                                @csrf
                                                                                                                                                                                <input type="hidden" name="shareholder_name"
                                                                                                                                                                                    value="{{ $shareholder }}">
                                                                                                                                                                                <input type="hidden" name="date_of_birth"
                                                                                                                                                                                    value="{{ $ownership->date_of_birth }}">
                                                                                                                                                                                <button type="submit" class="shareholder-button">
                                                                                                                                                                                    {{ $shareholder }}
                                                                                                                                                                                </button>
                                                                                                                                                                            </form>
                                                                                                                                                                        </div>
                                                                                                                                                                        <!-- Position -->
                                                                                                                                                                        <div class="col-lg-3 col-md-4 pl-lg-4">
                                                                                                                                                                            {{ $position }}
                                                                                                                                                                        </div>
                                                                                                                                                                        <!-- Percentage of Shares -->
                                                                                                                                                                        <div class="col-lg-2 col-md-4 pl-lg-4">
                                                                                                                                                                            {{ $percentage }}
                                                                                                                                                                        </div>
                                                                                                                                                                        <!-- Total of Shares -->
                                                                                                                                                                        <div class="col-lg-2 col-md-4 pl-lg-4">
                                                                                                                                                                            {{ $numberShare }}
                                                                                                                                                                        </div>
                                                                                                                                                                        <!-- Currency -->
                                                                                                                                                                        <div class="col-lg-2 col-md-4 pl-lg-4">
                                                                                                                                                                            {{ $currency }}
                                                                                                                                                                        </div>
                                                                                                                                                                    </div>
                                                                                                                                                                @endforeach
                                                                                                                        @endforeach
                                                                                @else
                                                                                    <div>: -</div>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <hr>

                                                                <h5 class="card-title" hidden>Facility</h5>

                                                                <div class="row" hidden>
                                                                    <!-- Facilities and Capacity Column -->
                                                                    <div class="col-lg-6 col-md-6">
                                                                        <div class="row">
                                                                            @if(count($consolidations) > 0)
                                                                                                                    @php
                                                                                                                        // Simpan fasilitas yang telah ditampilkan
                                                                                                                        $displayedFacilities = [];
                                                                                                                    @endphp
                                                                                                                    @foreach($consolidations as $consolidation)
                                                                                                                                            @if($consolidation->facilities)
                                                                                                                                                                    @foreach(explode("\n", e($consolidation->facilities)) as $facility)
                                                                                                                                                                                            @if(!in_array($facility, $displayedFacilities))
                                                                                                                                                                                                                    <div class="col-lg-6 col-md-4 label">
                                                                                                                                                                                                                        <!-- Cek nilai activity dan atur labelnya -->
                                                                                                                                                                                                                        @if($consolidation->principal_activities == 'Biodisel Plant')
                                                                                                                                                                                                                            Biodisel Plant
                                                                                                                                                                                                                        @elseif($consolidation->principal_activities == 'Kernel Chrusing Plant')
                                                                                                                                                                                                                            Kernel Chrusing Plant
                                                                                                                                                                                                                        @elseif($consolidation->principal_activities == 'Manufacturer')
                                                                                                                                                                                                                            Manufacturer
                                                                                                                                                                                                                        @elseif($consolidation->principal_activities == 'Oil Palm Plantation & Mill')
                                                                                                                                                                                                                            Palm Oil Mill
                                                                                                                                                                                                                        @elseif($consolidation->principal_activities == 'Palm Oil Mill')
                                                                                                                                                                                                                            Palm Oil Mill
                                                                                                                                                                                                                        @elseif($consolidation->principal_activities == 'Refinery')
                                                                                                                                                                                                                            Refinery
                                                                                                                                                                                                                        @else
                                                                                                                                                                                                                            Other Activity
                                                                                                                                                                                                                        @endif
                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                    <div class="col-lg-6 col-md-8">
                                                                                                                                                                                                                        <div>: {{ $facility }} ({{ $consolidation->capacity }})
                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                    @php
                                                                                                                                                                                                                        // Tandai fasilitas sebagai telah ditampilkan
                                                                                                                                                                                                                        $displayedFacilities[] = $facility;
                                                                                                                                                                                                                    @endphp
                                                                                                                                                                                            @endif
                                                                                                                                                                    @endforeach
                                                                                                                                            @else
                                                                                                                                                {{-- <div class="col-lg-6 col-md-4 label">-</div>
                                                                                                                                                <div class="col-lg-6 col-md-8">-</div> --}}
                                                                                                                                            @endif
                                                                                                                    @endforeach
                                                                            @endif
                                                                        </div>
                                                                    </div>

                                                                    <!-- Latitude/Longitude Column -->
                                                                    <div class="col-lg-6 col-md-6">
                                                                        <div class="row">
                                                                            @if(count($consolidations) > 0)
                                                                                                            @foreach($consolidations as $consolidation)
                                                                                                                                            @if($consolidation->principal_activities == 'Oil Palm Plantation & Mill' || $consolidation->principal_activities == 'Palm Oil Mill')
                                                                                                                                                                            @php
                                                                                                                                                                                // Tandai sudah menampilkan lat/long untuk aktivitas ini
                                                                                                                                                                                $displayedLatLong = true;
                                                                                                                                                                                // Set latitude and longitude for map
                                                                                                                                                                                $latitude = $consolidation->latitude;
                                                                                                                                                                                $longitude = $consolidation->longitude;
                                                                                                                                                                            @endphp
                                                                                                                                                                            <div class="col-lg-6 col-md-4 label">
                                                                                                                                                                                <div>Latitude/Longitude</div>
                                                                                                                                                                            </div>
                                                                                                                                                                            <div class="col-lg-6 col-md-8">
                                                                                                                                                                                @if($latitude && $longitude)
                                                                                                                                                                                    <div>: {{ $latitude }}, {{ $longitude }}</div>
                                                                                                                                                                                @else
                                                                                                                                                                                    <div>: No location data</div>
                                                                                                                                                                                @endif
                                                                                                                                                                            </div>
                                                                                                                                                                            @break <!-- Hentikan loop setelah menemukan data untuk satu aktivitas -->
                                                                                                                                            @endif
                                                                                                            @endforeach
                                                                            @endif

                                                                            {{-- @if(count($consolidations) > 0)
                                                                            @foreach($consolidations as $consolidation)
                                                                            @if($consolidation->latitude && $consolidation->longitude)
                                                                            @foreach(explode("\n", e($consolidation->facilities)) as $facility)
                                                                            <div class="col-lg-6 col-md-4 label">
                                                                                <div>Latitude/Longitude </div>
                                                                            </div>
                                                                            <div class="col-lg-6 col-md-8">
                                                                                <div>: {{ $consolidation->latitude }}, {{ $consolidation->longitude }}
                                                                                </div>
                                                                            </div>
                                                                            @endforeach
                                                                            @else
                                                                            <div class="col-lg-6 col-md-4 label">
                                                                                <div>Latitude/Longitude </div>
                                                                            </div>
                                                                            <div class="col-lg-6 col-md-8">
                                                                                <div>: No location data</div>
                                                                            </div>
                                                                            @endif
                                                                            @endforeach
                                                                            @endif --}}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-12 col-md-6">
                                                                        <div class="row">
                                                                            <div class="col-lg-3 col-md-4 label">Operating Status</div>
                                                                            @foreach($consolidations->pluck('status_operation')->unique() as $status_operation)
                                                                                @if($status_operation)
                                                                                    <div class="col-lg-3 col-md-8">: {!! nl2br(e($status_operation)) !!}</div>
                                                                                @else
                                                                                    <div class="col-lg-12 col-md-8">: -</div>
                                                                                @endif
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-12 col-md-6">
                                                                        @if(count($consolidations) > 0)
                                                                            <div class="row">
                                                                                <!-- Address Column -->
                                                                                <div class="col-lg-3 col-md-4 label">
                                                                                    Operating Address
                                                                                </div>
                                                                                <div class="col-lg-9 col-md-8">
                                                                                    @if($consolidation->country_operation || $consolidation->province || $consolidation->regency)
                                                                                        <div>
                                                                                            @if($consolidation->country_operation)
                                                                                                : {{ $consolidation->country_operation }},
                                                                                            @endif
                                                                                            @if($consolidation->province)
                                                                                                {{ $consolidation->province }},
                                                                                            @endif
                                                                                            @if($consolidation->regency)
                                                                                                {{ $consolidation->regency }}
                                                                                            @endif
                                                                                        </div>
                                                                                    @else
                                                                                        <div>No address data</div>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                                <div class="d-flex justify-content-between flex-wrap">
                                                                    <div class="d-flex flex-wrap">
                                                                        <h5 class="card-title me-3">Estate</h5>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <!-- Estate Column -->
                                                                    <div class="col-lg-6 col-md-6">
                                                                        <div class="row">
                                                                            @if(count($consolidations) > 0)
                                                                                                                    @php
                                                                                                                        // Simpan estate yang telah ditampilkan
                                                                                                                        $displayedEstates = [];
                                                                                                                    @endphp
                                                                                                                    @foreach($consolidations as $consolidation)
                                                                                                                                                        @php
                                                                                                                                                            // Cek nilai estate
                                                                                                                                                            $estateList = explode("\n", e($consolidation->estate));
                                                                                                                                                            // Tentukan nama estate default
                                                                                                                                                            $hasEstate = false;
                                                                                                                                                        @endphp

                                                                                                                                                        @foreach($estateList as $estate)
                                                                                                                                                                                        @php
                                                                                                                                                                                            // Tentukan nama estate untuk ditampilkan
                                                                                                                                                                                            $estateDisplay = !empty(trim($estate)) ? trim($estate) : 'Unknown Estate Name';
                                                                                                                                                                                            // Tandai jika ada estate yang valid
                                                                                                                                                                                            if ($estateDisplay !== 'Unknown Estate Name') {
                                                                                                                                                                                                $hasEstate = true;
                                                                                                                                                                                            }
                                                                                                                                                                                        @endphp

                                                                                                                                                                                        @if(!in_array($estateDisplay, $displayedEstates))
                                                                                                                                                                                                                    <!-- Tampilkan hanya jika estate belum ditampilkan -->
                                                                                                                                                                                                                    @if(
                                                                                                                                                                                                                        $consolidation->principal_activities == 'Oil Palm Plantation & Mill' ||
                                                                                                                                                                                                                        $consolidation->principal_activities == 'Oil Palm Plantation'
                                                                                                                                                                                                                    )
                                                                                                                                                                                                                                                <div class="col-lg-6 col-md-4 label">
                                                                                                                                                                                                                                                    <!-- Cek nilai activity dan atur labelnya -->
                                                                                                                                                                                                                                                    @if($consolidation->principal_activities == 'Oil Palm Plantation & Mill')
                                                                                                                                                                                                                                                        Estate
                                                                                                                                                                                                                                                    @elseif($consolidation->principal_activities == 'Oil Palm Plantation')
                                                                                                                                                                                                                                                        Estate
                                                                                                                                                                                                                                                    @else
                                                                                                                                                                                                                                                        Other Activity
                                                                                                                                                                                                                                                    @endif
                                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                                <div class="col-lg-6 col-md-8">
                                                                                                                                                                                                                                                    <div>: {{ $estateDisplay }} ({{ $consolidation->sizebyeq }} ha)
                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                                @php
                                                                                                                                                                                                                                                    // Tandai estate sebagai telah ditampilkan
                                                                                                                                                                                                                                                    $displayedEstates[] = $estateDisplay;
                                                                                                                                                                                                                                                @endphp
                                                                                                                                                                                                                    @endif
                                                                                                                                                                                        @endif
                                                                                                                                                        @endforeach

                                                                                                                                                        @if(!$hasEstate && !in_array('Unknown Estate Name', $displayedEstates))
                                                                                                                                                                                        <!-- Jika tidak ada estate yang valid, tampilkan Unknown Estate Name -->
                                                                                                                                                                                        @if(
                                                                                                                                                                                            $consolidation->principal_activities == 'Oil Palm Plantation & Mill' ||
                                                                                                                                                                                            $consolidation->principal_activities == 'Oil Palm Plantation'
                                                                                                                                                                                        )
                                                                                                                                                                                                                        <div class="col-lg-6 col-md-4 label">
                                                                                                                                                                                                                            <!-- Cek nilai activity dan atur labelnya -->
                                                                                                                                                                                                                            @if($consolidation->principal_activities == 'Oil Palm Plantation & Mill')
                                                                                                                                                                                                                                Estate
                                                                                                                                                                                                                            @elseif($consolidation->principal_activities == 'Oil Palm Plantation')
                                                                                                                                                                                                                                Estate
                                                                                                                                                                                                                            @else
                                                                                                                                                                                                                                Other Activity
                                                                                                                                                                                                                            @endif
                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                        <div class="col-lg-6 col-md-8">
                                                                                                                                                                                                                            <div>: Unknown Estate Name ({{ $consolidation->sizebyeq }})
                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                        @php
                                                                                                                                                                                                                            // Tandai Unknown Estate Name sebagai telah ditampilkan
                                                                                                                                                                                                                            $displayedEstates[] = 'Unknown Estate Name';
                                                                                                                                                                                                                        @endphp
                                                                                                                                                                                        @endif
                                                                                                                                                        @endif
                                                                                                                    @endforeach
                                                                            @endif
                                                                        </div>
                                                                    </div>

                                                                    <!-- Latitude/Longitude Column -->
                                                                    <div class="col-lg-6 col-md-6">
                                                                        <div class="row">
                                                                            @if(count($consolidations) > 0)
                                                                                @foreach($consolidations as $consolidation)
                                                                                    @if($consolidation->latitude && $consolidation->longitude)
                                                                                        @foreach(explode("\n", e($consolidation->estate)) as $facility)
                                                                                            <div class="col-lg-6 col-md-4 label">
                                                                                                <div>Latitude/Longitude </div>
                                                                                            </div>
                                                                                            <div class="col-lg-6 col-md-8">
                                                                                                <div>: {{ $consolidation->latitude }}, {{ $consolidation->longitude }}
                                                                                                </div>
                                                                                            </div>
                                                                                        @endforeach
                                                                                    @else
                                                                                        <div class="col-lg-6 col-md-4 label">
                                                                                            <div>Latitude/Longitude </div>
                                                                                        </div>
                                                                                        <div class="col-lg-6 col-md-8">
                                                                                            <div>: No location data</div>
                                                                                        </div>
                                                                                    @endif
                                                                                @endforeach
                                                                            @endif
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-lg-12 col-md-6">
                                                                        <div class="row">
                                                                            <div class="col-lg-3 col-md-4 label">Operating Status</div>
                                                                            @foreach($consolidations->pluck('status_operation')->unique() as $status_operation)
                                                                                @if($status_operation)
                                                                                    <div class="col-lg-3 col-md-8">: {!! nl2br(e($status_operation)) !!}</div>
                                                                                @else
                                                                                    <div class="col-lg-12 col-md-8">: -</div>
                                                                                @endif
                                                                            @endforeach
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-lg-12 col-md-6">
                                                                        @if(count($consolidations) > 0)
                                                                            <div class="row">
                                                                                <!-- Address Column -->
                                                                                <div class="col-lg-3 col-md-4 label">
                                                                                    Operating Address
                                                                                </div>
                                                                                <div class="col-lg-9 col-md-8">
                                                                                    @if($consolidation->country_operation || $consolidation->province || $consolidation->regency)
                                                                                        <div>
                                                                                            @if($consolidation->country_operation)
                                                                                                : {{ $consolidation->country_operation }},
                                                                                            @endif
                                                                                            @if($consolidation->province)
                                                                                                {{ $consolidation->province }},
                                                                                            @endif
                                                                                            @if($consolidation->regency)
                                                                                                {{ $consolidation->regency }}
                                                                                            @endif
                                                                                        </div>
                                                                                    @else
                                                                                        <div>No address data</div>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    </div>

                                                                    <div class="col-lg-12 col-md-6" hidden>
                                                                        <div class="row">
                                                                            <!-- Google Maps Embed -->
                                                                            @if(isset($latitude) && isset($longitude))
                                                                                                                    @php
                                                                                                                        $mapSrc = "https://www.google.com/maps/embed/v1/place?key=AIzaSyBgOmt5ydIttdpgZp6I830RPLBp1OGNwn8&q={$latitude},{$longitude}";
                                                                                                                        // <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d25034.653727798323!2d100.72741630529931!3d0.9904701800450332!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d4b114cddeb057%3A0x119c6f62951397ec!2sPT.%20Rohul%20Palmindo%20Muara%20Dilam!5e1!3m2!1sid!2sid!4v1684138457370!5m2!1sid!2sid" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                                                                                                    @endphp
                                                                                                                    <iframe src="{{ $mapSrc }}" width="100%" height="400" style="border:0;"
                                                                                                                        allowfullscreen="" loading="lazy"></iframe>
                                                                            @else
                                                                                <div>No map data available</div>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <h5 class="card-title" hidden>Notary Act</h5>

                                                                <div hidden>
                                                                    @foreach($consolidations->groupBy('subsidiary') as $subsidiaryGroup)
                                                                                                    @php
                                                                                                        $subsidiary = $subsidiaryGroup->first()->subsidiary;

                                                                                                        $directory = public_path('file/notarial-act-subsidiaries/');
                                                                                                        $matchingFiles = preg_grep('/^\d+ ' . preg_quote($subsidiary, '/') . '\.pdf$/', scandir($directory));

                                                                                                        if (!empty($matchingFiles)) {
                                                                                                            $fileNameInDirectory = reset($matchingFiles);
                                                                                                            $filePath = url('file/notarial-act-subsidiaries/' . $fileNameInDirectory);

                                                                                                            // Debug: Cetak URL yang dihasilkan ke konsol atau log
                                                                                                            error_log('Generated URL: ' . $filePath);
                                                                                                        } else {
                                                                                                            $filePath = ''; // Atau berikan nilai default jika file tidak ditemukan
                                                                                                        }
                                                                                                    @endphp

                                                                                                    @if(!empty($filePath))
                                                                                                        <iframe src="{{ $filePath }}" width="100%" height="600px"></iframe>
                                                                                                    @else
                                                                                                        <p>Please contact us to get notary act and other information of
                                                                                                            {{$subsidiaryGroup->first()->subsidiary}}.</p>
                                                                                                    @endif
                                                                                                    <!-- <p class="text-muted">{{ $subsidiary }}</p> -->
                                                                    @endforeach
                                                                </div>

                                                                <h6 class="card-title"><i>*Data source by Inovasi Digital</i></h6>

                                                                <div class="row" hidden>
                                                                    <div class="col-lg-6 col-md-6">
                                                                        <div class="row">
                                                                            <div class="col-lg-6 col-md-4 label">Data Source</div>
                                                                            @foreach($consolidations->pluck('data_source')->unique() as $data_source)
                                                                                @if($data_source)
                                                                                    <div class="col-lg-3 col-md-8">: {!! nl2br(e($data_source)) !!}</div>
                                                                                @else
                                                                                    <div class="col-lg-6 col-md-8">: -</div>
                                                                                @endif
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 col-md-6">
                                                                        <div class="row">
                                                                            <div class="col-lg-6 col-md-4 label">Data Update</div>
                                                                            @foreach($consolidations->pluck('data_update')->unique() as $data_update)
                                                                                @if($data_update)
                                                                                    <div class="col-lg-3 col-md-8">: {!! nl2br(e($data_update)) !!}</div>
                                                                                @else
                                                                                    <div class="col-lg-6 col-md-8">: -</div>
                                                                                @endif
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                @else
                                    <tr>
                                        <td colspan="2">
                                            <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                                                <h4 class="alert-heading">Data Not Found</h4>
                                                <p>Data not found, please enter the correct keywords.</p>
                                                <hr>
                                                <p class="mb-0">Please contact Us for more information at
                                                    <i><b>helpdesk@earthqualizer.org</b></i></p>
                                            </div>
                                        </td>
                                    </tr>
                                    {{-- @endif --}}
                                @endif
                            </div><!-- End Bordered Tabs -->
                        </div>
                    </div>
                </div>
            </div>
            {{-- <a href="{{ url()->previous() }}">
                <span>Return to previous page</span>
            </a> --}}
        </section>

        <!-- Leaflet JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.js"
            integrity="sha384-dRnG3QipUv9zvMAkW8XVg+heW0jhvccrGM6yDNC4uK+xmqvBnp+0xuL50PYs10n/" crossorigin=""></script>

    </main><!-- End #main -->
@endsection

<script>
    $(document).ready(function () {
        // group 
        $(".chatbox form .group").submit(function (e) {
            e.preventDefault();
            sendMessage2();
        });

        function sendMessage2() {
            var group_name = $("#group_name").val();
            var message = "<div class='response-group user'>" + group_name + "</div>";
            $("#response-group").append(message);

            $.ajax({
                url: "/eq-subsidiary-en",
                type: "POST",
                dataType: "json",
                data: {
                    message: group_name,
                    _token: "{{ csrf_token() }}"
                },
                success: function (response2) {
                    var message = "<div class='response-group bot'>" + response2.message + "</div>";
                    $("#response-group").append(message);
                }
            });

            $("#group_name").val("");
        }
        // end group


        // subsidiary 
        $(".chatbox form").submit(function (e) {
            e.preventDefault();
            sendMessage();
        });

        function sendMessage() {
            var subsidiary = $("#subsidiary").val();
            var message = "<div class='response user'>" + subsidiary + "</div>";
            $("#response").append(message);

            $.ajax({
                url: "/eq-subsidiary-en",
                type: "POST",
                dataType: "json",
                data: {
                    message: subsidiary,
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {
                    var message = "<div class='response bot'>" + response.message + "</div>";
                    $("#response").append(message);
                }
            });

            $("#subsidiary").val("");
        }
        // end 

        // nav 
        // Ambil semua link navigasi
        const navLinks = document.querySelectorAll('.nav-link');

        // Tambahkan event listener pada setiap link navigasi
        navLinks.forEach(link => {
            link.addEventListener('click', e => {
                e.preventDefault(); // Hentikan aksi default link navigasi

                // Ambil id tab pane yang sesuai dengan link navigasi yang ditekan
                const tabId = link.getAttribute('href');

                // Hapus class active dari semua link navigasi
                navLinks.forEach(link => {
                    link.classList.remove('active');
                });

                // Tambahkan class active pada link navigasi yang ditekan
                link.classList.add('active');

                // Sembunyikan semua tab pane
                const tabPanes = document.querySelectorAll('.tab.pane');
                tabPanes.forEach(pane => {
                    pane.style.display = 'none';
                });

                // Tampilkan tab pane yang sesuai dengan link navigasi yang ditekan
                const tabPane = document.querySelector(tabId);
                tabPane.style.display = 'block';
            });
        });

        var nav = document.querySelector('nav');
        nav.classList.add('active');
        // end nav 
    });

    // end nav 
</script>

@section('mapsLeaflet')
    <script src="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.js"></script>

    <script>
        const coordinates = <?php echo json_encode($coordinates); ?>;

        const map = L.map('map').setView([coordinates[0].latitude, coordinates[0].longitude], 13);

        // Pilihan basemap
        const basemaps = {
            'Esri Satellite': L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                attribution: 'Tiles &copy; Esri'
            }),
            'OpenStreetMap': L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
                maxZoom: 18,
            }),
            'Esri WorldStreetMap': L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}', {
                attribution: 'Tiles &copy; Esri'
            }),
            // Tambahkan jenis basemap lainnya sesuai kebutuhan
        };

        // Pilih basemap default
        basemaps['Esri Satellite'].addTo(map);

        // Tambahkan kontrol layer untuk mengubah basemap
        L.control.layers(basemaps).addTo(map);

        const markers = [];

        coordinates.forEach((coord, index) => {
            const marker = L.marker([coord.latitude, coord.longitude]).addTo(map);
            const formattedSize = Math.round(coord.sizebyeq).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

            @if(auth()->check() && in_array(auth()->user()->user_level, ['Premium']))
                if (coord.principal_activities === "Palm Oil Mill") {
                    marker.bindPopup(`<b>${coord.principal_activities}</b><br>Company Name: ${coord.subsidiary}<br>Mill Name: ${coord.facilities}<br>Mill Capacity: ${coord.capacity}<br>Location: ${coord.regency} District, ${coord.province} Province, ${coord.country_operation}<br>Latitude: ${coord.latitude}<br>Longitude: ${coord.longitude}<br>`);
                } else if (coord.principal_activities === "Refinery") {
                    marker.bindPopup(`<b>${coord.principal_activities}</b><br>Company Name: ${coord.subsidiary}<br>Refinery Name: ${coord.facilities}<br>Refinery Capacity: ${coord.capacity}<br>Location: ${coord.regency} District, ${coord.province} Province, ${coord.country_operation}<br>Latitude: ${coord.latitude}<br>Longitude: ${coord.longitude}<br>`);
                } else if (coord.principal_activities === "Manufacturer") {
                    marker.bindPopup(`<b>${coord.principal_activities}</b><br>Company Name: ${coord.subsidiary}<br>Manufacturer Name: ${coord.facilities}<br>Manufacturer Capacity: ${coord.capacity}<br>Location: ${coord.regency} District, ${coord.province} Province, ${coord.country_operation}<br>Latitude: ${coord.latitude}<br>Longitude: ${coord.longitude}<br>`);
                } else if (coord.principal_activities === "Oil Palm Plantation & Mill") {
                    marker.bindPopup(`<b>${coord.principal_activities}</b><br>Company Name: ${coord.subsidiary}<br>Mill Name: ${coord.facilities}<br>Mill Capacity: ${coord.capacity}<br>Estate Name: ${coord.estate}<br>Planted: ${formattedSize} hectare<br>Location: ${coord.regency} District, ${coord.province} Province, ${coord.country_operation}<br>Latitude: ${coord.latitude}<br>Longitude: ${coord.longitude}<br>`);
                } else
                    marker.bindPopup(`<b>${coord.principal_activities}</b><br>Company Name: ${coord.subsidiary}<br>Estate Name: ${coord.estate}<br>Location: ${coord.regency} District, ${coord.province} Province, ${coord.country_operation}<br>Latitude: ${coord.latitude}<br>Longitude: ${coord.longitude}<br>`);
            @else
                // Add conditions for non-Premium users if needed
                // if (coord.principal_activities === "Non-Premium Activity") {
                //     marker.bindPopup(`Non-Premium Activity: ${coord.principal_activities}<br>Company Name: ${coord.subsidiary}<br>Estate Name: ${coord.estate}<br>Location: ${coord.regency} District, ${coord.province} Province, ${coord.country_operation}<br>Latitude: ${coord.latitude}<br>Longitude: ${coord.longitude}<br>`);
                // }
                if (coord.principal_activities === "Palm Oil Mill") {
                    marker.bindPopup(`<b>${coord.principal_activities}</b><br>Company Name: ${coord.subsidiary}<br>Mill Name: ${coord.facilities}<br>Mill Capacity: ${coord.capacity}<br>Location: ${coord.regency} District, ${coord.province} Province, ${coord.country_operation}<br>Latitude: ${coord.latitude}<br>Longitude: ${coord.longitude}<br>`);
                } else if (coord.principal_activities === "Refinery") {
                    marker.bindPopup(`<b>${coord.principal_activities}</b><br>Company Name: ${coord.subsidiary}<br>Refinery Name: ${coord.facilities}<br>Refinery Capacity: ${coord.capacity}<br>Location: ${coord.regency} District, ${coord.province} Province, ${coord.country_operation}<br>Latitude: ${coord.latitude}<br>Longitude: ${coord.longitude}<br>`);
                } else if (coord.principal_activities === "Manufacturer") {
                    marker.bindPopup(`<b>${coord.principal_activities}</b><br>Company Name: ${coord.subsidiary}<br>Manufacturer Name: ${coord.facilities}<br>Manufacturer Capacity: ${coord.capacity}<br>Location: ${coord.regency} District, ${coord.province} Province, ${coord.country_operation}<br>Latitude: ${coord.latitude}<br>Longitude: ${coord.longitude}<br>`);
                } else if (coord.principal_activities === "Oil Palm Plantation & Mill") {
                    marker.bindPopup(`<b>${coord.principal_activities}</b><br>Company Name: ${coord.subsidiary}<br>Mill Name: ${coord.facilities}<br>Mill Capacity: ${coord.capacity}<br>Estate Name: ${coord.estate}<br>Planted: ${formattedSize} hectare<br>Location: ${coord.regency} District, ${coord.province} Province, ${coord.country_operation}<br>Latitude: ${coord.latitude}<br>Longitude: ${coord.longitude}<br>`);
                } else
                    marker.bindPopup(`<b>${coord.principal_activities}</b><br>Company Name: ${coord.subsidiary}<br>Estate Name: ${coord.estate}<br>Location: ${coord.regency} District, ${coord.province} Province, ${coord.country_operation}<br>Latitude: ${coord.latitude}<br>Longitude: ${coord.longitude}<br>`);
            @endif

            markers.push(marker);
        });

        const group = new L.featureGroup(markers);
        map.fitBounds(group.getBounds());
    </script>

@endsection