<?= $this->extend('layout/default'); ?>
<?= $this->section('title'); ?>Dashboard<?= $this->endSection() ?>
<?= $this->section('content'); ?>

<section class="h-100 my-5" style="background-color: #eee;">
    <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-12 col-xl-11">
                <div class="card text-black" style="border-radius: 25px;">
                    <div class="card-body p-md-5">
                        <div class="row w-100">
                            <div class="col-3">
                                <div class="nav flex-column nav-tabs text-center" id="v-tabs-tab" role="tablist" aria-orientation="vertical">
                                    <a class="nav-link active" id="home-tab" data-mdb-toggle="tab" href="#v-tabs-home">Home</a>
                                    <a class="nav-link" id="home-tab" data-mdb-toggle="tab" href="#v-tabs-profile">Profile</a>
                                    </br>
                                </div>
                                <button id="addCategory" type="button" class="btn btn-primary" data-mdb-toggle="modal" data-mdb-target="#addCategoryModal">Add Category</button>
                                <button id="addTask" type="button" class="btn btn-primary" data-mdb-toggle="modal" data-mdb-target="#addTaskModal">Add Task</button>
                            </div>
                            <div class="col-9">
                                <div class="tab-content" id="v-tabs-tabContent">
                                    <div id="v-tabs-home" class="tab-pane fade show active" role="tabpanel">
                                        Home content
                                    </div>
                                    <div id="v-tabs-profile" class="tab-pane fade show" role="tabpanel">
                                        Home content
                                    </div>
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
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button>
        <?= form_submit('','Add Task',['class' => 'btn btn-primary'])?>
        <?=form_close()?>
      </div>
    </div>
  </div>
</div>
</section>
<select class="custom-select select">
  <option selected>Open this select menu</option>
  <option value="1">One</option>
  <option value="2">Two</option>
  <option value="3">Three</option>

<?= $this->endSection() ?>