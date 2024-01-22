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
                <!-- <ol style="color:#4682B4;">
                    <li><a href="#" style="color:#4682B4;">Home</a></li>
                    <li><a href="#" style="color:#4682B4;">Indonesia</a></li>
                    <li><a href="#" style="color:#4682B4;">Corporate Profile</a></li>
                    <li><a href="#" style="color:#4682B4;">Group</a></li>
                </ol> -->
                <!-- <h2 style="color:#4682B4;">Subsidiary</h2> -->
            </div>

            <div class="row" style="box-shadow: rgba(44, 73, 100, 0.08) 0px 2px 15px 0px;">
                <div class="col-xl-12 col-lg-6 icon-boxes d-flex flex-column align-items-stretch justify-content-center py-5 px-lg-5">

                    <table class="table table-hover">
                        <thead>
                            <th class="d-flex justify-content-between align-items-center">
                                <h4 class="title mb-0">List of Groups</h4>
                                <form action="{{ route('searchFunctionGroup') }}" method="GET" class="d-flex">
                                    <input type="text" class="form-control me-2" name="query" placeholder="Search other groups">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </form>
                            </th>
                        </thead>

                        <form action="{{ route('groupShow') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if($consolidations->isEmpty())
                            <p>No results found.</p>
                            @else
                            @foreach($consolidations as $subs)
                            <tr>
                                <td>
                                    <input type="submit" name="group_name" value="{{ $subs->group_name }}" class="btn btn-light">
                                    <!-- <a href="subsidiaryShow" name="subsidiary" >{{ $subs->subsidiary }}</a> -->
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </form>
                    </table>
                        
                </div>
            </div>

        </div>
    </section><!-- End About Section -->

    <!-- Leaflet JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.js" integrity="sha384-dRnG3QipUv9zvMAkW8XVg+heW0jhvccrGM6yDNC4uK+xmqvBnp+0xuL50PYs10n/" crossorigin=""></script>

</main><!-- End #main -->
@endsection

