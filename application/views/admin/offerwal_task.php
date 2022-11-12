<?php $this->load->view('admin/include/head');?>

    <?php $this->load->view('admin/include/navbar');?>
    <?php $this->load->view('admin/include/sidebar');?>
           

        <div class="page-content">
            <div class="container-fluid">             
                <?php $this->load->view('admin/include/breadcrumb');?>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="header">
                                <div class="row mt-3 mr-2">
                                    <div class="col-md-12 text-right">
                                        <a href="javascript:void(0);" data-toggle="modal" data-target=".add" class="btn btn-primary">Create</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>S. No</th>
                                                <th>Task Title</th>
                                                <th>Description</th>
                                                <th>Earning when completed</th>
                                                <th>Add watch required</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php for ($i=1; $i < 9; $i++) { ?>
                                                <tr>
                                                    <td><?php echo $i ?> .</td>
                                                    <td>Toyota</td>
                                                    <td><?=substr('Enjoy Gains by Digital Investment in numerous currencies available through forex trading accounts.Enjoy Gains by Digital Investment in numerous currencies available through forex trading accounts.', 0, 45) . '...';?></td>
                                                   <td></td>
                                                   <td></td>
                                                    <td>
                                                        <a href="javascript:void(0);" data-toggle="modal" data-target=".edit" class="btn-sm"><i class="bx bx-edit-alt"></i></a>
                                                        <a href="javascript:void(0);" id="sa-params" class="btn-sm"><i class="bx bx-trash-alt"></i></a>
                                                    </td>
                                                </tr>
                                            <?php }?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
                
        <?php $this->load->view('admin/include/footer');?>     
        <?php $this->load->view('admin/include/foot');?>

          
       <div class="modal fade add" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel">Create</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="">
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Task Title</label>
                                    <input type="text" placeholder="Enter Task Title" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label> Earning when completed</label>
                                    <input type="text" placeholder="Enter Earning when completed" class="form-control">
                                </div>  
                                <div class="form-group col-md-6">
                                    <label>Add watch required</label>
                                    <input type="text" placeholder="Enter add watch required" class="form-control">
                                </div> 
                                <div class="form-group col-md-6">
                                    <label>Description</label>
                                    <textarea name="" id="" class="form-control" placeholder="Write Here..."></textarea>
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
        <div class="modal fade edit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel">Edit</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="">
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Task Title</label>
                                    <input type="text" placeholder="Enter Task Title" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label> Earning when completed</label>
                                    <input type="text" placeholder="Enter Earning when completed" class="form-control">
                                </div> 
                                <div class="form-group col-md-6">
                                    <label>Add watch required</label>
                                    <input type="text" placeholder="Enter add watch required" class="form-control">
                                </div> 
                                <div class="form-group col-md-6">
                                    <label>Description</label>
                                    <textarea name="" id="" class="form-control" placeholder="Write Here..."></textarea>
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