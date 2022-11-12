<?php $this->load->view('admin/include/head'); ?>

<?php $this->load->view('admin/include/navbar'); ?>
<?php $this->load->view('admin/include/sidebar'); ?>


<div class="page-content">
    <div class="container-fluid">
        <?php $this->load->view('admin/include/breadcrumb'); ?>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- <div class="header">
                                <div class="row mt-3 mr-2">
                                    <div class="col-md-12 text-right">
                                        <a href="javascript:void(0);" data-toggle="modal" data-target=".add" class="btn btn-primary">Create</a>
                                    </div>
                                </div>
                            </div> -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>S. No</th>
                                        <th>Email</th>
                                        <th>Dollar</th>
                                        <th>MH/s</th>
                                        <th>Referral Code</th>
                                        <th>Last Login</th>
                                        <th>Status</th>
                                        <th>Transaction history</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/include/footer'); ?>
<?php $this->load->view('admin/include/foot'); ?>

<script>
    $(document).ready(function() {
        // DATATABLE TO FETCH DATA FROM CONTROLLER ASYNCRONOUSLY
        var dataTable = $('#datatable').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "<?php echo base_url('get_users') ?>",
                type: "POST"
            },
            "columnDefs": [{
                "target": [0, 3, 4],
                "orderable": false
            }]
        }); // DATATABLE END

        // CHANGE STATUS
        $(document).on('click','.change_status',function() {
            const user_id = $(this).attr("id");
            const status = $(this).data("status");
            const table = 'users';

            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>Admin/change_status",
                data: {
                    user_id: user_id,
                    status:status,
                    table:table
                },
                success: function(data) {
                    $('#datatable').DataTable().ajax.reload(null, false);
                }
            });
        });
    });
</script>