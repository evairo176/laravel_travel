@extends('layouts.success')

@section('content')
<main>
    <div class="section-success d-flex align-items-center">
        <div class="col text-center">
            <img src="{{url('frontend')}}/images/ic_mail.png" alt="">
            <h1>Opps!</h1>
            <p>Your transaction is unfinish
                <br>
                please read it as well
            </p>
            <a href="{{url('/')}}" class="btn btn-home-pages mt-3 px-5">Home Page</a>
        </div>
    </div>
</main>
@endsection