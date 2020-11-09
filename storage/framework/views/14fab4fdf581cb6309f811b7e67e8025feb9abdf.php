

<?php $__env->startSection('content'); ?>
<?php $__env->startSection('bodyclass'); ?>
<body>
<?php $__env->stopSection(); ?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <h2>Adding a new shop item</h2>
         <ol class="breadcrumb">
            <li>
                <a href="<?php echo e(route('personal')); ?>">Home</a>
            </li>  
            <li class="active">
                <strong>Shop</strong>
            </li> 
         </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <?php if(isset($data['result'])): ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="alert alert-info alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <span class="alert-link"><?php echo e($data['result']); ?></span>.
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Adding a new shop item form</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <form method="POST" action="<?php echo e(route('admin.shop.create')); ?>" class="form-horizontal" enctype="multipart/form-data">

                        <input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">

                        <div class="form-group">
                            <label class="col-sm-12 b-r-xl">Name:</label>
                            <div class="col-sm-12 b-r-xl" > <input type="text" class="form-control" name="name" id="name"
                                                                   value="" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-12 b-r-xl">Price:</label>
                            <div class="col-sm-12 b-r-xl" > <input type="text" class="form-control" name="price" id="price"
                                                                   value="" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-12">Item ID:</label>
                            <div class="col-sm-12"><input type="text" class="form-control" name="itemid"
                                                          id="itemid"
                                                          value="" required></div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-12">Quantity:</label>
                            <div class="col-sm-12"><input type="text" class="form-control" name="count"
                                                          id="count"
                                                          value="" required></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12">Category:</label>
                            <div class="col-sm-12"><select name="categoryid" data-placeholder="Select a category..." class="chosen-select"  tabindex="2">
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($category->id); ?>"><?php echo e($category->local); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12">Realm:</label>
                            <div class="col-sm-12"><select name="realmid" data-placeholder="Select a server..." class="chosen-select"  tabindex="2">
                                    <?php $__currentLoopData = $realminfos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $realminfo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($realminfo->realmid); ?>"><?php echo e($realminfo->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select></div>
                        </div>
                        <div class="form-group ">
                            <div class="col-sm-12">
                                <button class="btn btn-block btn-outline btn-primary">Add item</button>
                            </div>
                        </div>


                    </form>


                </div>

            </div>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>