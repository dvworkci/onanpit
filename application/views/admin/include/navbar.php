<div id="layout-wrapper">
    <header id="page-topbar">
        <div class="navbar-header">
            <div class="d-flex">
                <div class="navbar-brand-box">
                    <a href="javascript:void(0);" class="logo logo-light">
                        <span class="logo-sm">
                            <!-- <img src="<?= base_url();?>assets/admin/default/images/logo.png" alt=""> -->
                        </span>
                        <span class="logo-lg">
                            <!-- <img src="<?= base_url();?>assets/admin/default/images/logo.png" alt="" width=""> -->
                            <h5>Tip Nano</h5>
                        </span>
                    </a>
                </div>
              <!--   <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">=
                    <img src="<?= base_url();?>assets/admin/default/images/bar.png" alt="">
                </button> -->
            </div>

            <div class="d-flex ">
                <div class="dropdown d-inline-block">
                 
                </div>
                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        
                        <img class="rounded-circle header-profile-user" src="<?= base_url();?>assets/admin/default/images/user1.png"
                            alt="user">
                        <span class="d-none d-xl-inline-block ml-1"><?php echo $this->session->userdata('admin')['user_name']; ?></span>
                        <i class="bx bx-chevron-down d-none d-xl-inline-block"></i>
                        
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">                   
                        <!-- <a class="dropdown-item" href="<?= base_url('profile');?>"><i class="bx bx-user font-size-16 align-middle mr-1"></i> Profile</a>
                        <div class="dropdown-divider"></div> -->
                        <a class="dropdown-item text-danger" href="<?= base_url('Admin/logout');?>"><i class="bx bx-power-off font-size-16 align-middle mr-1 text-danger"></i> Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </header> 

