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

// ====POST=======
Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');
Route::prefix('posts/trashed')->group(function(){
    Route::get('/','PostController@getPostsTrashed')->name('posts.trashed');
    Route::get('/{post}','PostController@restorePost')->name('posts.restore');
    Route::get('/forceDelete/{post}','PostController@forceDelete')->name('posts.forceDelete');
});
Route::resource('posts','PostController');
// ======++END_POST========

//=========USER===========
Route::get('profile/{user}','HomeController@show')->name('users.show');
Route::get('/update', 'ApiTokenController@update')->name('token.refresh');
Auth::routes(['verify' => true]);

//======END USER==========

// =====NOTIFICATION========
Route::get('/markAsRead/{notify}/{post}',function($notify,$post){
    $notification = auth()->user()->notifications()->where('id',$notify)->first();
    if($notification){
        $notification->markAsRead();
        return redirect(route('posts.show',$post));
    }
})->name('markAsRead');

Route::get('/markAllAsRead',function(){
    auth()->user()->unreadNotifications->markAsRead();
    return redirect()->back();
})->name('markAllAsRead');
// =======END_ NOTIFICATION=====
