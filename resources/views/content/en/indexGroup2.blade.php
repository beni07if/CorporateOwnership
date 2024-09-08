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
                    <p>Consequuntur sunt aut quasi enim aliquam quae harum pariatur laboris nisi ut aliquip</p>
                  </div>
                  <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="100">
                    <i class="bx bx-cube-alt"></i>
                    <h4>Ullamco laboris nisi</h4>
                    <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt</p>
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
                    <p>Consequuntur sunt aut quasi enim aliquam quae harum pariatur laboris nisi ut aliquip</p>
                  </div>
                  <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="100">
                    <i class="bx bx-cube-alt"></i>
                    <h4>Ullamco laboris nisi</h4>
                    <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt</p>
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
            <div class="image col-xl-5 d-flex align-items-stretch justify-content-center order-1 order-lg-2" data-aos="fade-left" data-aos-delay="100">
              <img src="assets/img/features.svg" class="img-fluid" alt="">
            </div>
          </div> --}}
  
        </div>
    </section><!-- End App Features Section -->

    <section class="section profile">
        <div class="row">
            <div class="section-title">
                @foreach($groups->pluck('group_name')->unique() as $subs)
                <h2 class="card-title">{{$subs}} Group</h2>
                @endforeach
            </div>
          <div class="col-xl-12">
  
            <form action="{{ route('searchFunctionGroup') }}" method="GET" class="d-flex ms-auto" style="width: 33%;">
                <input type="text" class="form-control me-2" name="group_name" placeholder="Search for other company groups">
                <button type="submit" class="btn btn-info">Search</button>
            </form>
            
            <div class="card">
              <div class="card-body pt-3">
                <div class="tab-content pt-2">
                    @if(count($groups)>0)
                    <div class="tab-pane fade show active profile-overview" id="profile-overview">
                        <div class="d-flex justify-content-between flex-wrap">
                            <div class="d-flex flex-wrap">
                                @foreach($groups->pluck('group_name')->unique() as $subs)
                                    <h5 class="card-title me-3">{{ $subs }}</h5>
                                @endforeach
                            </div>
                        </div>                        
                        
                        @foreach($groups->pluck('group_name')->unique() as $subs)
                        <p class="small fst-italic">Company structure of {{$subs}}</p>
                        @endforeach

                        <h5 class="card-title">Basic Information</h5>
    
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="row">
                                    <div class="col-lg-5 col-md-4 label">Group Name</div>
                                    @foreach($groups->pluck('group_name')->unique() as $group_name)
                                        @if($group_name)
                                        <div class="col-lg-7 col-md-8">: {!! nl2br(e($group_name)) !!}</div>
                                        @else
                                        <div class="col-lg-7 col-md-8">: -</div>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="row">
                                    <div class="col-lg-5 col-md-4 label">Official Group Name</div>
                                    @foreach($groups->pluck('group_official_name')->unique() as $group_official_name)
                                        @if($group_official_name)
                                        <div class="col-lg-7 col-md-8">: {!! nl2br(e($group_official_name)) !!}</div>
                                        @else
                                        <div class="col-lg-7 col-md-8">: -</div>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="row">
                                    <div class="col-lg-5 col-md-4 label">Group Status</div>
                                    @foreach($groups->pluck('group_status')->unique() as $group_status)
                                        @if($group_status)
                                        <div class="col-lg-7 col-md-8">: {!! nl2br(e($group_status)) !!}</div>
                                        @else
                                        <div class="col-lg-7 col-md-8">: -</div>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="row">
                                    <div class="col-lg-5 col-md-4 label">Listing Status</div>
                                    @foreach($groups->pluck('listing_status')->unique() as $listing_status)
                                        @if($listing_status)
                                        <div class="col-lg-7 col-md-8">: {!! nl2br(e($listing_status)) !!}</div>
                                        @else
                                        <div class="col-lg-7 col-md-8">: -</div>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="row">
                                    <div class="col-lg-5 col-md-4 label">Business Sector</div>
                                    @foreach($groups->pluck('business_sector')->unique() as $business_sector)
                                        @if($business_sector)
                                        <div class="col-lg-7 col-md-8">: {!! nl2br(e($business_sector)) !!}</div>
                                        @else
                                        <div class="col-lg-7 col-md-8">: -</div>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="row">
                                    <div class="col-lg-5 col-md-4 label">Main Product</div>
                                    @foreach($groups->pluck('main_product')->unique() as $main_product)
                                        @if($main_product)
                                        <div class="col-lg-7 col-md-8">: {!! nl2br(e($main_product)) !!}</div>
                                        @else
                                        <div class="col-lg-7 col-md-8">: -</div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        
                            <div class="col-lg-6 col-md-6">
                                <div class="row">
                                    <div class="col-lg-5 col-md-4 label">Incorporation Date</div>
                                    @foreach($groups->pluck('incorporation_date')->unique() as $incorporation_date)
                                        @if($incorporation_date)
                                        <div class="col-lg-7 col-md-8">: {!! nl2br(e($incorporation_date)) !!}</div>
                                        @else
                                        <div class="col-lg-7 col-md-8">: -</div>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="row">
                                    <div class="col-lg-5 col-md-4 label">Country Registration</div>
                                    @foreach($groups->pluck('country_registration')->unique() as $country_registration)
                                        @if($country_registration)
                                        <div class="col-lg-7 col-md-8">: {!! nl2br(e($country_registration)) !!}</div>
                                        @else
                                        <div class="col-lg-7 col-md-8">: -</div>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="row">
                                    <div class="col-lg-5 col-md-4 label">Country Operation</div>
                                    @foreach($groups->pluck('country_operation')->unique() as $country_operation)
                                        @if($country_operation)
                                        <div class="col-lg-7 col-md-8">: {!! nl2br(e($country_operation)) !!}</div>
                                        @else
                                        <div class="col-lg-7 col-md-8">: -</div>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="row">
                                    <div class="col-lg-5 col-md-4 label">Business Address</div>
                                    @foreach($groups->pluck('business_address')->unique() as $business_address)
                                        @if($business_address)
                                        <div class="col-lg-7 col-md-8">: {!! nl2br(e($business_address)) !!}</div>
                                        @else
                                        <div class="col-lg-7 col-md-8">: -</div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>      

                        <h5 class="card-title">Management and Controller</h5>
    
                        <div class="row">
                            <div class="col-lg-3 col-md-4 label ">Controller</div>
                            @foreach($groups->pluck('controller')->unique() as $controller)
                                @if($controller)
                                <div class="col-lg-9 col-md-8">: {!! nl2br(e($controller)) !!}</div>
                                @else
                                <div class="col-lg-9 col-md-8">: -</div>
                                @endif
                            @endforeach
                        </div>
    
                        <div class="row">
                            <div class="col-lg-3 col-md-4 label ">Name and Position</div>
                            @foreach($groups->pluck('management_name_and_position')->unique() as $management_name_and_position)
                                @if($management_name_and_position)
                                <div class="col-lg-9 col-md-8">: {!! nl2br(e($management_name_and_position)) !!}</div>
                                @else
                                <div class="col-lg-9 col-md-8">: -</div>
                                @endif
                            @endforeach
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <h5 class="card-title">Shareholders</h5>
                                <div class="row">
                                    <div class="col-lg-12 col-md-8">
                                        @foreach($groups as $subs)
                                        <form action="{{ route('searchFunctionShareholder') }}" method="GET" enctype="multipart/form-data">
                                            @csrf
                                            <div>
                                                @if($subs->shareholder_name1 !== 'Nil')
                                                    <input type="submit" name="shareholder_name" value="{{ $subs->shareholder_name1 }}" class="text-muted" style="border: none;"> ({{ $subs->percent_of_share1 }}) <br>
                                                @endif
                        
                                                @if($subs->shareholder_name2 !== 'Nil')
                                                    <input type="submit" name="shareholder_name" value="{{ $subs->shareholder_name2 }}" class="text-muted" style="border: none;"> ({{ $subs->percent_of_share2 }}) <br>
                                                @endif
                        
                                                @if($subs->shareholder_name3 !== 'Nil')
                                                    <input type="submit" name="shareholder_name" value="{{ $subs->shareholder_name3 }}" class="text-muted" style="border: none;"> ({{ $subs->percent_of_share3 }}) <br>
                                                @endif
                        
                                                @if($subs->shareholder_name4 !== 'Nil')
                                                    <input type="submit" name="shareholder_name" value="{{ $subs->shareholder_name4 }}" class="text-muted" style="border: none;"> ({{ $subs->percent_of_share4 }}) <br>
                                                @endif
                        
                                                @if($subs->shareholder_name5 !== 'Nil')
                                                    <input type="submit" name="shareholder_name" value="{{ $subs->shareholder_name5 }}" class="text-muted" style="border: none;"> ({{ $subs->percent_of_share5 }})
                                                @endif
                                            </div>
                                        </form>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        
                            <div class="col-lg-6 col-md-12">
                                <h5 class="card-title">Subsidiary</h5>
                                <div class="row">
                                    <form action="{{ route('subsidiaryShow') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @foreach($consolidations->pluck('subsidiary')->unique() as $subs)
                                        <div>
                                            <input type="submit" name="subsidiary" value="{{ $subs }}" class="text-muted" style="border: none;">
                                        </div>
                                        @endforeach
                                    </form>
                                </div>
                            </div>
                        </div>
                        

                        <h5 class="card-title">Land Area (in hectare)</h5>
    
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                            <div class="row">
                                <div class="col-lg-5 col-md-4 label">Land Area Controlled</div>
                                @foreach($groups->pluck('land_area_controlled')->unique() as $land_area_controlled)
                                    @if($land_area_controlled)
                                    <div class="col-lg-7 col-md-8">: {!! nl2br(e($land_area_controlled)) !!}</div>
                                    @else
                                    <div class="col-lg-7 col-md-8">: -</div>
                                    @endif
                                @endforeach
                            </div>
                            <div class="row">
                                <div class="col-lg-5 col-md-4 label">Total Planted</div>
                                @foreach($groups->pluck('total_planted')->unique() as $total_planted)
                                    @if($total_planted)
                                    <div class="col-lg-7 col-md-8">: {!! nl2br(e($total_planted)) !!}</div>
                                    @else
                                    <div class="col-lg-7 col-md-8">: -</div>
                                    @endif
                                @endforeach
                            </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                            <div class="row">
                                <div class="col-lg-5 col-md-4 label">Total Smallholders</div>
                                @foreach($groups->pluck('total_smallholders')->unique() as $total_smallholders)
                                    @if($total_smallholders)
                                    <div class="col-lg-7 col-md-8">: {!! nl2br(e($total_smallholders)) !!}</div>
                                    @else
                                    <div class="col-lg-7 col-md-8">: -</div>
                                    @endif
                                @endforeach
                            </div>
                            <div class="row">
                                <div class="col-lg-5 col-md-4 label">Total Land Designated and Managed as HCV/HCS Areas</div>
                                @foreach($groups->pluck('total_land_designed_hcv')->unique() as $total_land_designed_hcv)
                                    @if($total_land_designed_hcv)
                                    <div class="col-lg-7 col-md-8">: {!! nl2br(e($total_land_designed_hcv)) !!}</div>
                                    @else
                                    <div class="col-lg-7 col-md-8">: -</div>
                                    @endif
                                @endforeach
                            </div>
                            </div>
                        </div>
                        
                        <h5 class="card-title">Productivity/Volume Handled (tonnes per year)</h5>
    
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                            <div class="row">
                                <div class="col-lg-5 col-md-4 label">Annual FFB Productivity</div>
                                @foreach($groups->pluck('annual_ffb_productivity')->unique() as $annual_ffb_productivity)
                                    @if($annual_ffb_productivity)
                                    <div class="col-lg-7 col-md-8">: {!! nl2br(e($annual_ffb_productivity)) !!}</div>
                                    @else
                                    <div class="col-lg-7 col-md-8">: -</div>
                                    @endif
                                @endforeach
                            </div>
                            <div class="row">
                                <div class="col-lg-5 col-md-4 label">Annual CPO Productivity</div>
                                @foreach($groups->pluck('annual_cpo_productivity')->unique() as $annual_cpo_productivity)
                                    @if($annual_cpo_productivity)
                                    <div class="col-lg-7 col-md-8">: {!! nl2br(e($annual_cpo_productivity)) !!}</div>
                                    @else
                                    <div class="col-lg-7 col-md-8">: -</div>
                                    @endif
                                @endforeach
                            </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                            <div class="row">
                                <div class="col-lg-5 col-md-4 label">Annual FFB Productivity by RSPO Certified</div>
                                @foreach($groups->pluck('unnual_productivity_by_rspo_certified')->unique() as $unnual_productivity_by_rspo_certified)
                                    @if($unnual_productivity_by_rspo_certified)
                                    <div class="col-lg-7 col-md-8">: {!! nl2br(e($unnual_productivity_by_rspo_certified)) !!}</div>
                                    @else
                                    <div class="col-lg-7 col-md-8">: -</div>
                                    @endif
                                @endforeach
                            </div>
                            <div class="row">
                                <div class="col-lg-5 col-md-4 label">Annual CPK Productivity</div>
                                @foreach($groups->pluck('annual_cpk_productivity')->unique() as $annual_cpk_productivity)
                                    @if($annual_cpk_productivity)
                                    <div class="col-lg-7 col-md-8">: {!! nl2br(e($annual_cpk_productivity)) !!}</div>
                                    @else
                                    <div class="col-lg-7 col-md-8">: -</div>
                                    @endif
                                @endforeach
                            </div>
                            </div>
                        </div>
                        
                        
                        <h5 class="card-title">Membership in Global Sustainable Scheme</h5>
    
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                            <div class="row">
                                <div class="col-lg-5 col-md-4 label">RSPO Member</div>
                                @foreach($groups->pluck('rspo_member')->unique() as $rspo_member)
                                    @if($rspo_member)
                                    <div class="col-lg-7 col-md-8">: {!! nl2br(e($rspo_member)) !!}</div>
                                    @else
                                    <div class="col-lg-7 col-md-8">: -</div>
                                    @endif
                                @endforeach
                            </div>
                            <div class="row">
                                <div class="col-lg-5 col-md-4 label">CGF Member</div>
                                @foreach($groups->pluck('cgf_member')->unique() as $cgf_member)
                                    @if($cgf_member)
                                    <div class="col-lg-7 col-md-8">: {!! nl2br(e($cgf_member)) !!}</div>
                                    @else
                                    <div class="col-lg-7 col-md-8">: -</div>
                                    @endif
                                @endforeach
                            </div>
                            <div class="row">
                                <div class="col-lg-5 col-md-4 label">ASD Member</div>
                                @foreach($groups->pluck('asd_member')->unique() as $asd_member)
                                    @if($asd_member)
                                    <div class="col-lg-7 col-md-8">: {!! nl2br(e($asd_member)) !!}</div>
                                    @else
                                    <div class="col-lg-7 col-md-8">: -</div>
                                    @endif
                                @endforeach
                            </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                            <div class="row">
                                <div class="col-lg-5 col-md-4 label">GPNSR Member</div>
                                @foreach($groups->pluck('gpnsr_member')->unique() as $gpnsr_member)
                                    @if($gpnsr_member)
                                    <div class="col-lg-7 col-md-8">: {!! nl2br(e($gpnsr_member)) !!}</div>
                                    @else
                                    <div class="col-lg-7 col-md-8">: -</div>
                                    @endif
                                @endforeach
                            </div>
                            <div class="row">
                                <div class="col-lg-5 col-md-4 label">Other Membership</div>
                                @foreach($groups->pluck('ohters_mention')->unique() as $ohters_mention)
                                    @if($ohters_mention)
                                    <div class="col-lg-7 col-md-8">: {!! nl2br(e($ohters_mention)) !!}</div>
                                    @else
                                    <div class="col-lg-7 col-md-8">: -</div>
                                    @endif
                                @endforeach
                            </div>
                            </div>
                        </div>                     
                        
                        <h5 class="card-title">Transparency and Responsibility</h5>
    
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="row">
                                    <div class="col-lg-5 col-md-4 label">Certification</div>
                                    <div class="col-lg-7 col-md-8">: -</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5 col-md-4 label">Link Certification</div>
                                    <div class="col-lg-7 col-md-8">: -</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5 col-md-4 label">NDPE Policy</div>
                                    @foreach($groups->pluck('ndpe_policy')->unique() as $ndpe_policy)
                                        @if($ndpe_policy)
                                        <div class="col-lg-7 col-md-8">: {!! nl2br(e($ndpe_policy)) !!}</div>
                                        @else
                                        <div class="col-lg-7 col-md-8">: -</div>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="row">
                                    <div class="col-lg-5 col-md-4 label">NDPE Time Bound Plan Implementation</div>
                                    @foreach($groups->pluck('ndpe_time_bound_plan_implementation')->unique() as $ndpe_time_bound_plan_implementation)
                                        @if($ndpe_time_bound_plan_implementation)
                                        <div class="col-lg-7 col-md-8">: {!! nl2br(e($ndpe_time_bound_plan_implementation)) !!}</div>
                                        @else
                                        <div class="col-lg-7 col-md-8">: -</div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="row">
                                    <div class="col-lg-5 col-md-4 label">Sustainability Progress Report</div>
                                    @foreach($groups->pluck('sustainability_progress_report')->unique() as $sustainability_progress_report)
                                        @if($sustainability_progress_report)
                                        <div class="col-lg-7 col-md-8">: {!! nl2br(e($sustainability_progress_report)) !!}</div>
                                        @else
                                        <div class="col-lg-7 col-md-8">: -</div>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="row">
                                    <div class="col-lg-5 col-md-4 label">Supply Chain Traceability</div>
                                    @foreach($groups->pluck('supply_chain_traceability')->unique() as $supply_chain_traceability)
                                        @if($supply_chain_traceability)
                                        <div class="col-lg-7 col-md-8">: {!! nl2br(e($supply_chain_traceability)) !!}</div>
                                        @else
                                        <div class="col-lg-7 col-md-8">: -</div>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="row">
                                    <div class="col-lg-5 col-md-4 label">Grievance Mechanism</div>
                                    @foreach($groups->pluck('grievance_mechanism')->unique() as $grievance_mechanism)
                                        @if($grievance_mechanism)
                                        <div class="col-lg-7 col-md-8">: {!! nl2br(e($grievance_mechanism)) !!}</div>
                                        @else
                                        <div class="col-lg-7 col-md-8">: -</div>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="row">
                                    <div class="col-lg-5 col-md-4 label">Recovery Plan</div>
                                    @foreach($groups->pluck('recovery_plan')->unique() as $recovery_plan)
                                        @if($recovery_plan)
                                        <div class="col-lg-7 col-md-8">: {!! nl2br(e($recovery_plan)) !!}</div>
                                        @else
                                        <div class="col-lg-7 col-md-8">: -</div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>                      
                        
                        <h5 class="card-title">Company Group Structure</h5>

                        <div>
                            @foreach($groups->groupBy('group_name') as $subsidiaryGroup)
                                @php
                                    $subsidiary = $subsidiaryGroup->first()->group_name;
                        
                                    $directory = public_path('file/group-structure/');
                                    $filesInDirectory = scandir($directory);
                        
                                    // Filter files that match the group name and have a pdf or pptx extension
                                    $matchingFiles = preg_grep('/^\d+ \d+ ' . preg_quote($subsidiary, '/') . '\.(pdf|pptx)$/i', $filesInDirectory);
                        
                                    if (!empty($matchingFiles)) {
                                        $fileNameInDirectory = reset($matchingFiles);
                                        $fileExtension = pathinfo($fileNameInDirectory, PATHINFO_EXTENSION);
                                        
                                        if ($fileExtension == 'pdf') {
                                            $googleDocsUrl = route('serve.pdf', ['filename' => $fileNameInDirectory]);
                                        } elseif ($fileExtension == 'pptx') {
                                            $googleDocsUrl = 'https://docs.google.com/viewer?url=' . urlencode(url('file/group-structure/' . $fileNameInDirectory));
                                        } else {
                                            $googleDocsUrl = '';
                                        }
                                    } else {
                                        $googleDocsUrl = ''; // Provide a default value if no file is found
                                    }
                                @endphp
                        
                                @if($googleDocsUrl)
                                    <iframe src="{{ $googleDocsUrl }}" style="width: 100%; height: 600px;" frameborder="0" allowfullscreen></iframe>
                                @else
                                    <p>Please contact us to get company structure and other information of {{ $subsidiary }}.</p>
                                @endif
                            @endforeach
                        </div><br>

                        <h6 class="card-title"><i>*Data source by Inovasi Digital</i></h6>
    
                        <div class="row" hidden>
                            <div class="col-lg-6 col-md-6">
                                <div class="row">
                                    <div class="col-lg-5 col-md-4 label ">Data Source</div>
                                    @foreach($groups->pluck('data_sources')->unique() as $data_sources)
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
                                    @foreach($groups->pluck('data_update')->unique() as $data_update)
                                        @if($data_update)
                                        <div class="col-lg-7 col-md-8">: {!! nl2br(e($data_update)) !!}</div>
                                        @else
                                        <div class="col-lg-7 col-md-8">: -</div>
                                        @endif
                                    @endforeach
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
    <script src="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.js" integrity="sha384-dRnG3QipUv9zvMAkW8XVg+heW0jhvccrGM6yDNC4uK+xmqvBnp+0xuL50PYs10n/" crossorigin=""></script>

