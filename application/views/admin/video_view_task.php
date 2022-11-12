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
                                                <th>Earning when completed</th>
                                                <th>Add watch required</th>
                                                <th>Description</th>
                                                <th>Type</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($tasks as $i => $task) { ?>
                                                <tr>
                                                    <td><?php echo $i+1; ?></td>
                                                    <td><?php echo $task['task_title']; ?></td>
                                                    <td><?php echo $task['earning_when_completed']; ?></td>
                                                    <td><?php echo $task['watch_required']; ?></td>
                                                    <td><?php echo $task['description']; ?></td>
                                                    <td><?php 
                                                    if($task['type'] == '1')
                                                    {
                                                        echo "Video_task";
                                                    }else if($task['type'] == '2'){
                                                        echo "Referal_task";
                                                    }
                                                    
                                                    
                                                    ?></td>
                                                   
                                                    <td>
                                                        <a href="javascript:void(0);" data-toggle="modal" task_id = "<?php echo $task['task_id']; ?>" data-target=".edit" class="btn-sm edit_task"><i class="bx bx-edit-alt"></i></a>
                                                        <a href="javascript:void(0);" id="sa-params" task_id = "<?php echo $task['task_id']; ?>" class="btn-sm delete"><i class="bx bx-trash-alt"></i></a>
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
                    <form action="" id="submit_createmodel">
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Task Title</label>
                                    <input type="text" placeholder="Enter Task Title" name = "task_title" id = "task_title" class="form-control">
                                </div>
                                <div class="form-group col-md-12">
                                    <label> Earning when completed</label>
                                    <input type="text" placeholder="Enter Earning when completed" name = "earning_when_completed" id = "earning_when_completed" class="form-control">
                                </div> 
                                <div class="form-group col-md-12">
                                    <label>Add watch required</label>
                                    <input type="text" placeholder="Enter add watch required" class="form-control" name = "watch_required" id = "watch_required" >
                                </div> 
                                <div class="form-group col-md-12">
                                    <label>Description</label>
                                    <textarea name="description" id="description" class="form-control" placeholder="Write Here..."></textarea>
                                </div>   
                                <div class="form-group col-md-12">
                                    <label>Type</label>
                                    <select class="form-control" name = "type" id= "type" >
                                        <option value = "">Select</option>
                                        <option value = "1" >Video Task</option>
                                        <option value = "2" >Referal Task</option>
                                            </select>
                                    
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
                    <form action="" id = "editHere">
                        <!-- <div class="modal-body">
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
                        </div> -->
                    </form>                        
                </div>
            </div>
        </div>

        <script>
        $(document).ready(function() {
            $("#submit_createmodel").validate({
                rules: {
                    task_title: "required",
                    earning_when_completed: "required",
                    watch_required: "required",
                    description: "required",
                    type: "required",

                },
                messages: {
                   task_title: "Task title is required",
                    earning_when_completed: "earning when completed is required",
                    watch_required: "watch required is required",
                    description: "description is required",
                    type: "Type is required",
                }
            });
        });
    </script>

<script>
       // CREATE A NEW BRAND

$(document).on('submit', '#submit_createmodel', function(e) {
e.preventDefault();

$.ajax({
url: "<?php echo base_url(); ?>Admin/add_video_view_task",
type: "POST",
data: new FormData(this),
contentType: false,
processData: false,
success: function(response) {

$('#submit_createmodel')[0].reset();
$("#createmodel").hide();
$(".fade").hide();
Swal.fire('Success', 'Video view task Created Successfully.', 'success');
// $('#datatable').DataTable().ajax.reload(null, false);
// setInterval(function(){
location.reload() // this will run after every 5 seconds
// }, 1000);
}
});
});

</script>

<script>
            // Delete a brand
        $(document).on('click', '.delete', function() {
            const id = $(this).attr("task_id");
            
            Swal.fire({
                    title: "Are you sure?",
                    text: "Are you sure you want to delete ?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((result) => {
                    if (result.value) {
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url(); ?>Admin/delete_task",
                            data: {
                                id: id
                            },
                            success: function(data) {
                            Swal.fire("Success","Task deleted successfully.","success");
                                // $('#datatable').DataTable().ajax.reload(null, false);
                                // console.log(data);
                                // setInterval(function(){
                                location.reload() // this will run after every 5 seconds
                                // }, 5000);
                                if (data == 'success') {
                                    swal({
                                        title: "Success",
                                        text: "Task deleted Successfully",
                                        icon: "success",
                                        button: false,
                                        timer: 3000
                                    });
                                }
                                if (data == 'failed') {
                                    swal({
                                        title: "Failed",
                                        text: "Some Error Occured Please Try again.",
                                        icon: "error",
                                        button: false,
                                        timer: 3000
                                    });
                                }
                            }
                        });
                    }
                });
        });

    </script>

<script>
//OPEN EDIT MODEL WITH DATA
$(document).on('click', '.edit_task', function() {
const id = $(this).attr('task_id');

// alert(id);


$.ajax({
url: "<?php echo base_url() ?>Admin/edit_task",
type: "POST",
data: {
id: id
},
success: function(response) {
console.log(response);
$('#editHere').html(response);
}
});
});
</script>

<script>
// Update Brand
$(document).on('submit', '#editHere', function(e) {
e.preventDefault();

$.ajax({
url: "<?php echo base_url(); ?>Admin/update_task",
type: "POST",
data: new FormData(this),
contentType: false,
processData: false,
success: function(response) {
$('#editHere')[0].reset();
$("#editmodel").hide();
$(".fade").hide();
Swal.fire('Success', 'Task Updated Successfully.', 'success');
// setInterval(function() {
location.reload() // this will run after every 5 seconds
// }, 1000);
}
});

});
</script>