@extends('layouts.app')
@section('scripts')
@endsection
<script src="https://kit.fontawesome.com/d2b820e777.js"></script>
@section('content')
    @if($posts->count() > 0)
        @foreach ($posts as $post)
            <div class="col-md-12">
                <div class="blog-entry ftco-animate d-md-flex fadeInUp ftco-animated">
                    <a href="single.html" class="img img-2" style="background-image: url(images/image_1.jpg);"></a>
                    <div class="text text-2 pl-md-4">
                        <h3 class="mb-2"><a href="{{route('posts.show',$post->id)}}">{{$post->title}}</a></h3>
                        <div class="meta-wrap">
                            <p class="meta">
                                <span><i class="fa fa-calendar-o mr-2" aria-hidden="true"></i>{{date('M d, Y'),strtotime($post->created_at)}}</span>
                                <span><i class='fa fa-user mr-2' aria-hidden="true"></i>{{$post->user->name}}</span>
                                <span><a href="single.html"><i class="fa fa-folder-o mr-2" aria-hidden="true"></i>Travel</a></span>
                                <span><i class="fa fa-comment-o mr-2" aria-hidden="true"></i>5 Comment</span>
                            </p>
                        </div>
                        <p class="mb-4">A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
                        <p>
                            <a class='btn btn-info' href="{{route('posts.restore',$post->id)}}"
                               onclick="if(confirm('Are you sure want to delete this post?')) return true;else return false"
                            >Restore</a>
                            <a class='btn btn-danger' href="{{route('posts.forceDelete',$post->id)}}"
                               onclick="if(confirm('Delete will never take back?')) return true;else return false"
                            >Delete</a>
                    </div>
                </div>
            </div>
        @endforeach
        {{ $posts->links() }}
    @else
        <h1>Trash empty!</h1>
    @endif

@endsection