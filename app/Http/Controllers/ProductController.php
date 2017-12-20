<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Product;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth'])->except('index', 'show');
    }
    

    public function index($user_slug)
    {
        $product = Product::with('user')->orderBy('id', 'desc')->paginate(5);
        return view('products.index')->withProducts($product);
    }

    
    public function create($user_slug)
    {
        $this->authorize('create', Product::class);
        return view('products.create');
    }

     
    public function store(Request $request, $user_slug)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'body' => 'required'
        ]);
        $product = Product::create([
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'slug' => $request->title,
            'body' => $request->body
        ]);
        if($product) {
            return redirect()->route('product.index', ['user_slug' => $user_slug]);
        }else{
            return redirect()->back()->withErrors();
        }        
    }

    
    public function show($user_slug, $slug)
    {       
        $product = Product::fetchByUidSlug($user_slug, $slug);
        
        if($product) {
            return view ('products.show')->withProduct($product);
        }else{
            return redirect()->route('product.index', ['user_slug' => $user_slug]);
        }
    }

    
    public function edit($user_slug, $slug)
    {        
        $product = Product::findBySlug($slug);
        $this->authorize($product, 'update');
        return view('products.edit', ['product' => $product]); 
    }

    
    public function update(Request $request, $user_slug, $slug)
    {
        $this->validate($request, [
            'title' => 'required|max:100',
            'body' => 'required'
        ]);
        $product = Product::findBySlug($slug);

        $product->update([
            'title' => $request->title,
            'slug' => $request->title,
            'body' => $request->body
        ]);
        return redirect()->route('product.index', ['user_slug' => $user_slug]);
    }

    
    public function destroy($user_slug,$slug)
    {
        $product = Product::findBySlug($slug);
        $this->authorize($product, 'delete');
        $product->delete();
        return redirect()->route('product.index', ['user_slug' => $user_slug]);
    }
}
