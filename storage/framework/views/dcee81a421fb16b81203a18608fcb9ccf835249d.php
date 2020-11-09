<?php $__env->startComponent('mail::layout'); ?>

<?php $__env->slot('header'); ?>
<?php $__env->startComponent('mail::header', ['url' => config('app.url')]); ?>
<?php echo e(config('app.title')); ?>

<?php echo $__env->renderComponent(); ?>
<?php $__env->endSlot(); ?>


#Подтвердите вашу учетную запись!
Уважаемый(ая) <?php echo e($username); ?>, проект <?php echo e(config('app.name_prj')); ?> благодарит Вас за регистрацию! 
Мы рады, что Вы присоединились к нам, и надеемся, что Вам тут понравится.
<?php $__env->startComponent('mail::button', ['url' => route('register.verify', ['email' => $email, 'verify_token' => $token])]); ?>
Подтвердить учетную запись
<?php echo $__env->renderComponent(); ?>


<?php $__env->slot('subcopy'); ?>
<?php $__env->startComponent('mail::subcopy'); ?>             		
Если у вас возникли проблемы с нажатием на кнопку, скопируйте и вставьте URL-адрес, указанный ниже, в веб-браузер.
<?php echo e(route('register.verify', ['email' => $email, 'verify_token' => $token])); ?>	
<?php echo $__env->renderComponent(); ?>
<?php $__env->endSlot(); ?>


<?php $__env->slot('footer'); ?>
<?php $__env->startComponent('mail::footer'); ?>
© <?php echo e(date('Y')); ?> <?php echo e(config('app.name_prj')); ?>. <?php echo app('translator')->getFromJson('All rights reserved.'); ?>
<?php echo $__env->renderComponent(); ?>
<?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
