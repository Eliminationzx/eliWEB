<?php $__env->startSection('content'); ?>
<?php $__env->startSection('bodyclass'); ?>
<body>
<?php $__env->stopSection(); ?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <h2>Редактирование товара</h2>
         <ol class="breadcrumb">
            <li>
                <a href="<?php echo e(route('personal')); ?>">Главная</a>
            </li>  
            <li class="active">
                <strong>Магазин</strong>
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
                    <h5>Форма редактирования товара</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <form method="POST" action="<?php echo e(route('admin.shop.update')); ?>" class="form-horizontal" enctype="multipart/form-data">

                        <input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">

                        <div class="form-group">
                            <label class="col-sm-12 b-r-xl">Название:</label>
                            <div class="col-sm-12 b-r-xl" > <input type="text" class="form-control" name="name" id="name"
                                                                   value="<?php echo e($shopitem['name']); ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-12 b-r-xl">Цена:</label>
                            <div class="col-sm-12 b-r-xl" > <input type="text" class="form-control" name="price" id="price"
                                                                   value="<?php echo e($shopitem['price']); ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-12">Идентификатор предмета:</label>
                            <div class="col-sm-12"><input type="text" class="form-control" name="itemid"
                                                          id="itemid"
                                                          value="<?php echo e($shopitem['itemid']); ?>" required></div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-12">Количество:</label>
                            <div class="col-sm-12"><input type="text" class="form-control" name="count"
                                                          id="count"
                                                          value="<?php echo e($shopitem['count']); ?>" required></div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-12">Выберите реалм:</label>
                            <div class="col-sm-12"><select name="realmid" data-placeholder="Выберите сервер..." class="chosen-select"  tabindex="2">
                                    <option disabled>Выберите реалм...</option>
                                    <?php $__currentLoopData = $realminfos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $realminfo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($realminfo->realmid); ?>"><?php echo e($realminfo->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select></div>
                        </div>

                        <input type="hidden" name="idshop" value="<?php echo e($shopitem['id']); ?>">

                        <div class="form-group ">
                            <div class="col-sm-12">
                                <button class="btn btn-block btn-outline btn-primary">Изменить товар</button>
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