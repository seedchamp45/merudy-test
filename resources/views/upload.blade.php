<!-- resources/views/upload.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Image Upload</h1>
    @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <strong>{{$message}}</strong>
            </div>

            <img src="{{ asset('storage/images/'.Session::get('image')) }}" />
        @endif

    <form action="{{ route('image.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="image">
        <br>
        <br>
        <button type="submit">Upload</button>
    </form>
    <br>
    <br>
    <h2>File List</h2>
    @if (count($files) > 0)
        <ul class="file-list">
            @foreach ($files as $file)
                <li class="file-item">
                    <img style="width: -webkit-fill-available;" src="{{ asset('storage/images/' . $file->image_name) }}" alt="{{ $file->image_name }}" class="file-image">
                    <br>
                    <h3 class="file-name" style="">{{ $file->image_name }}</h3>
                </li>
            @endforeach
        </ul>
    @else
        <p>No files uploaded yet.</p>
    @endif
</div>
@endsection
