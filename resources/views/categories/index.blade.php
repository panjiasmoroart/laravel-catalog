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
              <strong>Category</strong>
            </div>
            <div class=" col-md-4 p-0">
              <form action={{ route('categories.index') }}>
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
              <a href={{ route('categories.create') }}>
                <button type="button" class="btn btn-primary text-white">New Category</button>
              </a>
            </div>

            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>Title</th>
                  <th>Parent</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($categories as $category)
                  <tr>
                    <td>{{ $category->title }}</td>
                    <td>{{ $category->parent ? $category->parent->title : '' }}</td>
                    <td class="text-center">
                      <a href={{ route('categories.edit', [$category->id]) }} class="btn btn-info text-white">
                        Edit
                      </a>

                      {{-- <form onsubmit="return confirm('Delete this user permanently?')" class="d-inline"
                        action="{{ route('categories.destroy', [$category->id]) }}" method="POST">@csrf
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="submit" value="Delete" class="btn btn-danger">
                      </form> --}}

                      {{-- <button class="btn btn-danger btn-flat remove-user" data-id="{{ $category->id }}"
                        data-action="{{ route('categories.destroy', [$category->id]) }}"> Delete</button> --}}

                      <button class="btn btn-danger" onclick='deleteData({{ $category->id }})'> Delete</button>

                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
            {{-- Pagination --}}
            <div class="d-flex justify-content: flex-start">
              {!! $categories->appends(request()->query())->links('pagination::bootstrap-4') !!}
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
    // $("body").on("click", ".remove-user", function() {
    //   let current_object = $(this);
    //   swal({
    //     title: "Are you sure?",
    //     text: "You will not be able to recover this imaginary file!",
    //     type: "error",
    //     showCancelButton: true,
    //     cancelButtonClass: '#DD6B55',
    //     confirmButtonColor: '#dc3545',
    //     confirmButtonText: 'Delete!',

    //   }, function(result) {
    //     console.log(result)
    //     if (result) {
    //       //   console.log('masuk');
    //       let action = current_object.attr('data-action');
    //       //   let token = jQuery('meta[name="csrf-token"]').attr('content');
    //       let token = current_object.attr('content');
    //       console.log(token);
    //       let id = current_object.attr('data-id');

    //       $('body').html("<form class='form-inline remove-form' method='post' action='" + action + "'></form>");
    //       $('body').find('.remove-form').append('<input name="_method" type="hidden" value="delete">');
    //       $('body').find('.remove-form').append('<input name="_token" type="hidden" value="' + token + '">');
    //       $('body').find('.remove-form').append('<input name="id" type="hidden" value="' + id + '">');
    //       $('body').find('.remove-form').submit();
    //     }
    //   });
    // });

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
          url: "{{ url('categories') }}" + '/' + id,
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
