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
                                        <p>Forget Your Password.</p>
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
                                            <img src="<?= base_url();?>assets/admin/default/images/icon.png"  width="100%"  alt="" class="rounded-circle" height="34">
                                        </span>
                                    </div>
                                </a>
                            </div>
                            <div class="p-2">
                                <form class="form-horizontal" action="">
    
                                    <div class="form-group">
                                        <label for="username">Email</label>
                                        <input type="Email" class="form-control" id="email" placeholder="Enter Email">
                                    </div>
                                    <div class="mt-3">
                                        <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Forget Password</button>
                                    </div>
        
                                    <div class="mt-4 text-center">
                                        <a href="<?= base_url('dashboard');?>" class="text-muted"><i class="mdi mdi-lock mr-1"></i>Back to Login</a>
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