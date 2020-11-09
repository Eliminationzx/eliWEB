

<?php $__env->startSection('content'); ?>
<?php $__env->startSection('bodyclass'); ?>
<body>
<?php $__env->stopSection(); ?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <h2>Creando un privilegios</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo e(route('personal')); ?>">Inicio</a>
            </li>
            <li>
                Sistema
            </li>
            <li>
                Privilegios
            </li>
            <li class="active">
                <strong>Creando un privilegios</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Formulario de creación de privilegios</h5>
				</div>
                <div class="ibox-content">
                    <form action="<?php echo e(route('admin.permissions.create')); ?> " method="POST" role="form">
                        <?php echo e(csrf_field()); ?>


                        <div class="form-group">
                            <label for="display_name">Nombre para mostrar privilegios </label>
                            <input type="text" class="form-control" name="display_name" id="" placeholder="Nombre para mostrar ...">
                        </div>

                        <div class="form-group">
                            <label for="name">Variable de privilegio</label>
                            <input type="text" class="form-control" name="name" id="" placeholder="Variable...">
                        </div>

                        <div class="form-group">
                            <label for="description">Descripción de privilegios</label>
                            <input type="text" class="form-control" name="description" id="" placeholder="Descripción...">
                        </div>
                        <div class="form-group text-left">
                            <h3>Agregar privilegio para roles</h3>
                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="i-checks"><label> <input type="checkbox"   name="role[]" value="<?php echo e($role->id); ?>"> <i></i> <?php echo e($role->display_name); ?> </label></div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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