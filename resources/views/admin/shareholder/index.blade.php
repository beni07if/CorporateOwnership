@extends('admin.layout.appAdmin')
@section('brudcump')
<div class="pagetitle">
  <h1>Shareholder</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
      <li class="breadcrumb-item active">Shareholder</li>
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
          <h5 class="card-title"></h5>
          <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addShareholderModal">
            Add Shareholder
          </button>

          <!-- Table with stripped rows -->
          <table class="table datatable">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Shareholder Name</th>
                <th scope="col">Date of Birth</th>
                <th scope="col">Company Shareholding</th>
                <th scope="col">Details</th>
              </tr>
            </thead>
            <tbody>
              @foreach($shareholders as $shareholder)
              <tr>
                <th scope="row">{{$loop->iteration}}</th>
                <td>{{$shareholder->shareholder_name}}</td>
                <td>{!!$shareholder->date_of_birth!!}</td>
                <td>{!!$shareholder->company_name!!}</td>
                <td><!-- Large Modal -->
                  <!-- Edit Modal Trigger -->
                <button type="button" class="badge btn btn-dark text-white" data-bs-toggle="modal" data-bs-target="#editModal{{$shareholder->id}}">
                  Edit
              </button>

              <!-- Delete Form -->
              <form action="{{ route('shareholders.destroy', $shareholder->id) }}" method="POST" style="display:inline;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="badge btn btn-danger text-white" onclick="return confirm('Are you sure you want to delete this shareholder?');">
                      Delete
                  </button>
              </form>

              <!-- Edit shareholder Modal -->
              <div class="modal fade" id="editModal{{$shareholder->id}}" tabindex="-1" aria-labelledby="editModalLabel{{$shareholder->id}}" aria-hidden="true">
                  <div class="modal-dialog">
                      <form action="{{ route('shareholders.update', $shareholder->id) }}" method="POST">
                          @csrf
                          @method('PUT')
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="modal-title" id="editModalLabel{{$shareholder->id}}">Edit Data shareholder</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                  <div class="mb-3">
                                      <label for="shareholder_name{{$shareholder->id}}" class="form-label">Shareholder Name</label>
                                      <input type="text" class="form-control" id="shareholder_name{{$shareholder->id}}" name="shareholder_name" value="{{$shareholder->shareholder_name}}" required>
                                  </div>
                                  <div class="mb-3">
                                      <label for="date_of_birth{{$shareholder->id}}" class="form-label">Date of Birth</label>
                                      <input type="text" class="form-control" id="date_of_birth{{$shareholder->id}}" name="date_of_birth" value="{{$shareholder->date_of_birth}}" required>
                                  </div>
                                  <div class="mb-3">
                                      <label for="company_name{{$shareholder->id}}" class="form-label">Shareholding Company</label>
                                      <input type="text" class="form-control" id="company_name{{$shareholder->id}}" name="company_name" value="{{$shareholder->company_name}}" required>
                                  </div>
                              </div>
                              <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                  <button type="submit" class="btn btn-primary">Save changes</button>
                              </div>
                          </div>
                      </form>
                  </div>
              </div>
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

<!-- Add shareholder Modal -->
<div class="modal fade" id="addShareholderModal" tabindex="-1" aria-labelledby="addShareholderModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <form action="{{ route('shareholders.store') }}" method="POST">
          @csrf
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="addshareholderModalLabel">Add Data shareholder</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <div class="mb-3">
                      <label for="shareholder_name" class="form-label">Shareholder Name</label>
                      <input type="text" class="form-control" id="shareholder_name" name="shareholder_name" required>
                  </div>
                  <div class="mb-3">
                      <label for="date_of_birth" class="form-label">Date of Birth</label>
                      <input type="text" class="form-control" id="date_of_birth" name="date_of_birth" required>
                  </div>
                  <div class="mb-3">
                      <label for="company_name" class="form-label">Company Name</label>
                      <textarea class="form-control" id="company_name" name="company_name" rows="3" required></textarea>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Save</button>
              </div>
          </div>
      </form>
  </div>
</div>

@endsection