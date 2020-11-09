<?php $__env->startSection('content'); ?>
<?php $__env->startSection('bodyclass'); ?>
<?php $__env->stopSection(); ?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <h2>History of activity</h2>
         <ol class="breadcrumb">
            <li>
                <a href="<?php echo e(route('personal')); ?>">Home</a>
            </li> 
            <li>
                Account
            </li>  
            <li class="active">
                <strong>History of activity</strong>
            </li>   
         </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
				<div class="ibox-title">
					<h5>Account history</h5>
				</div>
                <div class="ibox-content">
                    <div class="project-list">
                        <table class="table table-hover">
                            <tr>
                                <td class="project-title">
                                   <b>Event</b>
                                </td>
                                <td class="project-title">
                                   <b>IP</b>
                                </td>
                                <td class="project-title">
                                   <b>Time</b>
                                </td>
                            </tr>
                            <tbody>
                            <?php $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr id="<?php echo e($activity->id); ?>">

                                    <td class="project-title">
                                        <?php echo e($activity->comment); ?>

                                    </td>

                                    <td class="project-title">
                                        <?php echo e($activity->ip); ?>

                                    </td>

                                    <td class="project-title">
                                        <small><?php echo e($activity->created_at); ?></small>
                                    </td>
                                </tr>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                            </tbody>
                        </table>
                        <div class="pagination">
                            <?php echo e($activities->links('vendor.pagination.admin')); ?>

                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>