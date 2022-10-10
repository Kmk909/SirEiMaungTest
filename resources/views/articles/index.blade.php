@extends("layouts.app")
@section("content")
   <div class="container">
       @if(session('info'))
            <div>{{session('info')}}</div>
       @endif
      {{ $articles->links() }}
      @foreach($articles as $article)
           <div class="card mb-2">
               <div class="card-body">
                    <h5 class="card-title">{{ $article->title }}</h5>
                    <div class="card-subtitle mb-2 text-muted small">
                            {{ $article->updated_at->diffForHumans() }}
                            By <b>{{ $article->user->name }}</b>
                    </div>
                    {{-- <div class="small mt-2">By <b>{{ $article->user->name }}</b>
                    </div> --}}
                    <p class="card-text">{{ $article->body }}</p>
                    <a class="card-link" href="{{ url("/articles/details/$article->id") }}">View Detail &raquo;</a>
                </div>
            </div>
      @endforeach
    </div>
@endsection