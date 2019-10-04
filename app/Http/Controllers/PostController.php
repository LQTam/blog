<?php

namespace App\Http\Controllers;

use App\Events\JoinPostEvent;
use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return view('posts.index',['posts'=>Post::orderBy('created_at','asc')->paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!$this->authorize('create-post',Post::class)){
            abort(403,"You have to verify your email!");
        }
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $credentials = $this->validateRequest($request);
        auth()->user()->posts()->create($credentials);
        return redirect(route('home'));
    }

    public function validateRequest($request){
        return $this->validate($request,[
            'title' => 'required|min:3',
            'body' => 'required',
            ],
             [
                 'title.required' => "Truong nay la bat buoc!",
                 'title.min' => "Toi thieu 3 ky tu!",
                 'body.required' => "Truong nay la bat buoc!"
             ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('posts.show',['post'=>$post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $this->authorize('update-post',$post);
        return view('posts.edit',['post'=>$post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $credentials = $this->validateRequest($request);
        // if(!$credentials){
        //     return redirect()->back()->withErrors();
        // }
        $post->update($credentials);
        return redirect()->route('home');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete-post',$post);
        $post->delete();
        return redirect(route('home'));
    }


    public function getPostsTrashed(){
        return  auth()->user() ? view('posts.trashed',['posts'=>\App\Post::withTrashed()
            ->where('deleted_at','!=', null)
            ->paginate(10)])
            :   redirect()->route('home');
    }

    public function restorePost($id){
        $this->authorize('restore-post',Post::withTrashed()->where('id',$id)->get()->all());
        \App\Post::withTrashed()
        ->where('id',$id)
        ->restore();
        return redirect(route('home'));
    }

    public function forceDelete($id){
        $this->authorize('forceDelete-post',Post::withTrashed()->where('id',$id)->get()->all());
        \App\Post::withTrashed()
        ->where('id',$id)
        ->forceDelete();
        return redirect(route('home'));
    }
}
