@extends('layouts.app')
@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card shadow-sm" style="border:none">
          <div class="card-header d-flex align-items-center">
            <div class="col-md-6 p-0">
              <strong>Edit Category</strong>
            </div>
          </div>

          <div class="card-body">
            <form enctype="multipart/form-data" action="{{ route('categories.update', [$category->id]) }}"
              method="POST">
              @csrf
              <input type="hidden" name="_method" value="PUT">
              <div class="form-group">
                <label for="title">Title</label>
                <input value="{{ old('title') ? old('title') : $category->title }}" type="text"
                  class="form-control {{ $errors->first('title') ? 'is-invalid' : '' }} " name="title"
                  placeholder="Category title">
                <div class="invalid-feedback">
                  {{ $errors->first('title') }}
                </div>
              </div>

              <div class="form-group">
                <label for="categories">Parent</label>
                <select name="categories" id="categories"
                  class="form-control{{ $errors->first('categories') ? 'is-invalid' : '' }}">
                  <option value={{ $category->parent_id }} {{ $category->parent_id ? 'selected' : '' }}>
                    {{ $category->parent ? $category->parent->title : $category->parent_id }}
                  </option>
                </select>
              </div>

              <button class="btn btn-primary" name="save_action" value="Save">Update</button>
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
