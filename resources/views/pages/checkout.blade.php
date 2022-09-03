<?php if ($item->transaction_status != 'IN_CART') { ?>
    @extends('layouts.success')

    @section('content')
    <main>
        <div class="section-success d-flex align-items-center">
            <div class="col text-center">
                <img src="{{url('frontend')}}/images/ic_mail.png" alt="">
                <h1>Opps!</h1>
                <p>You Cannot Access Page Again!!!
                    <br>
                    please try again
                </p>
                <a href="{{url('/')}}" class="btn btn-home-pages mt-3 px-5">Home Page</a>
            </div>
        </div>
    </main>
    @endsection
<?php } else { ?>
    @extends('layouts.checkout')

    @section('content')
    <main>
        <section class="section-details-header"></section>
        <section class="section-details-content">
            <div class="container">
                <div class="row">
                    <div class="col p-0">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item" aria-current="page">
                                    Paket Travel
                                </li>
                                <li class="breadcrumb-item" aria-current="page">
                                    Details
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Checkout
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 pl-lg-0">
                        <div class="card card-details">
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            @if (session('error'))
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h5><i class="icon fas fa-check"></i> Alert!</h5>
                                {{session('error')}}
                            </div>
                            @endif
                            @if (session('sukses'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h5><i class="icon fas fa-check"></i> Alert!</h5>
                                {{session('sukses')}}
                            </div>
                            @endif
                            <h1>Who is Going?</h1>
                            <p>
                                Trip to {{$item->travel_package->title}}, {{$item->travel_package->location}}
                            </p>
                            <div class="attende">
                                <table class="table table-sm-responsive text-center">
                                    <thead>
                                        <tr>
                                            <th>Picture</th>
                                            <th>Name</th>
                                            <th>Nationality</th>
                                            <th>VISA</th>
                                            <th>Passport</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($item->details as $details)
                                        <tr>
                                            <td><img src="https://ui-avatars.com/api/?name={{$details->username}}" class="rounded-circle" alt=""></td>
                                            <td>{{$details->username}}</td>
                                            <td>{{$details->nationality}}</td>
                                            <td>{{$details->is_visa ? '30 Days' : 'N/A'}}</td>
                                            <td>{{\Carbon\Carbon::createFromDate($details->doe_passport) > 
                                            \Carbon\Carbon::now() ? 'Active' : 'Inactive'}}</td>
                                            <td><a href="{{route('checkout-remove',$details->id)}}"><img src="{{url('frontend')}}/images/ic_remove.png" alt=""></a></td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No Visitor</td>
                                        </tr>
                                        @endforelse

                                    </tbody>
                                </table>
                            </div>
                            <div class="member">
                                <h2>Add Member</h2>
                                <form action="{{route('checkout-create',$item->id)}}" method="post" class="form-inline">
                                    @csrf
                                    <label for="username" class="sr-only">Name</label>
                                    <input type="text" class="form-control mb-2 mr-sm-2" name="username" placeholder="Username">
                                    <label for="nationality" class="sr-only">Nationality</label>
                                    <input type="text" class="form-control mb-2 mr-sm-2" name="nationality" style="width: 50px" id="nationality" placeholder="Nationality">
                                    <label for="is_visa" class="sr-only">Visa</label>
                                    <select id="is_visa" name="is_visa" class="form-control mb-2 mr-sm-2">
                                        <option value="" selected>VISA</option>
                                        <option value="1">30 Days</option>
                                        <option value="0">N/A</option>
                                    </select>
                                    <label for="doePassport" class="sr-only">Doe Passport</label>
                                    <div class="input-group mb-2 mr-sm-2">
                                        <input type="text" class="form-control datepicker" width="180" name="doe_passport" id="doePassport" placeholder="Doe Passport">
                                    </div>
                                    <button type="submit" class="btn btn-add-now mb-2 px-4">Add Now</button>
                                </form>
                                <h3 class="mt-3 mb-0">Note</h3>
                                <p class="disclaimer mb-0">You are only able to invite member that has registered in Nomads.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card card-details card-right">
                            <h2>Checkout Informations</h2>
                            <table class="trip-informations">
                                <tr>
                                    <th width="50%">Members</th>
                                    <td width="50%" class="text-right">{{$item->details->count()}} person</td>
                                </tr>
                                <tr>
                                    <th width="50%">Additional VISA</th>
                                    <td width="50%" class="text-right">$ {{$item->additional_visa}},00</td>
                                </tr>
                                <tr>
                                    <th width="50%">Trip Price</th>
                                    <td width="50%" class="text-right">$ {{$item->travel_package->price}},00 / person</td>
                                </tr>
                                <tr>
                                    <th width="50%">Sub Total</th>
                                    <td width="50%" class="text-right">$ {{$item->transaction_total}},00</td>
                                </tr>
                                <tr>
                                    <th width="50%">Total (+Unique Code)</th>
                                    <td width="50%" class="text-right text-total">
                                        <span class="text-blue">$ {{$item->transaction_total}},</span>
                                        <span class="text-orange">{{mt_rand(0,99)}}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th width="50%">Total Saldo (+Unique Code)</th>
                                    <td width="50%" class="text-right text-total">
                                        <span class="text-blue">$ {{auth()->user()->saldo}},</span>
                                        <span class="text-orange">{{mt_rand(0,99)}}</span>
                                    </td>
                                </tr>
                            </table>
                            <hr>
                            <h2>Payment Instructions</h2>
                            <p class="payment-intructions">You will be redirect to another page to pay using Indomaret</p>
                            <img src="{{url('frontend/images/indomaret.png')}}" class="w-50" alt="">
                            <form action="{{url('/checkout/confirm/'.$item->id)}}" method="post">
                                @csrf
                                <label for="">Pilih Metode Pembayaran</label>
                                <select name="payment" id="" class="form-control">
                                    <option value="">Pilih Payment</option>
                                    <option value="indomaret">Indomaret</option>
                                    <option value="saldo">Saldo</option>
                                </select>
                        </div>
                        <div class="join-container">
                            <button type="submit" class="btn btn-block btn-join-now mt-3 py-2">Procces payment</button>
                        </div>
                        </form>
                        <div class="text-center mt-3">
                            <a href="{{route('detail',$item->travel_package->slug)}}" class="text-muted">
                                Cancel Booking
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    @endsection
    @push('prepend-style')
    <link rel="stylesheet" href="{{url('frontend')}}/libraries/gijgo/css/gijgo.css" />
    @endpush

    @push('addon-script')
    <script src="{{url('frontend')}}/libraries/gijgo/js/gijgo.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                uiLibrary: 'bootstrap4',
                icons: {
                    rightIcon: '<img src="{{url("frontend")}}/images/ic_doe.png"/>'
                }
            })
        });
    </script>
    @endpush
<?php } ?>