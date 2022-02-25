@extends('layout')

@section('header')
    <!-- header -->
    <header class="header">
        <div class="header-text">
            <img style="max-width: 100%; padding-top: 0.5rem;" src="{{asset("images/photography.gif")}}"  alt="">
            <h1 class="centered">Nerdvana</h1>
            <h2 class="centered1">Dashboard of verified blogs...</h2>
        </div>
        <div class="overlay"></div>
    </header>

@endsection

@section('main')


    <!-- main -->
    <main class="container">
        <h2 class="header-title">Latest Blog Posts</h2>
        <section class="cards-blog latest-blog">
            @foreach($posts as $post)
                <div class="card-blog-content">
                    {{--                    <img src="{{asset($post->imagePath)}}" alt="" />--}}
                    {{--                    <img src="{{ '/laravel/blog1.0/storage/app/public/'.$post->imagePath }}">--}}
                    <img src="{{asset('storage/'. $post->imagePath) }}"/>

                    <p>

                        {{$post->created_at->diffForHumans()}}
                        <span>Written By {{$post->user->name}}</span>
                    </p>
                    <h4>
                        <a href="{{route('single-post',$post)}}">{{$post->title}}</a>
                    </h4>
                </div>
            @endforeach
        </section>
    </main>

@endsection
