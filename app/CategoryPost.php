<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryPost extends Model
{
    protected $fillable = [
        'post_id','cate_id'
    ];

    public function post(){
        return $this->belongsToMany(Post::class);
    }

    public function category(){
        return $this->belongsToMany(Category::class);
    }
}
