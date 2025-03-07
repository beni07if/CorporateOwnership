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
                    @foreach($consolidations->pluck('subsidiary')->unique() as $subs)
                        <h2 class="card-title">Notarial Deed of {{$subs}}</h2>
                    @endforeach
                </div>
                <div class="col-xl-12">

                    <div class="row pb-3 justify-content-center">
                        <form action="{{ route('searchFunctionSubsidiary') }}" method="GET" class="d-flex"
                            style="width: 33%; background-color: #f8f9fa; border-radius: 10px; padding: 15px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                            <input type="text" class="form-control me-2" name="subsidiary"
                                placeholder="Search for other subsidiary company"
                                style="border: 1px solid #007bff; border-radius: 5px;">
                            <button type="submit" class="btn btn-info"
                                style="border-radius: 5px; transition: background-color 0.3s;">
                                Search
                            </button>
                        </form>
                    </div>

                    <div class="card">
                        <div class="card-body pt-3">
                            <div class="tab-content pt-2">
                                @if(count($consolidations) > 0)
                                                        <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                                            <div>
                                                                @foreach($consolidations->groupBy('subsidiary') as $subsidiary)
                                                                                                @php
                                                                                                    $subsidiary = $subsidiary->first()->subsidiary;

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

                                                                                                {{-- @if(!empty($filePath))
                                                                                                <iframe src="{{ $filePath }}" width="100%" height="600px"></iframe>
                                                                                                @else
                                                                                                <p>Please contact us to get notarial deed and other information of
                                                                                                    {{$subsidiaryGroup->first()->subsidiary}}.</p>
                                                                                                @endif
                                                                                                <!-- <p class="text-muted">{{ $subsidiary }}</p> --> --}}
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