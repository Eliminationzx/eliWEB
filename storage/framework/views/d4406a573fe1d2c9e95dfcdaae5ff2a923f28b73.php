

<?php $__env->startSection('content'); ?>
<?php $__env->startSection('bodyclass'); ?>
    <body class="gray-bg">
<?php $__env->stopSection(); ?>
    <div class="middle-box text-center loginscreen animated fadeInDown ">
         <div>
            <div>

                <h3 class="logo-name"><?php echo e(config('app.name_short')); ?></h3>

            </div>
            <h3>Solicitud de recuperación de contraseña</h3>
            
            <?php if( session('status')): ?>
                <div class="row">
                      <div class="alert alert-success">
                            <?php echo e(session('status')); ?>

                        </div>
                </div>
            <?php endif; ?>
            
            <form class="m-t" method="POST" action="<?php echo e(url('/password/email')); ?>">
                <?php echo e(csrf_field()); ?>

                <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                    <input id="email" type="email" class="form-control" name="email" value="<?php echo e(old('email')); ?>"
                           placeholder="E-mail" required autofocus>

                    <?php if($errors->has('email')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('email')); ?></strong>
                        </span>
                    <?php endif; ?>

                </div>
                
                <button type="submit" class="btn btn-primary block full-width m-b">Enviar</button>

                <p class="text-muted text-center">
                    <small>¿No tienes una cuenta?</small>
                </p>
                <a class="btn btn-sm btn-white btn-block" href="<?php echo e(url('/register')); ?>">Crea una cuenta</a>
				<p class="text-muted text-center">
                    <small>Ya tienes una cuenta?</small>
                </p>
                <a class="btn btn-sm btn-white btn-block" href="<?php echo e(url('/login')); ?>">Iniciar sesión</a>
            </form>
            <p class="m-t">
                <small>&copy; <?php echo e(now()->year.' '.config('app.name_prj')); ?></small>
            </p>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>