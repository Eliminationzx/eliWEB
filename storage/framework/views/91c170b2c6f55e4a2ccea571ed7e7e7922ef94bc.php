

<?php $__env->startSection('content'); ?>
<?php $__env->startSection('bodyclass'); ?>
<body>
<?php $__env->stopSection(); ?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <h2>Privilegios</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo e(route('personal')); ?>">Inicio</a>
            </li> 
            <li>
                Sistema
            </li>
            <li class="active">
                <strong>Privilegios</strong>
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
					    <h5>Lista de privilegios</h5>
                        <?php if (\Entrust::can('create-permissions')) : ?>
                        <div class="ibox-tools">
                            <a href="<?php echo e(route('admin.permissions.create')); ?>" class="btn btn-primary btn-xs"><i
                                        class="fa fa-plus"></i> Añadir privilegios
                            </a>
                        </div>
                        <?php endif; // Entrust::can ?>
                    </div>
                    <div class="ibox-content">

                        <div class="project-list">
                            <table class="table table-hover">
                                <tr>
                                    <th style="border-top: 1px solid #ffffff;">Estado</th>
                                    <th style="border-top: 1px solid #ffffff;">Nombre</th>
                                    <th style="border-top: 1px solid #ffffff;">Variable</th>
                                    <th style="border-top: 1px solid #ffffff;">Fecha de creación / actualización</th>
                                </tr>
                                <tbody>


                                <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr id="<?php echo e($permission->id); ?>">

                                        <td class="project-status">
                                            <?php $__empty_1 = true; $__currentLoopData = $permission->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <span class="label label-primary">Es usado</span>
                                                <?php break; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <span class="label label-danger">No utilizado</span>
                                            <?php endif; ?>
                                        </td>

                                        <td class="project-title">
                                            <?php echo e($permission->display_name); ?>

                                        </td>

                                        <td class="project-title">
                                            <?php echo e($permission->name); ?>

                                        </td>

                                        <td class="project-title">
                                            <small>
                                                    Creado por <?php echo e($permission->created_at); ?>

                                                       <br>
                                                    Actualizado <?php echo e($permission->updated_at); ?>


                                            </small>
                                        </td>

                                        <td class="project-actions">
                                            <form action="#" method="POST" role="form">

                                                <input type="hidden" name="url" value="<?php echo e($permission->id); ?>">
                                                <input type="hidden" name="_token" id="token"
                                                       value="<?php echo csrf_token(); ?>">
                                                <?php if (\Entrust::can('update-permissions')) : ?>
                                                <a href="<?php echo e(route('admin.permissions.id', ['id' => $permission->id])); ?>"
                                                   class="btn btn-success btn-sm"><i class="fa fa-pencil"></i> Editar
                                                </a>
                                                <?php endif; // Entrust::can ?>

                                                <?php if (\Entrust::can('delete-permissions')) : ?>
                                                <button class="btn btn-danger btn-sm delete вф"
                                                        data-element-id="<?php echo e($permission->id); ?>" data-method-post="deletepermissions"
                                                        onclick="return false;"><i class="fa fa-times"></i> Eliminar
                                                </button>
                                                <?php endif; // Entrust::can ?>
                                            </form>

                                        </td>
                                    </tr>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                </tbody>
                            </table>
                            <div class="pagination">
                                <?php echo e($permissions->links('vendor.pagination.admin')); ?>

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