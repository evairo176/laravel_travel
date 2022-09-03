@extends('layouts.admin')


@section('content')
<!-- Content Row -->
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{$subtitle}}</h1>
    <a href="{{route('gallery.create')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah {{$subtitle}}</a>
</div>
@if (session('sukses'))
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h5><i class="icon fas fa-check"></i> Alert!</h5>
    {{session('sukses')}}
</div>
@endif
<div class="row">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Travel</th>
                        <th>Gambar</th>
                        <th>action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                    <tr>
                        <td>{{$item->id}}</td>
                        <td>{{$item->travel_packages->title}}</td>
                        <td><img src="{{url('assets/gallery/'.$item->image)}}" alt="" class="img-thumbnail" width="150px"></td>
                        <td>
                            <a href="{{route('gallery.edit',$item->id)}}" class="btn btn-warning"><i class="fas fa-pencil-alt"></i></a>
                            <form action="{{route('gallery.destroy',$item->id)}}" method="post" class="d-inline">
                                @method('delete')
                                @csrf
                                <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Data Kosong</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@push('script-add')
<script>
    window.setTimeout(function() {
        $(".alert-success").fadeTo(200, 0).slideUp(200, function() {
            $(this).remove();
        });
    }, 3000);
</script>
@endpush