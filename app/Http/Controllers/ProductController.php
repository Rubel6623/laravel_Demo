<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Image;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::latest()->get();
        return view('admin.products.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        $brands = Brand::latest()->get();
        $categories = Category::latest()->get();
        return view('admin.products.create',compact('brands','categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $image =$request->file('product_image');
        $fileName = hexdec(uniqid()).'.'.
            $image->getClientOriginalExtension();
        Image::make($image)->resize(800,800)->save('upload/product/'.$fileName);
        $save_url = 'upload/product/'.$fileName;
        Product::create([
            'brand_id'=>$request->brand_id,
            'category_id'=>$request->category_id,
            'product_name'=>$request->product_name,
            'selling_price'=>$request->selling_price,
            'short_descp'=>$request->short_descp,
            'status'=>1,
            'product_image'=>$save_url,
            'created_at'=>Carbon::now(),
        ]);

        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('admin.products.show',[
            'product'=>$product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        
        $brands = Brand::latest()->get();
        $categories = Category::latest()->get();
        return view('admin.products.edit',['product'=>$product],compact('brands','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $image =$request->file('product_image');
        $fileName = hexdec(uniqid()).'.'.
            $image->getClientOriginalExtension();
        Image::make($image)->resize(800,800)->save('upload/product/'.$fileName);
        $save_url = 'upload/product/'.$fileName;
       $product->update([
            'brand_id'=>$request->brand_id,
            'category_id'=>$request->category_id,
            'product_name'=>$request->product_name,
            'selling_price'=>$request->selling_price,
            'short_descp'=>$request->short_descp,
            'status'=>1,
            'product_image'=>$save_url,
            'created_at'=>Carbon::now()            
        ]);

        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
    }

    // active status
    public function ProductInactive($id)
    {
        Product::findOrFail($id)->update(['status' => 0]);
        return redirect()->route('products.index');
    }

    public function ProductActive($id)
    {
        Product::findOrFail($id)->update(['status' => 1]);
        return redirect()->route('products.index');
    }
}
