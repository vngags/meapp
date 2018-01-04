<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use FunctionHelper;

use App\Repositories\Product\ProductRepositoryInterface;


class HomeController extends Controller
{
    protected $productRepository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->product = $productRepository;
        $this->middleware('auth')->except('index');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $product = $this->product->getAll(['user', 'attachments'], 12 );
        return view('products.index')->withProducts($product);
        // $media = \App\Media::get();
        // foreach($media as $image) {
        //     $user = \App\User::find($image->user_id);
        //     $fullurl = url('images/' . $user->uid . '/' . $image->original_url);
        //     FunctionHelper::saveThumbnail($fullurl);
        // }
        // dd(FunctionHelper::getImageVersion('c46ea60e88b1c53b5e41ffcc88574505e2c9e50c.jpg', 'small'));
        // dd(\App\User::role('writer')->get());
        // $role = Role::create(['name' => 'writer']);
        // $permission = Permission::create(['name' => 'edit articles']);
        // return FunctionHelper::saveImageVersion('http://coccoc.me/images/551466/7c8d282a8bbf7ff510572de1f331b55d3e4828b7.jpg', 'ss', 105, 105);
    }
}
