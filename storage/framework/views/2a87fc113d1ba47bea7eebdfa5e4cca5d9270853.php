<?php $__env->startSection('content'); ?>
<?php $__env->startSection('bodyclass'); ?>
    <body class="gray-bg">
<?php $__env->stopSection(); ?>
    <div class="middle-box text-center loginscreen animated fadeInDown ">
         <div>
            <div>

                <h3 class="logo-name"><?php echo e(config('app.name_short')); ?></h3>

            </div>
            <h3>Форма сброса пароля</h3>
            
            <?php if( session('status')): ?>
                <div class="row">
                        <div class="alert alert-success">
                            <?php echo e(session('status')); ?>

                        </div>
                </div>
            <?php endif; ?>
            
            <form class="m-t" method="POST" action="<?php echo e(url('/password/reset')); ?>">
                <?php echo e(csrf_field()); ?>

				<input type="hidden" name="token" value="<?php echo e($token); ?>">
				   
                <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                    <input id="email" type="email" class="form-control" name="email" value="<?php echo e(isset($email) ? $email : old('email')); ?>"
                           placeholder="E-mail" required autofocus>

                    <?php if($errors->has('email')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('email')); ?></strong>
                        </span>
                    <?php endif; ?>

                </div>

                <div class="form-group<?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                    <input id="password" type="password" class="form-control" name="password" placeholder="Введите пароль"
                           required>

                    <?php if($errors->has('password')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('password')); ?></strong>
                        </span>
                    <?php endif; ?>
                </div>
				
				<div class="form-group<?php echo e($errors->has('password_confirmation') ? ' has-error' : ''); ?>">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Подтвердите пароль"
                           required>

                    <?php if($errors->has('password_confirmation')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('password_confirmation')); ?></strong>
                        </span>
                    <?php endif; ?>
                </div>
                
                <button type="submit" class="btn btn-primary block full-width m-b">Сбросить пароль</button>
            </form>
            <p class="m-t">
                <small>&copy; <?php echo e(now()->year.' '.config('app.name_prj')); ?></small>
            </p>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>