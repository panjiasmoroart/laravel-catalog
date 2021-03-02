@extends('layouts.app')
@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card shadow-sm" style="border:none">
          <div class="card-header d-flex align-items-center">
            <div class="col-md-6 p-0">
              <strong>New Product</strong>
            </div>
          </div>

          <div class="card-body">
            <form action={{ route('products.store') }} method="POST" enctype="multipart/form-data">@csrf

              <div class="form-group">
                <label for="name">Name</label>
                <input value="{{ old('name') }}" type="text"
                  class="form-control {{ $errors->first('name') ? 'is-invalid' : '' }} " name="name"
                  placeholder="Product name">
                <div class="invalid-feedback">
                  {{ $errors->first('name') }}
                </div>
              </div>

              <div class="form-group">
                <label for="model">Model</label>
                <input value="{{ old('model') }}" type="text"
                  class="form-control {{ $errors->first('model') ? 'is-invalid' : '' }} " name="model"
                  placeholder="Product model">
                <div class="invalid-feedback">
                  {{ $errors->first('model') }}
                </div>
              </div>

              <div class="form-group">
                <label for="price">Price</label>
                <input value="{{ old('price') }}" type="number"
                  class="form-control {{ $errors->first('price') ? 'is-invalid' : '' }} " name="price"
                  placeholder="Price">
                <div class="invalid-feedback">
                  {{ $errors->first('price') }}
                </div>
              </div>

              <div class="form-group">
                <label for="weight">Weight</label>
                <input value="{{ old('weight') }}" type="number"
                  class="form-control {{ $errors->first('weight') ? 'is-invalid' : '' }} " name="weight"
                  placeholder="weight">
                <div class="invalid-feedback">
                  {{ $errors->first('weight') }}
                </div>
              </div>

              <div class="form-group">
                <label for="categories">Categories</label>
                <select name="categories[]" multiple id="categories"
                  class="form-control {{ $errors->first('categories') ? 'is-invalid' : '' }}"></select>
                <div class="invalid-feedback">
                  {{ $errors->first('categories') }}
                </div>
              </div>

              <div class="form-group">
                <label for="photo">Product photo (jpeg, png)</label>
                <input name="photo" type="file" class="form-control {{ $errors->first('photo') ? 'is-invalid' : '' }}">
                <div class="invalid-feedback">
                  {{ $errors->first('photo') }}
                </div>
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
  {{-- <link href="{{ asset('plugin/select2/customselect2.css') }}" rel="stylesheet"> --}}
  <script src="{{ asset('plugin/select2/select2.min.js') }}"></script>
  <script>
    const base_url = '{{ url('/') }}';

    $('#categories').select2({
      //   theme: "classic",
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
