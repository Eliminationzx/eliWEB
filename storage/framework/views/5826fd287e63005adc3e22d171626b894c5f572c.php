<?php $__env->startSection('content'); ?>
<?php $__env->startSection('bodyclass'); ?>
<body>
<?php $__env->stopSection(); ?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <h2>Созданние новой категории товаров</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo e(route('personal')); ?>">Главная</a>
            </li>
            <li>
                Система
            </li>
            <li>
                Управление категориями товаров
            </li>
            <li class="active">
                <strong>Создание новой категории товаров</strong>
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
					<h5>Форма создания категории товаров</h5>
				</div>
                <div class="ibox-content">
                    <form action="<?php echo e(route('admin.shopcategories.create')); ?>" method="POST" role="form">
                        <?php echo e(csrf_field()); ?>


                        <div class="form-group">
                            <label for="name">Переменная</label>
                            <input type="text" class="form-control" name="name" id="" placeholder="Переменная...">
                        </div>
                        
                        <div class="form-group">
                            <label for="display_name">Отображаемое имя категории</label>
                            <input type="text" class="form-control" name="display_name" id="" placeholder="Отображаемое имя...">
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