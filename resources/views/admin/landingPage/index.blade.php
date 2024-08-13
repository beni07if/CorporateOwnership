@extends('admin.layout.appAdmin')
@section('brudcump')
<div class="pagetitle">
  <h1>Landing Pages</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
      <li class="breadcrumb-item active">Landing Pages</li>
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
          <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addLandingPageModal">
            Add Landing Page
        </button>

          <!-- Table with stripped rows -->
          <table class="table datatable">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Tagline</th>
                <th scope="col">Data 1</th>
                <th scope="col">Data 2</th>
                <th scope="col">Data 3</th>
                <th scope="col">Details</th>
              </tr>
            </thead>
            <tbody>
              @foreach($landingPages as $landingPage)
              <tr>
                <th scope="row">{{$loop->iteration}}</th>
                <td>{{$landingPage->tagline}}</td>
                <td>{!!$landingPage->title_of_data1!!}</td>
                <td>{!!$landingPage->title_of_data2!!}</td>
                <td>{!!$landingPage->title_of_data3!!}</td>
                <td><!-- Large Modal -->
                  <!-- Edit Modal Trigger -->
                <button type="button" class="badge btn btn-dark text-white" data-bs-toggle="modal" data-bs-target="#editModal{{$landingPage->id}}">
                  Edit
              </button>

              <!-- Delete Form -->
              <form action="{{ route('landing-page.destroy', $landingPage->id) }}" method="POST" style="display:inline;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="badge btn btn-danger text-white" onclick="return confirm('Are you sure you want to delete this FAQ?');">
                      Delete
                  </button>
              </form>

              <!-- Edit Landing Page Modal -->
              <div class="modal fade" id="editModal{{$landingPage->id}}" tabindex="-1" aria-labelledby="editModalLabel{{$landingPage->id}}" aria-hidden="true">
                  <div class="modal-dialog modal-xl">
                      
                      <form action="{{ route('landing-page.update', $landingPage->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{$landingPage->id}}">Edit Landing Page</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="tagline" class="form-label">Tagline</label>
                                    <input type="text" class="form-control" id="tagline" name="tagline" value="{{ $landingPage->tagline }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="title_short_definition" class="form-label">Title Short Definition</label>
                                    <input type="text" class="form-control" id="title_short_definition" name="title_short_definition" value="{{ $landingPage->title_short_definition }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="short_definition" class="form-label">Short Definition</label>
                                    <textarea class="form-control" id="short_definition" name="short_definition" rows="3" required>{{ $landingPage->short_definition }}</textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="title_of_data1" class="form-label">Title of Data 1</label>
                                    <input type="text" class="form-control" id="title_of_data1" name="title_of_data1" value="{{ $landingPage->title_of_data1 }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="number_of_data1" class="form-label">Number of Data 1</label>
                                    <input type="text" class="form-control" id="number_of_data1" name="number_of_data1" value="{{ $landingPage->number_of_data1 }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="tag_of_data1" class="form-label">Tag of Data 1</label>
                                    <input type="text" class="form-control" id="tag_of_data1" name="tag_of_data1" value="{{ $landingPage->tag_of_data1 }}" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="title_of_data2" class="form-label">Title of Data 2</label>
                                    <input type="text" class="form-control" id="title_of_data2" name="title_of_data2" value="{{ $landingPage->title_of_data2 }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="number_of_data2" class="form-label">Number of Data 2</label>
                                    <input type="text" class="form-control" id="number_of_data2" name="number_of_data2" value="{{ $landingPage->number_of_data2 }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="tag_of_data2" class="form-label">Tag of Data 2</label>
                                    <input type="text" class="form-control" id="tag_of_data2" name="tag_of_data2" value="{{ $landingPage->tag_of_data2 }}" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="title_of_data3" class="form-label">Title of Data 3</label>
                                    <input type="text" class="form-control" id="title_of_data3" name="title_of_data3" value="{{ $landingPage->title_of_data3 }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="number_of_data3" class="form-label">Number of Data 3</label>
                                    <input type="text" class="form-control" id="number_of_data3" name="number_of_data3" value="{{ $landingPage->number_of_data3 }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="tag_of_data3" class="form-label">Tag of Data 3</label>
                                    <input type="text" class="form-control" id="tag_of_data3" name="tag_of_data3" value="{{ $landingPage->tag_of_data3 }}" required>
                                </div>
                        
                                <div class="mb-3">
                                    <label for="title_corporate_profile" class="form-label">Title Corporate Profile</label>
                                    <input type="text" class="form-control" id="title_corporate_profile" name="title_corporate_profile" value="{{ $landingPage->title_corporate_profile }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="definition_corporate_profile" class="form-label">Definition Corporate Profile</label>
                                    <textarea class="form-control" id="definition_corporate_profile" name="definition_corporate_profile" rows="3" required>{{ $landingPage->definition_corporate_profile }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="image_corporate_profile" class="form-label">Image Corporate Profile</label>
                                    <input type="file" class="form-control" id="image_corporate_profile" name="image_corporate_profile" accept="image/*">
                                    <small>Current Image: {{ $landingPage->image_corporate_profile }}</small>
                                </div>
                        
                                <div class="mb-3">
                                    <label for="key_feature_title1" class="form-label">Key Feature Title 1</label>
                                    <input type="text" class="form-control" id="key_feature_title1" name="key_feature_title1" value="{{ $landingPage->key_feature_title1 }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="key_feature_desc1" class="form-label">Key Feature Description 1</label>
                                    <textarea class="form-control" id="key_feature_desc1" name="key_feature_desc1" rows="3" required>{{ $landingPage->key_feature_desc1 }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="key_feature_image1" class="form-label">Key Feature Image 1</label>
                                    <input type="file" class="form-control" id="key_feature_image1" name="key_feature_image1" accept="image/*">
                                    <small>Current Image: {{ $landingPage->key_feature_image1 }}</small>
                                </div>
                                <div class="mb-3">
                                    <label for="key_feature_title2" class="form-label">Key Feature Title 2</label>
                                    <input type="text" class="form-control" id="key_feature_title2" name="key_feature_title2" value="{{ $landingPage->key_feature_title2 }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="key_feature_desc2" class="form-label">Key Feature Description 2</label>
                                    <textarea class="form-control" id="key_feature_desc2" name="key_feature_desc2" rows="3" required>{{ $landingPage->key_feature_desc2 }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="key_feature_image2" class="form-label">Key Feature Image 2</label>
                                    <input type="file" class="form-control" id="key_feature_image2" name="key_feature_image2" accept="image/*">
                                    <small>Current Image: {{ $landingPage->key_feature_image2 }}</small>
                                </div>
                                <div class="mb-3">
                                    <label for="key_feature_title3" class="form-label">Key Feature Title 3</label>
                                    <input type="text" class="form-control" id="key_feature_title3" name="key_feature_title3" value="{{ $landingPage->key_feature_title3 }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="key_feature_desc3" class="form-label">Key Feature Description 3</label>
                                    <textarea class="form-control" id="key_feature_desc3" name="key_feature_desc3" rows="3" required>{{ $landingPage->key_feature_desc3 }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="key_feature_image3" class="form-label">Key Feature Image 3</label>
                                    <input type="file" class="form-control" id="key_feature_image3" name="key_feature_image3" accept="image/*">
                                    <small>Current Image: {{ $landingPage->key_feature_image3 }}</small>
                                </div>
                                <div class="mb-3">
                                    <label for="key_feature_title4" class="form-label">Key Feature Title 4</label>
                                    <input type="text" class="form-control" id="key_feature_title4" name="key_feature_title4" value="{{ $landingPage->key_feature_title4 }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="key_feature_desc4" class="form-label">Key Feature Description 4</label>
                                    <textarea class="form-control" id="key_feature_desc4" name="key_feature_desc4" rows="3" required>{{ $landingPage->key_feature_desc4 }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="key_feature_image4" class="form-label">Key Feature Image 4</label>
                                    <input type="file" class="form-control" id="key_feature_image4" name="key_feature_image4" accept="image/*">
                                    <small>Current Image: {{ $landingPage->key_feature_image4 }}</small>
                                </div>
                        
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('landing-page.index') }}" class="btn btn-secondary">Cancel</a>
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

<!-- Add FAQ Modal -->
<div class="modal fade" id="addLandingPageModal" tabindex="-1" aria-labelledby="addLandingPageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <form action="{{ route('landing-page.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLandingPageModalLabel">Add Landing Page</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="tagline" class="form-label">Tagline</label>
                    <input type="text" class="form-control" id="tagline" name="tagline" required>
                </div>
                <div class="mb-3">
                    <label for="title_short_definition" class="form-label">Title Short Definition</label>
                    <input type="text" class="form-control" id="title_short_definition" name="title_short_definition" required>
                </div>
                <div class="mb-3">
                    <label for="short_definition" class="form-label">Short Definition</label>
                    <textarea class="form-control" id="short_definition" name="short_definition" rows="3" required></textarea>
                </div>
    
                <div class="mb-3">
                    <label for="title_of_data1" class="form-label">Title of Data 1</label>
                    <input type="text" class="form-control" id="title_of_data1" name="title_of_data1" required>
                </div>
                <div class="mb-3">
                    <label for="number_of_data1" class="form-label">Number of Data 1</label>
                    <input type="text" class="form-control" id="number_of_data1" name="number_of_data1" required>
                </div>
                <div class="mb-3">
                    <label for="tag_of_data1" class="form-label">Tag of Data 1</label>
                    <input type="text" class="form-control" id="tag_of_data1" name="tag_of_data1" required>
                </div>
                <div class="mb-3">
                    <label for="title_of_data2" class="form-label">Title of Data 2</label>
                    <input type="text" class="form-control" id="title_of_data2" name="title_of_data2" required>
                </div>
                <div class="mb-3">
                    <label for="number_of_data2" class="form-label">Number of Data 2</label>
                    <input type="text" class="form-control" id="number_of_data2" name="number_of_data2" required>
                </div>
                <div class="mb-3">
                    <label for="tag_of_data2" class="form-label">Tag of Data 2</label>
                    <input type="text" class="form-control" id="tag_of_data2" name="tag_of_data2" required>
                </div>
                <div class="mb-3">
                    <label for="title_of_data3" class="form-label">Title of Data 3</label>
                    <input type="text" class="form-control" id="title_of_data3" name="title_of_data3" required>
                </div>
                <div class="mb-3">
                    <label for="number_of_data3" class="form-label">Number of Data 3</label>
                    <input type="text" class="form-control" id="number_of_data3" name="number_of_data3" required>
                </div>
                <div class="mb-3">
                    <label for="tag_of_data3" class="form-label">Tag of Data 3</label>
                    <input type="text" class="form-control" id="tag_of_data3" name="tag_of_data3" required>
                </div>
    
                <div class="mb-3">
                    <label for="title_corporate_profile" class="form-label">Title Corporate Profile</label>
                    <input type="text" class="form-control" id="title_corporate_profile" name="title_corporate_profile" required>
                </div>
                <div class="mb-3">
                    <label for="definition_corporate_profile" class="form-label">Definition Corporate Profile</label>
                    <textarea class="form-control" id="definition_corporate_profile" name="definition_corporate_profile" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="image_corporate_profile" class="form-label">Image Corporate Profile</label>
                    <input type="file" class="form-control" id="image_corporate_profile" name="image_corporate_profile" accept="image/*" required>
                </div>
    
                <div class="mb-3">
                    <label for="key_feature_title1" class="form-label">Key Feature Title 1</label>
                    <input type="text" class="form-control" id="key_feature_title1" name="key_feature_title1" required>
                </div>
                <div class="mb-3">
                    <label for="key_feature_desc1" class="form-label">Key Feature Description 1</label>
                    <textarea class="form-control" id="key_feature_desc1" name="key_feature_desc1" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="key_feature_image1" class="form-label">Key Feature Image 1</label>
                    <input type="file" class="form-control" id="key_feature_image1" name="key_feature_image1" accept="image/*" required>
                </div>
                <div class="mb-3">
                    <label for="key_feature_title2" class="form-label">Key Feature Title 2</label>
                    <input type="text" class="form-control" id="key_feature_title2" name="key_feature_title2" required>
                </div>
                <div class="mb-3">
                    <label for="key_feature_desc2" class="form-label">Key Feature Description 2</label>
                    <textarea class="form-control" id="key_feature_desc2" name="key_feature_desc2" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="key_feature_image2" class="form-label">Key Feature Image 2</label>
                    <input type="file" class="form-control" id="key_feature_image2" name="key_feature_image2" accept="image/*" required>
                </div>
                <div class="mb-3">
                    <label for="key_feature_title3" class="form-label">Key Feature Title 3</label>
                    <input type="text" class="form-control" id="key_feature_title3" name="key_feature_title3" required>
                </div>
                <div class="mb-3">
                    <label for="key_feature_desc3" class="form-label">Key Feature Description 3</label>
                    <textarea class="form-control" id="key_feature_desc3" name="key_feature_desc3" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="key_feature_image3" class="form-label">Key Feature Image 3</label>
                    <input type="file" class="form-control" id="key_feature_image3" name="key_feature_image3" accept="image/*" required>
                </div>
                <div class="mb-3">
                    <label for="key_feature_title4" class="form-label">Key Feature Title 4</label>
                    <input type="text" class="form-control" id="key_feature_title4" name="key_feature_title4" required>
                </div>
                <div class="mb-3">
                    <label for="key_feature_desc4" class="form-label">Key Feature Description 4</label>
                    <textarea class="form-control" id="key_feature_desc4" name="key_feature_desc4" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="key_feature_image4" class="form-label">Key Feature Image 4</label>
                    <input type="file" class="form-control" id="key_feature_image4" name="key_feature_image4" accept="image/*" required>
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