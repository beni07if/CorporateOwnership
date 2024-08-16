@extends('admin.layout.appAdmin')

@section('brudcump')
<div class="pagetitle">
  <h1>Frequently Asked Questions</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item active">FAQ</li>
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
          <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addFaqModal">
            Add FAQ
          </button>

          <!-- Table with stripped rows -->
          <table class="table datatable">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Question</th>
                <th scope="col">Answer</th>
                <th scope="col">Details</th>
              </tr>
            </thead>
            <tbody>
              @foreach($faqs as $faq)
              <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $faq->question }}</td>
                <td>{!! $faq->answer !!}</td>
                <td>
                  <!-- Edit Modal Trigger -->
                  <button type="button" class="badge btn btn-dark text-white" data-bs-toggle="modal" data-bs-target="#editModal{{ $faq->id }}">
                    Edit
                  </button>

                  <!-- Delete Form -->
                  <form action="{{ route('faq.destroy', $faq->id) }}" method="POST" style="display:inline;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="badge btn btn-danger text-white" onclick="return confirm('Are you sure you want to delete this FAQ?');">
                          Delete
                      </button>
                  </form>

                  <!-- Edit FAQ Modal -->
                  <div class="modal fade" id="editModal{{ $faq->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $faq->id }}" aria-hidden="true">
                      <div class="modal-dialog">
                          <form action="{{ route('faq.update', $faq->id) }}" method="POST">
                              @csrf
                              @method('PUT')
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h5 class="modal-title" id="editModalLabel{{ $faq->id }}">Edit FAQ</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                      <div class="mb-3">
                                          <label for="category{{ $faq->id }}" class="form-label">Category</label>
                                          <input type="text" class="form-control" id="category{{ $faq->id }}" name="category" value="{{ $faq->category }}" required>
                                      </div>
                                      <div class="mb-3">
                                          <label for="question{{ $faq->id }}" class="form-label">Question</label>
                                          <input type="text" class="form-control" id="question{{ $faq->id }}" name="question" value="{{ $faq->question }}" required>
                                      </div>
                                      <div class="mb-3">
                                        <label for="answerEdit{{ $faq->id }}" class="form-label">Answer</label>
                                        <textarea class="form-control" id="answerEdit{{ $faq->id }}" name="answer" rows="3" required>{{ old('answer', $faq->answer) }}</textarea>
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

  <!-- Initialize CKEditor only when the modal is shown -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize CKEditor for the 'Add FAQ' modal
        var addFaqModal = document.getElementById('addFaqModal');
        addFaqModal.addEventListener('shown.bs.modal', function () {
            CKEDITOR.replace('answer');
        });

        // Initialize CKEditor for edit modals
        document.querySelectorAll('.modal').forEach(function(modal) {
            modal.addEventListener('shown.bs.modal', function() {
                var textarea = modal.querySelector('textarea');
                if (textarea) {
                    CKEDITOR.replace(textarea.id, { height: 300 });
                }
            });
            modal.addEventListener('hidden.bs.modal', function() {
                var textarea = modal.querySelector('textarea');
                if (textarea) {
                    CKEDITOR.instances[textarea.id]?.destroy();
                }
            });
        });
    });
  </script>

</section>

<!-- Add FAQ Modal -->
<div class="modal fade" id="addFaqModal" tabindex="-1" aria-labelledby="addFaqModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <form action="{{ route('faq.store') }}" method="POST">
          @csrf
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="addFaqModalLabel">Add FAQ</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <div class="mb-3">
                      <label for="category" class="form-label">Category</label>
                      <input type="text" class="form-control" id="category" name="category" required>
                  </div>
                  <div class="mb-3">
                      <label for="question" class="form-label">Question</label>
                      <input type="text" class="form-control" id="question" name="question" required>
                  </div>
                  <div class="mb-3">
                      <label for="answer" class="form-label">Answer</label>
                      <textarea class="form-control" id="answer" name="answer" rows="3" required></textarea>
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

<script src="https://cdn.ckeditor.com/4.22.0/standard/ckeditor.js"></script>
