@extends('layouts.app')
@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card shadow-sm" style="border:none">
          <div class="card-header d-flex align-items-center">
            <div class="col-md-6 p-0">
              <strong>New Category</strong>
            </div>
          </div>

          <div class="card-body">
            <form action={{ route('categories.store') }} method="POST" enctype="multipart/form-data">@csrf

              <div class="form-group">
                <label for="title">Title</label>
                <input value="{{ old('title') }}" type="text"
                  class="form-control {{ $errors->first('title') ? 'is-invalid' : '' }} " name="title"
                  placeholder="Category title">
                <div class="invalid-feedback">
                  {{ $errors->first('title') }}
                </div>
              </div>

              <div class="form-group">
                <label for="categories">Parent</label>
                <select name="categories" id="categories"
                  class="form-control {{ $errors->first('categories') ? 'is-invalid' : '' }}"></select>
              </div>

              <button class="btn btn-primary" name="save_action" value="Save">Save</button>
            </form>
          </div>

        </div>
      </div>
    </div>
  </div>
@endsection

@section('footer-scripts')
  <link href="{{ asset('plugin/select2/select2.min.css') }}" rel="stylesheet">
  <script src="{{ asset('plugin/select2/select2.min.js') }}"></script>
  <script>
    const base_url = '{{ url('/') }}';

    $('#categories').select2({
      theme: "classic",
      placeholder: "Select Category",
      ajax: {
        url: base_url + '/ajax/categories/search',
        processResults: function(data) {
          return {
            results: data.map(function(item) {
              //   console.log(item)
              return {
                id: item.id,
                text: item.title
              }
            })
          }
        }
      }
    });

  </script>
@endsection
