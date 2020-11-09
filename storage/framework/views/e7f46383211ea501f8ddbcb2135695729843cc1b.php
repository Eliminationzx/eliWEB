<?php $__env->startSection('content'); ?>
<?php $__env->startSection('bodyclass'); ?>
<body>
<?php $__env->stopSection(); ?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <h2>Роли</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo e(route('personal')); ?>">Главная</a>
            </li> 
            <li>
                Система
            </li>
            <li class="active">
                <strong>Роли</strong>
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
						<h5>Список ролей</h5>
                        <?php if (\Entrust::can('create-roles')) : ?>
                        <div class="ibox-tools">
                            <a href="<?php echo e(route('admin.roles.create')); ?>" class="btn btn-primary btn-xs"><i
                                        class="fa fa-plus"></i> Добавить роль
                            </a>
                        </div>
                        <?php endif; // Entrust::can ?>
                    </div>
                    <div class="ibox-content">

                        <div class="project-list">

                            <table class="table table-hover">
                                <tr>
                                    <th style="border-top: 1px solid #ffffff;">Статус</th>
                                    <th style="border-top: 1px solid #ffffff;">Название</th>
                                    <th style="border-top: 1px solid #ffffff;">Переменная</th>
                                    <th style="border-top: 1px solid #ffffff;">Дата создания / обновления</th>
                                </tr>
                                <tbody>
                                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr id="<?php echo e($role->id); ?>">

                                        <td class="project-status">
                                            <?php $__empty_1 = true; $__currentLoopData = $role->users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <span class="label label-primary">Используется</span>
                                                <?php break; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <span class="label label-danger">Не используется</span>
                                            <?php endif; ?>
                                        </td>

                                        <td class="project-title">
                                            <?php echo e($role->display_name); ?>

                                        </td>

                                        <td class="project-title">
                                            <?php echo e($role->name); ?>

                                        </td>

                                        <td class="project-title">
                                            <small><?php if($role->updated_at == $role->created_at): ?>
                                                    Создана <?php echo e($role->created_at); ?>

                                                <?php else: ?>
                                                    Обновлена <?php echo e($role->updated_at); ?>

                                                <?php endif; ?>
                                            </small>
                                        </td>


                                        <td class="project-actions">
                                            <form action="editnews" method="POST" role="form">

                                                <input type="hidden" name="url" value="<?php echo e($role->id); ?>">
                                                <input type="hidden" name="_token" id="token"
                                                       value="<?php echo csrf_token(); ?>">
                                                <?php if (\Entrust::can('update-roles')) : ?>
                                                <a href="<?php echo e(route('admin.roles.id', ['id' => $role->id])); ?>"
                                                   class="btn btn-success btn-sm"><i class="fa fa-pencil"></i> Редактировать
                                                </a>
                                                <?php endif; // Entrust::can ?>
                                                <?php if (\Entrust::can('delete-roles')) : ?>
                                                <button class="btn btn-danger btn-sm delete"
                                                        data-element-id="<?php echo e($role->id); ?>" data-method-post="deleteroles"
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
                                <?php echo e($roles->links('vendor.pagination.admin')); ?>

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