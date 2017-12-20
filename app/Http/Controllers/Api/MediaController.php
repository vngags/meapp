<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MediaController extends Controller
{
    public function upload(Request $request)
    {
        return response()->json([
            'file' => 'aaa'
        ]);
    }

    public function destroy(Request $request)
    {        
        return response()->json([
            // 'file' => 'bbb'
            'file' => $request->all()
        ]);
    }
}
