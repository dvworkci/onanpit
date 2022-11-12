<?php $this->load->view('admin/include/head');?>
    <!-- <div class="home-btn d-none d-sm-block">
        <a href="<?= base_url();?>" class="text-dark"><i class="fas fa-home h2"></i></a>
    </div> -->
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-soft-primary">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary p-4">
                                        <h5 class="text-primary">Welcome Back !</h5>
                                        <p>Sign in to continue to New Staff.</p>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img src="<?= base_url();?>assets/admin/default/images/profile-img.png" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0"> 
                            <div>
                                <a href="index-2.html">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <img src="<?= base_url();?>assets/admin/default/images/icon.png" width="100%" alt="" class="rounded-circle" height="34">
                                        </span>
                                    </div>
                                </a>
                            </div>
                            <div class="p-2">
                            <?php if($this->session->flashdata("message")){ ?>
                                <div class = "alert alert-danger">
                                <?php echo $this->session->flashdata("message"); ?> 
                                </div>

                            <?php } ?>
                            <?php if($this->session->flashdata("success")){ ?>
                                <div class = "alert alert-success">
                                <?php echo $this->session->flashdata("success"); ?> 
                                </div>

                            <?php } ?>
                                <form class="form-horizontal" action="<?php echo base_url();?>admin/login" method = "POST" id = "login_form">
    
                                    <div class="form-group">
                                        <label for="username">Email</label>
                                        <input type="email" class="form-control" id="email" name = "email" placeholder="Enter Email">
                                    </div>
            
                                    <div class="form-group">
                                        <label for="userpassword">Password</label>
                                        <input type="password" class="form-control" id="userpassword" name = "password" placeholder="Enter password">
                                    </div>
            
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customControlInline">
                                        <label class="custom-control-label" for="customControlInline">Remember me</label>
                                    </div>
                                    
                                    <div class="mt-3">
                                        <!-- <a href="<?= base_url('dashboard');?>" class="btn btn-primary btn-block waves-effect waves-light" type="submit">Log In</a> -->
                                        <button type = "submit" class="btn btn-primary btn-block waves-effect waves-light" >Log in</button>
                                    </div>
        
                                    <div class="mt-4 text-center">
                                        <a href="<?= base_url('forget');?>" class="text-muted"><i class="mdi mdi-lock mr-1"></i> Forgot your password?</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $this->load->view('admin/include/foot');?>

<script>
        $(document).ready(function() {
        $("#login_form").validate({
        rules: {
            email: {
                required: true,
                email:true,
            },
            password: {
                required: true,
            },
        },
        messages: {
            email: {
                required: "Email id is required",
                email:"Please enter valid email id",
            },
            password: {
                required: "Password is required",
            },
            
        }
    });
});
</script>
