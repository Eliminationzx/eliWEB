<?php $__env->startSection('content'); ?>
<?php $__env->startSection('bodyclass'); ?>
<body>
<?php $__env->stopSection(); ?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <h2>Новости</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo e(route('personal')); ?>">Главная</a>
            </li>
            <li>
                Лаунчер
            </li>
            <li>
                Новости
            </li>
            <li class="active">
                <strong>Создание новой новости</strong>
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
					<h5>Форма создания новости</h5>
				</div>
                <div class="ibox-content">
                    <form action="<?php echo e(route('admin.launcher.news.create')); ?>" method="POST" role="form" enctype="multipart/form-data">
                        <?php echo e(csrf_field()); ?>

                        
                        <div class="form-group">
                            <label for="title">Заголовок</label>
                            <input type="text" class="form-control" name="title" placeholder="Заголовок...">
                        </div>
						
                        <div class="form-group">
                            <label for="body">Содержание</label>
                            <textarea type="text" class="form-control" name="body" placeholder="Содержание..."></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="thumbnail_source">Ссылка на изображение</label>
                            <input type="file" class="form-control" name="thumbnail_source"placeholder="Изображение...">
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