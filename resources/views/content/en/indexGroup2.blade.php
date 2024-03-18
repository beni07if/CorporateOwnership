@extends('layout.app')

@section('styleMaps')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.css" />
<style>
    
</style>
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
            </div>
            @if(count($groups)>0)
            <div class="row" style="box-shadow: rgba(44, 73, 100, 0.08) 0px 2px 15px 0px;">
                <div class="col-xl-8 col-lg-6 icon-boxes d-flex flex-column align-items-stretch justify-content-center py-5 px-lg-5">
                    <div>
                        @foreach($groups->pluck('group_name')->unique() as $subs)
                        <h5 class="card-title description">Company Structure of {{$subs}}</h5>
                        @endforeach
                    </div>
                    <div class="line"></div>
                    <div>
                        @foreach($groups->groupBy('group_name') as $subsidiaryGroup)
                            @php
                                $subsidiary = $subsidiaryGroup->first()->group_name;

                                $directory = public_path('file/group-structure/');
                                $filesInDirectory = scandir($directory);

                                // Filter file yang sesuai dengan nama grup
                                $matchingFiles = array_filter($filesInDirectory, function($file) use ($subsidiary) {
                                    // Cocokkan dengan nama grup
                                    return preg_match('/^\d+ \d+ ' . preg_quote($subsidiary, '/') . '\.pdf$/i', $file);
                                });

                                if (!empty($matchingFiles)) {
                                    $fileNameInDirectory = reset($matchingFiles);
                                    $filePath = url('file/group-structure/' . $fileNameInDirectory);

                                    // Debug: Cetak informasi selama iterasi
                                    error_log('Group Name: ' . $subsidiary);
                                    error_log('Matching Files: ' . print_r($matchingFiles, true));
                                    error_log('Generated URL: ' . $filePath);
                                } else {
                                    $filePath = ''; // Atau berikan nilai default jika file tidak ditemukan
                                }
                            @endphp

                            @if(!empty($filePath))
                                <iframe src="{{ $filePath }}" width="100%" height="600px"></iframe>
                                <!-- <p class="description">{{ $subsidiary }}</p> -->
                            @else
                                <p>Please contact our team to get company structure and other information of {{ $subsidiary }}.</p>
                            @endif
                        @endforeach
                    </div>

                    <div style="padding-top:50px;">
                        <h5 class="card-title description">Summary</h4>
                    </div>

                    <!-- <div class="row pt-3" style="box-shadow: rgba(44, 73, 100, 0.08) 0px 2px 15px 0px;">
                        <div class="col-md-6">
                            <h4>Testing</h4>
                            <p>Testing2</p>
                        </div>
                        <div class="col-md-6">
                            <h4>Testing</h4>
                            <p>Testing2</p>
                        </div>
                    </div> -->

                    @if(count($groups)>0)
                    <div class="row pt-4 pl-15">
                        <div class="col-md-6">
                            <div class="">
                                <h6 class="text-muted">Group Name</h6>
                                @foreach($groups->pluck('group_name')->unique() as $subs)
                                <p class="text-muted">{{$subs}}</p>
                                @endforeach
                            </div>
                            <div class="">
                                <h6 class="text-muted">Official Group Name</h6>
                                @foreach($groups->pluck('official_group_name')->unique() as $subs)
                                <p class="text-muted">{{$subs}}</p>
                                @endforeach
                            </div>
                            <div class=" @if(!$groups->pluck('group_status')->unique()->count() || in_array('Check', $groups->pluck('group_status')->unique()->toArray())) d-none @endif">
                                <h6 class="text-muted">Group Status</h6>
                                @foreach($groups->pluck('group_status')->unique() as $group_status)
                                @if($group_status)
                                @if($group_status == 'Check')
                                <p class="text-muted">-</p>
                                @else
                                <p class="text-muted">{{ $group_status }}</p>
                                @endif
                                @else
                                <p class="text-muted">-</p>
                                @endif
                                @endforeach
                            </div>
                            <div class="">
                                <h6 class="text-muted">RSPO Member</h6>
                                @foreach($groups->pluck('rspo_member')->unique() as $subs)
                                <p class="text-muted">{{$subs}}</p>
                                @endforeach
                            </div>
                            <div class="">
                                <h6 class="text-muted">NDPE Policy</h6>
                                @foreach($groups->pluck('ndpe_policy')->unique() as $subs)
                                <p class="text-muted">{{$subs}}</p>
                                @endforeach
                            </div>

                            <!-- <div class="">
                                <h6 class="text-muted">Shareholders</h6>
                                @foreach($groups->pluck('shareholder_subsidiary')->unique() as $shareholders)
                                @if($shareholders)
                                <p class="text-muted">{{ $shareholders }}</p>
                                @else
                                <p class="text-muted">-</p>
                                @endif
                                @endforeach
                            </div> -->
                            <div class="">
                                <h6 class="text-muted">List of Subsidiaries</h6>
                                <form action="{{ route('subsidiaryShow') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @foreach($consolidations->pluck('subsidiary')->unique() as $subs)
                                    <div>
                                        <input type="submit" name="subsidiary" value="{{ $subs }}" class="text-muted" style=" border: none;">
                                    </div>
                                    @endforeach
                                </form>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="">
                                <h6 class="text-muted">Controller</h6>
                                @foreach($groups->pluck('controller')->unique() as $controller)
                                @if($controller)
                                <p class="text-muted">{{ $controller }}</p>
                                @else
                                <p class="text-muted">-</p>
                                @endif
                                @endforeach
                            </div>
                            <div class="">
                                <h6 class="text-muted">Management</h6>
                                @foreach($groups->pluck('management_name_and_position')->unique() as $management_name_and_position)
                                @if($management_name_and_position)
                                <p class="text-muted">{{ $management_name_and_position }}</p>
                                @else
                                <p class="text-muted">-</p>
                                @endif
                                @endforeach
                            </div>
                            <!-- <div class="">
                                <h6 class="text-muted">Shareholders</h6>
                                @foreach($groups->pluck('shareholder_name1')->unique() as $shareholder_name1)
                                @if($shareholder_name1)
                                <p class="text-muted">{{ $shareholder_name1 }}</p>
                                @else
                                <p class="text-muted">-</p>
                                @endif
                                @endforeach
                            </div> -->
                            <div class="">
                                <h6 class="text-muted">Shareholders</h6>
                                <form action="{{ route('shareholderShow') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                    @foreach($groups as $subs)
                                        <div>
                                            @if($subs->shareholder_name1 !== 'Nil')
                                                <input type="submit" name="shareholder_name" value="{{ $subs->shareholder_name1 }}" class="text-muted" style=" border: none;"> ({{ $subs->percent_of_share1 }}) <br>
                                            @endif

                                            @if($subs->shareholder_name2 !== 'Nil')
                                                <input type="submit" name="shareholder_name" value="{{ $subs->shareholder_name2 }}" class="text-muted" style=" border: none;"> ({{ $subs->percent_of_share2 }}) <br>
                                            @endif

                                            @if($subs->shareholder_name3 !== 'Nil')
                                                <input type="submit" name="shareholder_name" value="{{ $subs->shareholder_name3 }}" class="text-muted" style=" border: none;"> ({{ $subs->percent_of_share3 }}) <br>
                                            @endif

                                            @if($subs->shareholder_name4 !== 'Nil')
                                                <input type="submit" name="shareholder_name" value="{{ $subs->shareholder_name4 }}" class="text-muted" style=" border: none;"> ({{ $subs->percent_of_share4 }}) <br>
                                            @endif

                                            @if($subs->shareholder_name5 !== 'Nil')
                                                <input type="submit" name="shareholder_name" value="{{ $subs->shareholder_name5 }}" class="text-muted" style=" border: none;"> ({{ $subs->percent_of_share5 }})
                                            @endif
                                        </div>
                                    @endforeach
                                </form>
                            </div>
                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal">See more</button>
                        </div>
                    </div>
                    @endif
                    <!-- <div id="mapid" style="height: 500px;"></div> -->
                    <!-- <div>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d25034.653727798323!2d100.72741630529931!3d0.9904701800450332!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d4b114cddeb057%3A0x119c6f62951397ec!2sPT.%20Rohul%20Palmindo%20Muara%20Dilam!5e1!3m2!1sid!2sid!4v1684138457370!5m2!1sid!2sid" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div><br> -->
                    <!-- <div class="header-map">
                        <p class="text-muted">
                            Country Registration
                            @foreach($groups->pluck('country_registration')->unique() as $subs) {{$subs}}
                            @endforeach
                            Group
                        </p>
                    </div> -->
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
                    
                    <div class="col-lg-12 details order-2 order-lg-1 mt-3">
                        <div class="container">
                            <h6 class="text-muted">Search for other groups</h6>
                            <form action="{{ route('searchFunctionGroup2') }}" method="GET" class="d-flex">
                                <input type="text" class="form-control me-2" name="group_name" placeholder="Group Name">
                                <button type="submit" class="btn btn-secondary">Search</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 icon-boxes d-flex flex-column align-items-stretch py-5 px-lg-5" style="background-color: #F5F5F5;">
                    <div class="blog sidebar">
                        <h5 class="card-title description">Company Profile Access</h5><br>
                        <p>If the data You're looking for is not found, You can contact us via email at <i>helpdesk@earthqualizer.org</i>.</p>
                        <p>We will process your request within 3x24 hours.</p>
                        <div class="line"></div>
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
            @else
            <div class="row" style="box-shadow: rgba(44, 73, 100, 0.08) 0px 2px 15px 0px;">
                <div class="col-xl-8 col-lg-6 es d-flex flex-column align-items-stretch justify-content-center py-5 px-lg-5">
                    <div class="container" style="padding-top:50px;">
                        <h6 class="text-muted">To get information from this company, please contact helpdesk@earthqualizer.org</h6>
                        <!-- <p class="fst-italic">A group company is a collection of individual companies or subsidiaries that are controlled by a single parent company. The parent company, often referred to as the holding company or the group, typically holds a majority stake or controlling the subsidiary companies. The information about Group Company can be used to identify the subsidiary under.</p> -->
                        
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 es d-flex flex-column align-items-stretch py-5 px-lg-5" style="background-color: #F5F5F5;">
                    <div class="blog sidebar">
                        <h4>Company Profile Access</h4>
                    </div><!-- End sidebar -->
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
        marker.bindPopup(`<b>${coord.principal_activities}</b><br>Group Name: ${coord.subsidiary}<br>Subsidiary: ${coord.subsidiary}<br>Mill Name: ${coord.facilities}<br>Capacity: ${coord.capacity}<br>Estate Name: ${coord.estate}<br>Planted: ${formattedSize} hectare<br>Location: ${coord.regency} District, ${coord.country_operation}<br>Latitude: ${coord.latitude}<br>Longitude: ${coord.longitude}<br>`);
        markers.push(marker);
    });

    const group = new L.featureGroup(markers);
    map.fitBounds(group.getBounds());
