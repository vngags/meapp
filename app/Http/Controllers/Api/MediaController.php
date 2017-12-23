<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use FunctionHelper;
use App\Media;
use File;
use Image;
use Input;

class MediaController extends Controller
{
    public function upload(Request $request)
    {
        if($request->hasFile('product_images')) {

            $directory = $request->user()->uid;
            $filename = sha1(mt_rand());
            
            $data = FunctionHelper::save_attachment($request->product_images, $directory, $filename);
            // $data = FunctionHelper::save_attachment_nochange_filename($request->file, $directory);
            
            Media::create([
                'user_id' => $request->user()->id,
                'original_url' => $data['name']                
            ]);
            return [
                'name' => $data['name'] ,
                'size' => $data['size'],
                'url' => $data['url'] 
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
                'url' => url('images/' . $request->user()->uid . '/' . $image->original_url)
            ]);
        }
        return $data;
    }
}
