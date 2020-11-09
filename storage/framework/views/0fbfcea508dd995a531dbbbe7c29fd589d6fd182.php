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
                <strong>Редактирование новости</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Форма редактирования новости</h5>
				</div>
                <div class="ibox-content">

                    <form action="<?php echo e(route('admin.launcher.news.update')); ?>" method="POST" role="form" enctype="multipart/form-data">
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" class="form-control" name="newsid" value="<?php echo e($news->id); ?>">

                        <div class="form-group">
                            <label for="title">Заголовок</label>
                            <input type="text" class="form-control" name="title" value="<?php echo e($news->title); ?>" placeholder="Заголовок...">
                        </div>
                        
                        <div class="form-group">
                            <label for="body">Содержание</label>
                            <textarea type="text" class="form-control" name="body" placeholder="Содержание..."><?php echo e($news->body); ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="thumbnail_source">Изображение</label>
                            <input type="file" class="form-control" name="thumbnail_source" placeholder="Изображение...">
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