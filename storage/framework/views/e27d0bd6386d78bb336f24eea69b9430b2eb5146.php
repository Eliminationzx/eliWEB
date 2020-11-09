<?php $__env->startSection('content'); ?>
<?php $__env->startSection('bodyclass'); ?>
<body>
<?php $__env->stopSection(); ?>
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Смена фракции</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo e(route('personal')); ?>">Главная</a>
                </li> 
                <li>
                    Персонажи
                </li>  
                <li class="active">
                    <strong>Смена фракции</strong>
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
						<h5>Форма смены фракции персонажа</h5>
					</div>
                    <div class="ibox-content">

                        <div class="project-list">
                            <form method="POST" action="<?php echo e(route('characters.race')); ?>"
                                  class="form-horizontal" enctype="multipart/form-data">

                                <input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">

                                <div class="form-group">
                                    <label class="col-sm-3">Персонаж:</label>
                                    <div class="col-sm-9">
                                        <div class="input-group col-sm-12">
                                            <div>
                                                <select name="guid" data-placeholder="Выберите персонажа..." class="chosen-select"  tabindex="2">
													<?php if($userinfo != null): ?>
														<?php $__currentLoopData = $userinfo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userinf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
															<option value="<?php echo e($userinf->guid.','.$userinf->realm_id); ?>"><?php echo e($userinf->name); ?> (<?php echo e($userinf->realm_name); ?>)</option>
														<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
													<?php endif; ?>
                                                    <?php if($recruiterinfo != null): ?>
                                                         <option disabled>_________Персонажи связанной учетной записи_________</option>
                                                        <?php $__currentLoopData = $recruiterinfo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recruiterinf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($recruiterinf->guid.','.$recruiterinf->realm_id); ?>"><?php echo e($recruiterinf->name); ?> (<?php echo e($recruiterinf->realm_name); ?>)</option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-block btn-outline btn-primary">Сменить фракцию за <?php echo e($price->value); ?> навлонов</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>