</script>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">@foreach($groups as $subs)
                                @if($loop->first)
                                    <h4 class="title mb-0"> {{ $subs->group_name }}</h4>
                                @endif
                            @endforeach</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <div class="card" style="width: 100%;">
                <div class="card-body row">
                @foreach($groups as $subs)
                    <div class="col-6">
                        <h6 class="text-muted">Group Name</h6>
                        <p class="card-text">{{ $subs->group_name }}</p>
                        <h6 class="text-muted">Official Group Name</h6>
                        <p class="card-text">{{ $subs->official_group_name }}</p>
                        <h6 class="text-muted">Group Status</h6>
                        <p class="card-text">{{ $subs->group_status }}</p>
                        <h6 class="text-muted">Stock Exchange Name</h6>
                        <p class="card-text">{{ $subs->stock_exchange_name }}</p>
                        <h6 class="text-muted">Controller</h6>
                        <p class="card-text">{{ $subs->controller }}</p>
                        <h6 class="text-muted">Business Sector</h6>
                        <p class="card-text">{{ $subs->business_sector }}</p>
                        <h6 class="text-muted">Main Product</h6>
                        <p class="card-text">{{ $subs->main_product }}</p>
                        <h6 class="text-muted">Commercial Operation Date</h6>
                        <p class="card-text">{{ $subs->commercial_operation_date }}</p>
                        <h6 class="text-muted">Country Registration</h6>
                        <p class="card-text">{{ $subs->country_registration }}</p>
                        <h6 class="text-muted">Business Address</h6>
                        <p class="card-text">{{ $subs->business_address }}</p>
                        <h6 class="text-muted">Country Operation</h6>
                        <p class="card-text">{{ $subs->country_operation }}</p>
                        <h6 class="text-muted">Shareholder</h6>
                        <p class="card-text">{{ $subs->shareholder_name1 }} ({{ $subs->percent_of_share1 }})</p>
                        <p class="card-text">{{ $subs->shareholder_name2 }} ({{ $subs->percent_of_share2 }})</p>
                        <p class="card-text">{{ $subs->shareholder_name3 }} ({{ $subs->percent_of_share3 }})</p>
                        <p class="card-text">{{ $subs->shareholder_name4 }} ({{ $subs->percent_of_share4 }})</p>
                        <p class="card-text">{{ $subs->shareholder_name5 }} ({{ $subs->percent_of_share5 }})</p>
                        <!-- <h6 class="text-muted">Group Structure</h6>
                        <p class="card-text">{{ $subs->group_structure }}</p> -->
                        <h6 class="text-muted">Management (Name and Position)</h6>
                        <p class="card-text">{{ $subs->management_name_and_position }}</p>
                        <h6 class="text-muted">Land Area Controlled</h6>
                        <p class="card-text">{{ $subs->land_area_controlled }}</p>
                    </div>
                    <div class="col-6">
                        
                    <h6 class="text-muted">Total Planted</h6>
                        <p class="card-text">{{ $subs->total_planted }}</p>
                        <h6 class="text-muted">Total Smallholders</h6>
                        <p class="card-text">{{ $subs->total_smallholders }}</p>
                        <h6 class="text-muted">Total Land Designed HCV</h6>
                        <p class="card-text">{{ $subs->total_land_designated_hcv }}</p>
                        <h6 class="text-muted">Annual FFB Productivity</h6>
                        <p class="card-text">{{ $subs->annual_ffb_productivity }}</p>
                        <h6 class="text-muted">Annual Productivity by RSPO certified</h6>
                        <p class="card-text">{{ $subs->annual_productivity_by_rspo_certified }}</p>
                        <h6 class="text-muted">Annual CPO Productivity</h6>
                        <p class="card-text">{{ $subs->annual_cpo_productivity }}</p>
                        <h6 class="text-muted">Annual CPK Productivity</h6>
                        <p class="card-text">{{ $subs->annual_cpk_productivity }}</p>
                        <h6 class="text-muted">RSPO Member</h6>
                        <p class="card-text">{{ $subs->rspo_member }}</p>
                        <h6 class="text-muted">CGF Member</h6>
                        <p class="card-text">{{ $subs->cgf_member }}</p>
                        <h6 class="text-muted">ASD Member</h6>
                        <p class="card-text">{{ $subs->asd_member }}</p>
                        <h6 class="text-muted">GPNSR Member</h6>
                        <p class="card-text">{{ $subs->gpnsr_member }}</p>
                        <h6 class="text-muted">Others Mention</h6>
                        <p class="card-text">{{ $subs->others_mention }}</p>
                        <h6 class="text-muted">NDPE Policy</h6>
                        <p class="card-text">{{ $subs->ndpe_policy }}</p>
                        <h6 class="text-muted">NDPE Time Bound Plan Implementation</h6>
                        <p class="card-text">{{ $subs->ndpe_time_bound_plan_implementation }}</p>
                        <h6 class="text-muted">Sustainability Progress Report</h6>
                        <p class="card-text">{{ $subs->sustainability_progress_report }}</p>
                        <h6 class="text-muted">Supply Chain Traceability</h6>
                        <p class="card-text">{{ $subs->supply_chain_traceability }}</p>
                        <h6 class="text-muted">Grievance Mechanism</h6>
                        <p class="card-text">{{ $subs->grievance_mechanism }}</p>
                        <h6 class="text-muted">Recovery Plan</h6>
                        <p class="card-text">{{ $subs->recovery_plan }}</p>
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