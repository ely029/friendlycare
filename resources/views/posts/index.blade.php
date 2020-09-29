@extends('layouts.app')

@section('content')
    <main role="main" class="container">
        <div class="row">
            <div class="col-md-8 blog-main">
                <h3 class="pb-3 mb-4 font-italic border-bottom">
                    From the Firehose
                </h3>

                @forelse($posts as $post)
                    <div class="blog-post">
                        <img src="{{ $post->featured_image_url }}" alt="{{ $post->featured_image_alt }}" class="img-responsive">
                        <h2 class="blog-post-title">{{ $post->title }}</h2>
                        <p class="blog-post-meta"><a href="{{ url('posts/'. $post->uri_suffix) }}">{{ $post->created_at->format('F j, Y') }}</a> by {{ $post->author->name }}</p>

                        <p>{{ $post->excerpt }}</p>
                    </div><!-- /.blog-post -->
                @empty
                    <p>No blog posts yet.</p>
                @endforelse
            </div><!-- /.blog-main -->

            <aside class="col-md-4 blog-sidebar">
                <div class="p-3 mb-3 bg-light rounded">
                    <h4 class="font-italic">About</h4>
                    <p class="mb-0">
                        {{ config('boilerplate.description') }}
                    </p>
                </div>
            </aside><!-- /.blog-sidebar -->

        </div><!-- /.row -->

    </main><!-- /.container -->

@endsection
