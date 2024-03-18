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
            @foreach($sras->pluck('group_name')->unique() as $subs)
            <h4 scope="col" class="card-title description">RSA Summary of {{$subs}}</h4>
            @endforeach
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                        @if(count($sras)>0)
                        <!-- Default Table -->
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">*Note: The highest the score/percentage is, the best is the company</th>
                                 @foreach($sras->pluck('group_name')->unique() as $subs)
                                 <th scope="col" style="color:#0AA7C4;">{{$subs}}</th>
                                 @endforeach
                                <th scope="col">Percentage</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Transparency (out of 10)</td>
                                    @foreach($sras->pluck('transparency')->unique() as $subs)
                                    <td>{{$subs}}</td>
                                    @endforeach
                                    @foreach($sras->pluck('percent_transparency')->unique() as $subs)
                                    <td>{{$subs}} %</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td>RSPO Compliance (out of 10)</td>
                                    @foreach($sras->pluck('rspo_compliance')->unique() as $subs)
                                    <td>{{$subs}}</td>
                                    @endforeach
                                    @foreach($sras->pluck('percent_rspo_compliance')->unique() as $subs)
                                    <td>{{$subs}} %</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td>NDPE Compliance (out of 21)</td>
                                    @foreach($sras->pluck('ndpe_compliance')->unique() as $subs)
                                    <td>{{$subs}}</td>
                                    @endforeach
                                    @foreach($sras->pluck('percent_ndpe_compliance')->unique() as $subs)
                                    <td>{{$subs}} %</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <th scope="col">Total (out of 41)</th>
                                    @foreach($sras->pluck('total')->unique() as $subs)
                                    <th scope="col">{{$subs}}</th>
                                    @endforeach
                                    @foreach($sras->pluck('percent_total')->unique() as $subs)
                                    <th scope="col">{{$subs}} %</th>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                        @endif
                        <!-- End Default Table Example -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                        <h6 class="card-title">Percentage of @foreach($sras->pluck('group_name')->unique() as $subs)
                            {{$subs}} %
                            @endforeach SRA + Overall</h6>

                            <!-- Bar Chart -->
                            <canvas id="barChart" style="max-height: 400px;"></canvas>
                            <script>
                                document.addEventListener("DOMContentLoaded", () => {
                                    var labels = <?php echo json_encode($labels); ?>;
                                    var data = <?php echo json_encode($data); ?>;
                                    
                                    // Define colors for each bar in each dataset
                                    var backgroundColors = [
                                        ['rgba(255, 99, 132, 0.2)', 'rgba(75, 192, 192, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(201, 203, 207, 0.2)'],
                                        ['rgba(255, 159, 64, 0.2)', 'rgba(153, 102, 255, 0.2)', 'rgba(255, 205, 86, 0.2)', 'rgba(75, 192, 192, 0.2)'],
                                        ['rgba(255, 205, 86, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(153, 102, 255, 0.2)', 'rgba(255, 99, 132, 0.2)'],
                                        ['rgba(75, 192, 192, 0.2)', 'rgba(201, 203, 207, 0.2)', 'rgba(255, 159, 64, 0.2)', 'rgba(153, 102, 255, 0.2)']
                                    ];
                                    var borderColors = [
                                        ['rgb(255, 99, 132)', 'rgb(75, 192, 192)', 'rgb(54, 162, 235)', 'rgb(201, 203, 207)'],
                                        ['rgb(255, 159, 64)', 'rgb(153, 102, 255)', 'rgb(255, 205, 86)', 'rgb(75, 192, 192)'],
                                        ['rgb(255, 205, 86)', 'rgb(54, 162, 235)', 'rgb(153, 102, 255)', 'rgb(255, 99, 132)'],
                                        ['rgb(75, 192, 192)', 'rgb(201, 203, 207)', 'rgb(255, 159, 64)', 'rgb(153, 102, 255)']
                                    ];

                                    // Data processing to match Chart.js format
                                    var datasets = [];
                                    for (var i = 0; i < data.length; i++) {
                                        datasets.push({
                                            label: labels[i],
                                            data: data[i],
                                            backgroundColor: backgroundColors[i],
                                            borderColor: borderColors[i],
                                            borderWidth: 1
                                        });
                                    }

                                    new Chart(document.querySelector('#barChart'), {
                                        type: 'bar',
                                        data: {
                                            labels: ['Transparency', 'RSPO Compliance', 'NDPE Compliance', 'Overall'],
                                            datasets: datasets
                                        },
                                        options: {
                                            scales: {
                                                y: {
                                                    beginAtZero: true
                                                }
                                            }
                                        }
                                    });
                                });
                            </script>

                        <!-- End Bar CHart -->

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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">
            @foreach($sras as $subs)
                @if($loop->first)
                    <h4 class="title mb-0"> {{ $subs->group_name }}</h4>
                @endif
            @endforeach</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <div class="card" style="width: 100%;">
                <div class="card-body row">
                @foreach($sras as $subs)
                    <div class="col-6">
                        <h6 class="card-title description">Group Name</h6>
                        <p class="card-text">{{ $subs->group_name }}</p>
                        <h6 class="card-title description">Official Group Name</h6>
                        <p class="card-text">{{ $subs->official_group_name }}</p>
                        <h6 class="card-title description">Group Status</h6>
                        <p class="card-text">{{ $subs->group_status }}</p>
                        <h6 class="card-title description">Stock Exchange Name</h6>
                        <p class="card-text">{{ $subs->stock_exchange_name }}</p>
                        <h6 class="card-title description">Controller</h6>
                        <p class="card-text">{{ $subs->controller }}</p>
                        <h6 class="card-title description">Business Sector</h6>
                        <p class="card-text">{{ $subs->business_sector }}</p>
                        <h6 class="card-title description">Main Product</h6>
                        <p class="card-text">{{ $subs->main_product }}</p>
                        <h6 class="card-title description">Commercial Operation Date</h6>
                        <p class="card-text">{{ $subs->commercial_operation_date }}</p>
                        <h6 class="card-title description">Country Registration</h6>
                        <p class="card-text">{{ $subs->country_registration }}</p>
                        <h6 class="card-title description">Business Address</h6>
                        <p class="card-text">{{ $subs->business_address }}</p>
                        <h6 class="card-title description">Country Operation</h6>
                        <p class="card-text">{{ $subs->country_operation }}</p>
                        <h6 class="card-title description">Shareholder</h6>
                        <p class="card-text">{{ $subs->shareholder_name1 }} ({{ $subs->percent_of_share1 }})</p>
                        <p class="card-text">{{ $subs->shareholder_name2 }} ({{ $subs->percent_of_share2 }})</p>
                        <p class="card-text">{{ $subs->shareholder_name3 }} ({{ $subs->percent_of_share3 }})</p>
                        <p class="card-text">{{ $subs->shareholder_name4 }} ({{ $subs->percent_of_share4 }})</p>
                        <p class="card-text">{{ $subs->shareholder_name5 }} ({{ $subs->percent_of_share5 }})</p>
                        <!-- <h6 class="card-title description">Group Structure</h6>
                        <p class="card-text">{{ $subs->group_structure }}</p> -->
                        <h6 class="card-title description">Management (Name and Position)</h6>
                        <p class="card-text">{{ $subs->management_name_and_position }}</p>
                        <h6 class="card-title description">Land Area Controlled</h6>
                        <p class="card-text">{{ $subs->land_area_controlled }}</p>
                    </div>
                    <div class="col-6">
                        
                    <h6 class="card-title description">Total Planted</h6>
                        <p class="card-text">{{ $subs->total_planted }}</p>
                        <h6 class="card-title description">Total Smallholders</h6>
                        <p class="card-text">{{ $subs->total_smallholders }}</p>
                        <h6 class="card-title description">Total Land Designed HCV</h6>
                        <p class="card-text">{{ $subs->total_land_designated_hcv }}</p>
                        <h6 class="card-title description">Annual FFB Productivity</h6>
                        <p class="card-text">{{ $subs->annual_ffb_productivity }}</p>
                        <h6 class="card-title description">Annual Productivity by RSPO certified</h6>
                        <p class="card-text">{{ $subs->annual_productivity_by_rspo_certified }}</p>
                        <h6 class="card-title description">Annual CPO Productivity</h6>
                        <p class="card-text">{{ $subs->annual_cpo_productivity }}</p>
                        <h6 class="card-title description">Annual CPK Productivity</h6>
                        <p class="card-text">{{ $subs->annual_cpk_productivity }}</p>
                        <h6 class="card-title description">RSPO Member</h6>
                        <p class="card-text">{{ $subs->rspo_member }}</p>
                        <h6 class="card-title description">CGF Member</h6>
                        <p class="card-text">{{ $subs->cgf_member }}</p>
                        <h6 class="card-title description">ASD Member</h6>
                        <p class="card-text">{{ $subs->asd_member }}</p>
                        <h6 class="card-title description">GPNSR Member</h6>
                        <p class="card-text">{{ $subs->gpnsr_member }}</p>
                        <h6 class="card-title description">Others Mention</h6>
                        <p class="card-text">{{ $subs->others_mention }}</p>
                        <h6 class="card-title description">NDPE Policy</h6>
                        <p class="card-text">{{ $subs->ndpe_policy }}</p>
                        <h6 class="card-title description">NDPE Time Bound Plan Implementation</h6>
                        <p class="card-text">{{ $subs->ndpe_time_bound_plan_implementation }}</p>
                        <h6 class="card-title description">Sustainability Progress Report</h6>
                        <p class="card-text">{{ $subs->sustainability_progress_report }}</p>
                        <h6 class="card-title description">Supply Chain Traceability</h6>
                        <p class="card-text">{{ $subs->supply_chain_traceability }}</p>
                        <h6 class="card-title description">Grievance Mechanism</h6>
                        <p class="card-text">{{ $subs->grievance_mechanism }}</p>
                        <h6 class="card-title description">Recovery Plan</h6>
                        <p class="card-text">{{ $subs->recovery_plan }}</p>
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

<script>
        var pdfUrl = "{{ asset('file/notarial-act-sras/2021 07 Abdi Budi Mulia.pptx.pdf') }}";

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