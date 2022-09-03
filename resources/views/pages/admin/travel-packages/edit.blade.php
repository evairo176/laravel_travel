@extends('layouts.admin')


@section('content')
<!-- Content Row -->
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{$subtitle}}</h1>
    <a href="{{route('travel-packages.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm">
        <i class="fas fa-sign-out-alt fa-sm text-white-50"></i> Kembali</a>
</div>
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="card-shadow">
    <div class="card-body">
        <form action="{{route('travel-packages.update',$item->id)}}" method="post" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" name="title" id="" placeholder="Judul" value="{{$item->title}}">
            </div>
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" class="form-control" name="location" id="" placeholder="Location" value="{{$item->location}}">
            </div>
            <div class="form-group">
                <label for="title">About</label>
                <textarea name="about" id="" cols="30" rows="10" class="d-block w-100 form-control">{{$item->about}}</textarea>
            </div>
            <div class="form-group">
                <label for="featured_event">Featured Event</label>
                <input type="text" class="form-control" name="featured_event" id="" placeholder="Featured Event" value="{{$item->featured_event}}">
            </div>
            <div class="form-group">
                <label for="language">Language</label>
                <input type="text" class="form-control" name="language" id="" placeholder="Language" value="{{$item->language}}">
            </div>
            <div class="form-group">
                <label for="foods">Foods</label>
                <input type="text" class="form-control" name="foods" id="" placeholder="Foods" value="{{$item->foods}}">
            </div>
            <div class="form-group">
                <label for="departure_date">Departure Date</label>
                <input type="date" class="form-control" name="departure_date" id="" placeholder="Departure Date" value="{{$item->departure_date}}">
            </div>
            <div class="form-group">
                <label for="duration">Duration</label>
                <input type="text" class="form-control" name="duration" id="" placeholder="Duration" value="{{$item->duration}}">
            </div>
            <div class="form-group">
                <label for="type">Type</label>
                <input type="text" class="form-control" name="type" id="" placeholder="Type" value="{{$item->type}}">
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" class="form-control" name="price" id="" placeholder="Price" value="{{$item->price}}">
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" placeholder="Image" class="form-control">
                <input type="hidden" name="image_lama" placeholder="Image" value="{{$item->image}}" class="form-control">
            </div>
            <button class="btn btn-primary btn-block">Ubah</button>
        </form>
    </div>
</div>
@endsection