@extends('layout.app')

@section('styleMaps')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.css" />
<style>

</style>
@endsection

@section('content')
<main id="main">

    <!-- ======= App Features Section ======= -->
    <section id="features" class="features" hidden>
        <div class="container">

            <div class="section-title">
                <h2>Nama Perusahaan (Group)</h2>
                <p>Deskripsi Perusahaan.</p>
            </div>

            <div class="row no-gutters">
                <div class="col-xl-12 d-flex align-items-stretch order-2 order-lg-1">
                    <div class="content d-flex flex-column justify-content-center">
                        <div class="row">
                            <div class="col-md-6 icon-box" data-aos="fade-up">
                                <i class="bx bx-receipt"></i>
                                <h4>Corporis voluptates sit</h4>
                                <p>Consequuntur sunt aut quasi enim aliquam quae harum pariatur laboris nisi ut aliquip
                                </p>
                            </div>
                            <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="100">
                                <i class="bx bx-cube-alt"></i>
                                <h4>Ullamco laboris nisi</h4>
                                <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
                                </p>
                            </div>
                            <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="200">
                                <i class="bx bx-images"></i>
                                <h4>Labore consequatur</h4>
                                <p>Aut suscipit aut cum nemo deleniti aut omnis. Doloribus ut maiores omnis facere</p>
                            </div>
                            <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="300">
                                <i class="bx bx-shield"></i>
                                <h4>Beatae veritatis</h4>
                                <p>Expedita veritatis consequuntur nihil tempore laudantium vitae denat pacta</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="row no-gutters">
                <div class="col-xl-7 d-flex align-items-stretch order-2 order-lg-1">
                    <div class="content d-flex flex-column justify-content-center">
                        <div class="row">
                            <div class="col-md-6 icon-box" data-aos="fade-up">
                                <i class="bx bx-receipt"></i>
                                <h4>Corporis voluptates sit</h4>
                                <p>Consequuntur sunt aut quasi enim aliquam quae harum pariatur laboris nisi ut aliquip
                                </p>
                            </div>
                            <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="100">
                                <i class="bx bx-cube-alt"></i>
                                <h4>Ullamco laboris nisi</h4>
                                <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
                                </p>
                            </div>
                            <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="200">
                                <i class="bx bx-images"></i>
                                <h4>Labore consequatur</h4>
                                <p>Aut suscipit aut cum nemo deleniti aut omnis. Doloribus ut maiores omnis facere</p>
                            </div>
                            <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="300">
                                <i class="bx bx-shield"></i>
                                <h4>Beatae veritatis</h4>
                                <p>Expedita veritatis consequuntur nihil tempore laudantium vitae denat pacta</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="image col-xl-5 d-flex align-items-stretch justify-content-center order-1 order-lg-2"
                    data-aos="fade-left" data-aos-delay="100">
                    <img src="assets/img/features.svg" class="img-fluid" alt="">
                </div>
            </div> --}}

        </div>
    </section><!-- End App Features Section -->

    <section class="section profile">
        <div class="row">
            <div class="section-title">
                @foreach($allShareholderNames->pluck('shareholder_name')->unique() as $subs)
                    <h2 class="card-title">{{$subs}} Share Ownership</h2>
                @endforeach
            </div>
            <div class="col-xl-12">

                <div style="display: flex; justify-content: center; align-items: center;">
                    <form action="{{ route('searchFunctionShareholder') }}" method="GET" class="d-flex"
                        style="width: 50%; background-color: #f8f9fa; border-radius: 10px; padding: 15px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                        <input type="text" class="form-control me-2" name="shareholder_name"
                            placeholder="Search for other shareholders"
                            style="border: 1px solid #007bff; border-radius: 5px;">
                        <button type="submit" class="btn btn-info"
                            style="border-radius: 5px; transition: background-color 0.3s;">
                            Search
                        </button>
                    </form>
                </div>

                <div class="card">
                    <div class="card-body pt-3">
                        <div class="tab-content pt-2">
                            @if(count($allShareholderNames) > 0)
                                                        <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                                            <div class="d-flex justify-content-between flex-wrap">
                                                                <div class="d-flex flex-wrap">
                                                                    @foreach($allShareholderNames->pluck('shareholder_name')->unique() as $subs)
                                                                        <h5 class="card-title me-3">{{ $subs }}</h5>
                                                                    @endforeach
                                                                </div>
                                                            </div>

                                                            @php
                                                                // Get unique companies and their positions
                                                                $positions = $allShareholderNames->unique('company_name');
                                                                $positionCount = $positions->count();
                                                            @endphp

                                                            <p class="small pl-2">
                                                                @if($positionCount > 0)
                                                                                                @php
                                                                                                    $displayedPositions = $positions->take(2); // Get up to two positions
                                                                                                    $remainingCount = $positionCount - $displayedPositions->count();
                                                                                                    $isCompany = Str::startsWith($allShareholderNames[0]->shareholder_name, 'PT'); // Check if shareholder_name starts with "PT"
                                                                                                    $hasPosition = $positions->pluck('position')->unique()->filter(fn($pos) => $pos !== '-')->isNotEmpty(); // Check if there are any valid positions
                                                                                                  @endphp

                                                                                                {{$allShareholderNames[0]->shareholder_name }}
                                                                                                @if($isCompany)
                                                                                                    @if($hasPosition)
                                                                                                        is a company that owns shares in
                                                                                                    @else
                                                                                                        is a company that owns shares in
                                                                                                    @endif
                                                                                                @else
                                                                                                    @if($positionCount == 1 && $hasPosition)
                                                                                                        is an entrepreneur who serves as
                                                                                                    @elseif($positionCount > 1 && $hasPosition)
                                                                                                        is an entrepreneur who has held various positions in several companies including
                                                                                                    @else
                                                                                                        is an entrepreneur who owns shares in
                                                                                                    @endif
                                                                                                @endif

                                                                                                @if($hasPosition)
                                                                                                    @if(!$isCompany || $displayedPositions->isNotEmpty())
                                                                                                        @foreach($displayedPositions as $position)
                                                                                                            {{ ucwords(strtolower($position->position)) }} at {{ $position->company_name }}
                                                                                                            @if(!$loop->last && $displayedPositions->count() > 1)
                                                                                                                @if($loop->iteration < $displayedPositions->count())
                                                                                                                    @if($loop->remaining > 1),@else and @endif
                                                                                                                @else
                                                                                                                    @if($remainingCount > 0) and @endif
                                                                                                                @endif
                                                                                                            @endif
                                                                                                        @endforeach

                                                                                                        @if($remainingCount > 0)
                                                                                                            @if($displayedPositions->count() > 0)
                                                                                                                , and
                                                                                                            @endif
                                                                                                            {{ $remainingCount }} other position(s).
                                                                                                        @endif
                                                                                                    @elseif($isCompany && $displayedPositions->isEmpty())
                                                                                                        without available leadership position information.
                                                                                                    @endif
                                                                                                @else
                                                                                                    @if($isCompany)
                                                                                                        {{ ucwords(strtolower($positions->first()->position)) }}.
                                                                                                    @else
                                                                                                        at the following companies:
                                                                                                        @foreach($positions->pluck('company_name')->unique() as $companyName)
                                                                                                            {{ $companyName }}
                                                                                                            @if(!$loop->last)
                                                                                                                ,
                                                                                                            @endif
                                                                                                        @endforeach
                                                                                                        {{ $remainingCount > 0 ? 'and ' . $remainingCount . ' other company(s).' : '.' }}
                                                                                                    @endif
                                                                                                @endif
                                                                @else
                                                                    <!-- <p>No results found.</p> -->
                                                                @endif
                                                            </p>

                                                            <h5 class="card-title">Basic Information</h5>

                                                            <div class="row">
                                                                <div class="col-lg-6 col-md-6">
                                                                    <div class="row">
                                                                        <div class="col-lg-5 col-md-4 label">Shareholder Name</div>
                                                                        @foreach($allShareholderNames->pluck('shareholder_name')->unique() as $shareholder_name)
                                                                            @if($shareholder_name)
                                                                                <div class="col-lg-7 col-md-8">: {!! nl2br(e($shareholder_name)) !!}</div>
                                                                            @else
                                                                                <div class="col-lg-7 col-md-8">: -</div>
                                                                            @endif
                                                                        @endforeach
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-6 col-md-6">
                                                                    <div class="row">
                                                                        <div class="col-lg-5 col-md-4 label ">IC/Passport/Kitas/Company
                                                                            No./Indentification No.</div>
                                                                        @foreach($allShareholderNames->pluck('ic_pasport_comp_number')->unique() as $ic_pasport_comp_number)
                                                                            @if($ic_pasport_comp_number)
                                                                                <div class="col-lg-7 col-md-8">: {!! nl2br(e($ic_pasport_comp_number)) !!}
                                                                                </div>
                                                                            @else
                                                                                <div class="col-lg-7 col-md-8">: -</div>
                                                                            @endif
                                                                        @endforeach
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-6 col-md-6">
                                                                    <div class="row">
                                                                        <div class="col-lg-5 col-md-4 label">Date Of Birth</div>
                                                                        @foreach($allShareholderNames->pluck('date_of_birth')->unique() as $date_of_birth)
                                                                            @if($date_of_birth)
                                                                                <div class="col-lg-7 col-md-8">: {!! nl2br(e($date_of_birth)) !!}</div>
                                                                            @else
                                                                                <div class="col-lg-7 col-md-8">: -</div>
                                                                            @endif
                                                                        @endforeach
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-6 col-md-6">
                                                                    <div class="row">
                                                                        <div class="col-lg-5 col-md-4 label">Address</div>
                                                                        <div class="col-lg-7 col-md-8">
                                                                            @foreach($allShareholderNames->pluck('address')->unique() as $address)
                                                                                @if($address)
                                                                                    <div>: {!! nl2br(e($address)) !!}</div>
                                                                                @else
                                                                                    <div>: -</div>
                                                                                @endif
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <hr>

                                                            @foreach($allShareholderNames->pluck('shareholder_name')->unique() as $shareholder_name)
                                                                @if($shareholder_name)
                                                                    <h5 class="card-title">{!! nl2br(e($shareholder_name)) !!}'s share ownership in the
                                                                        Company</h5>
                                                                @else
                                                                    <div class="col-lg-7 col-md-8">: -</div>
                                                                @endif
                                                            @endforeach

                                                            {{-- <div class="row">
                                                                <form action="{{ route('subsidiaryShow') }}" method="POST"
                                                                    enctype="multipart/form-data">
                                                                    @csrf
                                                                    @foreach($allShareholderNames->pluck('company_name')->unique() as $subs)
                                                                    <div>
                                                                        <input type="submit" name="subsidiary" value="{{ $subs }}"
                                                                            class="text-muted" style=" border: none;">
                                                                    </div>
                                                                    @endforeach
                                                                </form>
                                                            </div> --}}

                                                            <div class="row">
                                                                @foreach($allShareholderNames->unique('company_name') as $shareholder)
                                                                    @if($shareholder->company_name)
                                                                        <div class="col-lg-12 col-md-6 mb-4">
                                                                            <h5 class="card-title">
                                                                                <form action="{{ route('subsidiaryShow') }}" method="POST"
                                                                                    style="display: inline;">
                                                                                    @csrf
                                                                                    <input type="hidden" name="subsidiary"
                                                                                        value="{{ $shareholder->company_name }}">
                                                                                    <button type="submit"
                                                                                        style="background: none; border: none; font-size:17px; color: #012970; cursor: pointer; font-weight: bold; transition: color 0.3s;"
                                                                                        onmouseover="this.style.color='#007BFF';"
                                                                                        onmouseout="this.style.color='#012970';">
                                                                                        {!! nl2br(e($shareholder->company_name)) !!}
                                                                                    </button>
                                                                                </form>
                                                                            </h5>
                                                                            <div class="row">
                                                                                <div class="col-lg-6 col-md-6">
                                                                                    <div class="row">
                                                                                        <div class="col-lg-5 col-md-4 label">Position</div>
                                                                                        <div class="col-lg-7 col-md-8">
                                                                                            : {{ $shareholder->position ?? '-' }}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-6 col-md-6">
                                                                                    <div class="row">
                                                                                        <div class="col-lg-5 col-md-4 label">Percentage of Shares</div>
                                                                                        <div class="col-lg-7 col-md-8">
                                                                                            : {{ $shareholder->percentage_of_shares ?? '-' }}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-lg-6 col-md-6">
                                                                                    <div class="row">
                                                                                        <div class="col-lg-5 col-md-4 label">Number of Shares</div>
                                                                                        <div class="col-lg-7 col-md-8">
                                                                                            : {{ $shareholder->number_of_shares ?? '-' }}
                                                                                            ({{ $shareholder->currency ?? '-' }})
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-6 col-md-6">
                                                                                    <div class="row">
                                                                                        <div class="col-lg-5 col-md-4 label">Update</div>
                                                                                        <div class="col-lg-7 col-md-8">
                                                                                            : {{ $shareholder->data_update ?? '-' }}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                        <div class="col-lg-7 col-md-8">: -</div>
                                                                    @endif
                                                                @endforeach
                                                            </div>

                                                            <h6 class="card-title"><i>*Data source by Inovasi Digital</i></h6>
                                                            <div class="row" hidden>
                                                                <div class="col-lg-6 col-md-6">
                                                                    <div class="row">
                                                                        <div class="col-lg-5 col-md-4 label ">Data Source</div>
                                                                        @foreach($allShareholderNames->pluck('data_source')->unique() as $data_sources)
                                                                            @if($data_sources)
                                                                                <div class="col-lg-7 col-md-8">: {!! nl2br(e($data_sources)) !!}</div>
                                                                            @else
                                                                                <div class="col-lg-7 col-md-8">: -</div>
                                                                            @endif
                                                                        @endforeach
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-6 col-md-6">
                                                                    <div class="row">
                                                                        <div class="col-lg-5 col-md-4 label ">Data Update</div>
                                                                        @foreach($allShareholderNames->pluck('data_update')->unique() as $data_update)
                                                                            @if($data_update)
                                                                                <div class="col-lg-7 col-md-8">: {!! nl2br(e($data_update)) !!}</div>
                                                                            @else
                                                                                <div class="col-lg-7 col-md-8">: -</div>
                                                                            @endif
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
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
    AOS.init({
        duration: 1000, // Durasi animasi dalam milidetik
        once: true, // Animasi hanya berjalan sekali
    });
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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">
                    @foreach($allShareholderNames as $subs)
                        @if($loop->first)
                            <h4 class="title mb-0"> {{ $subs->group_name }}</h4>
                        @endif
                    @endforeach
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card" style="width: 100%;">
                    <div class="card-body row">
                        @foreach($allShareholderNames as $subs)
                                                <div class="col-6">
                                                    <h6 class="card-title description">Shareholder Name</h6>
                                                    <p class="card-text">{{ $subs->shareholder_name }}</p>
                                                    <h6 class="card-title description">Position</h6>
                                                    <p class="card-text">{{ $subs->position }}</p>
                                                    // @foreach($allShareholderNames as $subs)
                                                        // <div>
                                                            // @if($subs->shareholder_name1 !== 'Nil')
                                                                // <p class="card-text">{{ $subs->shareholder_name1 }} ({{ $subs->percent_of_share1 }})
                                                                </p>
                                                            // @endif

                                                            // @if($subs->shareholder_name2 !== 'Nil')
                                                                // <p class="card-text">{{ $subs->shareholder_name2 }} ({{ $subs->percent_of_share2 }})
                                                                </p>
                                                            // @endif

                                                            // @if($subs->shareholder_name3 !== 'Nil')
                                                                // <p class="card-text">{{ $subs->shareholder_name3 }} ({{ $subs->percent_of_share3 }})
                                                                </p>
                                                            // @endif

                                                            // @if($subs->shareholder_name4 !== 'Nil')
                                                                // <p class="card-text">{{ $subs->shareholder_name4 }} ({{ $subs->percent_of_share4 }})
                                                                </p>
                                                            // @endif

                                                            // @if($subs->shareholder_name5 !== 'Nil')
                                                                // <p class="card-text">{{ $subs->shareholder_name5 }} ({{ $subs->percent_of_share5 }})
                                                            // @endif
                                                                // </div>
                                                    // @endforeach
                                                    // <h6 class="card-title description">Management (Name and Position)</h6>
                                                    // <p class="card-text">
                                                        // <?php
                            //     $management = $subs->management_name_and_position;
                            //     echo nl2br(preg_replace('/\)/', ")\n", $management));
                            //     ?>
                                                        // </p>
                                                </div>
                                                <div class="col-6">

                                                    <h6 class="card-title description">Total of Shares</h6>
                                                    <p class="card-text">{{ $subs->total_of_shares }}</p>
                                                    <h6 class="card-title description">Percentage of Shares</h6>
                                                    <p class="card-text">{{ $subs->percentage_of_shares }}</p>
                                                </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
        <!-- <div class="modal-footer">
        <button type="button" class="btn btn-info" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-info">Save changes</button>
      </div> -->
    </div>
</div>
</div>

<script>
    var pdfUrl = "{{ asset('file/notarial-act-groups/2021 07 Abdi Budi Mulia.pptx.pdf') }}";

    function loadPdfViewer() {
        var container = document.getElementById('pdf-viewer-container');
        var canvas = document.getElementById('pdf-viewer');
        var params = {
            pdfUrl: pdfUrl
        };

        var pdfViewer = new PDFJS.PDFViewer({
            container: container,
            viewer: {
                container: container,
                canvas: canvas,
            },
        });
        pdfViewer.init(params);
    }

    window.onload = function () {
        loadPdfViewer();
    };
</script>

@endsection