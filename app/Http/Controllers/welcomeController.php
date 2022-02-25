<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class welcomeController extends Controller
{
    public function index()
    {
        $posts=Post::latest()->take(6)->get();
        return view('welcome',compact('posts'));
    }
}
