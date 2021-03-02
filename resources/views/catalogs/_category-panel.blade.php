<ul class="list-group shadow" style="border:none">
  <h5 class="card-header">Show Category</h5>
  <li class="list-group-item d-flex justify-content-between align-items-center">
    All Product
    <span class="badge badge-primary badge-pill">{{ App\Models\Product::count() }}</span>
  </li>
  @foreach ($categories as $category)
    <li class="list-group-item d-flex justify-content-between align-items-center">
      {{ $category->title }}
      <span class="badge badge-primary badge-pill">2</span>
    </li>
  @endforeach
</ul><br />
