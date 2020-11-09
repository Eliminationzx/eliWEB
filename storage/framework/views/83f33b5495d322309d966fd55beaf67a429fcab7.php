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
            <li class="active">
                <strong>Промокоды</strong>
            </li> 
         </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <?php if( session('status')): ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="alert alert-info alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <span class="alert-link"><?php echo e(session('status')); ?></span>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content animated fadeInUp">
                <div class="ibox">
					<div class="ibox-title">
						<h5>Список промокодов</h5>
                        <?php if (\Entrust::can('create-promocodes')) : ?>
                        <div class="ibox-tools">
                            <a href="<?php echo e(route('admin.promocodes.create')); ?>" class="btn btn-primary btn-xs"><i
                                        class="fa fa-plus"></i> Добавить промокод
                            </a>
                        </div>
                        <?php endif; // Entrust::can ?>
                    </div>
                    <div class="ibox-content">

                        <div class="project-list">

                            <table class="table table-hover">
                                <tr>
                                    <th style="border-top: 1px solid #ffffff;">ID</th>
                                    <th style="border-top: 1px solid #ffffff;">Реалм</th>
                                    <th style="border-top: 1px solid #ffffff;">Название</th>
                                    <th style="border-top: 1px solid #ffffff;">Тип</th>
                                    <th style="border-top: 1px solid #ffffff;">Код</th>
                                    <th style="border-top: 1px solid #ffffff;">Количество использований</th>
                                    <th style="border-top: 1px solid #ffffff;">Время действия</th>
                                    <th style="border-top: 1px solid #ffffff;">Дата создания / обновления</th>
                                </tr>
                                <tbody>
                                <?php $__currentLoopData = $promocodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $promocode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr id="<?php echo e($promocode->id); ?>">
                                    
                                        <td class="project-title">
                                            <?php echo e($promocode->id); ?>

                                        </td>
                                        
                                        <td class="project-title">
                                            <?php echo e($promocode->realm_name); ?>

                                        </td>

                                        <td class="project-title">
                                            <?php echo e($promocode->name); ?>

                                        </td>
                                        
                                        <td class="project-title">
                                            <?php echo e($promocode->type_name); ?>

                                        </td>

                                        <td class="project-title">
                                            <?php echo e($promocode->code); ?>

                                        </td>
                                        
                                        <td class="project-title">
                                            <?php if($promocode->usage_count > -1): ?>
                                               <?php if($promocode->usage_count == 0): ?>
                                                    израсходован
                                               <?php else: ?>
                                                    <?php echo e($promocode->usage_count); ?>

                                                <?php endif; ?>
                                            <?php else: ?>
                                               без ограничения
                                            <?php endif; ?>
                                        </td>

                                        <td class="project-title">
                                            <?php if($promocode->unused_date > 0): ?>
                                                до <?php echo e(date("d-m-Y H:i:s", $promocode->unused_date)); ?>

                                            <?php else: ?>
                                                без ограничения
                                            <?php endif; ?>
                                        </td>
                                        
                                        <td class="project-title">
                                            <small><?php if($promocode->updated_at == $promocode->created_at): ?>
                                                    Создана <?php echo e($promocode->created_at); ?>

                                                <?php else: ?>
                                                    Обновлена <?php echo e($promocode->updated_at); ?>

                                                <?php endif; ?>
                                            </small>
                                        </td>


                                        <td class="project-actions">
                                            <form action="editnews" method="POST" role="form">

                                                <input type="hidden" name="url" value="<?php echo e($promocode->id); ?>">
                                                <input type="hidden" name="_token" id="token"
                                                       value="<?php echo csrf_token(); ?>">
                                                <?php if (\Entrust::can('update-promocodes')) : ?>
                                                <a href="<?php echo e(route('admin.promocodes.id', ['id' => $promocode->id])); ?>"
                                                   class="btn btn-success btn-sm"><i class="fa fa-pencil"></i> Редактировать
                                                </a>
                                                <?php endif; // Entrust::can ?>
                                                <?php if (\Entrust::can('delete-promocodes')) : ?>
                                                <button class="btn btn-danger btn-sm delete"
                                                        data-element-id="<?php echo e($promocode->id); ?>" data-method-post="<?php echo e(route('admin.promocodes.delete')); ?>"
                                                        onclick="return false;"><i class="fa fa-times"></i> Удалить
                                                </button>
                                                <?php endif; // Entrust::can ?>
                                            </form>

                                        </td>
                                    </tr>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                </tbody>
                            </table>
                            <div class="pagination">
                                <?php echo e($promocodes->links('vendor.pagination.admin')); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>