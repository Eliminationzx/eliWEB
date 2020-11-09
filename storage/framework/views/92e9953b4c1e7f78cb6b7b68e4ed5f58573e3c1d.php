<?php $__env->startSection('content'); ?>
<?php $__env->startSection('bodyclass'); ?>
<body>
<?php $__env->stopSection(); ?>
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Password change</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo e(route('personal')); ?>">Home</a>
                </li> 
                <li>
                    Account
                </li>  
                <li class="active">
                    <strong>Password change</strong>
                </li> 
            </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
	  <?php if( session('status')): ?>
			<div class="row">
				<div class="col-lg-12">
					<div class="alert alert-<?php echo e(session('type')); ?> alert-dismissable">
						<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
						<span class="alert-link"><?php echo e(session('status')); ?></span>
					</div>
				</div>
			</div>
		<?php endif; ?>
		
        <div class="row">
            <div class="col-lg-12">

                <div class="ibox">
					<div class="ibox-title">
						<h5>Password change form</h5>
					</div>
                    <div class="ibox-content">

                        <div class="project-list">
                            <form method="POST" action="<?php echo e(route('accounts.passwords')); ?>"
                                  class="form-horizontal" enctype="multipart/form-data">

                                <input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">

                                <div class="form-group">
                                    <label class="col-sm-12 b-r-xl">Old password:</label>
                                    <div class="col-sm-12 b-r-xl" > <input type="password" class="form-control" name="OldPassword" id="OldPassword"
                                                                           value="" required>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-sm-12">New password:</label>
                                    <div class="col-sm-12"><input type="password" class="form-control" name="NewPassword"
                                                                  id="NewPassword"
                                                                  value="" required></div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-12">Confirm Password:</label>
                                    <div class="col-sm-12"><input type="password" class="form-control" name="ConfrimPassword"
                                                                  id="ConfrimPassword"
                                                                  value="" required></div>
                                </div>

                                <div class="form-group ">
                                    <div class="col-sm-12">
                                        <button class="btn btn-block btn-outline btn-primary">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>