@extends('admin.layout.appAdmin')
@section('brudcump')
<div class="pagetitle">
  <h1>Data Consolidation</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
      <li class="breadcrumb-item active">Data Consolidation</li>
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
          <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addConsolidationModal">
            Add Consolidation
          </button>

          <!-- Table with stripped rows -->
          <table class="table datatable">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Subsidiary</th>
                <th scope="col">Country</th>
                <th scope="col">Parent Group</th>
                <th scope="col">Details</th>
              </tr>
            </thead>
            <tbody>
              @foreach($consolidations as $consolidation)
              <tr>
                <th scope="row">{{$loop->iteration}}</th>
                <td>{{$consolidation->subsidiary}}</td>
                <td>{!!$consolidation->country_operation!!}</td>
                <td>{!!$consolidation->group_name!!}</td>
                <td><!-- Large Modal -->
                  <!-- Edit Modal Trigger -->
                <button type="button" class="badge btn btn-dark text-white" data-bs-toggle="modal" data-bs-target="#editModal{{$consolidation->id}}">
                  Edit
              </button>

              <!-- Delete Form -->
              <form action="{{ route('consolidations.destroy', $consolidation->id) }}" method="POST" style="display:inline;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="badge btn btn-danger text-white" onclick="return confirm('Are you sure you want to delete this consolidation?');">
                      Delete
                  </button>
              </form>

              <!-- Edit consolidation Modal -->
              <div class="modal fade" id="editModal{{$consolidation->id}}" tabindex="-1" aria-labelledby="editModalLabel{{$consolidation->id}}" aria-hidden="true">
                  <div class="modal-dialog">
                      <form action="{{ route('consolidations.update', $consolidation->id) }}" method="POST">
                          @csrf
                          @method('PUT')
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="modal-title" id="editModalLabel{{$consolidation->id}}">Edit Data Consolidation</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                  <div class="mb-3">
                                      <label for="subsidiary{{$consolidation->id}}" class="form-label">Subsidiary</label>
                                      <input type="text" class="form-control" id="subsidiary{{$consolidation->id}}" name="subsidiary" value="{{$consolidation->subsidiary}}" required>
                                  </div>
                                  <div class="mb-3">
                                      <label for="country_operation{{$consolidation->id}}" class="form-label">Country Operation</label>
                                      <input type="text" class="form-control" id="country_operation{{$consolidation->id}}" name="country_operation" value="{{$consolidation->country_operation}}" required>
                                  </div>
                                  <div class="mb-3">
                                      <label for="group_name{{$consolidation->id}}" class="form-label">Parent Group</label>
                                      <input type="text" class="form-control" id="group_name{{$consolidation->id}}" name="group_name" value="{{$consolidation->group_name}}" required>
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

<!-- Add consolidation Modal -->
<div class="modal fade" id="addConsolidationModal" tabindex="-1" aria-labelledby="addConsolidationModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <form action="{{ route('consolidations.store') }}" method="POST">
          @csrf
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="addConsolidationModalLabel">Add Data Consolidation</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <div class="mb-3">
                      <label for="subsidiary" class="form-label">Subsidiary</label>
                      <input type="text" class="form-control" id="subsidiary" name="subsidiary" required>
                  </div>
                  <div class="mb-3">
                      <label for="country_operation" class="form-label">Country Operation</label>
                      <input type="text" class="form-control" id="country_operation" name="country_operation" required>
                  </div>
                  <div class="mb-3">
                      <label for="group_name" class="form-label">Parent Group</label>
                      <textarea class="form-control" id="group_name" name="group_name" rows="3" required></textarea>
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