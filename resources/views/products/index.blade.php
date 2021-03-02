@extends('layouts.app')

@section('title') Category List @endsection

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">

        @if (session('status'))
          <div class="alert alert-success">
            {{ session('status') }}
          </div>
        @endif

        <div class="card shadow-sm" style="border:none">
          <div class="card-header d-flex align-items-center">
            <div class="col-md-8 p-0">
              <strong>Produduct</strong>
            </div>
            <div class=" col-md-4 p-0">
              <form action={{ route('products.index') }}>
                <div class="input-group">
                  <input type="text" class="form-control" value="" placeholder="Search..." name="name">

                  <div class="input-group-append">
                    <input type="submit" value="Filter" class="btn btn-primary">
                  </div>
                </div>
              </form>
            </div>
          </div>

          <div class="card-body">
            <div class="mb-3">
              <a href={{ route('products.create') }}>
                <button type="button" class="btn btn-primary text-white">New Product</button>
              </a>
            </div>

            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Model</th>
                  <th>Price</th>
                  <th>Image</th>
                  <th>Category</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($products as $product)
                  <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->model }}</td>
                    <td>{{ $product->price }}</td>
                    <td>
                      @if ($product->photo)
                        <img src="{{ asset('img/' . $product->photo) }}" alt="Belum Tersedia" width="96px">
                      @else
                        <p>Belum ada gambar</p>
                      @endif
                    </td>
                    <td>
                      @foreach ($product->categories as $category)
                        <span class="badge badge-success">
                          <i class="fa fa-btn fa-tags"></i>
                          {{ $category->title }}
                        </span>
                      @endforeach
                    </td>
                    <td class="text-center">
                      <a class="btn btn-info text-white" href={{ route('products.edit', [$product->id]) }}>Edit</a>
                      <button class="btn btn-danger" onclick='deleteData({{ $product->id }})'> Delete</button>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
            {{-- Pagination --}}
            <div class="d-flex justify-content: flex-start">
              {!! $products->appends(request()->query())->links('pagination::bootstrap-4') !!}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('footer-scripts')
  <link href="{{ asset('plugin/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
  <script src="{{ asset('plugin/sweetalert2/sweetalert2.min.js') }}"></script>
  <script type="text/javascript">
    function deleteData(id) {
      let csrf_token = '{{ csrf_token() }}';
      // swal('Good job!', 'You clicked the button!', 'success')
      swal({
        title: 'Are you sure?',
        text: "Move data to trash",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then(function() {
        $.ajax({
          url: "{{ url('products') }}" + '/' + id,
          type: "POST",
          data: {
            '_method': 'DELETE',
            '_token': csrf_token
          },
          success: function(data) {
            // console.log(data);
            swal({
              title: 'Success!',
              // text: data.message,
              text: 'Data has been deleted to trash',
              type: 'success',
              timer: '1500'
            })
            location.reload();
          },
          error: function() {
            //alert('Oops Something Wrong!');
            swal({
              title: 'Oops...',
              // text: data.message,
              text: 'Something went wrong',
              type: 'error',
              timer: '1500'
            })
          }
        }); // end ajax
      }); // end then function swal
    }

  </script>
@endsection
