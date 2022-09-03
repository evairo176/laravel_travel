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
                                Dashboard
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 pl-lg-0">
                    <div class="card card-details">
                        <h3>Riwayat Transaksi</h3>
                        <hr>
                        <div class="table table-responsive">
                            <table id="transactions" class="table table-bordered table-hover table-striped" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Select</th>
                                        <th>Travel</th>
                                        <th>User</th>
                                        <th>Visa</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <button class="btn btn-danger" id="multidelete">Select Delete</button>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card card-details card-right">
                        <h2>Profil User</h2>
                        <div class="members my-2 text-center">
                            <img src="https://ui-avatars.com/api/?name={{auth()->user()->username}}" alt="" class="w-75" />
                        </div>
                        <hr />
                        <h2>User Informations</h2>
                        <table class="trip-informations">
                            <tr>
                                <th width="50%">Name</th>
                                <td width="50%" class="text-right">{{auth()->user()->name}}</td>
                            </tr>
                            <tr>
                                <th width="50%">Alamat</th>
                                <td width="50%" class="text-right">CIlandak</td>
                            </tr>
                            <tr>
                                <th width="50%">Saldo</th>
                                <td width="50%" class="text-right">${{auth()->user()->saldo}},00 Rupiah</td>
                            </tr>
                            <tr>
                                <th width="50%">Date</th>
                                <td width="50%" class="text-right">{{auth()->user()->created_at}}</td>
                            </tr>
                        </table>
                        <hr>
                        <h2>Payment Instructions</h2>
                        <p class="payment-intructions">You will be redirect to another page to pay using Indomaret</p>
                        <img src="{{url('frontend/images/indomaret.png')}}" class="w-50" alt="">
                    </div>
                    <div class="join-container">
                        <a href="{{route('checkout-prosses')}}" class="btn btn-block btn-top-up mt-3 py-2">Top Up Saldo</a>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
</main>
@endsection

@push('prepend-style')
<link rel="stylesheet" href="{{url('frontend')}}/libraries/xzoom/dist/xzoom.css" />

<!-- Custom styles for this page -->
<link href="{{url('backend')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

@endpush

@push('addon-script')
<script src="{{url('frontend')}}/libraries/xzoom/dist/xzoom.min.js"></script>

<!-- Page level plugins -->
<script src="{{url('backend')}}/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="{{url('backend')}}/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script>
    $(document).ready(function() {
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
        $('#image').change(function() {

            let reader = new FileReader();
            reader.onload = (e) => {
                $('#preview-image').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);

        });
        $('#transactions').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('/user/dashboard') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'cek',
                    name: 'cek',
                    orderable: false
                },
                {
                    data: 'name_title',
                    name: 'name_title',
                },
                {
                    data: 'name_users',
                    name: 'name_users'
                },
                {
                    data: 'additional_visa',
                    name: 'additional_visa'
                },
                {
                    data: 'transaction_total',
                    name: 'transaction_total'
                },
                {
                    data: 'transaction_status',
                    name: 'transaction_status'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false
                },
            ],
            order: [
                [0, 'desc']
            ]
        });
        $('#addNewTravel').click(function() {
            $('#addEditTransForm').trigger("reset");
            $('#ajaxTravelModel').html("Add Travel");
            $('#ajax-travel-model').modal('show');
            $("#image").attr("required", "true");
            $('#id').val('');
            $('#preview-image').attr('src', 'https://www.riobeauty.co.uk/images/product_image_not_found.gif');
        });

        $('body').on('click', '.edit', function() {
            var id = $(this).data('id');
            // ajax
            $.ajax({
                type: "POST",
                url: "{{ url('/admin/transactions/edit') }}",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(res) {
                    $('#ajaxTravelModel').html("Edit Travel");
                    $('#ajax-travel-model').modal('show');
                    $('#id').val(res.id);
                    $('#transaction_status').val(res.transaction_status);
                }
            });
        });
        // bagian delete 
        $('body').on('click', '.delete', function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#delete-book").html('loading..');
                    $("#delete-book").attr("disabled", 'disabled');
                    $.ajax({
                        type: "POST",
                        url: "{{ url('/user/transactions/delete') }}",
                        data: {
                            data: id,
                            multi: null
                        },
                        dataType: 'json',
                        success: function(res) {
                            var oTable = $('#transactions').dataTable();
                            oTable.fnDraw(false);
                            $("#delete-book").removeAttr("disabled");
                            $("#delete-book").html('Submit');
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                        }
                    });
                }
            })
        });
        $('body').delegate('#addEditTransForm', 'submit', function(e) {
            e.preventDefault();
            $("#btn-save").html('loading..');
            $("#btn-save").attr("disabled", 'disabled');
            var formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: "{{ url('/admin/transactions/store')}}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    $("#btn-save").removeAttr("disabled");
                    $("#btn-save").html('Submit');
                    if ($.isEmptyObject(data.error)) {
                        console.log(data);
                        $("#ajax-travel-model").modal('hide');
                        var oTable = $('#transactions').dataTable();
                        oTable.fnDraw(false);
                        Swal.fire({
                            position: 'top',
                            icon: 'success',
                            title: 'Success',
                            showConfirmButton: false,
                            timer: 1500
                        });

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

    //multi delete
    let dataCek = [];
    $(document).on('change', '.ceks', function() {
        let id = $(this).attr('id');
        if ($(this).is(':checked')) {
            dataCek.push(id);
            console.log(dataCek);
        } else {
            let index = dataCek.indexOf(id);
            if (index > -1) {
                dataCek.splice(index, 1);
            }
            console.log(dataCek);
        }
    });

    $(document).on('click', '#multidelete', function() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $("#multidelete").html('loading..');
                $("#multidelete").attr("disabled", 'disabled');
                $.ajax({
                    type: "POST",
                    url: "{{ url('/user/transactions/delete') }}",
                    data: {
                        data: dataCek,
                        multi: 1
                    },
                    dataType: 'json',
                    success: function(res) {
                        console.log(dataCek);
                        if (dataCek != '') {
                            dataCek = [];
                            console.log(dataCek);
                            var oTable = $('#transactions').dataTable();
                            oTable.fnDraw(false);
                            $("#multidelete").removeAttr("disabled");
                            $("#multidelete").html('Submit');
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                        } else {
                            Swal.fire({
                                position: 'top',
                                icon: 'warning',
                                title: 'Opps!',
                                text: res.text,
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                    }
                });
            }
        })
    });

    function printErrorMsg(msg) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display', 'block');
        $.each(msg, function(key, value) {
            $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
        });
    }
</script>
@endpush