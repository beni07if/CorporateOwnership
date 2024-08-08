@extends('admin.layout.appAdmin')
@section('brudcump')
<div class="pagetitle">
  <h1>Dashboard</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
      <li class="breadcrumb-item active">Policy</li>
    </ol>
  </nav>
</div>
@endsection
@section('content')
<section class="section dashboard">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Policy</h5>
          <!-- <p>Policy</p> -->

          <!-- Table with stripped rows -->
          <table class="table datatable">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Description</th>
                <th scope="col">Details</th>
              </tr>
            </thead>
            <tbody>
              @foreach($policies as $policy)
              <tr>
                <th scope="row">{{$loop->iteration}}</th>
                <td>{{$policy->title}}</td>
                <td>{!!$policy->description!!}</td>
                <td><!-- Large Modal -->
                  <button type="button" class="badge btn btn-dark text-white" data-bs-toggle="modal" data-bs-target="#largeModal{{$policy->id}}">
                    Edit
                  </button>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          <!-- End Table with stripped rows -->

        </div>
      </div>

    </div>
  </div>
</section>

@foreach($policies as $policy)
<div class="modal fade" id="largeModal{{$policy->id}}" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Privacy & Policy</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="tab-content pt-2" id="profile-edit">

          <!-- Profile Edit Form -->
          
          <form action="{{route('policy.update', $policy->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row mb-3">
              <div class="col-md-8 col-lg-12">
                <label for="title" class="col-md-4 col-lg-3 col-form-label">Title</label>
                <textarea name="title" class="form-control" id="title">{{$policy->title}}</textarea>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-8 col-lg-12">
                <label for="description" class="col-md-4 col-lg-3 col-form-label">Description</label>
                <textarea name="description" class="form-control" id="description">{{$policy->description}}</textarea>
              </div>
            </div>
            
            <!-- Include CKEditor Script -->
            <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
            <script>
              // Initialize CKEditor
              CKEDITOR.replace('description', 'title', {
                height: 300 // You can adjust the height as needed
              });
            </script>
            
            <button class="button button-info" type="submit">Save</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div><!-- End Large Modal-->
@endforeach

@endsection