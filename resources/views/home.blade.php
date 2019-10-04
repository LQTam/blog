@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><a class='btn btn-info' href="{{route('posts.index')}}">View Posts</a>
                    <a class='btn btn-info' href="{{route('posts.create')}}">Create Posts</a>
                    <a class='btn btn-info' href="{{route('posts.trashed')}}">Trashed</a>
                    <a class='btn btn-info' href="{{route('token.refresh')}}">Refresh Token</a>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (session('apiToken'))
                        <div class="alert alert-success" role="alert">
                            {{ session('apiToken') }}
                        </div>
                    @endif

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($posts as $post)
                                <tr>
                                    <td><a href="{{route('posts.show',$post->id)}}">{{$post->title}}</a></td>
                                    <td>
                                        <a class='btn btn-primary' href="{{route('posts.edit',$post->id)}}">Edit</a>
                                        <a class='btn btn-danger' 
                                        onclick="if(confirm('Are you sure want to delete this post?')){
                                            document.getElementById('delete-form').submit();
                                        }else return false;"
                                        >Delete</a>
                                        <form id="delete-form" action="{{route('posts.destroy',$post->id)}}" method="post">
                                            @csrf
                                            @method('delete')
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                    {{$posts->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
