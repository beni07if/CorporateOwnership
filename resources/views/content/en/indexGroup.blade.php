@extends('layout.app')

@section('styleMaps')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.css" />
<style>
    .descriptions {
        display: inline-block;
        padding: 5px 5px;
        font-size: 16px;
        background-color: #f0f0f0;
        border: none;
        border-radius: 4px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: background-color 0.5s ease, transform 0.5s ease;
    }

    .descriptions:hover {
        background-color: #e0e0e0;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .descriptions:active {
        background-color: #d0d0d0;
        transform: translateY(1px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .header-map p {
        padding-top: 50px;
        display: inline-block;
        margin: 0;
    }


    /* .icon-box {
        text-align: center;
    }

    .icon {
        margin-bottom: 10px;
    }

    .title {
        margin-bottom: 15px;
        font-size: 18px;
    } */

    .card {
        width: 300px;
        margin: 0 auto;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .card-body {
        padding: 20px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .descriptions {
        display: block;
        width: 100%;
        background-color: #F5F5F5;
        color: #696969;
        padding: 8px 15px;
        border: none;
        cursor: pointer;
        border-radius: 4px;
        text-align: left;
    }
</style>
@endsection

@section('content')
<main id="main">

    <!-- ======= About Section ======= -->
    <section id="about" class="about">
        <!-- <div class="container-fluid"> -->
        <div class="container">
            <div class="breadcrumbs" style="padding-left: 40px; background-color:white;">
                <ol style="color:#4682B4;">
                    <li><a href="#" style="color:#4682B4;">Home</a></li>
                    <li><a href="#" style="color:#4682B4;">Indonesia</a></li>
                    <li><a href="#" style="color:#4682B4;">Corporate Profile</a></li>
                    <li><a href="#" style="color:#4682B4;">Subsidiary</a></li>
                </ol>
                <!-- <h2 style="color:#4682B4;">Subsidiary</h2> -->
            </div>

            <div class="row" style="box-shadow: rgba(44, 73, 100, 0.08) 0px 2px 15px 0px;">
                <div class="col-xl-8 col-lg-6 icon-boxes d-flex flex-column align-items-stretch justify-content-center py-5 px-lg-5">

                    <h3>{{$perusahaan}}&ensp;  
                        <!-- <a href="#" class="btn btn-info btn-sm" style="align:right;">Non-compliance historical</a> -->
                    </h3>
                    <div>
                        <iframe src="{{asset('file/notarial-act-subsidiaries/TransformPlatform_Case_MON0002.pdf')}}" width="100%" height="600px"></iframe>
                    </div>
                    <div style="padding-top:50px;">
                        <h3>Summary</h3>
                    </div>
                    <p>{{$subsidiary}}</p>
                    @if(count($consolidations)>0)

                    <div class="row">
                        <div class="col-md-6">
                            <div class="icon-box">
                                <h4 class="title">Group Name</h4>
                                @foreach($consolidations->pluck('group_name')->unique() as $subs)
                                <p class="description">{{$subs}}</p>
                                @endforeach
                            </div>
                            <div class="icon-box @if(!$consolidations->pluck('owner')->unique()->count() || in_array('Check', $consolidations->pluck('owner')->unique()->toArray())) d-none @endif">
                                <h4 class="title">Owner</h4>
                                @foreach($consolidations->pluck('owner')->unique() as $owner)
                                @if($owner)
                                @if($owner == 'Check')
                                <p class="description">-</p>
                                @else
                                <p class="description">{{ $owner }}</p>
                                @endif
                                @else
                                <p class="description">-</p>
                                @endif
                                @endforeach
                            </div>
                            <div class="icon-box">
                                <h4 class="title">Address</h4>
                                <p class="description">...</p>
                            </div>
                            <div class="icon-box">
                                <h4 class="title">List of Subsidiary</h4>
                                <form action="{{ route('subsidiaryShow') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="card">
                                        <div class="card-body">
                                            @foreach($consolidations->pluck('subsidiary')->unique() as $subs)
                                            <div class="form-group">
                                                <input type="submit" name="subsidiary" value="{{ $subs }}" class="descriptions">
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- <div class="icon-box">
                                <h4 class="title">Shareholders</h4>
                                @foreach($consolidations->pluck('shareholder_subsidiary')->unique() as $shareholders)
                                @if($shareholders)
                                <p class="description">{{ $shareholders }}</p>
                                @else
                                <p class="description">-</p>
                                @endif
                                @endforeach
                            </div> -->

                        </div>
                        <div class="col-md-6">
                            <div class="icon-box">
                                <h4 class="title">Sector</h4>
                                @foreach($consolidations->pluck('principal_activities')->unique() as $activity)
                                @if($activity)
                                <p class="description">{{ $activity }}</p>
                                @else
                                <p class="description">-</p>
                                @endif
                                @endforeach
                            </div>
                            <div class="icon-box">
                                <h4 class="title">Country Operation</h4>
                                <!-- @php
                                $uniqueLocations = $consolidations->unique(function($item) {
                                return $item->country_operation . $item->province . $item->regency;
                                });
                                @endphp

                                @foreach($uniqueLocations->take(3) as $location)
                                @php
                                $country = $location->country_operation;
                                $province = $location->province;
                                $regency = $location->regency;
                                @endphp

                                @if($country && $province && $regency)
                                <p class="description">{{$country}}, {{$province}} Province, {{$regency}} District</p>
                                @else
                                <p class="description">-</p>
                                @endif
                                @endforeach

                                @if($uniqueLocations->count() > 3)
                                <p class="description">Other locations..</p>
                                @endif -->

                                @foreach($consolidations->pluck('country_operation')->unique() as $subs)
                                <p class="description">{{$subs}}</p>
                                @endforeach

                            </div>
                        </div>
                    </div>
                    @endif
                    <!-- <div id="mapid" style="height: 500px;"></div> -->
                    <!-- <div>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d25034.653727798323!2d100.72741630529931!3d0.9904701800450332!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d4b114cddeb057%3A0x119c6f62951397ec!2sPT.%20Rohul%20Palmindo%20Muara%20Dilam!5e1!3m2!1sid!2sid!4v1684138457370!5m2!1sid!2sid" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div><br> -->
                    <div class="header-map">
                        <p class="description">
                            Distribution of companies from the 
                            @foreach($consolidations->pluck('group_name')->unique() as $subs) {{$subs}}
                            @endforeach
                            Group
                        </p>
                    </div>
                    <div id="map" style="height: 400px;">
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
                    <div class="col-lg-12 details order-2 order-lg-1 mt-3">
                        <div class="container">
                            <h3>Search for other groups</h3>
                            <form action="{{ route('searchFunctionGroup') }}" method="GET" class="d-flex">
                                <input type="text" class="form-control me-2" name="query" placeholder="Group Name">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 icon-boxes d-flex flex-column align-items-stretch py-5 px-lg-5" style="background-color: #F5F5F5;">
                    <div class="blog sidebar">

                        <h3>Company Profile Access</h3>
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
                        <button type="button" class="alert alert-primary d-block w-100 left" data-bs-toggle="modal" data-bs-target="#modalPremium">
                            Premium (Standard + mapping structure)
                            <span class="right">$70</span>
                        </button> -->
                        
                    </div><!-- End sidebar -->
                    <!-- <a href="#appointment" class="appointment-btn" style="justify-content: center; align-items:center; text-align:center;">Buy</a> -->
                    <div class="line"></div>
                    <div class="report-benefit">
                        <p>If the data You're looking for is not found, You can contact us via email at info@inovasidigital.asia.</p>
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
                        <div class="col-lg-12 mt-5 mt-lg-0">
                            <h4 class="mt-3">Contact Us</h4>
                            <form action="forms/contact.php" method="post" role="form" class="php-email-form">
                            <div class="form-group mt-3">
                                <input type="text" class="form-control" name="name" id="name" placeholder="Your Name" required>
                            </div>
                            <div class="form-group mt-3">
                                <input type="text" class="form-control" name="institution" id="institution" placeholder="Institution" required>
                            </div>
                            <div class="form-group mt-3">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
                            </div>
                            <div class="form-group mt-3">
                                <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
                            </div>
                            <div class="form-group mt-3"><button class="btn btn-info" type="submit">Send Message</button></div>
                            </form>

                        </div>
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
                                <button type="button" class="btn btn-primary">Save changes</button>
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
                                <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
        const formattedSize = Math.round(coord.sizebyeq).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","); // Format angka bulat tanpa angka desimal dengan tanda koma sebagai pemisah ribuan
        marker.bindPopup(`<b>${coord.principal_activities}</b><br>Group Name: ${coord.subsidiary}<br>Subsidiary: ${coord.subsidiary}<br>Mill Name: ${coord.facilities}<br>Capacity: ${coord.capacity}<br>Estate Name: ${coord.estate}<br>Planted: ${formattedSize} hectare<br>Location: ${coord.regency} District, ${coord.province} Province, ${coord.country_operation}<br>Latitude: ${coord.latitude}<br>Longitude: ${coord.longitude}<br>`);
        markers.push(marker);
    });

    const group = new L.featureGroup(markers);
    map.fitBounds(group.getBounds());
</script>

@endsection