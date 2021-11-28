<?php

namespace App\Http\Controllers;
use App\Models\Post;

use Illuminate\Http\Request;

class PostsApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllPosts()
    {
        return Post::all();

    }

     //find the user by post id
     public function findUserByPost(){
       
        $posts = Post::find(2) ->users; 
        return $posts;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pagniatedList()
    {
        //authorized user based data
       // return Post::query()->where('userid',auth()->user()->id)->paginate(2);
        //to get all user data
        return Post::query()->paginate(1);
       
       
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   

         $request ->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'required',
            'userid' => 'required',
        ]);

        if($request->hasfile('image')){
        $Random_name =rand();
        $image_file_extension=".png";
        $fileName = $Random_name.$image_file_extension; 

        $path =$request->file('image')->move(public_path("/uploads/post_image/"),$fileName);
        $photoUrl = url('/uploads/post_image/'.$fileName);

        }

        //return Post::create($request->all());
        return Post::create([
            'title' => request('title'),
            'content' => request('content'),
            'image' => $photoUrl,
            'userid' => request('userid'),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function searchById($id)
    {
        return Post::query()->where('id',$id)->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        $post->update($request->all());
        return $post;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Post::destroy($id);
    }

    /**
     * Search by post title.
     *
     * @param  str title
     * @return \Illuminate\Http\Response
     */
    public function searchByTitle($keyword)
    {
       // return Post::where('title','like', '%'.$title.'%')->get();
       // return Post::where('title','like', '%'.$title.'%')->paginate(2);
       return Post::where(function ($query) use($keyword) {
        $query->where('title','like', '%'.$keyword.'%')
           ->orWhere('content', 'like', '%'.$keyword.'%');
      })->paginate(2);
    }   



    /**
     *getting image from the public folder.
     *
     * @return \Illuminate\Http\Response
     */
    public function getImage()
    {
        return response()->download(public_path('logo.png'),'Website Logo');
    }

    /**
     *Stroing image to the public folder.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeImage(Request $request)
    {
       $fileName="new.png";
       $path =$request->file('photo')->move(public_path("/"),$fileName);
       $photoUrl = url('/'.$fileName);
       return response()->json(['url'=>$photoUrl],200);

    }
}