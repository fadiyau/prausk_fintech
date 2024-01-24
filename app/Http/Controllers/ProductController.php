<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function add(){
        $categories = Category::all();

        return view('home', compact('categories'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $product = Product::create($request->all());
        if($product){
            return redirect('home')->with('status','Berhasil Menambah');
        }
        return redirect('home')->with('status','Gagal Menambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $product->update($request->all());
        if($product){
            return redirect('home')->with('status','Berhasil Mengupdate');
        }
        return redirect('home')->with('status','Gagal Mengupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        if($product){
            return redirect('home')->with('status','Berhasil Menghapus');
        }
        return redirect('home')->with('status','Gagal Menghapus');
    }
}
