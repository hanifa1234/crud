<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    //
    public function index(Request $req)
    {
        $keyword = $req->get('search');
        $perPage = 5;

        if (!empty($keyword)) {
            # code...
            $products = Product::where('name', 'LIKE', "%$keyword%")
                ->orWhere('category', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            # code...
            $products = Product::latest()->paginate($perPage);
        }

        return view('products.index', ['products' => $products])->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $req)
    {

        $req->validate([
            'name' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2028'
        ]);


        $product = new Product;

        $file_name = time() . '.' . request()->image->getClientOriginalExtension();
        request()->image->move(public_path('images'), $file_name);
        $product->name = $req->name;
        $product->description = $req->description;
        $product->category = $req->category;
        $product->quantity = $req->quantity;
        $product->price = $req->price;
        // $product->demo_link = $req->demo_link;
        $product->image = $file_name;

        $product->save();
        return redirect()->route('products.index')->with('success', 'products add successfully');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', ['product' => $product]);
    }






    public function update(Request $req, Product $product)
    {
        $req->validate([
            'name' => 'required'
        ]);

        $file_name = $req->hidden_product_image;

        if ($req->image != '') {
            # code...
            $file_name = time() . '.' . request()->image->getClientOriginalExtension();
            request()->image->move(public_path('images'), $file_name);
        }
        $product = Product::find($req->hidden_id);
        $product->name = $req->name;
        $product->description = $req->description;
        $product->category = $req->category;
        $product->quantity = $req->quantity;
        $product->price = $req->price;
        // $product->demo_link = $req->demo_link;
        $product->image = $file_name;

        $product->save();

        return redirect()->route('products.index')->with('success','products has been updates');
    }

    public function destroy($id){
        $product = Product::findOrFail($id);
        $image_path = public_path()."/images/";
        $image = $image_path. $product->image;
        if (file_exists($image)) {
            # code...
            @unlink($image);
        }
        $product->delete();
        return redirect('products')->with('success', 'products deleted');
    }
}
