

<?php $__env->startSection('content'); ?>
<?php $__env->startSection('bodyclass'); ?>
<body>
<?php $__env->stopSection(); ?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <h2>Categorías de Producto</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo e(route('personal')); ?>">Inicio</a>
            </li> 
            <li>
                Sistema
            </li>
            <li class="active">
                <strong>Categorías de Producto</strong>
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
					    <h5>Lista de categorías de productos</h5>
                        <?php if (\Entrust::can('create-shopcategories')) : ?>
                        <div class="ibox-tools">
                            <a href="<?php echo e(route('admin.shopcategories.create')); ?>" class="btn btn-primary btn-xs"><i
                                        class="fa fa-plus"></i> Añadir categoría
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
                                    <th style="border-top: 1px solid #ffffff;">Variable</th>
                                    <th style="border-top: 1px solid #ffffff;">Fecha de creación / actualización</th>
                                </tr>
                                <tbody>
                                <?php $__currentLoopData = $shopcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shopcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr id="<?php echo e($shopcategory->id); ?>">
                                    
                                        <td class="project-title">
                                            <?php echo e($shopcategory->id); ?>

                                        </td>

                                        <td class="project-title">
                                            <?php echo e($shopcategory->local); ?>

                                        </td>

                                        <td class="project-title">
                                            <?php echo e($shopcategory->name); ?>

                                        </td>

                                        <td class="project-title">
                                            <small><?php if($shopcategory->updated_at == $shopcategory->created_at): ?>
                                                    Creado el <?php echo e($shopcategory->created_at); ?>

                                                <?php else: ?>
                                                    Actualizado <?php echo e($shopcategory->updated_at); ?>

                                                <?php endif; ?>
                                            </small>
                                        </td>


                                        <td class="project-actions">
                                            <form action="editnews" method="POST" role="form">

                                                <input type="hidden" name="url" value="<?php echo e($shopcategory->id); ?>">
                                                <input type="hidden" name="_token" id="token"
                                                       value="<?php echo csrf_token(); ?>">
                                                <?php if (\Entrust::can('update-shopcategories')) : ?>
                                                <a href="<?php echo e(route('admin.shopcategories.id', ['id' => $shopcategory->id])); ?>"
                                                   class="btn btn-success btn-sm"><i class="fa fa-pencil"></i> Editar
                                                </a>
                                                <?php endif; // Entrust::can ?>
                                                <?php if (\Entrust::can('delete-shopcategories')) : ?>
                                                <button class="btn btn-danger btn-sm delete"
                                                        data-element-id="<?php echo e($shopcategory->id); ?>" data-method-post="deleteshopcategories"
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
                                <?php echo e($shopcategories->links('vendor.pagination.admin')); ?>

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