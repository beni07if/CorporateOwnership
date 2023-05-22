@extends('layout.app')

@section('content')
<main id="main">

    <!-- ======= About Section ======= -->
    <section id="about" class="about">
        <!-- <div class="container-fluid"> -->
        <div class="container">
            <div class="breadcrumbs" style="padding-left: 40px; background-color:white;">
                <ol style="color:#4682B4;">
                    <li><a href="" style="color:#4682B4;">Home</a></li>
                    <li><a href="" style="color:#4682B4;">Indonesia</a></li>
                    <li><a href="" style="color:#4682B4;">Corporate Profile</a></li>
                    <li><a href="" style="color:#4682B4;">Subsidiary</a></li>
                </ol>
                <!-- <h2 style="color:#4682B4;">Subsidiary</h2> -->
            </div>

            <div class="row" style="box-shadow: rgba(44, 73, 100, 0.08) 0px 2px 15px 0px;">
                @if(count($consolidations)>0)
                <div class="col-xl-8 col-lg-6 icon-boxes d-flex flex-column align-items-stretch justify-content-center py-5 px-lg-5">
                    @foreach($consolidations as $subs)
                    <h3>{{$subs->subsidiary}}</h3>
                    <p>{{$subs->subsidiary}} adalah anak perusahaan dari group {{$subs->group_name}} yang berlokasi di {{$subs->regency}}, {{$subs->province}}, {{$subs->country_operation}}. Aktivitas utama {{$subs->subsidiary}} adalah {{$subs->principal_activities}}. Kepemilikan sahamnya dimiliki oleh {{$subs->shareholder_subsidiary}}.</p>
                    <div class="row">

                        <div class="col-md-6">
                            <div class="icon-box">
                                <div class="icon"><i class="bx bx-atom"></i></div>
                                <h4 class="title"><a href="">Subsidiary name</a></h4>
                                <p class="description">{{$subs->subsidiary}}</p>
                            </div>
                            <div class="icon-box">
                                <div class="icon"><i class="bx bx-atom"></i></div>
                                <h4 class="title"><a href="">Group</a></h4>
                                <p class="description">{{$subs->group_name}}</p>
                            </div>
                            <div class="icon-box">
                                <div class="icon"><i class="bx bx-atom"></i></div>
                                <h4 class="title"><a href="">Shareholder of company</a></h4>
                                <p class="description">{{$subs->shareholder_subsidiary}}</p>
                            </div>
                            <!-- <div>
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d25034.653727798323!2d100.72741630529931!3d0.9904701800450332!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d4b114cddeb057%3A0x119c6f62951397ec!2sPT.%20Rohul%20Palmindo%20Muara%20Dilam!5e1!3m2!1sid!2sid!4v1684138457370!5m2!1sid!2sid" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div><br> -->
                            <div id="mapid" style="height: 500px;"></div>

                        </div>
                        <div class="col-md-6">
                            <div class="icon-box">
                                <div class="icon"><i class="bx bx-atom"></i></div>
                                <h4 class="title"><a href="">Main activity</a></h4>
                                <p class="description">{{$subs->principal_activities}}</p>
                            </div>
                            <div class="icon-box">
                                <div class="icon"><i class="bx bx-atom"></i></div>
                                <h4 class="title"><a href="">Address (Country, Province and Regency)</a></h4>
                                <p class="description">{{$subs->country_operation}}, {{$subs->province}}, {{$subs->regency}}</p>
                            </div>
                            <div class="icon-box">
                                <div class="icon"><i class="bx bx-atom"></i></div>
                                <h4 class="title"><a href="">Planted area</a></h4>
                                <p class="description">
                                    @if($subs->sizebyeq)
                                    {{$subs->sizebyeq}} hectare
                                    @else
                                    -
                                    @endif
                                </p>
                            </div>
                            <div class="icon-box">
                                <div class="icon"><i class="bx bx-atom"></i></div>
                                <h4 class="title"><a href="">Mill capacity</a></h4>
                                <p class="description">
                                    @if($subs->capacity)
                                    {{$subs->capacity}} ton/hours
                                    @else
                                    -
                                    @endif
                                </p>
                            </div>
                            <div class="icon-box">
                                <div class="icon"><i class="bx bx-atom"></i></div>
                                <h4 class="title"><a href="">Latitude</a></h4>
                                <p class="description">{{$subs->latitude}}</p>
                            </div>
                            <div class="icon-box">
                                <div class="icon"><i class="bx bx-atom"></i></div>
                                <h4 class="title"><a href="">Longitude</a></h4>
                                <p class="description">{{$subs->longitude}}</p>
                            </div>

                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
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

<script>
    // Inisialisasi peta
    var mymap = L.map('mapid').setView([-6.1753924, 106.8271528], 13);

    // Menambahkan tile layer (OpenStreetMap)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
        maxZoom: 19,
    }).addTo(mymap);

    // Menambahkan marker
    L.marker([-6.1753924, 106.8271528]).addTo(mymap)
        .bindPopup('Lokasi saya')
        .openPopup();
</script>