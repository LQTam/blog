<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Events\PostCommentEvent;
use App\Notifications\CommentPostedNotification;
use App\Post;
use App\User;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Post $post)
    {
        return response()->json($post->comments()->with('user')->latest()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Post $post,Request $request)
    {

        $data = $this->validateRequest($request);
        $comment = $post->comments()->create([
            'body' => $data['body'],
            'user_id' => auth()->user()->id,
        ]);

        $comment = Comment::where('id',$comment->id)->with('user')->first();

        broadcast(new PostCommentEvent($comment))->toOthers();
        $post->user->notify(new CommentPostedNotification($post));

        return $comment->toJson();
    }

    public function validateRequest(Request $request){
        return $this->validate($request,[
            'body' => 'required|min:3'
        ],[
           'body.required' => "Truong nay la bat buoc!",
           'body.min' => "Toi thieu 3 ky tu!"
        ]);
    }

    public function humanTiming ($time){
        $time = time() - $time; // to get the time since that moment
        $time = ($time<1)? 1 : $time;
        $tokens = array (
            31536000 => 'year',
            2592000 => 'month',
            604800 => 'week',
            86400 => 'day',
            3600 => 'hour',
            60 => 'minute',
            1 => 'second'
        );

        foreach ($tokens as $unit => $text) {
            if ($time < $unit) continue;
            $numberOfUnits = floor($time / $unit);
            return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
