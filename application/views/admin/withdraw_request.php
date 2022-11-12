<?php $this->load->view('admin/include/head'); ?>

<?php $this->load->view('admin/include/navbar'); ?>
<?php $this->load->view('admin/include/sidebar'); ?>


<div class="page-content">
    <div class="container-fluid">
        <?php $this->load->view('admin/include/breadcrumb'); ?>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>S. No</th>
                                        <th>Withdraw Amount</th>
                                        <th>Paypal Email</th>
                                        <th>Transaction ID</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Approve/Disapprove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($history)) : ?>
                                        <?php $serial = 1;
                                        foreach ($history as $h) : ?>
                                            <tr>
                                                <td><?php echo $serial++; ?></td>
                                                <td><?php echo $h['withdraw_amount']; ?></td>
                                                <td><?php echo $h['paypal_email']; ?></td>
                                                <td><?php echo ($h['transaction_id'] != '') ? $h['transaction_id'] : 'N/A'; ?></td>
                                                <td><?php echo date('d/m/Y h:i:s', strtotime($h['created_at'])); ?></td>
                                                <td>
                                                    <?php if ($h['status'] == 0) : ?>
                                                        <?php echo 'Failed'; ?>
                                                    <?php elseif ($h['status'] == 1) : ?>
                                                        <?php echo 'Success'; ?>
                                                    <?php else : ?>
                                                        <?php echo 'Pending'; ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if ($h['status'] == 0) : ?>
                                                        <button type="button" class="btn btn-danger" disabled>Disapproved</button>
                                                    <?php elseif ($h['status'] == 1) : ?>
                                                        <button type="button" class="btn btn-success" disabled>Approved</button>
                                                    <?php else : ?>
                                                        <a href="javascript:void(0);" data-toggle="modal" data-target=".payment_status" onclick="attachId(<?php echo $h['wallet_id'] ?>)" class="btn btn-success">Approve</a>
                                                        <a href="javascript:void(0);" class="btn btn-danger" onclick="disapprovePayment(<?php echo $h['wallet_id'] ?>)">Disapprove</a>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="10">No Data Found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade payment_status" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myLargeModalLabel">Payment Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="add_payment" action="<?php echo base_url('admin/approve_payment') ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Transaction Id</label>
                            <input type="hidden" name="wallet_id" id="wall_id">
                            <input type="text" name="transaction_id" placeholder="Enter Transaction Id" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Image</label>
                            <input type="file" name="image" placeholder="Enter" class="form-control" accept="image/*">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php $this->load->view('admin/include/footer'); ?>
<?php $this->load->view('admin/include/foot'); ?>

<script>
    function attachId(id) {
        $('#wall_id').val(id);
    }

    function disapprovePayment(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to disapprove this withdraw request ?",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('admin/disapprove_payment'); ?>",
                    data: {
                        wallet_id: id,
                    },
                    success: function(data) {
                        Swal.fire('Success','Payment disapproved','success').then(() => {
                            location.reload();
                        });
                    }
                });
            }
        })
    }

    $('#add_payment').validate({
        rules: {
            transaction_id: {
                required: true
            },
            image: {
                required: true
            }
        },
    });
</script>
<?php if (isset($_SESSION['success']) && $_SESSION['success'] != '') : ?>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        Toast.fire({
            icon: 'success',
            title: 'Payment approved successfully.'
        });
    </script>
<?php
    unset($_SESSION['success']);
endif; ?>