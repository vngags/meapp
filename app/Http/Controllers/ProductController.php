<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Product;
use Input;

class ProductController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->product = $productRepository;
        $this->middleware(['auth'])->except('index', 'show', 'search');
    }
    

    public function index($user_slug)
    {
        $product = $this->product->getAll(['user', 'attachments'], 10 );
        return view('products.index')->withProducts($product);
    }

    
    public function create($user_slug)
    {
        $this->authorize('create', Product::class);
        return view('products.create');
    }   

    
    public function show($user_slug, $slug)
    {       
        $product = $this->product->findByUidAndSlug($user_slug, $slug);        
        if($product) {
            return view ('products.detail')->withProduct($product);
        }else{
            return redirect()->route('product.index', ['user_slug' => $user_slug]);
        }
    }

    
    public function edit($user_slug, $slug)
    {        
        
        $product = Product::findBySlug($slug);       
        $this->authorize('update', $product); 
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
