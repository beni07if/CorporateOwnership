@extends('admin.layout.appAdmin')
@section('brudcump')
<div class="pagetitle">
  <h1>Dashboard</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
      <li class="breadcrumb-item active">Inbox</li>
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
          <h5 class="card-title">Inbox</h5>
          <!-- <p>Inbox</p> -->

          <!-- Table with stripped rows -->
          <table class="table datatable">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Institution</th>
                <th scope="col">Email</th>
                <th scope="col">Message</th>
                <th scope="col">Response Status</th>
                <th scope="col">Details</th>
              </tr>
            </thead>
            <tbody>
              @foreach($messages as $message)
              <tr>
                <th scope="row">{{$loop->iteration}}</th>
                <td>{{$message->name}}</td>
                <td>{{$message->institution}}</td>
                <td>{{$message->email}}</td>
                <td>{{$message->message}} <span class="text-muted d-block">{{$message->date_message}}</span></td>
                <td>
                    @if($message->status == 'Open')
                        <span class="badge bg-danger text-white"><i class="bi bi-x-circle me-1"></i>{{ $message->status }}</span>
                    @elseif($message->status == 'In Progress/Assigned')
                        <span class="badge bg-warning text-white"><i class="bi bi-info-circle me-1"></i>{{ $message->status }}</span>
                    @elseif($message->status == 'Pending')
                        <span class="badge bg-warning text-white"><i class="bi bi-info-circle me-1"></i>{{ $message->status }}</span>
                    @elseif($message->status == 'Resolved')
                        <span class="badge bg-success text-white"><i class="bi bi-check-circle me-1"></i>{{ $message->status }}</span>
                    @else
                        <span class="badge bg-warning text-white"><i class="bi bi-question-circle me-1"></i>{{ $message->status }}</span>
                    @endif
                </td>
                <td><!-- Large Modal -->
                  <button type="button" class="badge btn btn-dark text-white" data-bs-toggle="modal" data-bs-target="#largeModal{{$message->id}}">
                    Details
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

@foreach($messages as $message)
<div class="modal fade" id="largeModal{{$message->id}}" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Message Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="tab-content pt-2" id="profile-edit">

          <!-- Profile Edit Form -->
          
          <form action="{{route('messages.update', $message->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row mb-3">
              <label for="name" class="col-md-4 col-lg-3 col-form-label">Name</label>
              <div class="col-md-8 col-lg-9">
                <input name="name" type="text" class="form-control" id="name" value="{{$message->name}}">
              </div>
            </div>

            <div class="row mb-3">
              <label for="phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
              <div class="col-md-8 col-lg-9">
                <input name="phone" type="text" class="form-control" id="phone" value="{{$message->phone}}">
              </div>
            </div>

            <div class="row mb-3">
              <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
              <div class="col-md-8 col-lg-9">
                <input name="email" type="email" class="form-control" id="email" value="{{$message->email}}">
              </div>
            </div>

            <div class="row mb-3">
              <label for="institution" class="col-md-4 col-lg-3 col-form-label">Institution</label>
              <div class="col-md-8 col-lg-9">
                <input name="institution" type="text" class="form-control" id="institution" value="{{$message->institution}}">
              </div>
            </div>

            <div class="row mb-3">
              <label for="message" class="col-md-4 col-lg-3 col-form-label">Message</label>
              <div class="col-md-8 col-lg-9">
                <textarea name="message" class="form-control" id="message">{{$message->message}}</textarea>
              </div>
            </div>

            <div class="row mb-3">
              <label for="date_message" class="col-md-4 col-lg-3 col-form-label">Message Date</label>
              <div class="col-md-8 col-lg-9">
                <input name="date_message" type="date" class="form-control" id="date_message" value="{{$message->date_message}}">
              </div>
            </div>

            <div class="row mb-3">
              <label for="response" class="col-md-4 col-lg-3 col-form-label">Response</label>
              <div class="col-md-8 col-lg-9">
                <textarea name="response" class="form-control" id="response">{{$message->response}}</textarea>
              </div>
            </div>

            <div class="row mb-3">
              <label for="date_response" class="col-md-4 col-lg-3 col-form-label">Response Date</label>
              <div class="col-md-8 col-lg-9">
                <input name="date_response" type="date" class="form-control" id="date_response" value="{{$message->date_response}}">
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-md-4 col-lg-3 col-form-label">Status</label>
              <div class="col-md-8 col-lg-9">
                <select name="status" class="form-select" aria-label="Default select example">
                  <option value="{{$message->status}}" selected>{{$message->status}}</option>
                  <option value="Open">Open</option>
                  <option value="Pending">Pending</option>
                  <option value="In Progess/Assigned">In Progess/Assigned</option>
                  <option value="Resolved">Resolved</option>
                </select>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
          </form><!-- End Profile Edit Form -->

        </div>
      </div>
    </div>
  </div>
</div><!-- End Large Modal-->
@endforeach
@endsection