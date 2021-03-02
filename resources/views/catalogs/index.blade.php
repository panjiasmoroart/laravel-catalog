@extends('layouts.app')

@section('title') Catalogs All @endsection

@section('content')
  <div id="app" class="container">
    <div class="row">
      <div class="col-12 col-md-3 col-lg-3">
        @include('catalogs._category-panel')
      </div>
      <div class="col-12 col-md-9 col-lg-9">

        <div class="row">

          <div class="col-md-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <i class="breadcrumb-item active" aria-current="page">@{{ titleProduct }}</i>
              </ol>
            </nav>
          </div>

          <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-5 h-100" v-for="(data, key) in products" :key="key">
            <h4>@{{ data.name }}</h4>
            <div class="card shadow p-1" style="border:none">
              <div v-if="data.photo">
                <img :src="'img/' + data.photo" class="card-img-top" alt="Belum Tersedia"
            style="width: 100%; height: 30vh;">
              </div>
              <div class="card-body">
                <h5 class="card-title">@{{ data.model }}</h5>
                <p class="card-text">Harga: <strong>Rp @{{ data.price }}</strong></p>
                <p><a href="#" class="btn btn-primary btn-block">Detail</a></p>
              </div>
            </div>
          </div>

        </div>

      </div>
    </div>
  </div>
@endsection

@section('footer-scripts')
  <script>
    let products = {!! $products !!}
    const app = new Vue({
      el: '#app',
      data: {
        titleProduct: 'Category : All Products',
        products: products
      }
    });
  </script>
@endsection


