<?= $this->extend('layout/default'); ?>
<?= $this->section('title'); ?>Dashboard<?= $this->endSection() ?>
<?= $this->section('content'); ?>

<?php
  function checked() {
    echo '<script>console.log(this)</script>';
  }
?>

<section class="h-100 my-5" style="background-color: #eee;">
    <div class="container h-100 w-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-12 col-xl-11 w-100">
                <div class="card text-black" style="border-radius: 25px;">
                    <div class="card-body p-md-5">
                        <div class="row w-100">
                            <div class="col-3">
                                <div class="nav flex-column nav-tabs text-center" id="v-tabs-tab" role="tablist" aria-orientation="vertical">
                                    <?php
                                      for ($i = 0; $i < count($grid); $i++) {
                                          $value = $grid[$i];
                                          if ($i == 0) {
                                            echo '<a class="nav-link active" id="tab-' . $value['categoryName'] . '-tab" data-mdb-toggle="tab" href="#v-tabs-' . $value['categoryName'] . '" role="tab">' . $value['categoryName'] . '</a>';
                                          }else {
                                            echo '<a class="nav-link" id="tab-' . $value['categoryName'] . '-tab" data-mdb-toggle="tab" href="#v-tabs-' . $value['categoryName'] . '" role="tab">' . $value['categoryName'] . '</a>';
                                          }
                                      }
                                    ?>
                                    </br>
                                </div>
                                <div class="row w-100 m-0">
                                  <div class="col w-100 px-1"><button id="addCategory" type="button" class="btn btn-primary w-100 px-0" data-mdb-toggle="modal" data-mdb-target="#addCategoryModal">Add Category</button></div>
                                  <div class="col w-100 px-1"><button id="addTask" type="button" class="btn btn-primary w-100 px-0" data-mdb-toggle="modal" data-mdb-target="#addTaskModal">Add Task</button></div>
                                </div>
                                </p>
                                <div class="row w-100 m-0 px-1"><button id="completeTask" type="button" class="btn btn-primary w-100" data-mdb-toggle="modal" data-mdb-target="#completeTaskModal">Complete Task</button></div>
                                </p>
                                <div class="row w-100 m-0 px-1"><button id="deleteTask" type="button" class="btn btn-primary w-100" data-mdb-toggle="modal" data-mdb-target="#deleteTaskModal">Delete Task</button></div>
                                </p>
                                <?php if(isset($validation)): ?>
                                  <div class="alert alert-danger" role="alert">
                                    <?= $validation->listErrors() ?>
                                  </div>
                                <?php endif; ?>
                                <?php if (!empty(session()->getFlashdata('success'))): ?>
                                  <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
                                  <?php header( "refresh:2; url=login" ); ?>
                                <?php endif; ?>
                            </div>
                            <div class="col-9">
                                <div class="tab-content" id="v-tabs-tabContent">
                                    <?php
                                      for ($i = 0; $i < count($grid); $i++) {
                                          $value = $grid[$i];
                                          if ($i == 0) {
                                            echo '<div class="tab-pane fade show active" id="v-tabs-' . $value['categoryName'] . '" role="tabpanel">';
                                          }else {
                                            echo '<div class="tab-pane fade" id="v-tabs-' . $value['categoryName'] . '" role="tabpanel">';
                                          }
                                          echo '<div class="list-group list-group-light">';
                                          for ($j = 0; $j < count($value['taskList']); $j++) {
                                            $task = $value['taskList'][$j];
                                            echo '<li class="list-group-item">';
                                            echo '<label class="form-check-label">' . $task['taskName'] . '</label>';
                                            echo '</li>';
                                          }
                                          echo '</div>';
                                          echo '</div>';
                                      }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</select>
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
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button>
        <?= form_submit('','Add Task',['class' => 'btn btn-primary'])?>
        <?=form_close()?>
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
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button>
        <?= form_submit('','Add Task',['class' => 'btn btn-primary'])?>
        <?=form_close()?>
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
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button>
        <?= form_submit('','Add Task',['class' => 'btn btn-primary'])?>
        <?=form_close()?>
      </div>
    </div>
  </div>
</div>
</section>
<?= $this->endSection() ?>