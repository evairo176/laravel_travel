@extends('layouts.admin')


@section('content')
<!-- Content Row -->
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{$subtitle}}</h1>
    <a href="{{route('gallery.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm">
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
        <form action="{{route('gallery.update',$item->id)}}" method="post" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="travel_packages_id">Paket Travel</label>
                <select name="travel_packages_id" id="" class="form-control">
                    <option value="{{$item->id}}">Jangan Diubah</option>
                    @foreach($travel_package as $travel_packages)
                    <option value="{{$item->id}}">{{$travel_packages->title}}</option>
                    @endforeach
                </select>
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