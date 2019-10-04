@extends('layouts.app')
@section('styles')
    <style>
        .comment-wrapper .panel-body {
            max-height:650px;
            overflow:auto;
        }

        .comment-wrapper .media-list .media img {
            width:64px;
            height:64px;
            border:2px solid #e5e7e8;
        }

        .comment-wrapper .media-list .media {
            border-bottom:1px dashed #efefef;
            margin-bottom:25px;
        }
    </style>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="">
                <count-reader :postid="{{$post->id}}"></count-reader>
                <div class="card-body">
                    <div class="col-md-12">
                        <div class="blog-entry ftco-animate d-md-flex fadeInUp ftco-animated">
                            <a href="single.html" class="img img-2" style="background-image: url(images/image_1.jpg);"></a>
                            <div class="text text-2 pl-md-4">
                                <h2 class="mb-2">{{$post->title}}</h2>
                                <div class="meta-wrap">
                                    <p class="meta">
                                        <span><i class="fa fa-calendar-o mr-2" aria-hidden="true"></i>{{date('M d, Y'),strtotime($post->created_at)}}</span>
                                        <span><i class='fa fa-user mr-2' aria-hidden="true"></i>{{$post->user->name}}</span>
                                        <span><a href="single.html"><i class="fa fa-folder-o mr-2" aria-hidden="true"></i>Travel</a></span>
                                        <span><i class="fa fa-comment-o mr-2" aria-hidden="true"></i>5 Comment</span>
                                    </p>
                                </div>
                                <p class="mb-4">A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
                                @can(['update-post','delete-post'], $post)
                                    <p>
                                        <a class='btn btn-primary' href="{{route('posts.edit',$post->id)}}">Edit</a>
                                        <a class='btn btn-danger' href="{{route('posts.destroy',$post->id)}}"
                                            onclick="if(confirm('Are you sure want to delete this post?')){
                                                event.preventDefault();
                                                document.getElementById('delete-form').submit();
                                            }else return false"
                                            >Delete</a>
                                        <form id="delete-form"  action="{{ route('posts.destroy',$post->id) }}" method="POST" style="display:none">
                                            @csrf
                                            @method('delete')
                                        </form>
                                    </p>
                                @endcan
                            </div>
                        </div>
                        <div id="comment" class="row bootstrap snippets">
                                <comment-component
                                    :postid="{{$post->id}}"
                                    :user = "{{(auth()->user()) ?? 'null'}}"
                                />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
