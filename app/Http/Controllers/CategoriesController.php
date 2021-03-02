<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // hanya user yang sudah login dan role admin yang bole mengakses
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function index(Request $request)
    {
        // $categories = Category::get();
        $categories = Category::paginate(5);

        $filterKeyword = $request->get('name');

        if ($filterKeyword) {
            $categories = Category::where("title", "LIKE", "%$filterKeyword%")->orderBy('title')->paginate(5);
        }

        return view('categories.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
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
            'title' => 'required|string|max:255|unique:categories',
            'parent_id' => 'exists:categories,id'
        ])->validate();

        // print_r($request->all());
        // Category::create($request->all());

        $new_category = new Category;
        $new_category->title = $request->get('title');
        $new_category->parent_id = $request->get('categories');
        $new_category->save();
        return redirect()->route('categories.index')->with('status', 'Category successfully created');
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
        $category = Category::findOrFail($id);
        return view('categories.edit', ['category' => $category]);
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
        $category = Category::findOrFail($id);
        Validator::make($request->all(), [
            'title' => 'required|string|max:255|unique:categories,title,' . $category->id,
            // 'parent_id' => 'exists:categories,id'
        ])->validate();

        // $category->parent_id = $request->get('categories');
        // echo $category;
        // die();

        // jika ada perubhan pada selectbox
        if ($request->get('categories')) {
            $category->parent_id = $request->get('categories');
            $category->save();
        }

        $category->update($request->all());


        return redirect()->route('categories.index')->with('status', 'Category successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('categories.index')->with('status', 'Category successfully deleted');
    }

    public function ajaxSearch(Request $request)
    {
        $keyword = $request->get('q');
        $categories = Category::where("title", "LIKE", "%$keyword%")->get();
        return $categories;
    }
}
