<?php $__env->startSection('content'); ?>
<?php $__env->startSection('bodyclass'); ?>
<body>
<?php $__env->stopSection(); ?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <h2>Промокоды</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo e(route('personal')); ?>">Главная</a>
            </li>
            <li>
                Система
            </li>
            <li>
                Промокоды
            </li>
            <li class="active">
                <strong>Создание нового промокода</strong>
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
					<h5>Форма создания промокода</h5>
				</div>
                <div class="ibox-content">
                    <form action="<?php echo e(route('admin.promocodes.create')); ?>" method="POST" role="form">
                        <?php echo e(csrf_field()); ?>

                        
                        <div class="form-group">
                            <label for="name">Название</label>
                            <input type="text" class="form-control" name="name" placeholder="Название...">
                        </div>

                        <div class="form-group">
                            <label for="typeid">Тип:</label>
                            <select name="typeid" data-placeholder="Выберите тип..." class="chosen-select"  tabindex="2">
                                    <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($type->id); ?>"><?php echo e($type->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="code">Код</label>
                            <input type="text" class="form-control" name="code" placeholder="Код...">
                        </div>
                        
                        <div class="form-group">
                            <label for="data0">data0</label>
                            <input type="text" class="form-control" name="data0" value="0" placeholder="data0...">
                        </div>
                        
                        <div class="form-group">
                            <label for="data1">data1</label>
                            <input type="text" class="form-control" name="data1" value="0" placeholder="data1...">
                        </div>
                        
                        <div class="form-group">
                            <label for="usage_count">Количество использований</label>
                            <input type="text" class="form-control" name="usage_count" value="-1" placeholder="Количество использований...">
                        </div>
                        
                        <div class="form-group">
                            <label for="unused_date">Время действия</label>
                            <input type="datetime-local" class="form-control" name="unused_date">
                        </div>
                        
                        <div class="form-group">
                            <label for="realmid">Реалм:</label>
                            <select name="realmid" data-placeholder="Выберите сервер..." class="chosen-select"  tabindex="2">
                                    <?php $__currentLoopData = $realminfos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $realminfo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($realminfo->realmid); ?>"><?php echo e($realminfo->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
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