<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Image;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::latest()->get();

        return view('admin.categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $image =$request->file('category_image');
        $fileName = hexdec(uniqid()).'.'.
            $image->getClientOriginalExtension();
        Image::make($image)->resize(200,200)->save('upload/category/'.$fileName);
        $save_url = 'upload/category/'.$fileName;
        Category::create([
            'category_name'=>$request->category_name,
            'category_slug'=>strtolower(str_replace('','-',$request->category_name)),
            'category_image'=>$save_url,
        ]);

        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view('admin.categories.show',[
            'category'=>$category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit',[
            'category'=>$category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $image =$request->file('category_image');
        $fileName = hexdec(uniqid()).'.'.
            $image->getClientOriginalExtension();
        Image::make($image)->resize(300,300)->save('upload/category/'.$fileName);
        $save_url = 'upload/category/'.$fileName;
        $category->update([
            'category_name'=>$request->category_name,
            'category_slug'=>strtolower(str_replace('','-',$request->category_name)),
            'category_image'=>$save_url,
        ]);

        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index');
    }
}
