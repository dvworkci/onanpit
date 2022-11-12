<?php $this->load->view('admin/include/head'); ?>

<?php $this->load->view('admin/include/navbar'); ?>
<?php $this->load->view('admin/include/sidebar'); ?>


<div class="page-content">
    <div class="container-fluid">
        <?php $this->load->view('admin/include/breadcrumb'); ?>
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <form action="<?php echo base_url('admin/update_settings') ?>" method="POST">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>Referral Amount</label>
                                    <input type="number" placeholder="Enter Referral Amount" name="referral_amount" value="<?= $setting['referral_amount'] ?>" id="" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Ad-Mob Publisher ID</label>
                                    <input type="text" placeholder="Enter Ad-Mob Publisher ID" name="ad_mob_pub_id" value="<?= $setting['ad_mob_pub_id'] ?>" id="" class="form-control">
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Ad-Mob Ad ID</label>
                                    <input type="text" placeholder="Enter Ad-Mob Ad ID" name="ad_mob_ad_id" value="<?= $setting['ad_mob_ad_id'] ?>" id="" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Paytm Key</label>
                                    <input type="text" placeholder="Enter Paytm Key" name="paytm_key" value="<?= $setting['paytm_key'] ?>" id="" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Paypal Key</label>
                                    <input type="text" placeholder="Enter Paypal Key" name="paypal_key" value="<?= $setting['paypal_key'] ?>" id="" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Default Dollar to User</label>
                                    <input type="text" placeholder="Enter Dollar Balance to User" name="default_dollar_to_user" value="<?= $setting['default_dollar_to_user'] ?>" id="" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Boost MH</label>
                                    <input type="text" placeholder="Enter Boost MH Value" name="boost_mh" value="<?= $setting['boost_mh'] ?>" id="" class="form-control">
                                </div>

                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>


                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/include/footer'); ?>
<?php $this->load->view('admin/include/foot'); ?>

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
            title: 'Settings updated successfully.'
        });
    </script>
<?php 
unset($_SESSION['success']);
endif; ?>