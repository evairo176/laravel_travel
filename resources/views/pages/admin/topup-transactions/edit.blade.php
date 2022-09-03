@extends('layouts.admin')


@section('content')
<!-- Content Row -->
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{$subtitle}}</h1>
    <a href="{{route('transactions.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm">
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
        <form action="{{route('transactions.update',$item->id)}}" method="post">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="transaction_status">Status Transaksi</label>
                <select name="transaction_status" id="" class="form-control">
                    <option value="IN_CART" {{($item->transaction_status == 'IN_CART') ? 'selected' : ''}}>In Cart</option>
                    <option value="PENDING" {{($item->transaction_status == 'PENDING') ? 'selected' : ''}}>Pending</option>
                    <option value="SUCCESS" {{($item->transaction_status == 'SUCCESS') ? 'selected' : ''}}>Success</option>
                    <option value="CANCEL" {{($item->transaction_status == 'CANCEL') ? 'selected' : ''}}>Cancel</option>
                    <option value="FAILED" {{($item->transaction_status == 'FAILED') ? 'selected' : ''}}>Failed</option>
                </select>
            </div>
            <button class="btn btn-primary btn-block">Ubah</button>
        </form>
    </div>
</div>
@endsection