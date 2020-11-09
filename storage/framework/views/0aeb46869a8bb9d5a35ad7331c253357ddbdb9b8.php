

<?php $__env->startSection('content'); ?>
<?php $__env->startSection('bodyclass'); ?>
<body>
<?php $__env->stopSection(); ?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <h2>Crea un top de votación</h2>
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
                <strong>Crea un top de votación</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <?php if(isset($data['result'])): ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="alert alert-info alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <span class="alert-link"><?php echo e($data['result']); ?></span>
                    .
                </div>
            </div>
        </div>
    <?php endif; ?>


    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Formulario de votación superior</h5>
				</div>
                <div class="ibox-content">
                    <form action="<?php echo e(route('admin.votes.create')); ?>" method="POST" role="form" enctype="multipart/form-data">
                        <?php echo e(csrf_field()); ?>

                        
                        <div class="form-group">
                            <label for="vote_name">Nombre</label>
                            <input type="text" class="form-control" name="vote_name" placeholder="Nombre...">
                        </div>

                        <div class="form-group">
                            <label for="vote_descr">Descripción</label>
                            <input type="text" class="form-control" name="vote_descr" placeholder="Descripción...">
                        </div>
						
                        <div class="form-group">
                            <label for="vote_img">Imagen</label>
                            <input type="file" class="form-control" name="vote_img">
                        </div>

                        <div class="form-group">
                            <label for="vote_reward">Recompensa</label>
                            <input type="text" class="form-control" name="vote_reward" placeholder="Recompensa..." value="0">
                        </div>
						
						<div class="form-group">
                            <label for="vote_url">Enlace de votación </label>
                            <input type="text" class="form-control" name="vote_url" placeholder="Enlace de votación...">
                        </div>
						
					    <?php for($i = 1; $i <= 5; $i++): ?>
					    <div class="form-group">
                            <label for="<?php echo e('vote_log'.$i); ?>">vote log <?php echo e('#'.$i); ?></label>
                            <input type="text" class="form-control" name="<?php echo e('vote_log'.$i); ?>" placeholder="<?php echo e('Enlace para registro de votación #'.$i.'...'); ?>">
                        </div>
						<?php endfor; ?>
                        
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>

            </div>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>