<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Str;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/update', 'ApiTokenController@update')->name('token.refresh');
Route::get('/calc', function(){
    return \App\Comment::find(119)->user()->get();
});
Route::get('/findOrFail',function(){
    return \App\Post::findOrFail(1)->user_id;
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');
Route::prefix('posts/trashed')->group(function(){
    Route::get('/','PostController@getPostsTrashed')->name('posts.trashed');
    Route::get('/{post}','PostController@restorePost')->name('posts.restore');
    Route::get('/forceDelete/{post}','PostController@forceDelete')->name('posts.forceDelete');
});

Route::get('/markAsRead/{notify}',function($notify){
    $notification = auth()->user()->notifications()->where('id',$notify)->first();
    // if($notification){
        $notification->markAsRead();
        return redirect()->back();
    // }
})->name('markAsRead');

Route::get('/markAllAsRead',function(){
    auth()->user()->unreadNotifications->markAsRead();
    return redirect()->back();
})->name('markAllAsRead');

Route::resource('posts','PostController');