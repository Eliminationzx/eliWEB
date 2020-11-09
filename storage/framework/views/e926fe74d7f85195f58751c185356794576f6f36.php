<?php $__env->startSection('content'); ?>
<?php $__env->startSection('bodyclass'); ?>
<body>
<?php $__env->stopSection(); ?>
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Promo codes</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo e(route('personal')); ?>">Home</a>
                </li> 
                <li class="active">
                    <strong>Promo codes</strong>
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
						<h5>Promotion code activation form</h5>
					</div>
                    <div class="ibox-content">

                        <div class="project-list"> 
                            <div class="col-lg-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                        <i class="fa fa-info-circle"></i> Useful information
                                        </div>
                                        <div class="panel-body">
                                            <p>Our project tries as often as possible to please its players with free gifts and valuable prizes, which can be obtained automatically on your character for special promotional codes.
                                            <p><b>Note:</b> Follow the news of the project, there you can find many promotional codes that we will play or give away for free.
                                        </div>
                                    </div>
                                </div>
                            <form method="POST" action="/personal/promocodes"
                                  class="form-horizontal" enctype="multipart/form-data">

                                <input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">

                                <div class="form-group">
                                    <label class="col-sm-3">Your promo code:</label>
                                    <div class="col-sm-9">
                                        <div class="input-group col-sm-12">
                                            <input type="text" class="form-control" name="promocode" id="promocode" value="" placeholder="Select a promo code...">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3">Character:</label>
                                    <div class="col-sm-9">
                                        <div class="input-group col-sm-12">
                                            <div>
                                                <select name="guid" data-placeholder="Select a character..." class="chosen-select"  tabindex="2">
													<?php if($userinfo != null): ?>
														<?php $__currentLoopData = $userinfo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userinf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
															<option value="<?php echo e($userinf->guid); ?>"><?php echo e($userinf->name); ?> (<?php echo e($userinf->realm_name); ?>)</option>
														<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
													<?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-block btn-outline btn-primary">Activate</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>