

<?php $__env->startSection('content'); ?>
<?php $__env->startSection('bodyclass'); ?>
<body>
<?php $__env->stopSection(); ?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <h2>Edición de usuario</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo e(route('personal')); ?>">Inicio</a>
            </li>
            <li>
                Sistema
            </li>
            <li>
                Usuarios
            </li>
            <li class="active">
                <strong>Edición de usuario</strong>
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
					<h5>Formulario de edición del usuario</h5>
				</div>
                <div class="ibox-content">
                    <form action="<?php echo e(route('admin.users.update')); ?>" method="POST" role="form">
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" class="form-control" name="usersid" value="<?php echo e($user->id); ?>">

                        <div class="form-group">
                            <label for="username">Usuario</label>
                            <input type="text" class="form-control" name="username" id=""
                                   value="<?php echo e($user->name); ?>" placeholder="Usuario...">
                        </div>

                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="text" class="form-control" name="email" id="" placeholder="E-mail..."
                                   value="<?php echo e($user->email); ?>">
                        </div>
						
                        <div class="form-group">
                            <label for="password">Nueva contraseña</label>
                            <input type="password" class="form-control" name="password" id="" placeholder="Nueva contraseña..."
                                   value="">
                        </div>

                        <div class="form-group">
                            <label for="repeatpassword">Confirma la contraseña</label>
                            <input type="password" class="form-control" name="repeatpassword" id="" placeholder="Confirmación de contraseña..."
                                   value="">
                        </div>
						 
						<?php $__currentLoopData = explode(',', env('APP_GAME_SERVER_LIST')); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $server): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<div class="form-group">
								<label for="<?php echo e('userid_'.$server); ?>"><?php echo e($server.' id'); ?></label>
								<input type="text" class="form-control" name="<?php echo e('userid_'.$server); ?>" id="" placeholder="ID de la cuenta ..."
									   value="<?php echo e($user['userid_'.$server]); ?>">
							</div>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						
						<div class="form-group">
                            <label for="donate">Puntos de donación</label>
                            <input type="text" class="form-control" name="donate" id="" placeholder="Número de donación...."
                                   value="<?php echo e($user->donate); ?>">
                        </div>
						
						<div class="form-group">
                            <label for="vote">Puntos de votación</label>
                            <input type="text" class="form-control" name="vote" id="" placeholder="Numero de votos...."
                                   value="<?php echo e($user->vote); ?>">
                        </div>
						
						<div class="form-group text-left">
						    <h3>Estado de activación</h3>
                            <div class="i-checks">
							<label>
                                    <input type="checkbox" <?php echo e($user->status == 1 ? "checked":""); ?> name="status" value="<?php echo e($user->status); ?>">
							</label>
							</div>

                        </div>

                        <div class="form-group text-left">
                            <h3>Grupo</h3>
                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="i-checks">
								<label>
                                        <input type="checkbox"
                                               <?php echo e(in_array($role->id,$role_permissions)?"checked":""); ?> name="role[]"
                                               value="<?php echo e($role->id); ?>">
                                        <?php echo e($role->display_name); ?> </label>
							    </div>

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