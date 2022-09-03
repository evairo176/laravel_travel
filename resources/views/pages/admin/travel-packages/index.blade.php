@extends('layouts.admin')


@section('content')
<!-- Content Row -->
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{$subtitle}}</h1>
    <button type="button" id="addNewTravel" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"> <i class="fas fa-plus fa-sm text-white-50"></i>Add</button>
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
        <table id="travelpackage" class="table table-bordered table-hover table-striped" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Select</th>
                    <th>Title</th>
                    <th>Location</th>
                    <th>Departure Date</th>
                    <th>Type</th>
                    <th>Image</th>
                    <th>Created</th>
                    <th>action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    <button class="btn btn-danger" id="multidelete">Select Delete</button>
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
                <form action="javascript:void(0)" id="addEditTravelForm" name="addEditTravelForm" class="form-horizontal" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="title" id="title" placeholder="Judul" value="{{old('title')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="location">Location</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="location" id="location" placeholder="Location" value="{{old('location')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="title">About</label>
                        <div class="col-sm-12">
                            <textarea name="about" id="about" cols="30" rows="10" class="d-block w-100 form-control">{{old('about')}}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="featured_event">Featured Event</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="featured_event" id="featured_event" placeholder="Featured Event" value="{{old('featured_event')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="language">Language</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="language" id="language" placeholder="Language" value="{{old('language')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="foods">Foods</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="foods" id="foods" placeholder="Foods" value="{{old('foods')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="departure_date">Departure Date</label>
                        <div class="col-sm-12">
                            <input type="date" class="form-control" name="departure_date" id="departure_date" placeholder="Departure Date" value="{{old('departure_date')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="duration">Duration</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="duration" id="duration" placeholder="Duration" value="{{old('duration')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="type">Type</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="type" id="type" placeholder="Type" value="{{old('type')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" name="price" id="price" placeholder="Price" value="{{old('price')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Travel Image</label>
                        <div class="col-sm-6 pull-left">
                            <input type="file" class="form-control" id="image" name="image" placeholder="Image" value="{{old('image')}}" required="">
                        </div>
                        <div class="col-sm-6 pull-right">
                            <img id="preview-image" src="https://www.riobeauty.co.uk/images/product_image_not_found.gif" alt="preview image" style="max-height: 250px;">
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
        $('#travelpackage').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('/admin/travel-packages') }}",
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
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'location',
                    name: 'location'
                },
                {
                    data: 'departure_date',
                    name: 'departure_date'
                },
                {
                    data: 'type',
                    name: 'type'
                },
                {
                    data: 'image',
                    name: 'image',
                    orderable: false
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
            $('#addEditTravelForm').trigger("reset");
            $('#ajaxTravelModel').html("Add Travel");
            $('#ajax-travel-model').modal('show');
            $("#image").attr("required", "true");
            $('#id').val('');
            $('#preview-image').attr('src', 'https://www.riobeauty.co.uk/images/product_image_not_found.gif');
        });

        $('body').on('click', '.edit', function() {
            var id = $(this).data('id');
            var urlimage = "{{url('assets/gallery')}}";
            // ajax
            $.ajax({
                type: "POST",
                url: "{{ url('/admin/travel-packages/edit') }}",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(res) {
                    $('#ajaxTravelModel').html("Edit Travel");
                    $('#ajax-travel-model').modal('show');
                    $('#id').val(res.id);
                    $('#title').val(res.title);
                    $('#location').val(res.location);
                    $('#about').val(res.about);
                    $('#featured_event').val(res.featured_event);
                    $('#language').val(res.language);
                    $('#foods').val(res.foods);
                    $('#departure_date').val(res.departure_date);
                    $('#duration').val(res.duration);
                    $('#type').val(res.type);
                    $('#price').val(res.price);
                    $('#preview-image').attr('src', urlimage + '/' + res.image);
                    $('#image').removeAttr('required');
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
                        url: "{{ url('/admin/travel-packages/delete') }}",
                        data: {
                            data: id,
                            multi: null
                        },
                        dataType: 'json',
                        success: function(res) {
                            var oTable = $('#travelpackage').dataTable();
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
        $('body').delegate('#addEditTravelForm', 'submit', function(e) {
            e.preventDefault();
            $("#btn-save").html('loading..');
            $("#btn-save").attr("disabled", 'disabled');
            var formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: "{{ url('/admin/travel-packages/store')}}",
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
                        var oTable = $('#travelpackage').dataTable();
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
                    url: "{{ url('/admin/travel-packages/delete') }}",
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
                            var oTable = $('#travelpackage').dataTable();
                            oTable.fnDraw(false);
                            $("#multidelete").removeAttr("disabled");
                            $("#multidelete").html('Select Delete');
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

    window.setTimeout(function() {
        $(".alert-success").fadeTo(200, 0).slideUp(200, function() {
            $(this).remove();
        });
    }, 3000);

    function printErrorMsg(msg) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display', 'block');
        $.each(msg, function(key, value) {
            $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
        });
    }
</script>
@endpush