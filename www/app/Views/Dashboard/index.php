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




<section class="vh-100 mt-5" style="background-color: #eee;">
<div class="container py-5 h-100">
        <div class="card rounded-3" style="height: 800px;">
          <div class="card-body p-4">
            <h4 class="text-center my-3 pb-3">To Do List</h4>
            <?= form_open('dashboard/addCategory', ['autocomplete' => 'off', 'class'=>'row row-cols-lg-auto g-3 justify-content-center align-items-center mb-4 pb-2'])?>
            <?= csrf_field(); ?>
            <!-- <form class="row row-cols-lg-auto g-3 justify-content-center align-items-center mb-4 pb-2" action="Dashboard/addTask"> -->
              <div class="col-12">
                <div class="form-outline">
                <?=form_input('',set_value('categoryName'),['name' => 'categoryName', 'id' => 'categoryName', 'class' => 'form-control'],'text')?>
                  <!-- <input type="text" id="categoryName" name="categoryName" class="form-control" /> -->
                  <label class="form-label" for="form1">Add Category</label>
                </div>
              </div>

              <div class="col-12">
                <?= form_submit('','ADD Category',['class' => 'btn btn-primary'])?>
                <!-- <button type="submit" class="btn btn-primary">Save Category</button> -->
              </div>

            <!-- </form> -->
            <?=form_close()?>
              <div class="scrolling-wrapper container mt-5">
                
              <?php foreach($grid as $category): ?>
                <div class="card p-3 me-4" style="height: 450px; overflow-y: scroll">
                <?= $category['taskId']?>
                  <h4 class="text-center my-3 pb-3"> <?= $category['content']?></h4>
                    <?= form_open('dashboard/addTask', ['autocomplete' => 'off', 'class'=>'row row-cols-lg-auto g-3 justify-content-center align-items-center mb-4 pb-2'])?>
                    <?= csrf_field(); ?>
                    <!-- <form class="row row-cols-lg-auto g-3 justify-content-center align-items-center mb-4 pb-2"> -->
                      <div class="col-12">
                        <?= form_hidden('categoryId', $category['taskId'])?>
                        <div class="form-outline">
                          <?=form_input('',set_value('taskName'),['name' => 'taskName', 'id' => 'taskName', 'class' => 'form-control'],'text')?>
                          <label class="form-label" for="form1">Add a task here</label>
                        </div>
                      </div>
                      
                      <div class="col-12">
                      <?= form_submit('','SAVE TASK',['class' => 'btn btn-warning'])?>
                        <!-- <button type="submit" class="btn btn-warning">Save Task</button> -->
                      </div>
                      <?=form_close()?>     
                    <ul class="list-group rounded-0 mb-3">
                                
                                <?php foreach($category['taskList'] as $task): ?>
                                  <?php if($task['finished']==0):?>
                                    <li class="list-group-item border-0 d-flex align-items-center ps-0">
                                      <input class="form-check-input me-3" type="checkbox" value="" aria-label="..." />
                                      <?= $task['content']?>
                                        <a href="<?= base_url('dashboard/deleteTask/'.$task['taskId'])?>"><i class="fa-solid fa-trash ps-3" ></i></a>
                                    </li>
                                  <?php else: ?>
                                      <li class="list-group-item border-0 d-flex align-items-center ps-0">
                                        <input class="form-check-input me-3" type="checkbox" value="" aria-label="..." checked disabled />
                                        <s><?= $task['content']?></s> &nbsp;&nbsp;(finished)
                                        <i class="fa-solid fa-trash ps-3"></i>
                                      </li>
                                  <?php endif; ?>
                                <?php endforeach; ?>

                      </ul>
                      <button type="submit" class="btn btn-danger float-end">Del Category</button>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
  </div>
</section>
<!-- Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Category</h5>
        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <?= form_open('Dashboard/addCategory', ['autocomplete' => 'off'])?>
      <div class="form-outline flex-fill mb-0">
      <?=form_input('',set_value('categoryName'),['name' => 'categoryName', 'id' => 'categoryName', 'class' => 'form-control'],'text')?>
      <label class="form-label">Category Name</label>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button>
        <?= form_submit('','Add Category',['class' => 'btn btn-primary'])?>
        <?=form_close()?>
      </div>
    </div>
  </div>
</div>
</div>

<div class="modal fade" id="addTaskModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Task</h5>
        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <?= form_open('Dashboard/addTask', ['autocomplete' => 'off'])?>
      <?php 
        $t = new \App\Models\TaskDto();
        $list = $t->listCategoryNameAndIdByUserId(session('userId'));
        $options = [];
        for($i = 0; $i < count($list); $i++){
            $options[$list[$i]['taskId']] = $list[$i]['content'];
        }?>
      <?= form_dropdown('', $options, '', ['name' => 'categoryName', 'id' => 'categoryName', 'class' => 'form-select'])?>
    </br>
      <div class="form-outline flex-fill mb-0">
      <?=form_input('',set_value('taskName'),['name' => 'taskName', 'id' => 'taskName', 'class' => 'form-control'],'text')?>
      <label class="form-label">Task Name</label>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button>
        <?= form_submit('','Add Task',['class' => 'btn btn-primary'])?>
        <?=form_close()?>
      </div>
    </div>
  </div>
</div>
</div>

<div class="modal fade" id="completeTaskModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Complete Task</h5>
        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <?= form_open('Dashboard/completeTask', ['autocomplete' => 'off'])?>
      <?php 
        $t = new \App\Models\TaskDto();
        $list = $t->listCategoryNameAndIdByUserId(session('userId'));
        $options = [];
        for($i = 0; $i < count($list); $i++){
            $options[$list[$i]['taskId']] = $list[$i]['content'];
        }?>
      <?= form_dropdown('', $options, '', ['name' => 'categoryName', 'id' => 'categoryName', 'class' => 'form-select'])?>
    </br>
      <div class="form-outline flex-fill mb-0">
      <?=form_input('',set_value('taskName'),['name' => 'taskName', 'id' => 'taskName', 'class' => 'form-control'],'text')?>
      <label class="form-label">Task Name</label>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button>
        <?= form_submit('','Add Task',['class' => 'btn btn-primary'])?>
        <?=form_close()?>
      </div>
    </div>
  </div>
</div>
</div>

<div class="modal fade" id="deleteTaskModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete Task</h5>
        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <?= form_open('Dashboard/deleteTask', ['autocomplete' => 'off'])?>
      <?php 
        $t = new \App\Models\TaskDto();
        $list = $t->listCategoryNameAndIdByUserId(session('userId'));
        $options = [];
        for($i = 0; $i < count($list); $i++){
            $options[$list[$i]['taskId']] = $list[$i]['content'];
        }?>
      <?= form_dropdown('', $options, '', ['name' => 'categoryName', 'id' => 'categoryName', 'class' => 'form-select'])?>
    </br>
      <div class="form-outline flex-fill mb-0">
      <?=form_input('',set_value('taskName'),['name' => 'taskName', 'id' => 'taskName', 'class' => 'form-control'],'text')?>
      <label class="form-label">Task Name</label>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button>
        <?= form_submit('','Add Task',['class' => 'btn btn-primary'])?>
        <?=form_close()?>
      </div>
    </div>
  </div>
</div>
</div>
</section>

<script>

$(document).ready(function() {
  //check if there is error message from the controller
  if (<?= session('error') ? 'true' : 'false' ?>) {
    //alert the error message
    alert('<?= session('error') ?>');
  }
});

</script>

<?= $this->endSection() ?>

