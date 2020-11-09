<?php $__env->startSection('content'); ?>
<?php $__env->startSection('bodyclass'); ?>
    <body class="gray-bg">
    <?php $__env->stopSection(); ?>
    <div class="middle-box text-center loginscreen   animated fadeInDown">
        <div>
            <div>
                <h3 class="logo-name"><?php echo e(config('app.name_short')); ?></h3>
            </div>
            
            <?php if( session('status')): ?>
                <div class="row">
                        <div class="alert alert-<?php echo e(session('type')); ?>">
                        <?php echo e(session('status')); ?>

                        </div>
                </div>
            <?php else: ?>
                <div class="row">
                        <div class="alert alert-info">
                            Электронное письмо активации будет отправлено на ваш адрес электронной почты после завершения регистрации.Это может занять до 30 минут.<br />
                            (Обязательно проверьте папку со спамом)
                        </div>
                </div>
            <?php endif; ?>

            <form class="m-t<?php echo e($errors->has('other') ? ' has-error' : ''); ?>" method="POST" action="<?php echo e(url('/register')); ?>">
                <?php echo e(csrf_field()); ?>


                <div class="form-group<?php echo e($errors->has('name') ? ' has-error' : ''); ?>">

                    <input id="name" type="text" class="form-control" name="name" value="<?php echo e(old('name')); ?>" required
                           placeholder="Логин" autofocus>

                    <?php if($errors->has('name')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('name')); ?></strong>
                        </span>
                    <?php endif; ?>

                </div>

                <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">

                    <input id="email" type="email" class="form-control" name="email" value="<?php echo e(old('email')); ?>"
                           placeholder="E-mail" required>

                    <?php if($errors->has('email')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('email')); ?></strong>
                        </span>
                    <?php endif; ?>

                </div>

                <div class="form-group<?php echo e($errors->has('password') ? ' has-error' : ''); ?>">

                    <input id="password" type="password" class="form-control" name="password" required
                           placeholder="Введите пароль">

                    <?php if($errors->has('password')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('password')); ?></strong>
                        </span>
                    <?php endif; ?>

                </div>

                <div class="form-group">


                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                           required placeholder="Повторите пароль">

                </div>
                <div class="form-group<?php echo e($errors->has('recruiter_name') ? ' has-error' : ''); ?>">
                <?php if($recruiter): ?>
                    <input type="text" class="form-control" readonly value="Пригласил: <?php echo e($recruiter->name); ?>">
                    <input id="recruiter-name" type="hidden" class="form-control" readonly name="recruiter_name" value="<?php echo e($recruiter->name); ?>">
                <?php else: ?>
                    <input id="recruiter-name" type="text" class="form-control" name="recruiter_name" value="" placeholder="Пригласивший (Не обязательно)">
                <?php endif; ?>
                <?php if($errors->has('recruiter_name')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('recruiter_name')); ?></strong>
                    </span>
                <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <input id="phone-number" type="text" onKeyPress="cislo()" class="form-control" name="phone" data-mask="+7(999) 99-99-999" value="" placeholder="Телефон (Не обязательно)">
                </div>

                <div class="form-group<?php echo e($errors->has('terms') ? ' has-error' : ''); ?>">
                    <div class="checkbox checkbox-primary">
                        <input id="terms" type="checkbox" name="terms" value="yes">
                        <label id="checkbox"><small>Принимаю <a href="" data-toggle="modal" data-target=".bs-modal-lg"><b>лицензионное соглашение</b></a></small> </label>
                    </div>                   
                     <?php if($errors->has('terms')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('terms')); ?></strong>
                        </span>
                    <?php endif; ?>
                </div>
                
                <div class="form-group<?php echo e($errors->has('g-recaptcha-response') ? ' has-error' : ''); ?>">
                               
                    <?php if(env('GOOGLE_RECAPTCHA_KEY')): ?>
                         <div class="g-recaptcha"
                              data-sitekey="<?php echo e(env('GOOGLE_RECAPTCHA_KEY')); ?>">
                         </div>
                    <?php endif; ?>
                               
                    <?php if($errors->has('g-recaptcha-response')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('g-recaptcha-response')); ?></strong>
                        </span>
                    <?php endif; ?>
                </div>
                               
                <button type="submit" class="btn btn-primary block full-width m-b">Зарегистрироваться</button>
                
                <?php if($errors->has('other')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('other')); ?></strong>
                    </span>
                <?php endif; ?>

                <p class="text-muted text-center">
                    <small>У вас уже есть аккаунт?</small>
                </p>
                <a class="btn btn-sm btn-white btn-block" href="<?php echo e(url('/login')); ?>">Войти</a>
            </form>
            <p class="m-t">
                <small>&copy; <?php echo e(now()->year.' '.config('app.name_prj')); ?></small>
            </p>
        </div>
                <div class="modal fade bs-modal-lg" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Закрыть</span></button>
                            <h4 class="modal-title">Лицензионное соглашение</h4>
                        </div>
                        <div class="modal-body">
                           
                        </div>
                        <div class="modal-footer">

                            <button type="button" class="btn btn-primary" data-dismiss="modal">Всё понятно</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>
    </div>
    <script>
    function cislo(){
        if (event.keyCode < 48 || event.keyCode > 57)
            event.returnValue= false;
    }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>