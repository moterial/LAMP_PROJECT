<?= $this->extend('layout/default'); ?>
<?= $this->section('title'); ?>Profile<?= $this->endSection() ?>
<?= $this->section('content'); ?>

<section class="h-100 my-5">
    <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-4 col-md-offset-4">
                <h4>Profile</h4>
                <table class="table table-striped">
                    <tr>
                        <td>Username</td>
                        <td><?= $userInfo['ac'] ?></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><?= $userInfo['email'] ?></td>
                    </tr>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>