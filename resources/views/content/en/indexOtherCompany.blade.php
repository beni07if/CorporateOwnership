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
                    <li><a href="#" style="color:#4682B4;">badan_hukum</a></li>
                </ol> -->
                <!-- <h2 style="color:#4682B4;">badan_hukum</h2> -->
            </div>
            <div class="row" style="box-shadow: rgba(44, 73, 100, 0.08) 0px 2px 15px 0px;">
                <div class="col-xl-8 col-lg-6 es d-flex flex-column align-items-stretch justify-content-center py-5 px-lg-5">
                @foreach($otherCompanies->groupBy('badan_hukum') as $badanHukumGroup)
                    <div style="display:flex;">
                        <h4 class="description">{{$badanHukumGroup->first()->badan_hukum}} &ensp;  
                        </h4>
                    </div>
                @endforeach
                    <!-- <div style="padding-top:50px;">
                        <h3 class="description">Summary</h3>
                    </div> -->
                    <div class="row pt-4 pl-15">
                        <div class="col-md-6">
                            <div class="">
                                <h6 class="description">Badan Hukum</h6>
                                @foreach($otherCompanies->pluck('badan_hukum')->unique() as $subs)
                                    <p class="text-muted">{{$subs}}</p>
                                @endforeach
                            </div>
                            <div class="">
                                <h6 class="description">Notaris</h6>
                                @foreach($otherCompanies->pluck('notaris')->unique() as $subs)
                                    <p class="text-muted">{{$subs}}</p>
                                @endforeach
                            </div>
                            <div class="">
                                <h6 class="description">Kedudukan</h6>
                                @if(auth()->check() && in_array(auth()->user()->user_level, ['Standard', 'Premium']))
                                    @foreach($otherCompanies->pluck('kedudukan')->unique() as $subs)
                                    <p class="text-muted">{{$subs}}</p>
                                    @endforeach
                                @else
                                @foreach($otherCompanies->pluck('kedudukan')->unique() as $subs)
                                    <p class="text-muted">{{$subs}}</p>
                                @endforeach
                                <!-- <div class="card">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <div class="alert alert-danger" role="alert">
                                                For standard/premium subscribed userssss
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                                @endif
                            </div>
                            <div class="">
                                <h6 class="description">No BN</h6>
                                @foreach($otherCompanies->pluck('no_bn')->unique() as $subs)
                                    <p class="text-muted">{{$subs}}</p>
                                @endforeach
                            </div>
                            <div class="">
                                <h6 class="description">No TBN</h6>
                                @foreach($otherCompanies->pluck('no_tbn')->unique() as $subs)
                                    <p class="text-muted">{{$subs}}</p>
                                @endforeach
                            </div>
                            <div class="">
                                <h6 class="description">Tahun Terbit</h6>
                                @foreach($otherCompanies->pluck('tahun_terbit')->unique() as $subs)
                                    <p class="text-muted">{{$subs}}</p>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="">
                                <h6 class="description">Jenis Badah Hukum</h6>
                                @foreach($otherCompanies->pluck('jenis_badan_hukum')->unique() as $subs)
                                    <p class="text-muted">{{$subs}}</p>
                                @endforeach
                            </div>
                            <div class="">
                                <h6 class="description">Jenis Transaksi</h6>
                                @foreach($otherCompanies->pluck('jenis_transaksi')->unique() as $subs)
                                    <p class="text-muted">{{$subs}}</p>
                                @endforeach
                            </div>
                            <div class="">
                                <h6 class="description">No SK</h6>
                                @foreach($otherCompanies->pluck('no_sk')->unique() as $subs)
                                    <p class="text-muted">{{$subs}}</p>
                                @endforeach
                            </div>
                            <div class="">
                                <h6 class="description">Tanggal SK</h6>
                                @foreach($otherCompanies->pluck('tanggal_sk')->unique() as $subs)
                                    <p class="text-muted">{{$subs}}</p>
                                @endforeach
                            </div>
                            <div class="">
                                <h6 class="description">No Akta</h6>
                                @foreach($otherCompanies->pluck('no_akta')->unique() as $subs)
                                    <p class="text-muted">{{$subs}}</p>
                                @endforeach
                            </div>
                            <div class="">
                                <h6 class="description">Tanggal Akta</h6>
                                @foreach($otherCompanies->pluck('tanggal_akta')->unique() as $subs)
                                    <p class="text-muted">{{$subs}}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="container" style="padding-top:50px;">
                        <h5 class="description">Search other Subsidiaries</h5>
                        <!-- <p class="fst-italic">A group company is a collection of individual companies or subsidiaries that are controlled by a single parent company. The parent company, often referred to as the holding company or the group, typically holds a majority stake or controlling the badan_hukum companies. The information about Group Company can be used to identify the badan_hukum under.</p> -->
                        <form action="{{ route('searchFunctionSubsidiary') }}" method="GET" class="d-flex">
                            <input type="text" class="form-control me-2" name="query" placeholder="Search...">
                            <button type="submit" class="btn btn-info">Search</button>
                        </form>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 es d-flex flex-column align-items-stretch py-5 px-lg-5" style="background-color: #F5F5F5;">
                    <div class="blog sidebar">
                        <h4>Company Profile Access</h4>
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
        </div>
    </section><!-- End About Section -->

    <!-- Leaflet JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.js" integrity="sha384-dRnG3QipUv9zvMAkW8XVg+heW0jhvccrGM6yDNC4uK+xmqvBnp+0xuL50PYs10n/" crossorigin=""></script>

</main><!-- End #main -->
@endsection
