<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    protected $fillable = ['user_id','title','body'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function categories(){
        return $this->belongsToMany(Category::class);
    }

    public function category(){
        return $this->hasMany(Category::class);
    }

    public function userName(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function scopeWithUserName($query){
        $query->addSubSelect('user_name',function($query){
            $query->select('name')
                ->from('users')
                ->whereColumn('users.id','posts.user_id')
                ->limit(1);
        })->with('userName');
    }

    public function scopeWithCategories($query){
        $query
//            ->selectRaw('true')
//            ->from('categories')
//            ->where('user')

        ->with('categories');
    }
}
