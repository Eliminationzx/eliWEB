<?php $__env->startSection('content'); ?>
<?php $__env->startSection('bodyclass'); ?>
<body>
<?php $__env->stopSection(); ?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <h2>Редактирование привелегии</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo e(route('personal')); ?>">Главная</a>
            </li>
            <li>
                Система
            </li>
            <li>
                Привелегии
            </li>
            <li class="active">
                <strong>Редактирование привелегии</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Форма редактирования привилегии</h5>
				</div>
                <div class="ibox-content">

                    <form action="<?php echo e(route('admin.permissions.update')); ?>" method="POST" role="form">
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" class="form-control" name="permissionid" value="<?php echo e($permissions->id); ?>">
                        <div class="form-group">
                            <label for="display_name">Отображаемое имя</label>
                            <input type="text" class="form-control" name="display_name" id=""
                                   value="<?php echo e($permissions->display_name); ?>" placeholder="Отображаемое имя...">
                        </div>
                        <div class="form-group">
                            <label for="name">Переменная</label>
                            <input type="text" class="form-control" name="name" id="" placeholder="Переменная..."
                                   value="<?php echo e($permissions->name); ?>">
                        </div>

                        <div class="form-group">
                            <label for="description">Описание</label>
                            <input type="text" class="form-control" name="description" id="" placeholder="Описание..."
                                   value="<?php echo e($permissions->description); ?>">
                        </div>

                        <div class="form-group text-left">
                            <h3>Добавить привелегию для ролей</h3>
                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="i-checks"><label>
                                        <input type="checkbox"
                                               <?php echo e(in_array($role->id,$role_permissions)?"checked":""); ?>   name="role[]"
                                               value="<?php echo e($role->id); ?>">
                                        <i></i> <?php echo e($role->display_name); ?> </label></div>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>


                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </form>


                </div>

            </div>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>