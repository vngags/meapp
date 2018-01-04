<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Product;
use App\Media;
// use Auth;
use FunctionHelper;
use File;
// use DB;

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
        $this->authorize('create', Product::class);
        $this->validate($request, [
            'title' => 'required|max:255',
            'body' => 'required',
            'attachments' => 'nullable|array',
            'price' => 'nullable|numeric',
            'new_price' => 'nullable|numeric',
            'start_price' => 'nullable|numeric',
            'end_price' => 'nullable|numeric'
        ]);

        $data = [
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'body' => $request->body,
            'attachments' => $request->attachments,
            'price' => $request->price ? $request->price : null,
            'new_price' => $request->new_price ? $request->new_price : null,
            'start_price' => $request->start_price ? $request->start_price : null,
            'end_price' => $request->end_price ? $request->end_price : null
        ];
        $product = $this->product->create($data);
        
        return response()->json([
            'status' => 'success',
            'product' => $product
        ]);      
    }

    public function update(Request $request)
    {
        $p = Product::find($request->id);
        $this->authorize('update', $p);
        $this->validate($request, [
            'title' => 'required|max:255',
            'body' => 'required',
            'attachments' => 'nullable|array',
            'id' => 'required|numeric',
            'price' => 'nullable|numeric',
            'new_price' => 'nullable|numeric',
            'start_price' => 'nullable|numeric',
            'end_price' => 'nullable|numeric'
        ]);

        $data = [
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'body' => $request->body,
            'attachments' => $request->attachments,
            'price' => $request->price ? $request->price : null,
            'new_price' => $request->new_price ? $request->new_price : null,
            'start_price' => $request->start_price ? $request->start_price : null,
            'end_price' => $request->end_price ? $request->end_price : null
        ];
        $product = $this->product->update($request->id, $data);
        return response()->json([
            'status' => 'success',
            'product' => $product
        ]);  
    }
    
    public function get_index(Request $request)
    {
        $this->authorize('view', Product::class);
        $this->validate($request, [
            'product_id' => 'required|numeric'
        ]);
        $product = $this->product->find($request->product_id);
        return response()->json([
            'product' => $product,
            'attachments' => $product->attachments->pluck('id'),
            'user' => $product->user
        ]);
    }

    public function index(Request $request)
    {
        // DB::connection()->enableQueryLog();

        $products = $this->product->getAll(['user', 'attachments'], 9);
        // $log = DB::getQueryLog();
        // print_r($log);
        $data = [];
        $data['data'] = $products->map(function($p) {
            return [
                'title' => $p->title,
                'body' => FunctionHelper::truncate($p->body),
                'slug' => $p->slug,
                'new_price' => $p->new_price,
                'price' => $p->price,
                'price_start' => $p->price_start,
                'price_end' => $p->price_end,
                'created_at' => $p->created_at,
                'user' => $p->user()->get()->map(function($user) {
                    $dataUser = [
                        'name' => $user->name,
                        'slug' => $user->slug,
                        'avatar' => $user->avatar,
                        'uid' => $user->uid
                    ];
                    return $dataUser;
                }),
                'attachments' => $p->attachments()->get()->map(function($a) {
                    return [
                      'original_url' => $a->original_url,
                      'full' => FunctionHelper::getImageVersion($a->original_url, 'full'),
                      'large' => FunctionHelper::getImageVersion($a->original_url, 'large'),
                      'half' => FunctionHelper::getImageVersion($a->original_url, 'half'),
                      'small' => FunctionHelper::getImageVersion($a->original_url, 'small')
                    ];
                })               
            ];
        });
        
        $data['page'] = [
            'current_page' => $products->currentPage(),
            'total' => $products->total(),
            'per_page' => $products->perPage(),
            'last_page' => $products->lastPage(),
            'from' => $products->firstItem(),
            'to' => $products->lastItem()
        ];

        return collect($data);
    }

    public function getIndex($user_slug, $slug)
    {
        $product = $this->product->findByUidAndSlug($user_slug, $slug);      
        $dataProduct = [];  
        if($product) {
            array_push($dataProduct, [
                'id' => $product->id,
                'title' => $product->title,
                'slug' => $product->slug,
                'body' => $product->body,
                'created_at' => $product->created_at,
                'user' => [
                    'uid' => $product->user->uid,
                    'name' => $product->user->name,
                    'slug' => $product->user->slug,
                    'avatar' => $product->user->avatar,
                ],
                'attachments' => $product->attachments->map(function($attach) use ($product) {
                    return [
                        'id' => $attach->id,
                        'original_url' => $attach->original_url,
                        'large' => $product->user->uid . '/' . FunctionHelper::getImageVersion($attach->original_url, 'large'),
                        'thumb' => 'images/' . $product->user->uid . '/' . FunctionHelper::getImageVersion($attach->original_url, 'small'),
                        'fullname' => $product->user->uid . '/' . $attach->original_url,
                        'detail' => [
                            'price' => isset($attach->image_detail->media_price) ? $attach->image_detail->media_price : null,
                            'caption' => isset($attach->image_detail->media_caption) ? $attach->image_detail->media_caption : null
                        ]
                    ];
                }),
            ]);
            return response()->json($dataProduct[0]);
        }else{
            return response()->json(['status' => 'errors']);
        }
    }

    public function delete(Request $request)
    {        
        $this->validate($request, [
            'postId' => 'required|numeric'
        ]);
        $post = $this->product->find($request->postId);

        $this->authorize('delete', $post);

        $attachments = $post->attachments->pluck('id');
        foreach($attachments as $attach) {
            $image = Media::where('id', $attach)
                        ->where('user_id', $request->user()->id)
                        ->first();
        
            if($image) {
                if(File::exists(public_path('images/' . $request->user()->uid . '/' . $image->original_url))) {
                    File::delete(public_path('images/' . $request->user()->uid . '/' . $image->original_url));
                    FunctionHelper::deleteThumbnail(url('images/' . $request->user()->uid . '/' . $image->original_url));
                }
                $image->delete();
            }            
        }
        $post->delete();
        return response()->json([
            'status' => 'deleted'
        ]);
    }
}
