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
            <div class="row mt-50" style="margin-top:50px;">
                <div class="card">
                    <div class="card-body">
                    <h5 class="card-title">RSA Assessment Details</h5>

                    <!-- Default Tabs -->
                    <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
                        <li class="nav-item flex-fill" role="presentation">
                        <button class="nav-link w-100 active" id="transparency-tab" data-bs-toggle="tab" data-bs-target="#transparency-justified" type="button" role="tab" aria-controls="transparency" aria-selected="true">Transparency</button>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                        <button class="nav-link w-100" id="rspo-tab" data-bs-toggle="tab" data-bs-target="#rspo-justified" type="button" role="tab" aria-controls="rspo" aria-selected="false">RSPO Compliance</button>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                        <button class="nav-link w-100" id="ndpe-tab" data-bs-toggle="tab" data-bs-target="#ndpe-justified" type="button" role="tab" aria-controls="ndpe" aria-selected="false">NDPE Compliance</button>
                        </li>
                    </ul>
                    <div class="tab-content pt-2" id="myTabjustifiedContent">
                        <div class="tab-pane fade show active profile-overview" id="transparency-justified" role="tabpanel" aria-labelledby="transparency-tab">
                            <div class="alert alert-light alert-dismissible fade show" role="alert">
                                <h6 class="alert-heading">Upstream transparency <span style="color:#0AA7C4;">(score 0)</span></h6>
                                <p>The subsidiaries and location of mills are available in  the SY's website, but the company does not mention its total land bank and planted area.</p>
                                <!-- <div class="row">
                                    <div class="col-lg-3 col-md-4 label font-weight-bold">Score</div>
                                    <div class="col-lg-9 col-md-8 label font-weight-bold">Description</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">0</div>
                                    <div class="col-lg-9 col-md-8">
                                        <p>The subsidiaries and location of mills are available in  the SY's website, but the company does not mention its total land bank and planted area.</p>
                                    </div>
                                </div> -->
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingOne">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne-transparencyUpstreamTransparency" aria-expanded="false" aria-controls="flush-collapseOne-transparencyUpstreamTransparency">
                                                <p>Click here to details</p>
                                            </button>
                                        </h2>
                                        <div id="flush-collapseOne-transparencyUpstreamTransparency" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label font-weight-bold">Score Parameter</div>
                                                    <div class="col-lg-9 col-md-8 label font-weight-bold">Description</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">2 = High</div>
                                                    <div class="col-lg-9 col-md-8">
                                                        <p>Availability and sufficient level of detail on:</p>
                                                        <ul>
                                                            <li class="bi bi-check-circle"> Company subsidiaries (including mills, refineries, etc.), </li>
                                                            <li class="bi bi-check-circle"> Total landbank and planted land</li>
                                                            <li class="bi bi-check-circle"> Location of concessions and mills </li>
                                                            <li class="bi bi-check-circle"> Up-to-date supplier lists (at least one quarter before research)</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">0 = Low</div>
                                                    <div class="col-lg-9 col-md-8">
                                                        <ul>
                                                            <li class="bi bi-check-circle"> Substential parts of the above mentioned criteria are not clear, not complete, not up-to-date, or there are other reasons to doubt </li>
                                                            <li class="bi bi-check-circle"> No or very limited information available on the above mentioned criteria</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr style="border-top: 2px solid; border-color: black;">
                                <h6 class="alert-heading">Sustainability and Policy Implementation report <span style="color:#0AA7C4;">(score 0)</span></h6>
                                <p>Very limited information available</p>
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingOne">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne-sustainability" aria-expanded="false" aria-controls="flush-collapseOne-sustainability">
                                                <p>Click here to details</p>
                                            </button>
                                        </h2>
                                        <div id="flush-collapseOne-sustainability" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label font-weight-bold">Score Parameter</div>
                                                    <div class="col-lg-9 col-md-8 label font-weight-bold">Description</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">2 = High</div>
                                                    <div class="col-lg-9 col-md-8">
                                                        <ul>
                                                            <li class="bi bi-check-circle"> Company is reporting (at least) annually on implementation progress (e.g. through sustainability report, progress report, or dashboard); and/or </li>
                                                            <li class="bi bi-check-circle"> Company is actively engaging with NGOs; and/or </li>
                                                            <li class="bi bi-check-circle"> Company is active in working groups (e.g. POIG)  </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">0 = Low</div>
                                                    <div class="col-lg-9 col-md-8">
                                                        <p>There is no evidence that the company is actively implementing any commitments, and there are no signs that this will change soon </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr style="border-top: 2px solid; border-color: black;">
                                <h6 class="alert-heading">Refiners and grievance management <span style="color:#0AA7C4;">(score 0)</span></h6>
                                <p>No information available</p>
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingOne">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne-refiners" aria-expanded="false" aria-controls="flush-collapseOne-refiners">
                                                <p>Click here to details</p>
                                            </button>
                                        </h2>
                                        <div id="flush-collapseOne-refiners" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label font-weight-bold">Score Parameter</div>
                                                    <div class="col-lg-9 col-md-8 label font-weight-bold">Description</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">2 = High</div>
                                                    <div class="col-lg-9 col-md-8">
                                                        <p>Availability and sufficient level of details on:</p>
                                                        <ul>
                                                            <li class="bi bi-check-circle"> Grievance and complaint handling </li>
                                                            <li class="bi bi-check-circle"> Supplier mill list at refinery level  </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">1 = Medium</div>
                                                    <div class="col-lg-9 col-md-8">
                                                        <p>Substential parts of the above mentioned criteria are not clear or not complete. </p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">0 = Low</div>
                                                    <div class="col-lg-9 col-md-8">
                                                        <p>No grievance information available</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr style="border-top: 2px solid; border-color: black;">
                                <h6 class="alert-heading">Publish Maps <span style="color:#0AA7C4;">(score 1)</span></h6>
                                <p>No submisson and no RSPO membership</p>
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingOne">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne-pubishMaps" aria-expanded="false" aria-controls="flush-collapseOne-pubishMaps">
                                                <p>Click here to details</p>
                                            </button>
                                        </h2>
                                        <div id="flush-collapseOne-pubishMaps" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label font-weight-bold">Score Parameter</div>
                                                    <div class="col-lg-9 col-md-8 label font-weight-bold">Description</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">3 = High</div>
                                                    <div class="col-lg-9 col-md-8">
                                                        <p>Full submission</p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">2 = Medium</div>
                                                    <div class="col-lg-9 col-md-8">
                                                        <p>Partial submission </p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">1 = Low</div>
                                                    <div class="col-lg-9 col-md-8">
                                                        <p>No submisson and no RSPO membership</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr style="border-top: 2px solid; border-color: black;">
                                <h6 class="alert-heading" style="color:red;">% of concessions that obtain legal status (HGU, SHM, MPOB) <span style="color:#0AA7C4;">(score 1)</span></h6>
                                <p>No submisson and no RSPO membership</p>
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingOne">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#percent_of_concessions" aria-expanded="false" aria-controls="percent_of_concessions">
                                                <p>Click here to details</p>
                                            </button>
                                        </h2>
                                        <div id="percent_of_concessions" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label font-weight-bold">Score Parameter</div>
                                                    <div class="col-lg-9 col-md-8 label font-weight-bold">Description</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">3 = High</div>
                                                    <div class="col-lg-9 col-md-8">
                                                        <p>Full submission</p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">2 = Medium</div>
                                                    <div class="col-lg-9 col-md-8">
                                                        <p>Partial submission </p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">1 = Low</div>
                                                    <div class="col-lg-9 col-md-8">
                                                        <p>No submisson and no RSPO membership</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr style="border-top: 2px solid; border-color: black;">
                                <h6 class="alert-heading">Website <span style="color:#0AA7C4;">(score 1)</span></h6>
                                <p>No submisson and no RSPO membership</p>
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingOne">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne-website" aria-expanded="false" aria-controls="flush-collapseOne-website">
                                                <p>Click here to details</p>
                                            </button>
                                        </h2>
                                        <div id="flush-collapseOne-website" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label font-weight-bold">Score Parameter</div>
                                                    <div class="col-lg-9 col-md-8 label font-weight-bold">Description</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">1 = Yes</div>
                                                    <div class="col-lg-9 col-md-8">
                                                        <p>Does the company have a website?</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">0 = No</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr style="border-top: 2px solid; border-color: black;">
                            </div>
                        </div>
                        <div class="tab-pane fade" id="rspo-justified" role="tabpanel" aria-labelledby="rspo-tab">
                            <div class="alert alert-light alert-dismissible fade show" role="alert">
                                <h6 class="alert-heading">Registration at the group level <span style="color:#0AA7C4;">(score 0)</span></h6>
                                <p>Not RSPO Member</p>
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingOne">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne-registratioinGroup" aria-expanded="false" aria-controls="flush-collapseOne-registratioinGroup">
                                                <p>Click here to details</p>
                                            </button>
                                        </h2>
                                        <div id="flush-collapseOne-registratioinGroup" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label font-weight-bold">Score Parameter</div>
                                                    <div class="col-lg-9 col-md-8 label font-weight-bold">Description</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">2 = High</div>
                                                    <div class="col-lg-9 col-md-8">
                                                        <p>Group and complete info on subsidiaries</p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">1 = Medium</div>
                                                    <div class="col-lg-9 col-md-8">
                                                        <p>Group but not complete info on subsidiaries </p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">0 = Low</div>
                                                    <div class="col-lg-9 col-md-8">
                                                        <p>One entity registered only</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr style="border-top: 2px solid; border-color: black;">
                                <h6 class="alert-heading">RSPO certification progress since the first RSPO membership registration date <span style="color:#0AA7C4;">(score 0)</span></h6>
                                <p>Not RSPO Member</p>
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingOne">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne-rspoCertification" aria-expanded="false" aria-controls="flush-collapseOne-rspoCertification">
                                                <p>Click here to details</p>
                                            </button>
                                        </h2>
                                        <div id="flush-collapseOne-rspoCertification" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label font-weight-bold">Score Parameter</div>
                                                    <div class="col-lg-9 col-md-8 label font-weight-bold">Description</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">3 : > 10 years membership</div>
                                                    <div class="col-lg-9 col-md-8">
                                                        <p>Between 70%-100% certification</p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">2 : < 5-10 years membership</div>
                                                    <div class="col-lg-9 col-md-8">
                                                        <p>Between 30%-70% certification </p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">1 : 0-5 years membersip</div>
                                                    <div class="col-lg-9 col-md-8">
                                                        <p>Between 0 - 30% certification</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr style="border-top: 2px solid; border-color: black;">
                                <h6 class="alert-heading">% of plantations RSPO audited <span style="color:#0AA7C4;">(score 0)</span></h6>
                                <p>Not RSPO Member</p>
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingOne">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne-refiners" aria-expanded="false" aria-controls="flush-collapseOne-refiners">
                                                <p>Click here to details</p>
                                            </button>
                                        </h2>
                                        <div id="flush-collapseOne-refiners" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label font-weight-bold">Score Parameter</div>
                                                    <div class="col-lg-9 col-md-8 label font-weight-bold">Description</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">2 : 70% to 100%</div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">1 : 30% to < 70%</div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">0 : less then 30%</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr style="border-top: 2px solid; border-color: black;">
                                <h6 class="alert-heading">RSPO Complaints <span style="color:#0AA7C4;">(score 0)</span></h6>
                                <p>No RSPO Member</p>
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingOne">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne-pubishMaps" aria-expanded="false" aria-controls="flush-collapseOne-pubishMaps">
                                                <p>Click here to details</p>
                                            </button>
                                        </h2>
                                        <div id="flush-collapseOne-pubishMaps" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label font-weight-bold">Score Parameter</div>
                                                    <div class="col-lg-9 col-md-8 label font-weight-bold">Description</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">3 = High</div>
                                                    <div class="col-lg-9 col-md-8">
                                                        <p>No complaints detected</p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">2 = Medium</div>
                                                    <div class="col-lg-9 col-md-8">
                                                        <p>Cases have been detected and closed </p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">1 = Low</div>
                                                    <div class="col-lg-9 col-md-8">
                                                        <p>Case have been detected and investigation is on progress</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr style="border-top: 2px solid; border-color: black;">
                            </div>
                        </div>
                        <div class="tab-pane fade" id="ndpe-justified" role="tabpanel" aria-labelledby="ndpe-tab">
                            <div class="alert alert-light alert-dismissible fade show" role="alert">
                                <h6 class="alert-heading">NDPE Policy adopted <span style="color:#0AA7C4;">(score 0)</span></h6>
                                <p>The company has some policies pertaining to sustainability and  but no explicit commitments to NDPE (bit.ly/3i8Trs9)</p>
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingOne">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne-ndpePolicy" aria-expanded="false" aria-controls="flush-collapseOne-ndpePolicy">
                                                <p>Click here to details</p>
                                            </button>
                                        </h2>
                                        <div id="flush-collapseOne-ndpePolicy" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label font-weight-bold">Score Parameter</div>
                                                    <div class="col-lg-9 col-md-8 label font-weight-bold">Description</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">3 = Publicly available and adopted</div>
                                                    <div class="col-lg-9 col-md-8">
                                                        <p>NDPE policy is available on company website and adopted</p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">2 = Adopted but not made public </div>
                                                    <div class="col-lg-9 col-md-8">
                                                        <p>NDPE policy is not available, but it is known that the company has adopted a policy  </p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">1 = NDPE policy published, but not adopted</div>
                                                    <div class="col-lg-9 col-md-8">
                                                        <p>The company has published a NDPE policy but not adopted it</p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">0 = No NDPE policy adopted </div>
                                                    <div class="col-lg-9 col-md-8">
                                                        <p>The company has not published and not adopted a NDPE policy</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr style="border-top: 2px solid; border-color: black;">
                                <h6 class="alert-heading">Social issues (reported or identified by EQ) <span style="color:#0AA7C4;">(score 3)</span></h6>
                                <p>No issues found</p>
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingOne">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne-socialIssues" aria-expanded="false" aria-controls="flush-collapseOne-socialIssues">
                                                <p>Click here to details</p>
                                            </button>
                                        </h2>
                                        <div id="flush-collapseOne-socialIssues" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label font-weight-bold">Score Parameter</div>
                                                    <div class="col-lg-9 col-md-8 label font-weight-bold">Description</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">3 = No issues since January 2016</div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">2 = Issues on 30% of the subsidiaries or less since 2016</div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">1 = Issues on 30 to 70% of the subsidiaries since January 2016</div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">0 = Issues on over 70% of the subsidiaries </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr style="border-top: 2px solid; border-color: black;">
                                <h6 class="alert-heading">Deforestation (ha) <span style="color:#0AA7C4;">(score 1)</span></h6>
                                <p>2016-2018=1795</p>
                                <p>2019=1733</p>
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingOne">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne-deforestation" aria-expanded="false" aria-controls="flush-collapseOne-deforestation">
                                                <p>Click here to details</p>
                                            </button>
                                        </h2>
                                        <div id="flush-collapseOne-deforestation" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label font-weight-bold">Score Parameter</div>
                                                    <div class="col-lg-9 col-md-8 label font-weight-bold">Description</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">3 = Not detected after 1 January 2016</div>
                                                    <div class="col-lg-9 col-md-8">
                                                        <p>No Deforestation since 2016</p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">2 = Detected between 1 January 2016 - 31 December 2018</div>
                                                    <div class="col-lg-9 col-md-8">
                                                        <p>Deforestation was detected after 2016 and stopped</p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">1= Detected after 1 January 2019</div>
                                                    <div class="col-lg-9 col-md-8">
                                                        <p>Deforestation has been detected in 2019 </p>
                                                    </div>
                                                </div>
                                                <hr>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr style="border-top: 2px solid; border-color: black;">
                                <h6 class="alert-heading">Peatland development (including peatforest) <span style="color:#0AA7C4;">(score 3)</span></h6>
                                <p>2016-2018=0</p>
                                <p>2019=0</p>
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingOne">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne-peatland" aria-expanded="false" aria-controls="flush-collapseOne-peatland">
                                                <p>Click here to details</p>
                                            </button>
                                        </h2>
                                        <div id="flush-collapseOne-peatland" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label font-weight-bold">Score Parameter</div>
                                                    <div class="col-lg-9 col-md-8 label font-weight-bold">Description</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">3 = Not detected after 1 January 2016</div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">2= Detected between 1 January 2016 - 31 December 2018</div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">1 = Detected after 1 January 2019</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr style="border-top: 2px solid; border-color: black;">
                                <h6 class="alert-heading">Burn areas (ha) <span style="color:#0AA7C4;">(score 3)</span></h6>
                                <p>2016-2018=0</p>
                                <p>2019=0</p>
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingOne">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne-burnArea" aria-expanded="false" aria-controls="flush-collapseOne-burnArea">
                                                <p>Click here to details</p>
                                            </button>
                                        </h2>
                                        <div id="flush-collapseOne-burnArea" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label font-weight-bold">Score Parameter</div>
                                                    <div class="col-lg-9 col-md-8 label font-weight-bold">Description</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">3= Not detected after 1 January 2016</div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">2= Detected between 1 January 2016 - 31 December 2018</div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">1= Detected after 1 January 2019</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr style="border-top: 2px solid; border-color: black;">
                                <h6 class="alert-heading">Land protection and usage <span style="color:#0AA7C4;">(score 3)</span></h6>
                                <p>No burning</p>
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingOne">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne-landProtection" aria-expanded="false" aria-controls="flush-collapseOne-landProtection">
                                                <p>Click here to details</p>
                                            </button>
                                        </h2>
                                        <div id="flush-collapseOne-landProtection" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label font-weight-bold">Score Parameter</div>
                                                    <div class="col-lg-9 col-md-8 label font-weight-bold">Description</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">3 = High</div>
                                                    <div class="col-lg-9 col-md-8">
                                                        <p>No burning</p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">2 = Medium</div>
                                                    <div class="col-lg-9 col-md-8">
                                                        <p>Burning was detected but not planted with oil palm</p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">1 = Low</div>
                                                    <div class="col-lg-9 col-md-8">
                                                        <p>Burning and oil palm planting have been detected</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr style="border-top: 2px solid; border-color: black;">
                                <h6 class="alert-heading">Restoration in Peatland <span style="color:#0AA7C4;">(score 3)</span></h6>
                                <p>No peatland conversion</p>
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingOne">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne-restorationPeatland" aria-expanded="false" aria-controls="flush-collapseOne-restorationPeatland">
                                                <p>Click here to details</p>
                                            </button>
                                        </h2>
                                        <div id="flush-collapseOne-restorationPeatland" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label font-weight-bold">Score Parameter</div>
                                                    <div class="col-lg-9 col-md-8 label font-weight-bold">Description</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">3 = High</div>
                                                    <div class="col-lg-9 col-md-8">
                                                        <p>No peatland conversion</p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">2 = Medium</div>
                                                    <div class="col-lg-9 col-md-8">
                                                        <p>Peatland conversion and restoration have been detected</p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">1 = Low</div>
                                                    <div class="col-lg-9 col-md-8">
                                                        <p>Peatland conversion detected but no restoration measures have been taken</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr style="border-top: 2px solid; border-color: black;">
                                <h6 class="alert-heading" style="color:red;">HCV/HCS Assessment <span style="color:#0AA7C4;">(score 3)</span></h6>
                                <p>No peatland conversion</p>
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingOne">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne-hcv-hcs-assessment" aria-expanded="false" aria-controls="flush-collapseOne-hcv-hcs-assessment">
                                                <p>Click here to details</p>
                                            </button>
                                        </h2>
                                        <div id="flush-collapseOne-hcv-hcs-assessment" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label font-weight-bold">Score Parameter</div>
                                                    <div class="col-lg-9 col-md-8 label font-weight-bold">Description</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">3 = High</div>
                                                    <div class="col-lg-9 col-md-8">
                                                        <p>No peatland conversion</p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">2 = Medium</div>
                                                    <div class="col-lg-9 col-md-8">
                                                        <p>Peatland conversion and restoration have been detected</p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 label">1 = Low</div>
                                                    <div class="col-lg-9 col-md-8">
                                                        <p>Peatland conversion detected but no restoration measures have been taken</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr style="border-top: 2px solid; border-color: black;">
                            </div>
                        </div>
                    </div><!-- End Default Tabs -->

                    </div>
                </div>
            </div>
            <a href="{{ url()->previous() }}">
                <span>Return to previous page</span>
            </a>
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