

<?php $__env->startSection('content'); ?>
<?php $__env->startSection('bodyclass'); ?>
<body>
<?php $__env->stopSection(); ?>
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Configuraciones</h2>
            <ol class="breadcrumb">
            <li>
                <a href="<?php echo e(route('personal')); ?>">Inicio</a>
            </li> 
            <li>
                Sistema
            </li>
            <li class="active">
                <strong>Configuraciones</strong>
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
						<h5>Lista de ajustes</h5>
					</div>
                    <div class="ibox-content">

                        <div class="project-list">
                            <form method="POST" action="<?php echo e(route('admin.settings')); ?>"
                                  class="form-horizontal" enctype="multipart/form-data">

                                <input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
                                <?php $__currentLoopData = $settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $setting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="form-group">
                                    <label class="col-sm-12 b-r-xl"><?php echo e($setting->local); ?></label>
                                    <div class="col-sm-12 b-r-xl" > <input type="text" class="form-control" name="<?php echo e($setting->key); ?>" id="<?php echo e($setting->key); ?>"
                                                                           value="<?php echo e($setting->value); ?>" required>
                                    </div>
                                </div>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <div class="form-group ">
                                    <div class="col-sm-12">
                                        <button class="btn btn-block btn-outline btn-primary">Guardar</button>
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