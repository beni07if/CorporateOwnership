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
            @if (count($consolidations) > 0)
            <div class="row" style="box-shadow: rgba(44, 73, 100, 0.08) 0px 2px 15px 0px;">
                <div class="col-xl-8 col-lg-6 es d-flex flex-column align-items-stretch justify-content-center py-5 px-lg-5">
                @foreach($consolidations->groupBy('subsidiary') as $subsidiaryGroup)
                    <div style="display:flex;">
                        <h5 class="card-title-description">{{$subsidiaryGroup->first()->subsidiary}} &ensp;  
                        <!-- <a href="#" class="btn btn-info btn-sm" style="align:right;">Non-compliance historical</a> -->
                        </h5>
                    </div>
                    <p><i>Please contact helpdesk@earthqualizer.org to get notary act data.</i></p>
                    <div hidden>
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
                        <p>Please contact Us to get notarial deed and other information of {{$subsidiaryGroup->first()->subsidiary}}.</p>
                        @endif
                        <!-- <p class="text-muted">{{ $subsidiary }}</p> -->
                    </div>
                @endforeach

                    <div style="padding-top:50px;">
                        <h5 class="card-title-description">Summary</h5>
                    </div>
                     <p>{{$subsidiari}}</p>
                    @if(count($consolidations)>0)

                    <div class="row pt-4 pl-15">
                        <div class="col-md-6">
                            <div class="">
                            
                                <h6 class="text-muted">Company Name</h6>
                                @foreach($consolidations->pluck('subsidiary')->unique() as $subs)
                                    <p class="text-muted">{{$subs}}</p>
                                @endforeach
                            </div>
                            <div class="">
                            
                                <h6 class="text-muted">Group</h6>
                                @if(auth()->check() && in_array(auth()->user()->user_level, ['Standard', 'Premium']))
                                    @foreach($consolidations->pluck('group_name')->unique() as $subs)
                                    <p class="text-muted">{{$subs}}</p>
                                    @endforeach
                                @else
                                @foreach($consolidations->pluck('group_name')->unique() as $subs)
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
                                <h6 class="text-muted">Shareholders</h6>
                                <form action="{{ route('shareholderShow') }}" method="POST">
                                    @csrf
                                    @foreach($consolidations->pluck('shareholder_subsidiary')->flatten()->unique() as $shareholder)
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
                                                <button type="submit" name="shareholder_name" value="{{ $name }}" class="text-muted">
                                                    <p>{{ $key + 1 }}) {{ $name }} ({{ $ownership }})</p>
                                                </button>
                                            @endforeach
                                        @else
                                            <button type="submit" name="shareholder_name" value="{{ $shareholder }}" class="text-muted">
                                                <p>{{ $shareholder }}</p>
                                            </button>
                                        @endif
                                    @endforeach
                                </form>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="">
                                <h6 class="text-muted">Activity</h6>
                                @foreach($consolidations->pluck('principal_activities')->unique() as $activity)
                                @if($activity)
                                <p class="text-muted">{{ $activity }}</p>
                                @else
                                <p class="text-muted">-</p>
                                @endif
                                @endforeach
                            </div>
                            <div class="">
                                <h6 class="text-muted">Status Operation</h6>
                                @foreach($consolidations->pluck('status_operation')->unique() as $subs)
                                <p class="text-muted">{{$subs}}</p>
                                @endforeach
                            </div>
                            <!-- <div class="">
                                
                                <h6 class="text-muted">Planted</h6>
                                @if(count($consolidations) > 1)
                                @foreach($consolidations as $key => $subs)
                                @if($subs->sizebyeq)
                                <p class="text-muted">{{ $key + 1 }}) {{$subs->sizebyeq}} hectare</p>
                                @else
                                <p class="text-muted">{{ $key + 1 }}) -</p>
                                @endif
                                @endforeach
                                @else
                                @foreach($consolidations as $subs)
                                @if($subs->sizebyeq)
                                <p class="text-muted">{{$subs->sizebyeq}} hectare</p>
                                @else
                                <p class="text-muted">-</p>
                                @endif
                                @endforeach
                                @endif

                            </div>
                            <div class="">
                                <h6 class="text-muted">Capacity</h6>
                                @foreach($consolidations as $subs)
                                @if($subs->facilities)
                                <p class="text-muted">{{$subs->facilities}} ({{$subs->capacity}})</p>
                                @else
                                <p class="text-muted">-</p>
                                @endif
                                @endforeach
                            </div> -->
                            <div class="">
                                <h6 class="text-muted">Country Operation</h6>
                                @foreach($consolidations->pluck('country_operation')->unique() as $subs)
                                <p class="text-muted">{{$subs}}</p>
                                @endforeach
                            </div>
                            <!-- <div class="">
                                <h6 class="text-muted">Province</h6>
                                @foreach($consolidations->pluck('province')->unique() as $subs)
                                <p class="text-muted">{{$subs}}</p>
                                @endforeach
                            </div>
                            <div class="">
                                <h6 class="text-muted">District</h6>
                                @foreach($consolidations->pluck('regency')->unique() as $subs)
                                <p class="text-muted">{{$subs}}</p>
                                @endforeach
                            </div> -->
                        </div>
                    </div>
                    @endif
                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#exampleModal">See More</button>
                    <!-- <div id="mapid" style="height: 500px;"></div> -->
                    <!-- <div>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d25034.653727798323!2d100.72741630529931!3d0.9904701800450332!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d4b114cddeb057%3A0x119c6f62951397ec!2sPT.%20Rohul%20Palmindo%20Muara%20Dilam!5e1!3m2!1sid!2sid!4v1684138457370!5m2!1sid!2sid" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div><br> -->
                    <!-- <h3>Distribution of related companies</h3> -->
                    <div id="map" style="height: 400px;" hidden>
                        <div id="basemapSelector">
                            <label class="basemap-option">
                                <input type="radio" name="basemap" value="osm" checked> OpenStreetMap
                            </label>
                            <label class="basemap-option">
                                <input type="radio" name="basemap" value="satellite"> Satellite
                            </label>
                            <label class="basemap-option">
                                <input type="radio" name="basemap" value="topo"> Topographic
                            </label>
                        </div>
                    </div>
                    <!-- <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                @if(!auth()->check() || (auth()->user()->user_level === "Standard"))
                                    <div class="alert alert-danger" role="alert">
                                    Location information popup for premium subscribed users.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div> -->
                    <div class="container" style="padding-top:50px;">
                        <h5 class="card-title description">Search more companies</h5>
                        <!-- <p class="fst-italic">A group company is a collection of individual companies or subsidiaries that are controlled by a single parent company. The parent company, often referred to as the holding company or the group, typically holds a majority stake or controlling the subsidiary companies. The information about Group Company can be used to identify the subsidiary under.</p> -->
                        <form action="{{ route('searchFunctionSubsidiary') }}" method="GET" class="d-flex">
                            <input type="text" class="form-control me-2" name="query" placeholder="Search...">
                            <button type="submit" class="btn btn-info">Search</button>
                        </form>
                    </div>
                    <a href="{{ url()->previous() }}">
                        <span>Return to previous page</span>
                    </a>
                </div>
                <div class="col-xl-4 col-lg-6 es d-flex flex-column align-items-stretch py-5 px-lg-5" style="background-color: #F5F5F5;">
                    <div class="blog sidebar">
                        <h5 class="card-title-description">Company Profile Access</h5>
                        <!-- <p>Official company dataset of @foreach($consolidations->pluck('subsidiary')->unique() as $subs)
                            {{$subs}}.
                            @endforeach
                        </p> -->
                        <!-- End sidebar tags-->
                        <!-- <a href="default.asp" class="book" target="_blank">This is a link</a><span>test</span> -->
                        <!-- <button type="button" class="alert alert-success d-block w-100 left" data-bs-toggle="modal" data-bs-target="#modalStandard">
                            Standard (full dataset)
                            <span class="right">$50</span>
                        </button>
                        <br>
                        <button type="button" class="alert alert-info d-block w-100 left" data-bs-toggle="modal" data-bs-target="#modalPremium">
                            Premium (Standard + mapping structure)
                            <span class="right">$70</span>
                        </button> -->
                        
                    </div><!-- End sidebar -->
                    <!-- <a href="#appointment" class="appointment-btn" style="justify-content: center; align-items:center; text-align:center;">Buy</a> -->
                    <div class="line"></div>
                    <div class="report-benefit">
                        <p>If the data You're looking for is not found, You can contact us via email at helpdesk@earthqualizer.org.</p>
                        <p>We will process your request within 3x24 hours.</p>
                        <!-- <ul class="benefit-list">
                            <li>Sector operation</li>
                            <li>Group</li>
                            <li>Shareholder</li>
                            <li>Etc</li>
                        </ul> -->
                        <!-- <p>View sample data</p>
                        <ul class="sample-subsidiary">
                            <li><a href="#">Standard member</a>
                            </li>
                            <li><a href="#">Premium member</a>
                            </li>
                        </ul> -->
                        <div class="line"></div>
                        <!-- <div class="col-lg-12 mt-5 mt-lg-0">
                            <p class="mt-3">Contact Us</p>
                            <form action="{{route('messages.store')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group mt-3">
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Your Name" required>
                                </div>
                                <div class="form-group mt-3">
                                    <input type="text" class="form-control" name="phone" id="phone" placeholder="Your Phone" required>
                                </div>
                                <div class="form-group mt-3">
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
                                </div>
                                <div class="form-group mt-3">
                                    <input type="text" class="form-control" name="institution" id="institution" placeholder="Institution" required>
                                </div>
                                <div class="form-group mt-3">
                                    <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
                                </div>
                                <div class="form-group mt-3">
                                    <input type="text" class="form-control" name="status" id="status" placeholder="Status" value="Open" hidden>
                                </div>
                                <div class="form-group mt-3">
                                <input type="date" class="form-control" name="date_message" id="date_message" placeholder="date_message" value="<?= date('Y-m-d'); ?>" hidden>
                                </div>
                                <div class="form-group mt-3"><button class="btn btn-info" type="submit">Send Message</button></div>
                            </form>
                        </div> -->
                    </div>
                    <!-- Modal Standard -->
                    <div class="modal fade" id="modalStandard" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Standard member data set overview</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Tambahkan elemen gambar di bawah ini -->
                                <div style="max-width: 100%; height: auto; text-align: center;">
                                <img src="{{asset('img/standard.JPG')}}" alt="Image">
                                </div>
                                <!-- Akhiri bagian elemen gambar -->
                                <p></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-info">Save changes</button>
                            </div>
                            </div>
                        </div>
                    </div><!-- Modal Premium-->
                    <div class="modal fade" id="modalPremium" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Premium member data set overview</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Tambahkan elemen gambar di bawah ini -->
                                <div style="max-width: 100%; height: auto; text-align: center;">
                                <img src="{{asset('img/premium.JPG')}}" alt="Image">
                                </div>
                                <!-- Akhiri bagian elemen gambar -->
                                <p></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-info">Save changes</button>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                <i class="text-muted">*Note: Data source from InovasiDigital</i>
            </div>
            @else
            <div class="row" style="box-shadow: rgba(44, 73, 100, 0.08) 0px 2px 15px 0px;">
                <div class="col-xl-8 col-lg-6 es d-flex flex-column align-items-stretch justify-content-center py-5 px-lg-5">
                    <div class="container" style="padding-top:50px;">
                        <h5 class="card-title description">To get information from this company please contact us at <span style="color: #0AA7C4;">helpdesk@earthqualizer.org</span></h5>
                        <!-- <p class="fst-italic">A group company is a collection of individual companies or subsidiaries that are controlled by a single parent company. The parent company, often referred to as the holding company or the group, typically holds a majority stake or controlling the subsidiary companies. The information about Group Company can be used to identify the subsidiary under.</p> --> 
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 es d-flex flex-column align-items-stretch py-5 px-lg-5" style="background-color: #F5F5F5;">
                    <div class="blog sidebar">
                    <h5 class="card-title-description">Company Profile Access</h5>
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

        <div>
            <!-- resources/views/search.blade.php -->

            <!-- <form action="{{ route('search') }}" method="GET">
                <input type="text" name="keyword" placeholder="Search...">
                <button type="submit">Search</button>
            </form>

            <h2>Search Results</h2>

            <h3>Users</h3>
            <ul>
                @foreach ($users as $user)
                <li>{{ $user->message }} - {{ $user->reply }}</li>
                @endforeach
            </ul>

            <h3>Products</h3>
            <ul>
                @foreach ($consolidations as $product)
                <li>{{ $product->group_name }} - {{ $product->shareholder_subsidiary }}</li>
                @endforeach
            </ul> -->

        </div>
        
    </section><!-- End About Section -->

    <!-- Leaflet JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.js" integrity="sha384-dRnG3QipUv9zvMAkW8XVg+heW0jhvccrGM6yDNC4uK+xmqvBnp+0xuL50PYs10n/" crossorigin=""></script>

