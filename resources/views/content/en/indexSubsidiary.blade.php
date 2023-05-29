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

                    <h3>{{$perusahaan}}</h3>
                    <p>{{$subsidiary}}</p>
                    @if(count($consolidations)>0)

                    <div class="row">
                        <div class="col-md-6">
                            <div class="icon-box">
                                <div class="icon"><i class="bx bx-atom"></i></div>
                                <h4 class="title"><a href="">Company name</a></h4>
                                @foreach($consolidations->pluck('subsidiary')->unique() as $subs)
                                <p class="description">{{$subs}}</p>
                                @endforeach
                            </div>
                            <div class="icon-box">
                                <div class="icon"><i class="bx bx-atom"></i></div>
                                <h4 class="title"><a href="">Group</a></h4>
                                @foreach($consolidations->pluck('group_name')->unique() as $subs)
                                <p class="description">{{$subs}}</p>
                                @endforeach
                            </div>
                            <div class="icon-box">
                                <div class="icon"><i class="bx bx-atom"></i></div>
                                <h4 class="title"><a href="">Shareholders</a></h4>
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
                                <p class="description">{{ $key + 1 }}) {{ $name }} ({{ $ownership }})</p>
                                @endforeach
                                @else
                                <p class="description">{{ $shareholder }}</p>
                                @endif
                                @endforeach

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="icon-box">
                                <div class="icon"><i class="bx bx-atom"></i></div>
                                <h4 class="title"><a href="">Activity</a></h4>
                                @foreach($consolidations->pluck('principal_activities')->unique() as $activity)
                                @if($activity)
                                <p class="description">{{ $activity }}</p>
                                @else
                                <p class="description">-</p>
                                @endif
                                @endforeach
                            </div>
                            <!-- <div class="icon-box">
                                <div class="icon"><i class="bx bx-atom"></i></div>
                                <h4 class="title"><a href="">Planted</a></h4>
                                @if(count($consolidations) > 1)
                                @foreach($consolidations as $key => $subs)
                                @if($subs->sizebyeq)
                                <p class="description">{{ $key + 1 }}) {{$subs->sizebyeq}} hectare</p>
                                @else
                                <p class="description">{{ $key + 1 }}) -</p>
                                @endif
                                @endforeach
                                @else
                                @foreach($consolidations as $subs)
                                @if($subs->sizebyeq)
                                <p class="description">{{$subs->sizebyeq}} hectare</p>
                                @else
                                <p class="description">-</p>
                                @endif
                                @endforeach
                                @endif

                            </div>
                            <div class="icon-box">
                                <div class="icon"><i class="bx bx-atom"></i></div>
                                <h4 class="title"><a href="">Capacity</a></h4>
                                @foreach($consolidations as $subs)
                                @if($subs->facilities)
                                <p class="description">{{$subs->facilities}} ({{$subs->capacity}})</p>
                                @else
                                <p class="description">-</p>
                                @endif
                                @endforeach
                            </div> -->
                            <div class="icon-box">
                                <div class="icon"><i class="bx bx-atom"></i></div>
                                <h4 class="title"><a href="">Country Operation</a></h4>
                                <!-- @foreach($consolidations as $subs)
                                @if($subs->country_operation)
                                <p class="description">{{$subs->country_operation}}, {{$subs->province}} Province, {{$subs->regency}} District</p>
                                @else
                                <p class="description">-</p>
                                @endif
                                @endforeach -->
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
                    <form id="search-form" method="POST" action="{{ route('subsidiaryShow') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="text" id="subsidiary search-input" class="form-control" name="subsidiary" list="subsidiary-list" placeholder="Search other company...">
                        <datalist id="subsidiary-list">
                            @foreach(DB::table('consolidations')->pluck('subsidiary')->unique() as $subsidiary)
                            @php
                            $shareholder = DB::table('consolidations')->where('subsidiary', $subsidiary)->value('subsidiary');
                            @endphp
                            @if(!empty($shareholder) && $shareholder != 'N/A' && $shareholder != 'check')
                            <option value="{{ $subsidiary }}"></option>
                            @endif
                            @endforeach
                        </datalist>
                        <button type="submit" class="btn btn-primary">Search</button>
                    </form>
                </div>
                <div class="col-xl-4 col-lg-6 icon-boxes d-flex flex-column align-items-stretch py-5 px-lg-5" style="background-color: #F5F5F5;">
                    <div class="blog sidebar">

                        <h3>Buy company report</h3>
                        <p>Official company report of PT. Abidin Palmita Bros.</p>
                        <!-- End sidebar tags-->
                        <!-- <a href="default.asp" class="book" target="_blank">This is a link</a><span>test</span> -->
                        <div class="book">
                            <!-- <div class="left">Full Report</div>
                            <div class="right">$100</div> -->
                            <p class="left">Full Report</p>
                            <span class="right">$100</span>
                        </div>

                    </div><!-- End sidebar -->
                    <a href="#appointment" class="appointment-btn" style="justify-content: center; align-items:center; text-align:center;">Add to chart</a>
                    <div class="line"></div>
                    <div class="report-benefit">
                        <p>What's included in the report?</p>
                        <ul class="benefit-list">
                            <li>Registered business classifications</li>
                            <li>Shareholder table</li>
                            <li>List of corporate commissioners and directors</li>
                            <li>List of corporate commissioners and directors</li>
                        </ul>
                        <p>Download sample report</p>
                        <ul class="sample-subsidiary">
                            <li>Report of PT. Abidin Palmita Bros</li>
                        </ul>
                    </div>
                </div>
            </div>

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
        const formattedSize = Math.round(coord.sizebyeq).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","); // Format angka bulat tanpa angka desimal dengan tanda koma sebagai pemisah ribuan
        marker.bindPopup(`<b>${coord.principal_activities}</b><br>Company Name: ${coord.subsidiary}<br>Mill Name: ${coord.facilities}<br>Capacity: ${coord.capacity}<br>Estate Name: ${coord.estate}<br>Planted: ${formattedSize} hectare<br>Location: ${coord.regency} District, ${coord.province} Province, ${coord.country_operation}<br>Latitude: ${coord.latitude}<br>Longitude: ${coord.longitude}<br>`);
        markers.push(marker);
    });

    const group = new L.featureGroup(markers);
    map.fitBounds(group.getBounds());
</script>

@endsection