

<?php $__env->startSection('content'); ?>
<?php $__env->startSection('bodyclass'); ?>
<body>
<?php $__env->stopSection(); ?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <h2>Editar un top de votación</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo e(route('personal')); ?>">Inicio</a>
            </li>
            <li>
                Sistema
            </li>
            <li>
                Tops de votación
            </li>
            <li class="active">
                <strong>Editar un top de votación</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <?php if( session('status')): ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="alert alert-info alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <span class="alert-link"><?php echo e(session('status')); ?></span>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Formulario de edición superior de votación</h5>
				</div>
                <div class="ibox-content">
                    <form action="<?php echo e(route('admin.votes.update')); ?>" method="POST" role="form" enctype="multipart/form-data">
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" class="form-control" name="vote_id" value="<?php echo e($vote->id); ?>">

                        <div class="form-group">
                            <label for="vote_name">Nombre</label>
                            <input type="text" class="form-control" name="vote_name" id=""
                                   value="<?php echo e($vote->name); ?>" placeholder="Nombre...">
                        </div>

                        <div class="form-group">
                            <label for="vote_descr">Descripción</label>
                            <input type="text" class="form-control" name="vote_descr" id="" placeholder="Descripción..."
                                   value="<?php echo e($vote->descr); ?>">
                        </div>
						
                        <div class="form-group">
                            <label for="vote_img">Imagen</label>
                            <input type="file" class="form-control" name="vote_img">
                        </div>

                        <div class="form-group">
                            <label for="vote_reward">Recompensa</label>
                            <input type="text" class="form-control" name="vote_reward" id="" placeholder="Recompensa por votar..."
                                   value="<?php echo e($vote->reward); ?>">
                        </div>
						
						<div class="form-group">
                            <label for="vote_url">Enlace de votación</label>
                            <input type="text" class="form-control" name="vote_url" id="" placeholder="Enlace de votación..."
                                   value="<?php echo e($vote->url); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="hostname">Hostname</label>
                            <input type="text" class="form-control" name="hostname" id="" placeholder="Hostname..."
                                   value="<?php echo e($vote->hostname); ?>">
                        </div>

						
						<?php for($i = 1; $i <= 5; $i++): ?>
					    <div class="form-group">
                            <label for="<?php echo e('vote_log'.$i); ?>">vote log <?php echo e('#'.$i); ?></label>
                            <input type="text" class="form-control" name="<?php echo e('vote_log'.$i); ?>" id="" placeholder="<?php echo e('Enlace para registro de votación #'.$i.'...'); ?>"
                                   value="<?php echo e($vote['log_url'.$i]); ?>">
                        </div>
						<?php endfor; ?>
                        
                        <div class="form-group">
                            <label for="inputs">Inputs</label>
                            <input type="text" class="form-control" name="inputs" placeholder="Inputs..." value="<?php echo e($vote->inputs); ?>">
                        </div>
                        
                        <div class="form-group text-left">
						    <h3>Estado de activación</h3>
                            <div class="i-checks">
							<label>
                                    <input type="checkbox" <?php echo e($vote->status == 1 ? "checked":""); ?> name="status" value="<?php echo e($vote->status); ?>">
							</label>
							</div>

                        </div>
                        
                        <div class="form-group text-left">
						    <h3>Clickable only</h3>
                            <div class="i-checks">
							<label>
                                    <input type="checkbox" <?php echo e($vote->clickable_only == 1 ? "checked":""); ?> name="clickable_only" value="<?php echo e($vote->clickable_only); ?>">
							</label>
							</div>

                        </div>
											
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>

                </div>

            </div>

        </div>
    </div>


</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>