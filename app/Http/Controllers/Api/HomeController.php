<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Country;
use App\Models\Post;
use App\Http\Resources\CountryResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\HomeResource;
class HomeController extends Controller
{
    public function countries()
    {
         $countries = Country::all();
        return api_response(CountryResource::collection($countries) ?? [], 'success', 1);
        
    }
    public function home(){
        $posts = Post::orderBy('id', 'DESC')->get();
      //  dd( $posts );
        $categories = Category::all();
        return api_response([ 
            'categories' => CategoryResource::collection($categories) ?? [],
            'posts' =>   $posts ?  HomeResource::collection($posts) : []
        ]  , 'success', 1);
    }
}
