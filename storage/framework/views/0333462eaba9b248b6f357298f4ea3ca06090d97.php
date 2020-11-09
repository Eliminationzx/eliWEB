<?php $__env->startSection('content'); ?>
<?php $__env->startSection('bodyclass'); ?>
<body>
<?php $__env->stopSection(); ?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <h2>Видео</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo e(route('personal')); ?>">Главная</a>
            </li>
            <li>
                Лаунчер
            </li>
            <li>
                Видео
            </li>
            <li class="active">
                <strong>Редактирование видео</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Форма редактирования видео</h5>
				</div>
                <div class="ibox-content">

                    <form action="<?php echo e(route('admin.launcher.videos.update')); ?>" method="POST" role="form" enctype="multipart/form-data">
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" class="form-control" name="videoid" value="<?php echo e($video->id); ?>">

                          <div class="form-group">
                            <label for="name">Название</label>
                            <input type="text" class="form-control" name="name" value="<?php echo e($video->name); ?>" placeholder="Название...">
                        </div>
                        
                        <div class="form-group">
						    <label for="video_source">Видео</label>
                            <input type="file" class="form-control" name="video_source">
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Описание</label>
                            <input type="text" class="form-control" name="description" value="<?php echo e($video->description); ?>" placeholder="Описание...">
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