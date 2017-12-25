<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Product\ProductRepositoryInterface;

class ProductController extends Controller
{

    /**
     * @var ProductRepositoryInterface|\App\Repositories\Product\ProductRepositoryInterface
     */
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->product = $productRepository;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'body' => 'required',
            'attachments' => 'nullable|array'
        ]);

        $data = [
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'body' => $request->body,
            'attachments' => $request->attachments
        ];
        $product = $this->product->create($data);
        
        if($product) {            
            return response()->json([
                'status' => 'success',
                'product' => $product
            ]);
        }else{
            return response()->json([
                'status' => 'errors'
            ], 422);
        }        
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'body' => 'required',
            'attachments' => 'nullable|array',
            'id' => 'required|numeric'
        ]);

        $data = [
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'body' => $request->body,
            'attachments' => $request->attachments
        ];
        $product = $this->product->update($request->id, $data);
        if($product) {            
            return response()->json([
                'status' => 'success',
                'product' => $product
            ]);
        }else{
            return response()->json([
                'status' => 'errors'
            ], 422);
        }    
    }
    
    public function get_index(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required|numeric'
        ]);
        $product = $this->product->find($request->product_id);
        return response()->json([
            'product' => $product,
            'attachments' => $product->attachments->pluck('id')
        ]);
    }
}
