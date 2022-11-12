<div class="modal-body">
<div class="row">
    <div class="form-group col-md-12">
        <label>Task Title</label>
        <input type="text" placeholder="Enter Task Title" name = "task_title" id = "task_title" value = "<?php echo $task['task_title']; ?>" class="form-control">
        <input type = "hidden" name = "id" id = "id" value = "<?php echo $task['task_id']; ?>" >
    </div>
    <div class="form-group col-md-12">
        <label> Earning when completed</label>
        <input type="text" placeholder="Enter Earning when completed" name = "earning_when_completed" id = "earning_when_completed" value = "<?php echo $task['earning_when_completed'];?>" class="form-control">
    </div> 
    <div class="form-group col-md-12">
        <label>Add watch required</label>
        <input type="text" placeholder="Enter add watch required" name = "watch_required" id = "watch_required" value = "<?php echo $task['watch_required'];?>" class="form-control">
    </div>
    <div class="form-group col-md-12">
        <label>Description</label>
        <textarea class="form-control" name = "description" id = "description" placeholder="Write Here..." ><?php echo $task['description'];?></textarea>
    </div>        
    <div class="form-group col-md-12">
        <label>Type</label>
        <select class="form-control" name = "type" id= "type" >
            <option value = "">Select</option>
            <option value = "1" <?php if($task['type'] == "1"){ echo "selected"; } ?> >Video Task</option>
            <option value = "2" <?php if($task['type'] == "2"){ echo "selected"; } ?> >Referal Task</option>
        </select>
    </div>                          
</div>
</div>
<div class="modal-footer">
<button type="submit" class="btn btn-primary">Submit</button>
</div>

<script>
        $(document).ready(function() {
            $("#editHere").validate({
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