

<?php $__env->startSection('content'); ?>
<?php $__env->startSection('bodyclass'); ?>
<body>
<?php $__env->stopSection(); ?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <h2>Usuarios</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo e(route('personal')); ?>">Inicio</a>
            </li> 
            <li>
                Sistema
            </li>
            <li class="active">
                <strong>Usuarios</strong>
            </li> 
         </ol>
    </div>
</div>

<div class="chat-message">
	<form method="POST" action="<?php echo e(route('admin.users.search')); ?>"
		  class="form-horizontal" enctype="multipart/form-data">
		<input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
			<div class="input-group">
				<input type="text" name="searchstr" class="form-control" value="" placeholder="Ingrese nombre de usuario o correo electrónico ...">
				<span class="input-group-btn">
					<button type="submit" class="btn btn-primary">Buscar
					</button>
				</span>
			</div>
	</form>
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
						<h5>Lista de usuarios</h5>
					</div>
                    <div class="ibox-content">

                        <div class="project-list">

                            <table class="table table-hover">
                                <tr>
									<th style="border-top: 1px solid #ffffff;">Estado</th>
                                    <th style="border-top: 1px solid #ffffff;">Nombre de usuario</th>
                                    <th style="border-top: 1px solid #ffffff;">Grupo de usuario</th>
                                    <th style="border-top: 1px solid #ffffff;">Email</th>
									<th style="border-top: 1px solid #ffffff;">Puntos de donación</th>
									<th style="border-top: 1px solid #ffffff;">Puntos de votación</th>
                                    <th style="border-top: 1px solid #ffffff;">Fecha de creación / actualización</th>
                                </tr>
                                <tbody>
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr id="<?php echo e($user->id); ?>">
									
										<td class="project-status">
                                            <?php if($user->status == 1): ?>
                                                <span class="label label-primary">Activo</span>
                                            <?php else: ?>
                                                <span class="label label-danger">No activo</span>
                                            <?php endif; ?>
                                        </td>
									
                                        <td class="project-status">
                                            <?php echo e($user->name); ?>

                                        </td>

                                        <td class="project-title">

                                            <?php $__empty_1 = true; $__currentLoopData = $user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <?php echo e($role->name); ?>

                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                Без группы
                                            <?php endif; ?>
                                        </td>

                                        <td class="project-title">
                                            <?php echo e($user->email); ?>

                                        </td>
										
										<td class="project-title">
                                            <?php echo e($user->donate); ?>

                                        </td>
										
										<td class="project-title">
                                            <?php echo e($user->vote); ?>

                                        </td>
										
                                        <td class="project-title">
                                            <small>
                                                    Creado el: <?php echo e($user->created_at); ?>

<br>
                                                    Actualizado: <?php echo e($user->updated_at); ?>


                                            </small>
                                        </td>


                                        <td class="project-actions">
                                            <form action="editnews" method="POST" role="form">

                                                <input type="hidden" name="url" value="<?php echo e($user->id); ?>">
                                                <input type="hidden" name="_token" id="token"
                                                       value="<?php echo csrf_token(); ?>">
                                                <?php if (\Entrust::can('update-users')) : ?>
                                                <a href="<?php echo e(route('admin.users.id', ['id' => $user->id])); ?>"
                                                   class="btn btn-success btn-sm"><i class="fa fa-pencil"></i> Editar
                                                </a>
                                                <?php endif; // Entrust::can ?>
                                                <?php if (\Entrust::can('delete-users')) : ?>
                                                <button class="btn btn-danger btn-sm delete"
                                                        data-element-id="<?php echo e($user->id); ?>" data-method-post="<?php echo e(route('admin.users')); ?>"
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
                                <?php echo e($users->links('vendor.pagination.admin')); ?>

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