</main><!-- End #main -->
@endsection

<script>
    $(document).ready(function() {
        // group 
        $(".chatbox form .group").submit(function(e) {
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
                success: function(response2) {
                    var message = "<div class='response-group bot'>" + response2.message + "</div>";
                    $("#response-group").append(message);
                }
            });

            $("#group_name").val("");
        }
        // end group


        // subsidiary 
        $(".chatbox form").submit(function(e) {
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
                success: function(response) {
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
        }else if (coord.principal_activities === "Refinery") {
            marker.bindPopup(`<b>${coord.principal_activities}</b><br>Company Name: ${coord.subsidiary}<br>Refinery Name: ${coord.facilities}<br>Refinery Capacity: ${coord.capacity}<br>Location: ${coord.regency} District, ${coord.province} Province, ${coord.country_operation}<br>Latitude: ${coord.latitude}<br>Longitude: ${coord.longitude}<br>`);
        }else if (coord.principal_activities === "Manufacturer") {
            marker.bindPopup(`<b>${coord.principal_activities}</b><br>Company Name: ${coord.subsidiary}<br>Manufacturer Name: ${coord.facilities}<br>Manufacturer Capacity: ${coord.capacity}<br>Location: ${coord.regency} District, ${coord.province} Province, ${coord.country_operation}<br>Latitude: ${coord.latitude}<br>Longitude: ${coord.longitude}<br>`);
        }else if (coord.principal_activities === "Oil Palm Plantation & Mill") {
            marker.bindPopup(`<b>${coord.principal_activities}</b><br>Company Name: ${coord.subsidiary}<br>Mill Name: ${coord.facilities}<br>Mill Capacity: ${coord.capacity}<br>Estate Name: ${coord.estate}<br>Planted: ${formattedSize} hectare<br>Location: ${coord.regency} District, ${coord.province} Province, ${coord.country_operation}<br>Latitude: ${coord.latitude}<br>Longitude: ${coord.longitude}<br>`);
        }else
            marker.bindPopup(`<b>${coord.principal_activities}</b><br>Company Name: ${coord.subsidiary}<br>Estate Name: ${coord.estate}<br>Location: ${coord.regency} District, ${coord.province} Province, ${coord.country_operation}<br>Latitude: ${coord.latitude}<br>Longitude: ${coord.longitude}<br>`);
    @else
        // Add conditions for non-Premium users if needed
        // if (coord.principal_activities === "Non-Premium Activity") {
        //     marker.bindPopup(`Non-Premium Activity: ${coord.principal_activities}<br>Company Name: ${coord.subsidiary}<br>Estate Name: ${coord.estate}<br>Location: ${coord.regency} District, ${coord.province} Province, ${coord.country_operation}<br>Latitude: ${coord.latitude}<br>Longitude: ${coord.longitude}<br>`);
        // }
        if (coord.principal_activities === "Palm Oil Mill") {
            marker.bindPopup(`<b>${coord.principal_activities}</b><br>Company Name: ${coord.subsidiary}<br>Mill Name: ${coord.facilities}<br>Mill Capacity: ${coord.capacity}<br>Location: ${coord.regency} District, ${coord.province} Province, ${coord.country_operation}<br>Latitude: ${coord.latitude}<br>Longitude: ${coord.longitude}<br>`);
        }else if (coord.principal_activities === "Refinery") {
            marker.bindPopup(`<b>${coord.principal_activities}</b><br>Company Name: ${coord.subsidiary}<br>Refinery Name: ${coord.facilities}<br>Refinery Capacity: ${coord.capacity}<br>Location: ${coord.regency} District, ${coord.province} Province, ${coord.country_operation}<br>Latitude: ${coord.latitude}<br>Longitude: ${coord.longitude}<br>`);
        }else if (coord.principal_activities === "Manufacturer") {
            marker.bindPopup(`<b>${coord.principal_activities}</b><br>Company Name: ${coord.subsidiary}<br>Manufacturer Name: ${coord.facilities}<br>Manufacturer Capacity: ${coord.capacity}<br>Location: ${coord.regency} District, ${coord.province} Province, ${coord.country_operation}<br>Latitude: ${coord.latitude}<br>Longitude: ${coord.longitude}<br>`);
        }else if (coord.principal_activities === "Oil Palm Plantation & Mill") {
            marker.bindPopup(`<b>${coord.principal_activities}</b><br>Company Name: ${coord.subsidiary}<br>Mill Name: ${coord.facilities}<br>Mill Capacity: ${coord.capacity}<br>Estate Name: ${coord.estate}<br>Planted: ${formattedSize} hectare<br>Location: ${coord.regency} District, ${coord.province} Province, ${coord.country_operation}<br>Latitude: ${coord.latitude}<br>Longitude: ${coord.longitude}<br>`);
        }else
            marker.bindPopup(`<b>${coord.principal_activities}</b><br>Company Name: ${coord.subsidiary}<br>Estate Name: ${coord.estate}<br>Location: ${coord.regency} District, ${coord.province} Province, ${coord.country_operation}<br>Latitude: ${coord.latitude}<br>Longitude: ${coord.longitude}<br>`);
    @endif

    markers.push(marker);
});

    const group = new L.featureGroup(markers);
    map.fitBounds(group.getBounds());
</script>


<!-- Modal -->
@if(count($consolidations)>0)
@foreach($consolidations->pluck('subsidiary')->unique() as $subs)
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                @foreach($consolidations->pluck('subsidiary')->unique() as $subs)
                    <h5 class="card-title description">{{$subs}}</h5>
                @endforeach
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card" style="width: 100%;">
                    <div class="card-body row">
                        <div class="col-6">
                            <h6 class="card-title description">Company Name</h6>
                            @foreach($consolidations->pluck('subsidiary')->unique() as $subs)
                                <p class="text-muted">{{$subs}}</p>
                            @endforeach
                            <h6 class="card-title description">Group</h6>
                            @foreach($consolidations->pluck('group_name')->unique() as $subs)
                                <p class="text-muted">{{$subs}}</p>
                            @endforeach
                            <h6 class="card-title description">Shareholders</h6>
                            @foreach($consolidations->pluck('shareholder_subsidiary')->unique() as $subs)
                                <p class="text-muted">{{$subs}}</p>
                            @endforeach
                            <h6 class="card-title description">Principal Activity</h6>
                            @foreach($consolidations->pluck('principal_activities')->unique() as $subs)
                                <p class="text-muted">{{$subs}}</p>
                            @endforeach
                            <h6 class="card-title description">Status Operation</h6>
                            @foreach($consolidations->pluck('status_operation')->unique() as $subs)
                                <p class="text-muted">{{$subs}}</p>
                            @endforeach
                            <h6 class="card-title description">Facility</h6>
                            @foreach($consolidations->pluck('facilities')->unique() as $subs)
                                <p class="text-muted">{{$subs}}</p>
                            @endforeach
                            <h6 class="card-title description">Estate</h6>
                            @foreach($consolidations->pluck('estate')->unique() as $subs)
                                <p class="text-muted">{{$subs}}</p>
                            @endforeach
                            <!-- <h6 class="card-title description">Capacity</h6>
                            @foreach($consolidations->pluck('capacity')->unique() as $subs)
                                <p class="text-muted">{{$subs}}</p>
                            @endforeach
                            <h6 class="card-title description">Latitude</h6>
                            @foreach($consolidations->pluck('latitude')->unique() as $subs)
                                <p class="text-muted">{{$subs}}</p>
                            @endforeach
                            <h6 class="card-title description">Longitude</h6>
                            @foreach($consolidations->pluck('longitude')->unique() as $subs)
                                <p class="text-muted">{{$subs}}</p>
                            @endforeach -->
                        </div>
                        <div class="col-6">
                            <h6 class="card-title description">Country Operation</h6>
                            @foreach($consolidations->pluck('country_operation')->unique() as $subs)
                                <p class="text-muted">{{$subs}}</p>
                            @endforeach
                            <h6 class="card-title description">Province</h6>
                            @foreach($consolidations->pluck('province')->unique() as $subs)
                                <p class="text-muted">{{$subs}}</p>
                            @endforeach
                            <h6 class="card-title description">District</h6>
                            @foreach($consolidations->pluck('regency')->unique() as $subs)
                                <p class="text-muted">{{$subs}}</p>
                            @endforeach
                            <!-- <h6 class="card-title description">Size by EQ</h6>
                            @foreach($consolidations->pluck('sizebyeq')->unique() as $subs)
                                <p class="text-muted">{{$subs}}</p>
                            @endforeach -->
                            <h6 class="card-title description">RSPO Certified</h6>
                            @foreach($consolidations->pluck('rspo_certified')->unique() as $subs)
                                <p class="text-muted">{{$subs}}</p>
                            @endforeach
                            <h6 class="card-title description">Other Certification</h6>
                            @foreach($consolidations->pluck('other_certification')->unique() as $subs)
                                <p class="text-muted">{{$subs}}</p>
                            @endforeach
                            <h6 class="card-title description">Data Source</h6>
                            @foreach($consolidations->pluck('data_source')->unique() as $subs)
                                <p class="text-muted">{{$subs}}</p>
                            @endforeach
                            <h6 class="card-title description">Data Update</h6>
                            @foreach($consolidations->pluck('data_update')->unique() as $subs)
                                <p class="text-muted">{{$subs}}</p>
                            @endforeach
                        </div>
                        <div class="border-top my-3"></div>
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
@endforeach
@endif
@endsection