</main><!-- End #main -->
@endsection

<script>
    AOS.init({
        duration: 1000, // Durasi animasi dalam milidetik
        once: true, // Animasi hanya berjalan sekali
    });
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
        <h1 class="modal-title fs-5" id="exampleModalLabel">
        @foreach($groups as $subs)
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
                        <h6 class="card-title description">Incorporation Date</h6>
                        <p class="card-text">{{ $subs->commercial_operation_date }}</p>
                        <h6 class="card-title description">Country Registration</h6>
                        <p class="card-text">{{ $subs->country_registration }}</p>
                        <h6 class="card-title description">Business Address</h6>
                        <p class="card-text">{{ $subs->business_address }}</p>
                        <h6 class="card-title description">Country Operation</h6>
                        <p class="card-text">{{ $subs->country_operation }}</p>
                        <h6 class="card-title description">Shareholder</h6>
                        @foreach($groups as $subs)
                            <div>
                                @if($subs->shareholder_name1 !== 'Nil')
                                    <p class="card-text">{{ $subs->shareholder_name1 }} ({{ $subs->percent_of_share1 }}) </p>
                                @endif

                                @if($subs->shareholder_name2 !== 'Nil')
                                    <p class="card-text">{{ $subs->shareholder_name2 }} ({{ $subs->percent_of_share2 }}) </p>
                                @endif

                                @if($subs->shareholder_name3 !== 'Nil')
                                    <p class="card-text">{{ $subs->shareholder_name3 }} ({{ $subs->percent_of_share3 }}) </p>
                                @endif

                                @if($subs->shareholder_name4 !== 'Nil')
                                    <p class="card-text">{{ $subs->shareholder_name4 }} ({{ $subs->percent_of_share4 }}) </p>
                                @endif

                                @if($subs->shareholder_name5 !== 'Nil')
                                    <p class="card-text">{{ $subs->shareholder_name5 }} ({{ $subs->percent_of_share5 }})
                                @endif
                            </div>
                        @endforeach
                        <!-- <h6 class="card-title description">Group Structure</h6>
                        <p class="card-text">{{ $subs->group_structure }}</p> -->
                        <h6 class="card-title description">Management (Name and Position)</h6>
                        <p class="card-text">
                            <?php
                            $management = $subs->management_name_and_position;
                            echo nl2br(preg_replace('/\)/', ")\n", $management));
                            ?>
                        </p>
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
                        <h6 class="card-title description">Others Membership Mention</h6>
                        <p class="card-text">{{ $subs->others_mention }}</p>
                        <h6 class="card-title description">NDPE Policy</h6>
                        <p class="card-text">{{ $subs->ndpe_policy }}</p>
                        <!-- <h6 class="card-title description">NDPE Time Bound Plan Implementation</h6>
                        <p class="card-text">{{ $subs->ndpe_time_bound_plan_implementation }}</p> -->
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