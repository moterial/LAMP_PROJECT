<?= $this->extend('layout/default'); ?>
<?= $this->section('title'); ?>Dashboard<?= $this->endSection() ?>
<?= $this->section('content'); ?>

<?php
  function checked() {
    echo '<script>console.log(this)</script>';
  }
?>
<style>
.scrolling-wrapper {
  overflow-x: scroll;
  height: 500px;
  white-space: nowrap;
}

.scrolling-wrapper .card{
  display: inline-block;
}

.fa-trash:hover{
  color: red;
  cursor: pointer;
  transform: translateX(5px);
  transition: transform .3s;
}
</style>

<?php if(session()->get('privilege') == 'admin'): ?>
  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle" style="color:red;">Unusual Activities</h5>
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-2">UserID</div>
          <div class="col-5">Content</div>
          <div class="col-5">Time</div>
        </div>
        <?php foreach($logs as $log): ?>
          <div class="row">
            <div class="col-2"><?= $log['userID'] ?></div>
            <div class="col-5"><?= $log['content'] ?></div>
            <div class="col-5"><?= $log['created_at'] ?></div>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close">Close</button>
      </div>
    </div>
  </div>
</div>


<?php endif; ?>


<section class="vh-100 mt-5" style="background-color: #eee;">

<div class="">
    <div class="ms-5">
      <div class="col col-md-9 col-lg-7 col-xl-5">
        <div class="card" style="border-radius: 15px;">
          <div class="card-body p-4">
            <div class="d-flex text-black">
              <div class="flex-shrink-0">
                <img src="https://cdn-icons-png.flaticon.com/512/3135/3135768.png"
                  alt="Generic placeholder image" class="img-fluid"
                  style="width: 180px; border-radius: 10px;">
              </div>
              <div class="flex-grow-1 ms-3">
                <h5 class="mb-1"><?= 
                    session()->get('ac')
                ?></h5>
                <p class="mb-2 pb-1" style="color: #2b2a2a;"></p>
                <div class="d-flex justify-content-start rounded-3 p-2 mb-2"
                  style="background-color: #efefef;">
                  <div>
                    <p class="small text-muted mb-1">Privilege</p>
                    <p class="mb-0"><?=
                        session()->get('privilege')
                     ?></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<div class="container py-5 h-100">
        <div class="card rounded-3" style="height: 800px;">
          <div class="card-body p-4">
            <h4 class="text-center my-3 pb-3">To Do List</h4>
            <?php 
              if (session()->get('privilege') == 'admin'|| session()->get('privilege') == 'manager') {
            ?>
            <?= form_open('dashboard/addCategory', ['autocomplete' => 'off', 'class'=>'row row-cols-lg-auto g-3 justify-content-center align-items-center mb-4 pb-2'])?>
            <?= csrf_field(); ?>
              <div class="col-12">
                <div class="form-outline">
                <?=form_input('',set_value('categoryName'),['name' => 'categoryName', 'id' => 'categoryName', 'class' => 'form-control'],'text')?>
                  <label class="form-label" for="form1">Add Category</label>
                </div>
              </div>

              <div class="col-12">
                <?= form_submit('','ADD Category',['class' => 'btn btn-primary'])?>
              </div>
            <?=form_close()?>
            <?php
              }
            ?>
              <div class="scrolling-wrapper container mt-5">
              <? if($grid): ?>
              <?php foreach($grid as $category): ?>
                <div class="card p-3 me-4" style="height: 450px; overflow-y: scroll">
                  <h4 class="text-center my-3 pb-3"> <?= $category['content']?></h4>
                    
                    <?= form_open('dashboard/addTask', ['autocomplete' => 'off', 'class'=>'row row-cols-lg-auto g-3 justify-content-center align-items-center mb-4 pb-2'])?>
                    <?= csrf_field(); ?>
                    <!-- <form class="row row-cols-lg-auto g-3 justify-content-center align-items-center mb-4 pb-2"> -->
                      <div class="col-12">
                        <?= form_hidden('categoryId', $category['taskId'])?>
                        <div class="form-outline">
                        <?php 
                          if (session()->get('privilege') == 'admin'|| session()->get('privilege') == 'manager') {
                        ?>
                          <?=form_input('',set_value('taskName'),['name' => 'taskName', 'id' => 'taskName', 'class' => 'form-control'],'text')?>
                        <?php
                          }else{
                        ?>
                          <?=form_input('',set_value('taskName'),['name' => 'taskName', 'id' => 'taskName', 'class' => 'form-control','disabled'=>'true'],'text')?>
                        <?php
                          }
                        ?>
                          <label class="form-label" for="form1">Add a task here</label>
                        </div>
                      </div>
                      
                      <div class="col-12">
                      <?php 
                        if (session()->get('privilege') == 'admin'|| session()->get('privilege') == 'manager') {
                      ?>
                      <?= form_submit('','SAVE TASK',['class' => 'btn btn-warning'])?>
                      <?php
                        }else{
                      ?>
                      <?= form_submit('','SAVE TASK',['class' => 'btn btn-warning','disabled'=>'true'])?>
                      <?php
                        }
                      ?>
                        <!-- <button type="submit" class="btn btn-warning">Save Task</button> -->
                      </div>
                      <?=form_close()?>
                        
                    <ul class="list-group rounded-0 mb-3">
                                
                                <?php foreach($category['taskList'] as $task): ?>
                                  <?php if($task['finished']==0):?>
                                    <li class="list-group-item border-0 d-flex align-items-center ps-0">
                                      <input class="form-check-input me-3" type="checkbox" value="" aria-label="..." id="completeTask" data-task-id=<?= $task['taskId']?> />
                                      <?= $task['content']?>
                                      <?php 
                                        if (session()->get('privilege') == 'admin'|| session()->get('privilege') == 'manager') {
                                      ?>
                                        <a href="<?= base_url('dashboard/deleteTask/'.$task['taskId'])?>"><i class="fa-solid fa-trash ps-3" ></i></a>
                                      <?php
                                        }
                                      ?>
                                    </li>
                                  <?php else: ?>
                                      <li class="list-group-item border-0 d-flex align-items-center ps-0">
                                        <input class="form-check-input me-3" type="checkbox" value="" aria-label="..." checked disabled />
                                        <s><?= $task['content']?></s> &nbsp;&nbsp;(finished)
                                        <?php 
                                        if (session()->get('privilege') == 'admin'|| session()->get('privilege') == 'manager') {
                                      ?>
                                        <a href="<?= base_url('dashboard/deleteTask/'.$task['taskId'])?>"><i class="fa-solid fa-trash ps-3"></i></a>
                                      <?php
                                        }
                                      ?>
                                      </li>
                                  <?php endif; ?>
                                <?php endforeach; ?>

                      </ul>
                      <?php if (session()->get('privilege') == 'admin'|| session()->get('privilege') == 'manager') {?>
                      <a href="<?= base_url('dashboard/deleteCategory/'.$category['taskId'])?>"><button class="btn btn-danger float-end">Del Category</button></a>
                      <?php } ?>
                      

                </div>
              <?php endforeach; ?>
              <? endif; ?>
            </div>
          </div>
        </div>
  </div>
</section>
<!-- Modal -->
<!--  -->

<script>

$(document).ready(function() {


  $(window).on('load', function() {
        $('#exampleModalCenter').modal('show');
  });

  $('#close').click(function() {
    $('#exampleModalCenter').modal('hide');
  });


  //check if there is error message from the controller
  if (<?= session('error') ? 'true' : 'false' ?>) {
    //alert the error message
    alert('<?= session('error') ?>');
  }

  //get completeTask button
  var completeTask = document.getElementById('completeTask');
  completeTask.onclick = function() {
    //get the task id
    var taskId = this.getAttribute('data-task-id');
    //send ajax request to the controller
    $.ajax({
      url: '<?= base_url('dashboard/completeTask') ?>',
      method: 'post',
      data: {
        taskId: taskId
      },
      success: function(response) {
        //if the response is true
        if (response) {
          //reload the page
          location.reload();
        }
      }
    });
  }
});

</script>

<?= $this->endSection() ?>

