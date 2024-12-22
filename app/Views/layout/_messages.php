<?php if (session()->has('message-success')) : ?>
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?php echo session('message-success'); ?>
    </div>
<?php endif; ?>

<?php if (session()->has('message-info')) : ?>
    <div class="alert alert-info">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?php echo session('message-info'); ?>
    </div>
<?php endif; ?>

<?php if (session()->has('message-warning')) : ?>
    <div class="alert alert-warning">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?php echo session('message-warning'); ?>
    </div>
<?php endif; ?>

<?php if (session()->has('message-error')) : ?>
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?php echo session('message-error'); ?>
    </div>
<?php endif; ?>