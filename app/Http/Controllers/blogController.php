<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class blogController extends Controller
{
    public function __construct()
    {
//        will ask fo rauthentication for all teh functions
        $this->middleware('auth')->except('index','show');
    }

    public function index(Request $request){
        if($request->search){
            $posts=Post::where('title','like','%'.$request->search.'%')
            ->orwhere('body','like','%'.$request->search.'%')->latest()->paginate(9);
        }
        elseif($request->category){
            $posts = Category::where('name', $request->category)->firstOrFail()->posts()->paginate(9)->withQueryString();
        }
        else{
            $posts=Post::latest()->paginate(9);
        }
        $categories=Category::all();

        return view('blog-post\blog',compact('posts','categories'));
    }
    public function create(){
        $categories=Category::all();
        return view('blog-post\create-blog-post',compact('categories'));
    }
    public function store(Request $request){

        $request->validate([
            'title'=>'required',
            'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg',
            'body'=>'required',
            'category-id=>required'
        ]);

        $path = $request->file('image')->store('postsImages', 'public');

        $imagePath='./'.$path;
        $title=$request->input('title');
        $category_id=$request->input('category_id');

        if(Post::latest()->first() !== null){
            $postId = Post::latest()->first()->id + 1;
        } else{
            $postId = 1;
        }
        $slug=Str::slug($title,'-').'-'.$postId;
        if (Auth::check())
        {
            // The user is logged in...
            $user_id=Auth::user()->id;
        }


        $body=$request->input('body');
//        creating an instance of post model
        $post=new Post();
        $post->title=$title;
        $post->slug=$slug;
        $post->imagePath=$imagePath;
        $post->body=$body;
        $post->user_id=$user_id;
        $post->category_id=$category_id;

        $post->save();
//        return $user_id;
        return redirect()->back()->with('status','Post created succesfully');
    }

    public function edit(Post $post){
//        to avoid others access
        if(auth()->user()->id!==$post->user->id) {
            abort(403);
        }
        return view('blog-post\edit-blog-post', compact('post'));
    }

    public function update(Request $request ,Post $post){
        if(auth()->user()->id!==$post->user->id) {
            abort(403);
        }
        $request->validate([
            'title'=>'required',
            'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg',
            'body'=>'required'
        ]);

        $path = $request->file('image')->store('postsImages', 'public');


        $title=$request->input('title');

        $postId=$post->id;
        $slug=Str::slug($title,'-').'-'.$postId;
        $body=$request->input('body');
        $imagePath='./'.$path;


        $post->title=$title;
        $post->slug=$slug;
        $post->imagePath=$imagePath;
        $post->body=$body;

        $post->save();

        return redirect()->back()->with('status','Post edited successfully');
    }

    public function destroy(Post $post){
         $post->delete();
        return redirect()->back()->with('status','Post deleted successfully');

    }




//    public function show($slug){
//        $post=Post::where('slug',$slug)->first();
//        return view('blog-post\single-blog-post',compact('post'));
////        to pass the chosen post to display entirely
//    }

//using route model binding
//the variable name should be sam eas the variable passed in web route i.e {post-slug}
public function show(Post $post){
        return view('blog-post\single-blog-post',compact('post'));
}

}
