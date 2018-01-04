<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use FunctionHelper;
use App\Media;
use File;
use Image;
use Input;
use App\User;
use App\ProductImageDetail;

class MediaController extends Controller
{
    public function upload(Request $request)
    {
        if($request->hasFile('product_images')) {

            $directory = $request->user()->uid;
            $filename = sha1(time() . mt_rand());
            
            $data = FunctionHelper::save_attachment($request->product_images, $directory, $filename);
            
            $media = Media::create([
                'user_id' => $request->user()->id,
                'original_url' => $data['name']                
            ]);
            return [
                'name' => $data['name'] ,
                'size' => $data['size'],
                'fullname' => $request->user()->uid . '/' . $data['name'],
                'thumb' => 'images/' . $request->user()->uid . '/' . FunctionHelper::getImageVersion($data['name'], 'small'),
                'url' => $data['url'],
                'id' => $media->id
            ];   
        }
        return 0;
    }

    public function destroy(Request $request)
    {        
        $this->validate($request, [
            'product_image' => 'required'
        ]);

        $image = Media::where('original_url', $request->product_image)
                        ->where('user_id', $request->user()->id)
                        ->first();
        
        if($image) {
            if(File::exists(public_path('images/' . $request->user()->uid . '/' . $request->product_image))) {
                File::delete(public_path('images/' . $request->user()->uid . '/' . $request->product_image));
                FunctionHelper::deleteThumbnail(url('images/' . $request->user()->uid . '/' . $request->product_image));
            }
            $image->delete();
            return response()->json([
                'status' => 'deleted'
            ], 200);
        }
        return response()->json([
            'status' => 'errors'
        ], 401);
    }

    public function list(Request $request)
    {
        $data = [];
        $images = Media::all();
        foreach ($images as $image) {
            array_push($data, [
                'name' => $image->original_url,
                'size' => File::size(public_path('images/' . $request->user()->uid . '/' . $image->original_url)),
                'fullname' => $request->user()->uid . '/' . $image->original_url,
                'url' => url('images/' . $request->user()->uid . '/' . $image->original_url),
                'id' => $image->id
            ]);
        }
        return $data;
    }


    public function get_images(Request $request)
    {
        $imagesIds = Input::get('images');
        $images = [];
        if($imagesIds) {
            $ids = explode(',', $imagesIds);
            foreach($ids as $id) {
                $image = Media::find($id);
                $user = User::find($image->user_id);    
                array_push($images, [
                    'name' => $image->original_url,
                    'size' => File::size(public_path('images/' . $user->uid . '/' . $image->original_url)),
                    'fullname' => $user->uid . '/' . $image->original_url,
                    'url' => url('images/' . $user->uid . '/' . $image->original_url),
                    'thumb' => 'images/' . $user->uid . '/' . FunctionHelper::getImageVersion($image->original_url, 'small'),
                    'id' => $image->id,
                    'price' => isset($image->image_detail->media_price) ? $image->image_detail->media_price : null,
                    'caption' => isset($image->image_detail->media_caption) ? $image->image_detail->media_caption : null
                ]);
            }
            return $images;
        }
        return 0;
    }


    public function media_detail(Request $request)
    {
        $mediaDetail = ProductImageDetail::where('media_id', $request->dataId)->first();
        if($mediaDetail) {
            return response()->json([
                'status' => 'success',
                'data' => [
                    'price' => $mediaDetail->media_price,
                    'caption' => $mediaDetail->media_caption
                ]
            ]);
        }
        return response()->json([
            'status' => 'errors'
        ]);
    }

    public function setMediaDetail(Request $request)
    {
        $this->validate($request, [
            'dataId' => 'required|numeric',
            'price' => 'nullable|numeric',
            'caption' => 'nullable|max:255'
        ]);
        $mediaDetail = ProductImageDetail::where('media_id', $request->dataId)->first();
        if($mediaDetail) {
            $mediaDetail->update([
                'media_price' => $request->price,
                'media_caption' => $request->caption
            ]);
        }else{
            $mediaDetail = ProductImageDetail::create([
                'media_id' => $request->dataId,
                'media_price' => $request->price,
                'media_caption' => $request->caption
            ]);
        }        
        return $mediaDetail;
    }
}
