<?php echo $__env->make('layouts.admin.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('layouts.admin.menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->yieldContent('content'); ?>

<?php echo $__env->make('layouts.admin.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>