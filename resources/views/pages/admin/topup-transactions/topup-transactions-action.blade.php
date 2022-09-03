<?php if ($transaction_status == 'PENDING') { ?>
    <a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $id_trans }}" data-original-title="Edit" class="edit btn btn-warning edit">
        <i class="fas fa-edit"></i>
    </a>
<?php } ?>
<?php if ($transaction_status != 'SUCCESS') { ?>
    <a href="javascript:void(0);" id="delete-book" data-toggle="tooltip" data-original-title="Delete" data-id="{{ $id_trans }}" class="delete btn btn-danger">
        <i class="fas fa-trash"></i>
    </a>
<?php } ?>