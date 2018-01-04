<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Product;
use Input;

class SearchController extends Controller
{
    
    public function search(Request $request)
    {
        $query = Input::get('q');
        $type = Input::get('type');
        switch ($type) {
            case 'member':
                $members = User::search($query, null, true, true)
                        ->with('products', 'profile')
                        ->paginate(10);   
                if(count($members) == 1) {
                    return redirect()->route('profile.index', ['slug' => $members[0]->slug]);
                }
                return view('search.member')->withMembers($members)->withQuery($query);
                break;
            case 'brand':
                return 'brand';
                break;
            default:
                $products = Product::search($query, null, true)
                    ->with('user', 'attachments')
                    ->paginate(10);            

                return view('products.search_result', ['products' => $products, 'query' => $query]);
                break;
        }        
    }

}
