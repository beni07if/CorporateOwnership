@extends('admin.layout.appAdmin')
@section('brudcump')
<div class="pagetitle">
  <h1>Group</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
      <li class="breadcrumb-item active">Group</li>
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
          <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addGroupModal">
            Add Group
        </button>

          <!-- Table with stripped rows -->
          <table class="table datatable">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Group Name</th>
                <th scope="col">Country Registration</th>
                <th scope="col">Controller</th>
                <th scope="col">Detail</th>
              </tr>
            </thead>
            <tbody>
              @foreach($groups as $group)
              <tr>
                <th scope="row">{{$loop->iteration}}</th>
                <td>{{$group->group_name}}</td>
                <td>{!!$group->country_registration!!}</td>
                <td>{!!$group->controller!!}</td>
                <td><!-- Large Modal -->
                  <!-- Edit Modal Trigger -->
                <button type="button" class="badge btn btn-dark text-white" data-bs-toggle="modal" data-bs-target="#editModal{{$group->id}}">
                  Edit
              </button>

              <!-- Delete Form -->
              <form action="{{ route('groups.destroy', $group->id) }}" method="POST" style="display:inline;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="badge btn btn-danger text-white" onclick="return confirm('Are you sure you want to delete this group?');">
                      Delete
                  </button>
              </form>

              <!-- Edit group Modal -->
              <div class="modal fade" id="editModal{{$group->id}}" tabindex="-1" aria-labelledby="editModalLabel{{$group->id}}" aria-hidden="true">
                  <div class="modal-dialog">
                      <form action="{{ route('groups.update', $group->id) }}" method="POST">
                          @csrf
                          @method('PUT')
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="modal-title" id="editModalLabel{{$group->id}}">Edit Group</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                  <div class="mb-3">
                                      <label for="group_name{{$group->id}}" class="form-label">Group Name</label>
                                      <input type="text" class="form-control" id="group_name{{$group->id}}" name="group_name" value="{{$group->group_name}}" required>
                                  </div>
                                  <div class="mb-3">
                                      <label for="country_registration{{$group->id}}" class="form-label">Country Operation</label>
                                      <input type="text" class="form-control" id="country_registration{{$group->id}}" name="country_registration" value="{{$group->country_registration}}" required>
                                  </div>
                                  <div class="mb-3">
                                      <label for="controller{{$group->id}}" class="form-label">Controller</label>
                                      <textarea class="form-control" id="controller{{$group->id}}" name="controller" rows="3" required>{!! $group->controller !!}</textarea>
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

<!-- Add group Modal -->
<div class="modal fade" id="addGroupModal" tabindex="-1" aria-labelledby="addGroupModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <form action="{{ route('groups.store') }}" method="POST">
          @csrf
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="addgroupModalLabel">Add Group</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <div class="mb-3">
                      <label for="group_name" class="form-label">Group Name</label>
                      <input type="text" class="form-control" id="group_name" name="group_name" required>
                  </div>
                  <div class="mb-3">
                      <label for="country_registration" class="form-label">Country Registration</label>
                      <input type="text" class="form-control" id="country_registration" name="country_registration" required>
                  </div>
                  <div class="mb-3">
                      <label for="controller" class="form-label">Controller</label>
                      <textarea class="form-control" id="controller" name="controller" rows="3" required></textarea>
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