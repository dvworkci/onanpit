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
                                                <th>Task</th>
                                                <th>Sub Task</th>
                                                <th>Point</th>
                                                <th>Description</th>
                                                <th>Action</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php for ($i=1; $i < 9; $i++) { ?>
                                                <tr>
                                                    <td><?php echo $i ?> .</td>
                                                    <td>Login</td>
                                                    <td>Sub Login</td>                                                    
                                                    <td>5</td>                                                    
                                                    <td><?=substr('In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document', 0, 35) . '<a href="" data-toggle="modal" data-target=".moredescription">...</a>';?></td>                                                    
                                                    <td>
                                                        <a href="javascript:void(0);" data-toggle="modal" data-target=".edit"  class="btn-sm"><i class="bx bx-edit-alt"></i></a>
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
      


        <div class="modal fade moredescription" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel">Description</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <p>In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document</p>
                            </div>
                        </div>
                    </div>    
                </div>
            </div>
        </div>
        <div class="modal fade add" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel">Add Sub Task</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="">
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Select Task</label>
                                    <select name="" id="" class="form-control">
                                        <option value="">Select</option>
                                        <option value="">Task 1</option>
                                        <option value="">Task 2</option>
                                    </select>
                                    
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Sub task</label>
                                    <input type="text" placeholder="Enter Sub task" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Point</label>
                                    <input type="number" placeholder="Enter Point" class="form-control">
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Description</label>
                                    <textarea name="" id=""  class="form-control"></textarea>
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
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel">Edit Sub Task</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="">
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Select Task</label>
                                    <select name="" id="" class="form-control">
                                        <option value="">Select</option>
                                        <option value="">Task 1</option>
                                        <option value="">Task 2</option>
                                    </select>
                                    
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Sub task</label>
                                    <input type="text" placeholder="Enter Sub task" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Point</label>
                                    <input type="number" placeholder="Enter Point" class="form-control">
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Description</label>
                                    <textarea name="" id=""  class="form-control"></textarea>
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
       
                
        <?php $this->load->view('admin/include/footer');?>     
        <?php $this->load->view('admin/include/foot');?>