@extends('layouts.app')
@section('content')
<div class="container">
    @if($errors->any())
        <div class="alert alert-warning">
            <ol>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ol>
        </div>
    @endif
<form action="{{route('article.update',['id' => $article->id])}}" method="post">
@csrf
<div class="form-group">
<label>Title</label>
<input type="text" name="title" class="form-control" value="{{ old('title') ?: $article->title }}">
</div>
<div class="form-group">
<label>Body</label>
<textarea name="body" class="form-control">{{ old('body') ?: $article->body }}</textarea>
</div>
<div class="form-group">
<label>Category</label>
<select class="form-control" name="category_id">
@foreach($categories as $category)
<option value="{{ $category['id']}}" {{$category['id'] == $article->category_id ? 'selected':''}}>
{{ $category['name'] }}
</option>
@endforeach
</select>
</div>
<input type="submit" value="Update Article"
class="btn btn-primary">
</form>
</div>
@endsection