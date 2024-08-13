@extends('admin.layout.appAdmin')
@section('brudcump')
<div class="pagetitle">
  <h1>Sustainability Risk Assessment</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
      <li class="breadcrumb-item active">SRA</li>
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
          <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addSraModal">
            Add SRA
        </button>

          <!-- Table with stripped rows -->
          <table class="table datatable">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Group Name</th>
                <th scope="col">% Tranparency</th>
                <th scope="col">% RSPO Compliance</th>
                <th scope="col">% NDPE Compliance</th>
                <th scope="col">% Total</th>
                <th scope="col">Detail</th>
              </tr>
            </thead>
            <tbody>
              @foreach($sras as $sra)
              <tr>
                <th scope="row">{{$loop->iteration}}</th>
                <td>{{$sra->group_name}}</td>
                <td>{{$sra->percent_transparency}}</td>
                <td>{{$sra->percent_rspo_compliance}}</td>
                <td>{{$sra->percent_ndpe_compliance}}</td>
                <td>{{$sra->percent_total}}</td>
                <td><!-- Large Modal -->
                  <!-- Edit Modal Trigger -->
                <button type="button" class="badge btn btn-dark text-white" data-bs-toggle="modal" data-bs-target="#editModal{{$sra->id}}">
                  Edit
                </button>

              <!-- Delete Form -->
              <form action="{{ route('sras.destroy', $sra->id) }}" method="POST" style="display:inline;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="badge btn btn-danger text-white" onclick="return confirm('Are you sure you want to delete this sra?');">
                      Delete
                  </button>
              </form>

              <!-- Edit sra Modal -->
              <div class="modal fade" id="editModal{{$sra->id}}" tabindex="-1" aria-labelledby="editModalLabel{{$sra->id}}" aria-hidden="true">
                  <div class="modal-dialog">
                      <form action="{{ route('sras.update', $sra->id) }}" method="POST">
                          @csrf
                          @method('PUT')
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="modal-title" id="editModalLabel{{$sra->id}}">Edit SRA</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                  <div class="mb-3">
                                      <label for="group_name{{$sra->id}}" class="form-label">Group Name</label>
                                      <input type="text" class="form-control" id="group_name{{$sra->id}}" name="group_name" value="{{$sra->group_name}}" required>
                                  </div>
                                  <div class="mb-3">
                                      <label for="percent_transparency{{$sra->id}}" class="form-label">Percent Transparency</label>
                                      <input type="text" class="form-control" id="percent_transparency{{$sra->id}}" name="percent_transparency" value="{{$sra->percent_transparency}}" required>
                                  </div>
                                  <div class="mb-3">
                                      <label for="percent_rspo_compliance{{$sra->id}}" class="form-label">Percent RSPO Compliance</label>
                                      <input class="form-control" id="percent_rspo_compliance{{$sra->id}}" name="percent_rspo_compliance" rows="3" value="{!! $sra->percent_rspo_compliance !!}" required>
                                  </div>
                                  <div class="mb-3">
                                      <label for="percent_ndpe_compliance{{$sra->id}}" class="form-label">Percent NDPE Compliance</label>
                                      <input class="form-control" id="percent_ndpe_compliance{{$sra->id}}" name="percent_ndpe_compliance" rows="3" value="{!! $sra->percent_ndpe_compliance !!}" required>
                                  </div>
                                  <div class="mb-3">
                                      <label for="percent_total{{$sra->id}}" class="form-label">Percent Total</label>
                                      <input class="form-control" id="percent_total{{$sra->id}}" name="percent_total" rows="3" value="{!! $sra->percent_total !!}" required>
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

<!-- Add sra Modal -->
<div class="modal fade" id="addSraModal" tabindex="-1" aria-labelledby="addSraModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <form action="{{ route('sras.store') }}" method="POST">
          @csrf
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="addSraModalLabel">Add SRA</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <div class="mb-3">
                      <label for="group_name" class="form-label">Group Name</label>
                      <input type="text" class="form-control" id="group_name" name="group_name" required>
                  </div>
                  <div class="mb-3">
                      <label for="percent_transparency" class="form-label">Percent Transparency</label>
                      <input type="text" class="form-control" id="percent_transparency" name="percent_transparency" required>
                  </div>
                  <div class="mb-3">
                      <label for="percent_rspo_compliance" class="form-label">Percent RSPO Compliance</label>
                      <input class="form-control" id="percent_rspo_compliance" name="percent_rspo_compliance" rows="3" required>
                  </div>
                  <div class="mb-3">
                      <label for="percent_ndpe_compliance" class="form-label">Percent NDPE Compliance</label>
                      <input class="form-control" id="percent_ndpe_compliance" name="percent_ndpe_compliance" rows="3" required>
                  </div>
                  <div class="mb-3">
                      <label for="percent_total" class="form-label">Percent Total</label>
                      <input class="form-control" id="percent_total" name="percent_total" rows="3" required>
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