@extends('layouts.app')

@section('title', $post->title)
@section('description', $post->excerpt)

@section('content')
    <main role="main" class="container">
        <div class="row">
            <div class="col-md blog-main">
                <h3 class="pb-3 mb-4 font-italic border-bottom">
                    From the Firehose
                </h3>
                <div class="blog-post">
                    <img src="{{ $post->featured_image_url }}" alt="{{ $post->featured_image_alt }}" class="img-fluid">
                    <h2 class="blog-post-title">{{ $post->title }}</h2>
                    <p class="blog-post-meta"><a href="{{ url('posts/'. $post->uri_suffix) }}">{{ $post->created_at->format('F j, Y') }}</a> by {{ $post->author->name }}</p>
                    @if($post->excerpt)
                        <p>{{ $post->excerpt }}</p>
                        <hr>
                    @endif
                    {!! $post->content !!}
                </div><!-- /.blog-post -->
            </div><!-- /.blog-main -->
        </div><!-- /.row -->
    </main><!-- /.container -->
@endsection
