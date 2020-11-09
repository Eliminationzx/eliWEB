

<?php $__env->startSection('content'); ?>
<?php $__env->startSection('bodyclass'); ?>
<body>
<?php $__env->stopSection(); ?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <h2>Tops de votación</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo e(route('personal')); ?>">Inicio</a>
            </li> 
            <li>
                Sistema
            </li>
            <li class="active">
                <strong>Tops de votación</strong>
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
						<h5>Lista de tapas de votación</h5>
                        <?php if (\Entrust::can('create-votes')) : ?>
                        <div class="ibox-tools">
                            <a href="<?php echo e(route('admin.votes.create')); ?>" class="btn btn-primary btn-xs"><i
                                        class="fa fa-plus"></i> Agregar Topsite
                            </a>
                        </div>
                        <?php endif; // Entrust::can ?>
                    </div>
                    <div class="ibox-content">

                        <div class="project-list">

                            <table class="table table-hover">
                                <tr>
								    <th style="border-top: 1px solid #ffffff;">ID</th>
                                    <th style="border-top: 1px solid #ffffff;">Nombre</th>
                                    <th style="border-top: 1px solid #ffffff;">Descripción</th>
                                    <th style="border-top: 1px solid #ffffff;">Imagen</th>
                                    <th style="border-top: 1px solid #ffffff;">Recompensa</th>
									<th style="border-top: 1px solid #ffffff;">Fecha de creación / actualización</th>
                                </tr>
                                <tbody>
                                <?php $__currentLoopData = $votes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vote): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr id="<?php echo e($vote->id); ?>">

										<td class="project-title">
                                            <?php echo e($vote->id); ?>

                                        </td>
										
                                        <td class="project-title">
                                            <?php echo e($vote->name); ?>

                                        </td>

                                        <td class="project-title">
											<?php echo e($vote->descr); ?>

                                        </td>

                                        <td class="project-title">
                                           	<img src="<?php echo e($vote->img); ?>"/>
                                        </td>
										
										<td class="project-title">
                                            <?php echo e($vote->reward); ?> PD
                                        </td>

                                        <td class="project-title">
                                            <small>
                                                    Creado el: <?php echo e($vote->created_at); ?>

<br>
                                                    Actualizado: <?php echo e($vote->updated_at); ?>


                                            </small>
                                        </td>
										
										
                                        <td class="project-actions">
                                            <form action="editnews" method="POST" role="form">

                                                <input type="hidden" name="url" value="<?php echo e($vote->id); ?>">
                                                <input type="hidden" name="_token" id="token"
                                                       value="<?php echo csrf_token(); ?>">
                                                <?php if (\Entrust::can('update-votes')) : ?>
                                                <a href="<?php echo e(route('admin.votes.id', ['id' => $vote->id])); ?>"
                                                   class="btn btn-success btn-sm"><i class="fa fa-pencil"></i> Editar
                                                </a>
                                                <?php endif; // Entrust::can ?>
                                                <?php if (\Entrust::can('delete-votes')) : ?>
                                                <button class="btn btn-danger btn-sm delete"
                                                        data-element-id="<?php echo e($vote->id); ?>" data-method-post="<?php echo e(route('admin.votes.delete')); ?>"
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
                                <?php echo e($votes->links('vendor.pagination.admin')); ?>

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