

<?php $__env->startSection('content'); ?>
<?php $__env->startSection('bodyclass'); ?>
<body>
<?php $__env->stopSection(); ?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <h2>Videos</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo e(route('personal')); ?>">Home</a>
            </li> 
            <li>
                Launcher
            </li>
            <li class="active">
                <strong>Videos</strong>
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
						<h5>Список видео</h5>
                        <?php if (\Entrust::can('create-launcher-videos')) : ?>
                        <div class="ibox-tools">
                            <a href="<?php echo e(route('admin.launcher.videos.create')); ?>" class="btn btn-primary btn-xs"><i
                                        class="fa fa-plus"></i> Add video
                            </a>
                        </div>
                        <?php endif; // Entrust::can ?>
                    </div>
                    <div class="ibox-content">

                        <div class="project-list">

                            <table class="table table-hover">
                                <tr>
                                    <th style="border-top: 1px solid #ffffff;">ID</th>
                                    <th style="border-top: 1px solid #ffffff;">Title</th>
                                    <th style="border-top: 1px solid #ffffff;">Video</th>
                                    <th style="border-top: 1px solid #ffffff;">Date of creation / update</th>
                                </tr>
                                <tbody>
                                <?php $__currentLoopData = $videos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $video): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr id="<?php echo e($video->id); ?>">
                                    
                                        <td class="project-title">
                                            <?php echo e($video->id); ?>

                                        </td>
                                        
                                        <td class="project-title">
                                            <?php echo e($video->name); ?>

                                        </td>

                                        <td class="project-title">
                                            <a href="<?php echo e($video->source_url); ?>" target="_blank"><?php echo e(mb_substr($video->source_url, 0, 40).'...'); ?></a>
                                        </td>
                                        
                                        
                                        <td class="project-title">
                                            <small><?php if($video->updated_at == $video->created_at): ?>
                                                    Created <?php echo e($video->created_at); ?>

                                                <?php else: ?>
                                                    Updated <?php echo e($video->updated_at); ?>

                                                <?php endif; ?>
                                            </small>
                                        </td>


                                        <td class="project-actions">
                                            <form action="editnews" method="POST" role="form">

                                                <input type="hidden" name="url" value="<?php echo e($video->id); ?>">
                                                <input type="hidden" name="_token" id="token"
                                                       value="<?php echo csrf_token(); ?>">
                                                <?php if (\Entrust::can('update-launcher-videos')) : ?>
                                                <a href="<?php echo e(route('admin.launcher.videos.id', ['id' => $video->id])); ?>"
                                                   class="btn btn-success btn-sm"><i class="fa fa-pencil"></i> Edit
                                                </a>
                                                <?php endif; // Entrust::can ?>
                                                <?php if (\Entrust::can('delete-launcher-videos')) : ?>
                                                <button class="btn btn-danger btn-sm delete"
                                                        data-element-id="<?php echo e($video->id); ?>" data-method-post="<?php echo e(route('admin.launcher.videos.delete')); ?>"
                                                        onclick="return false;"><i class="fa fa-times"></i> Delete
                                                </button>
                                                <?php endif; // Entrust::can ?>
                                            </form>

                                        </td>
                                    </tr>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                </tbody>
                            </table>
                            <div class="pagination">
                                <?php echo e($videos->links('vendor.pagination.admin')); ?>

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