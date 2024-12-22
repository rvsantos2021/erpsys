<?= $this->extend('/mentor/layout/main'); ?>

<?= $this->section('title'); ?>
<?= APP_NAME . ' - ' . APP_VERSION . ' - ' . $title; ?>
<?= $this->endSection(); ?>

<?= $this->section('styles'); ?>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<?= $this->include('/mentor/layout/_messages'); ?>
<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<?= $this->endSection(); ?>