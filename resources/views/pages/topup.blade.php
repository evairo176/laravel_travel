<?php if ($item->transaction_status != 'PENDING') { ?>
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
    @extends('layouts.app')

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
                                <li class="breadcrumb-item active" aria-current="page">
                                    Top Up
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-5 col-md-6 col-sm-12">
                        <div class="card card-details">
                            <ul class="position-btn-harga-top-up">
                                <li class="btn-harga-top-up">
                                    <label class="label-harga">10000
                                        <input type="radio" checked="checked" name="radio">
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                <li class="btn-harga-top-up">
                                    <label class="label-harga">15000
                                        <input type="radio" checked="checked" name="radio">
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                <li class="btn-harga-top-up">
                                    <label class="label-harga">20000
                                        <input type="radio" checked="checked" name="radio">
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                <li class="btn-harga-top-up">
                                    <label class="label-harga">25000
                                        <input type="radio" checked="checked" name="radio">
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                <li class="btn-harga-top-up">
                                    <label class="label-harga">50000
                                        <input type="radio" checked="checked" name="radio">
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                <li class="btn-harga-top-up">
                                    <label class="label-harga">75000
                                        <input type="radio" checked="checked" name="radio">
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                <li class="btn-harga-top-up">
                                    <label class="label-harga">100000
                                        <input type="radio" checked="checked" name="radio">
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                <li class="btn-harga-top-up">
                                    <label class="label-harga">250000
                                        <input type="radio" checked="checked" name="radio">
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                <li class="btn-harga-top-up">
                                    <label class="label-harga">500000
                                        <input type="radio" checked="checked" name="radio">
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                <li class="btn-harga-top-up">
                                    <label class="label-harga">750000
                                        <input type="radio" checked="checked" name="radio">
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                <li class="btn-harga-top-up">
                                    <label class="label-harga">1000000
                                        <input type="radio" checked="checked" name="radio">
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                <li class="btn-harga-top-up">
                                    <label class="label-harga">1500000
                                        <input type="radio" checked="checked" name="radio">
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-6 col-sm-12">
                        <div class="card card-details card-right">
                            <h2>Profil User</h2>
                            <hr>
                            <h2>User Informations</h2>
                            <table class="trip-informations">
                                <table class="trip-informations">
                                    <tr>
                                        <th width="50%">Name</th>
                                        <td width="50%" class="text-right">{{auth()->user()->name}}</td>
                                    </tr>
                                    <tr>
                                        <th width="50%">Saldo</th>
                                        <td width="50%" class="text-right" id="saldo">{{auth()->user()->saldo}}</td>
                                    </tr>
                                    <tr>
                                        <th width="50%">Alamat</th>
                                        <td width="50%" class="text-right" id="sisa_saldo">CIlandak</td>
                                    </tr>
                                </table>
                            </table>
                            <hr>
                            <div class="join-container">
                                <form id="topup" action="" method="POST">
                                    <label for="">Jumlah</label>
                                    <input id="id_transaction" type="hidden" value="{{$item->id}}" class="form-control" name="id_transaction">
                                    <input id="disini" class="form-control" name="saldo">
                                    <button type="submit" id="btn-save" class="btn btn-save btn-top-up form-control">Top Up</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1 "></div>
                </div>
            </div>
        </section>
    </main>
    @endsection

    @push('prepend-style')
    <link rel="stylesheet" href="{{url('frontend')}}/libraries/xzoom/dist/xzoom.css" />
    @endpush

    @push('addon-script')
    <script src="{{url('frontend')}}/libraries/xzoom/dist/xzoom.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script>
        $(document).ready(function() {
            $('.btn-harga-top-up').click(function() {
                var saldo = document.getElementById("myBtn").textContent;
                console.log(saldo);
                // console.log($(this).text());
                $('.btn-harga-top-up').removeClass('active');
                $(this).toggleClass('active');
                $('#disini').val($(this).text());
                // $('#disini').val($(this).text());
            });
            $('.xzoom, .xzoom-gallery').xzoom({
                zoomWidth: 500,
                title: false,
                tint: '#333',
                Xoffset: 15
            });
        });
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('body').delegate('#topup', 'submit', function(e) {
                e.preventDefault();
                $("#btn-save").html('loading..');
                $("#btn-save").attr("disabled", 'disabled');
                var id = $('#id_transaction').val();
                var formData = new FormData(this);
                var urlcreate = "{{ url('/checkout-top-up/confirm')}}"

                $.ajax({
                    type: 'POST',
                    url: urlcreate + '/' + id,
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        $("#btn-save").removeAttr("disabled");
                        $("#btn-save").html('Submit');
                        if ($.isEmptyObject(data.error)) {
                            console.log(data.message);
                            Swal.fire({
                                position: 'top',
                                icon: 'success',
                                title: 'Success',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            setTimeout(function() {
                                window.location.href = "{{ url('/user/dashboard')}}";
                            }, 1500);
                        } else {
                            $('#preview-image').attr('src', 'https://www.riobeauty.co.uk/images/product_image_not_found.gif');
                            printErrorMsg(data.error);
                        }
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            });
        });
    </script>
    @endpush
<?php } ?>