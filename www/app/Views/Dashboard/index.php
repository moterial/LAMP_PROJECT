<?= $this->extend('layout/default'); ?>
<?= $this->section('title'); ?>Login<?= $this->endSection() ?>
<?= $this->section('content'); ?>
<?php $session = session(); ?>
<?php echo $_SESSION['userID'] ?>

<?= $this->endSection() ?>