@extends('layouts.admin')


@section('content')
<!-- Content Row -->
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{$subtitle}}</h1>
</div>
@if (session('sukses'))
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h5><i class="icon fas fa-check"></i> Alert!</h5>
    {{session('sukses')}}
</div>
@endif
<div class="card-body">
    <div class="table-responsive">
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
                    <th>Created</th>
                    <th>action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <button class="btn btn-danger" id="multidelete">Multi Delete</button>
</div>

<!-- boostrap add and edit travel package -->
<div class="modal fade" id="ajax-travel-model" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="ajaxTravelModel"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger print-error-msg" style="display:none">
                    <ul></ul>
                </div>
                <form action="javascript:void(0)" id="addEditTransForm" name="addEditTransForm" class="form-horizontal" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="transaction_status">Status Transaksi</label>
                        <div class="col-sm-12">
                            <select name="transaction_status" id="transaction_status" class="form-control">
                                <option value="" selected>Tidak Di ubah</option>
                                <option value="IN_CART">In Cart</option>
                                <option value="PENDING">Pending</option>
                                <option value="SUCCESS">Success</option>
                                <option value="CANCEL">Cancel</option>
                                <option value="FAILED">Failed</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="btn-save" value="addNewTravel">Save changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end bootstrap model -->
@endsection
@push('prepend-style')
<!-- Custom styles for this page -->
<link href="{{url('backend')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush
@push('script-add')
<!-- Page level plugins -->
<script src="{{url('backend')}}/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="{{url('backend')}}/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script>
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
            ajax: "{{ url('/admin/transactions') }}",
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
                    data: 'created_at',
                    name: 'created_at'
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
                    $("#delete").html('loading..');
                    $("#delete").attr("disabled", 'disabled');
                    $.ajax({
                        type: "POST",
                        url: "{{ url('/admin/transactions/delete') }}",
                        data: {
                            data: id,
                            multi: null
                        },
                        dataType: 'json',
                        success: function(res) {
                            var oTable = $('#transactions').dataTable();
                            oTable.fnDraw(false);
                            $("#delete").removeAttr("disabled");
                            $("#delete").html('Delete');
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
                    url: "{{ url('/admin/transactions/delete') }}",
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
                            $("#multidelete").html('Delete');
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                        } else {
                            $("#multidelete").removeAttr("disabled");
                            $("#multidelete").html('Select Delete');
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

<script>
    window.setTimeout(function() {
        $(".alert-success").fadeTo(200, 0).slideUp(200, function() {
            $(this).remove();
        });
    }, 3000);
</script>
@endpush