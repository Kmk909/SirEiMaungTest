@extends("layouts.app")
@section("content")
                <div class="container">
                    @if($errors->any())
                    <div class="alert alert-warning">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                            @if(session('info'))
                                <div class="alert alert-warning">
                                    {{session('info')}}
                                </div>
                            @endif
                            @if(session('error'))
                                <div class="alert alert-warning">
                                    {{session('error')}}
                                </div>
                            @endif
                        <div class="card mb-2">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $article->title }}</h5>
                                                    <div class="card-subtitle mb-2 text-muted small">

                                                               {{ $article->updated_at->diffForHumans() }}
                                                               By <b>{{ $article->user->name }}</b>
                                                    </div>
                                                    
                                        <p class="card-text">{{ $article->body }}</p>
                                        {{-- <div class="small mt-2">By <b>{{ $article->user->name }}</b>
                                        </div> --}}
                                        <a class="btn btn-warning" href="{{route('article.delete',['id'=>$article->id]) }}">Delete</a>
                                        
                                        <a class="btn btn-primary" href="{{ route('article.edit',['id'=>$article->id]) }}">Edit</a>
                                    </div>
                        </div>
                        <ul class="list-group">
                        <li class="list-group-item active">
                        <b>Comments ({{ count($article->comments) }})</b>
                        </li>
                        @foreach($article->comments as $comment)
                        <li class="list-group-item">
                        {{ $comment->content }}
                        <a href="{{ route('comment.delete',['id'=>$comment->id]) }}" class="close">&times;</a>
                        <div class="small mt-2">By <b>{{ $comment->user->name }}</b>,{{ $comment->created_at->diffForHumans() }}
                        </div>
                        </li>
                        @endforeach
                        </ul>
                        @auth
                        <form action="{{ url('/comments/add') }}" method="post">
                        @csrf
                        <input type="hidden" name="article_id"
                        value="{{ $article->id }}">
                        <textarea name="content" class="form-control mb-2" 
                        placeholder="New Comment"></textarea>
                        <input type="submit" value="Add Comment"
                        class="btn btn-secondary">
                        </form>
                        @endauth
                </div>
@endsection