@extends('layout.app')

@section('styleMaps')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.css" />
<style>
    
</style>
@endsection

@section('content')
<main id="main">

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
</main><!-- End #main -->
@endsection