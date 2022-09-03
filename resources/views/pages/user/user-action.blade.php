<?php if ($transaction_status == 'PENDING') { ?>
    <a href="{{url('/checkout/'.$id_trans)}}" class="edit btn btn-info edit">
        Melanjutkan
    </a>
<?php } ?>
<?php if ($transaction_status != 'SUCCESS') { ?>
    <a href="javascript:void(0);" id="delete-book" data-toggle="tooltip" data-original-title="Delete" data-id="{{ $id_trans }}" class="delete btn btn-danger mt-2">
        Batal
    </a>
<?php } ?>