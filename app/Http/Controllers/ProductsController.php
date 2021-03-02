<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function index(Request $request)
    {
        $products = Product::paginate(5);
        // print_r($products);

        $filterKeyword = $request->get('name');

        if ($filterKeyword) {
            $products = Product::where("name", "LIKE", "%$filterKeyword%")
                ->orWhere('model', 'LIKE', '%' . $filterKeyword . '%')
                ->orderBy('name')->paginate(5);
        }

        return view('products.index', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required|unique:products',
            'model' => 'required',
            'photo' => 'mimes:jpeg,png|max:10240',
            'price' => 'required|numeric|min:1000',
            'weight' => 'required|integer|min:100',
            "photo"       => "required",
            "categories"  => "required"
        ])->validate();

        $product = new Product;
        $product->name = $request->get('name');
        $product->model = $request->get('model');
        $product->price = $request->get('price');
        $product->weight = $request->get('weight');

        // buat nama file gambar product
        // $fileName = str_random(40) . '.' . $request->file('photo')->extension();
        $fileName = time() . '.' . $request->file('photo')->extension();

        $product_image = $request->file('photo');
        if ($product_image) {
            // DIREC-TORY_SEPARATOR untuk menghindari error karena unix menggunakan / (slash) untuk pemisah folder sedangkan windows \ (backslash)
            $destinationPath = public_path() . DIRECTORY_SEPARATOR . 'img';
            $product_image->move($destinationPath, $fileName);
            $product->photo = $fileName;
        }

        $product->save();
        // insert juga ke book_category
        $product->categories()->attach($request->get('categories'));

        return redirect()->route('products.index')->with('status', 'Product successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', ['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        Validator::make($request->all(), [
            'name' => 'required|unique:products,name,' . $product->id,
            'model' => 'required',
            'photo' => 'mimes:jpeg,png|max:10240',
            'price' => 'required|numeric|min:1000',
            'weight' => 'required|numeric|min:100',
            "categories"  => "required"
        ])->validate();

        $product->name = $request->get('name');
        $product->model = $request->get('model');
        $product->price = $request->get('price');
        $product->weight = $request->get('weight');

        $product_image = $request->file('photo');
        if ($product_image) {
            $destinationPath = public_path() . DIRECTORY_SEPARATOR . 'img';
            if ($product->photo && file_exists($destinationPath . DIRECTORY_SEPARATOR . $product->photo)) {
                File::delete($destinationPath . DIRECTORY_SEPARATOR . $product->photo);
            }
            $fileName = time() . '.' . $request->file('photo')->extension();
            $product_image->move($destinationPath, $fileName);
            $product->photo = $fileName;
        }

        $product->save();

        $product->categories()->sync($request->get('categories'));

        return redirect()->route('products.index')->with('status', 'Product successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $destinationPath = public_path() . DIRECTORY_SEPARATOR . 'img';
        if ($product->photo && file_exists($destinationPath . DIRECTORY_SEPARATOR . $product->photo)) {
            File::delete($destinationPath . DIRECTORY_SEPARATOR . $product->photo);
        }
        // hapus juga relasi ditabel product_category
        $product->categories()->detach();
        $product->delete();
        return redirect()->route('products.index')->with('status', 'Product successfully deleted');
    }
}
