<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Image;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::all();
        return view('admin.brands.index',compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $image =$request->file('brand_image');
        $fileName = hexdec(uniqid()).'.'.
            $image->getClientOriginalExtension();
        Image::make($image)->resize(300,300)->save('upload/brand/'.$fileName);
        $save_url = 'upload/brand/'.$fileName;
        Brand::create([
            'brand_name'=>$request->brand_name,
            'brand_slug'=>strtolower(str_replace('','-',$request->brand_name)),
           'brand_image'=>$save_url,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        return view('admin.brands.show',[
            'brand'=>$brand
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        return view('admin.brands.edit',[
            'brand'=>$brand
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        $image =$request->file('brand_image');
        $fileName = hexdec(uniqid()).'.'.
            $image->getClientOriginalExtension();
        Image::make($image)->resize(300,300)->save('upload/brand/'.$fileName);
        $save_url = 'upload/brand/'.$fileName;
        $brand->update([
            'brand_name'=>$request->brand_name,
            'brand_slug'=>strtolower(str_replace('','-',$request->brand_name)),
            'brand_image'=>$save_url,
        ]);

        return redirect()->route('brands.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();

        return redirect()->route('brands.index');
    }
}
