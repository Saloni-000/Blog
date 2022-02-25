@extends('layout')
@section('head')


    <script src="https://cdn.ckeditor.com/4.17.2/standard/ckeditor.js"></script>

@endsection
@section('main')
    <main class="container" style="background-color: #fff;">
        <section id="contact-us">
            <h1 style="padding-top: 50px;">Edit Post!</h1>
            @include('includes.flash-message')
            <form action="{{route('blog.update',$post)}}" method="post" enctype="multipart/form-data">
{{--                to hit put method when the server is up  as form is only get or post--}}
            @method('put')

            @csrf
            <!-- Title -->
                <label for="title"><span>Title</span></label>
                <input type="text" id="title" name="title" value="{{$post->title }}" />
                @error('title')
                {{-- The $attributeValue field is/must be $validationRule --}}
                <p style="color: red; margin-bottom:25px;">{{ $message }}</p>
                @enderror
            <!-- Image -->
                <label for="image"><span>Image</span></label>
                <input type="file" id="image" name="image" />
                @error('image')
                {{-- The $attributeValue field is/must be $validationRule --}}
                <p style="color: red; margin-bottom:25px;">{{ $message }}</p>
                @enderror
            <!-- Body-->
                <label for="body"><span>Body</span></label>
                <textarea id="body" name="body">{{ $post->body }}</textarea>
                @error('body')
                {{-- The $attributeValue field is/must be $validationRule --}}
                <p style="color: red; margin-bottom:25px;">{{ $message }}</p>
            @enderror
            <!-- Button -->
                <input type="submit" value="Submit" />

            </form>

            @endsection
            @section('scripts')
                <script>
                    CKEDITOR.replace( 'body' );
                </script>
@endsection
