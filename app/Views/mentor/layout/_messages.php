<?php if (session()->has('message-success')) : ?>
    <div class="alert alert-icon alert-inverse-success alert-dismissible fade show" role="alert">
        <i class="fa fa-info-circle"></i>
        <?php echo session('message-success'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="ti ti-close"></i>
        </button>
    </div>
<?php endif; ?>

<?php if (session()->has('message-info')) : ?>
    <div class="alert alert-icon alert-inverse-info alert-dismissible fade show" role="alert">
        <i class="fa fa-info-circle"></i>
        <?php echo session('message-info'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="ti ti-close"></i>
        </button>
    </div>
<?php endif; ?>

<?php if (session()->has('message-warning')) : ?>
    <div class="alert alert-icon alert-inverse-warning alert-dismissible fade show" role="alert">
        <i class="fa fa-info-circle"></i>
        <?php echo session('message-warning'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="ti ti-close"></i>
        </button>
    </div>
<?php endif; ?>

<?php if (session()->has('message-error')) : ?>
    <div class="alert alert-icon alert-inverse-danger alert-dismissible fade show" role="alert">
        <i class="fa fa-info-circle"></i>
        <?php echo session('message-error'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="ti ti-close"></i>
        </button>
    </div>
<?php endif; ?>