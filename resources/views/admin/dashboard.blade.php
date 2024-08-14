@extends('admin.layout.appAdmin')
@section('content')
<section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">

            <!-- Sales Card -->
            <div class="col-xxl-3 col-md-6">
              <div class="card info-card sales-card">

                <div class="card-body">
                    <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <li class="dropdown-header text-start">
                        <p>{{ number_format($groupCounts) }} rows data</p>
                        </li>
                    </ul>
                    </div>
                  <h5 class="card-title">Group<span></span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="ri-door-open-fill"></i>
                    </div>
                    <div class="ps-3">
                        <h6>{{ number_format($groupCounts) }}</h6>
                        <span class="text-success small pt-1 fw-bold"></span> <span class="text-muted small pt-2 ps-1">groups</span>
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->

            <!-- Revenue Card -->
            <div class="col-xxl-3 col-md-6">
              <div class="card info-card revenue-card">

                <div class="card-body">
                    <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <li class="dropdown-header text-start">
                        <p>{{ number_format($consolidationCounts) }} rows data</p>
                        </li>
                    </ul>
                    </div>
                  <h5 class="card-title">Company/Subsidiary<span></span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="ri-door-open-line"></i>
                    </div>
                    <div class="ps-3">
                        <h6>{{ number_format($consolidationCountsDistinct) }}</h6>
                        <span class="text-success small pt-1 fw-bold"></span> <span class="text-muted small pt-2 ps-1">subsidiaries</span>
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->

            <!-- Customers Card -->
            <div class="col-xxl-3 col-xl-12">

              <div class="card info-card customers-card">

                <div class="card-body">
                    <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <li class="dropdown-header text-start">
                        <p>{{ number_format($shareholderCounts) }} rows data</p>
                        </li>
                    </ul>
                    </div>
                  <h5 class="card-title">Shareholder<span></span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                        <h6>{{ number_format($shareholderCountsDistinct) }}</h6>
                        <span class="text-success small pt-1 fw-bold"></span> <span class="text-muted small pt-2 ps-1">shareholders</span>
                    </div>
                  </div>

                </div>
              </div>

            </div><!-- End Customers Card -->

            <!-- Customers Card -->
            <div class="col-xxl-3 col-xl-12">

              <div class="card info-card customers-card">

                <div class="card-body">
                    <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <li class="dropdown-header text-start">
                        <p>{{ number_format($sraCounts) }} rows data</p>
                        </li>
                    </ul>
                    </div>
                  <h5 class="card-title">SRA<span></span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-pencil"></i>
                    </div>
                    <div class="ps-3">
                        <h6>{{ number_format($sraCountsDistinct) }}</h6>
                        <span class="text-success small pt-1 fw-bold"></span> <span class="text-muted small pt-2 ps-1">groups</span>
                    </div>
                  </div>

                </div>
              </div>

            </div><!-- End Customers Card -->

            <!-- Recent Sales -->
            <div class="col-12" hidden>
              <div class="card recent-sales overflow-auto">

                <div class="card-body">
                    <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <li class="dropdown-header text-start">
                        <p>Number of group by country</p>
                        </li>
                    </ul>
                    </div>
                  <h5 class="card-title">5 Top Groups <span></span></h5>

                  <table class="table table-borderless datatable">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Group Name</th>
                        <th scope="col">Country</th>
                        <th scope="col">Number of Subsidiaries</th>
                        <th scope="col">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row"><a href="#">#2457</a></th>
                        <td>Brandon Jacob</td>
                        <td><a href="#" class="text-primary">At praesentium minu</a></td>
                        <td>$64</td>
                        <td><span class="badge bg-success">Approved</span></td>
                      </tr>
                      <tr>
                        <th scope="row"><a href="#">#2147</a></th>
                        <td>Bridie Kessler</td>
                        <td><a href="#" class="text-primary">Blanditiis dolor omnis similique</a></td>
                        <td>$47</td>
                        <td><span class="badge bg-warning">Pending</span></td>
                      </tr>
                      <tr>
                        <th scope="row"><a href="#">#2049</a></th>
                        <td>Ashleigh Langosh</td>
                        <td><a href="#" class="text-primary">At recusandae consectetur</a></td>
                        <td>$147</td>
                        <td><span class="badge bg-success">Approved</span></td>
                      </tr>
                      <tr>
                        <th scope="row"><a href="#">#2644</a></th>
                        <td>Angus Grady</td>
                        <td><a href="#" class="text-primar">Ut voluptatem id earum et</a></td>
                        <td>$67</td>
                        <td><span class="badge bg-danger">Rejected</span></td>
                      </tr>
                      <tr>
                        <th scope="row"><a href="#">#2644</a></th>
                        <td>Raheem Lehner</td>
                        <td><a href="#" class="text-primary">Sunt similique distinctio</a></td>
                        <td>$165</td>
                        <td><span class="badge bg-success">Approved</span></td>
                      </tr>
                    </tbody>
                  </table>

                </div>

              </div>
            </div><!-- End Recent Sales -->

          </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-12 col-md-6">
            <div class="row">

                <div class="col-xxl-4">
                    <!-- Website Traffic -->
                    <div class="card">
                        <div class="filter">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start">
                            <p>Number of group by country</p>
                            </li>
                        </ul>
                        </div>

                        <div class="card-body pb-0">
                        <h5 class="card-title">Group by Country<span></span></h5>
                        <div id="trafficChart1" style="min-height: 400px;" class="echart"></div>
                          
                          <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                // Ambil data dari controller
                                var allGroupCountes = @json($allGroupCountes);
                                var top5GroupCountes = @json($top5GroupCountes);
                        
                                // Fungsi untuk menghasilkan warna gradasi orange
                                function getGradientColor(index) {
                                    const startColor = [251, 140, 1]; // RGB untuk orange tua gelap
                                    const endColor = [255, 204, 0]; // RGB untuk orange muda
                                    const ratio = index / 4; // 5 warna (0 hingga 4)
                                    const color = startColor.map((start, i) => Math.round(start + (endColor[i] - start) * ratio));
                                    return `rgb(${color.join(',')})`;
                                }
                        
                                // Susun data untuk chart pie (semua data)
                                var pieData = allGroupCountes.map((item, index) => {
                                    let color;
                                    if (index < 5) {
                                        // Gunakan gradasi warna orange untuk 5 teratas
                                        color = getGradientColor(index);
                                    } else {
                                        // Warna acak untuk sisanya
                                        color = `rgba(${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, 0.8)`;
                                    }
                                    return {
                                        value: item.count,
                                        name: item.country_registration,
                                        itemStyle: {
                                            color: color
                                        }
                                    };
                                });
                        
                                // Susun data untuk legenda (5 terbanyak)
                                var legendData = top5GroupCountes.map(item => item.country_registration);
                        
                                // Inisialisasi chart pie
                                var chart = echarts.init(document.querySelector("#trafficChart1"));
                                chart.setOption({
                                    tooltip: {
                                        trigger: 'item'
                                    },
                                    legend: {
                                        top: '5%',
                                        left: 'center',
                                        data: legendData // Menampilkan hanya 5 terbanyak di legenda
                                    },
                                    series: [{
                                        name: 'Number of Group',
                                        type: 'pie',
                                        radius: ['40%', '70%'],
                                        avoidLabelOverlap: false,
                                        label: {
                                            show: false,
                                            position: 'center'
                                        },
                                        emphasis: {
                                            label: {
                                                show: true,
                                                fontSize: '18',
                                                fontWeight: 'bold'
                                            }
                                        },
                                        labelLine: {
                                            show: false
                                        },
                                        data: pieData
                                    }]
                                });
                            });
                          </script>
                        

                        </div>
                    </div>
                </div>

                <div class="col-xxl-4">
                    <!-- Website Traffic -->
                    <div class="card">
                        <div class="filter">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start">
                            <p>Number of companies by country</p>
                            </li>
                        </ul>
                        </div>

                        <div class="card-body pb-0">
                        <h5 class="card-title">Company by Country <span></span></h5>
                        <div id="trafficChart2" style="min-height: 400px;" class="echart"></div>

                        <script>
                          document.addEventListener("DOMContentLoaded", () => {
                              // Ambil data dari controller
                              var allSubsidiaryCountes = @json($allSubsidiaryCountes);
                              var top5SubsidiaryCountes = @json($top5SubsidiaryCountes);

                              // Fungsi untuk menghasilkan warna gradasi orange
                              function getGradientColor(index) {
                                    const startColor = [105, 105, 105]; // RGB untuk orange tua gelap
                                    const endColor = [255, 204, 0]; // RGB untuk orange muda
                                    const ratio = index / 4; // 5 warna (0 hingga 4)
                                    const color = startColor.map((start, i) => Math.round(start + (endColor[i] - start) * ratio));
                                    return `rgb(${color.join(',')})`;
                                }
                          
                              // Susun data untuk chart pie (semua data)
                              var pieData = allSubsidiaryCountes.map((item, index) => {
                                    let color;
                                    if (index < 5) {
                                        // Gunakan gradasi warna orange untuk 5 teratas
                                        color = getGradientColor(index);
                                    } else {
                                        // Warna acak untuk sisanya
                                        color = `rgba(${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, 0.8)`;
                                    }
                                    return {
                                        value: item.count,
                                        name: item.country_registration,
                                        itemStyle: {
                                            color: color
                                        }
                                    };
                                });
                          
                              // Susun data untuk legenda (5 terbanyak)
                              var legendData = top5SubsidiaryCountes.map(item => item.country_registration);
                          
                              // Inisialisasi chart pie
                              var chart = echarts.init(document.querySelector("#trafficChart2"));
                              chart.setOption({
                                  tooltip: {
                                      trigger: 'item'
                                  },
                                  legend: {
                                      top: '5%',
                                      left: 'center',
                                      data: legendData // Menampilkan hanya 5 terbanyak di legenda
                                  },
                                  series: [{
                                      name: 'Number of Subsidiaries',
                                      type: 'pie',
                                      radius: ['40%', '70%'],
                                      avoidLabelOverlap: false,
                                      label: {
                                          show: false,
                                          position: 'center'
                                      },
                                      emphasis: {
                                          label: {
                                              show: true,
                                              fontSize: '18',
                                              fontWeight: 'bold'
                                          }
                                      },
                                      labelLine: {
                                          show: false
                                      },
                                      data: pieData
                                  }]
                              });
                          });
                          </script>                          

                        </div>
                    </div>
                </div>

                <div class="col-xxl-4">
                    <!-- Website Traffic -->
                    <div class="card">
                        <div class="filter">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start">
                            <p>Number of shareholder by company based on company ownership data</p>
                            </li>
                        </ul>
                        </div>

                        <div class="card-body pb-0">
                        <h5 class="card-title">Shareholders by Company <span></span></h5>
                        <div id="trafficChart3" style="min-height: 400px;" class="echart"></div>
                        <script>
                          document.addEventListener("DOMContentLoaded", () => {
                              // Ambil data dari controller
                              var allShareholderCountes = @json($allShareholderCountes);
                              var top5ShareholderCountes = @json($top5ShareholderCountes);
                      
                              // Fungsi untuk menghasilkan warna gradasi hijau
                              function getGradientColor(index) {
                                  const startColor = [26, 128, 127]; // RGB untuk hijau tua
                                  const endColor = [144, 238, 144]; // RGB untuk hijau muda
                                  const ratio = index / 4; // 5 warna (0 hingga 4)
                                  const color = startColor.map((start, i) => Math.round(start + (endColor[i] - start) * ratio));
                                  return `rgb(${color.join(',')})`;
                              }
                      
                              // Susun data untuk chart pie (semua data)
                              var pieData = allShareholderCountes.map((item, index) => {
                                  let color;
                                  if (index < 10) {
                                      // Gunakan gradasi warna hijau untuk 5 teratas
                                      color = getGradientColor(index);
                                  } else {
                                      // Warna acak untuk sisanya
                                      color = `rgba(${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, 0.8)`;
                                  }
                                  return {
                                      value: item.count,
                                      name: item.company_name,
                                      itemStyle: {
                                          color: color
                                      }
                                  };
                              });
                      
                              // Susun data untuk legenda (5 terbanyak)
                              var legendData = top5ShareholderCountes.map(item => item.company_name);
                      
                              // Inisialisasi chart pie
                              var chart = echarts.init(document.querySelector("#trafficChart3"));
                              chart.setOption({
                                  tooltip: {
                                      trigger: 'item'
                                  },
                                  legend: {
                                      top: '5%',
                                      left: 'center',
                                      data: legendData // Menampilkan hanya 5 terbanyak di legenda
                                  },
                                  series: [{
                                      name: 'Number of Shareholder',
                                      type: 'pie',
                                      radius: ['40%', '70%'],
                                      avoidLabelOverlap: false,
                                      label: {
                                          show: false,
                                          position: 'center'
                                      },
                                      emphasis: {
                                          label: {
                                              show: true,
                                              fontSize: '18',
                                              fontWeight: 'bold'
                                          }
                                      },
                                      labelLine: {
                                          show: false
                                      },
                                      data: pieData
                                  }]
                              });
                          });
                      </script>                  
                      
                        </div>
                    </div>
                </div>
                        </div>
      </div>
    </section>
@endsection