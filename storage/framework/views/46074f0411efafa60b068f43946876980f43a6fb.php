<?php $__env->startSection('content'); ?>
<?php $__env->startSection('bodyclass'); ?>
<body>
<?php $__env->stopSection(); ?>
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Эфириальные монеты</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo e(route('personal')); ?>">Главная</a>
                </li> 
                <li>
                    Игровая валюта
                </li>  
                <li class="active">
                    <strong>Эфириальные монеты</strong>
                </li> 
            </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">

        <div class="row">
            <div class="col-lg-12">

                <div class="ibox">
					<div class="ibox-title">
						<h5>Форма покупки эфириальных монет</h5>
					</div>
                    <div class="ibox-content">

                        <div class="project-list">
                            <?php if( session('status')): ?>
                                <div class="alert alert-<?php echo e(session('type')); ?>">
                                    <?php echo e(session('status')); ?>

                                </div>
                            <?php endif; ?>
                                <div class="col-lg-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <i class="fa fa-info-circle"></i> Полезная информация
                                        </div>
                                        <div class="panel-body">
                                            <p>На текущий период времени вы можете приобрести эфириальные монеты по курсу <b><?php echo e($price->value); ?>:1</b></p>
                                        </div>
                                    </div>
                                </div>
                            <form method="POST" action="<?php echo e(route('currency.ether')); ?>" class="form-horizontal" enctype="multipart/form-data">

                                <input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
                                <input type="hidden" id="price" value="<?php echo e($price->value); ?>" type="text">
                                
                                <div class="form-group">
                                    <label class="col-sm-3">Получаете:</label>
                                    <div class="col-sm-9">
                                        <div class="input-group col-sm-12">
                                            <div>
                                                <input type="text" onfocus="calculate(this)" class="form-control" name="cur_count" id="cur_count" value="" placeholder="Введите количество эфириальных монет...">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3">Отдаете:</label>
                                    <div class="col-sm-9">
                                        <div class="input-group col-sm-12">
                                            <div>
                                                <input type="text" onfocus="calculate(this)" class="form-control" name="bp_count" id="bp_count" value="" placeholder="Введите количество бонусов...">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3">Персонаж:</label>
                                    <div class="col-sm-9">
                                        <div class="input-group col-sm-12">
                                            <div>
                                                <select name="guid" data-placeholder="Выберите персонажа..." class="chosen-select"  tabindex="2">
                                                    <?php if($userinfo != null): ?>
														<?php $__currentLoopData = $userinfo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userinf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
															<option value="<?php echo e($userinf->guid.','.$userinf->realm_id); ?>"><?php echo e($userinf->name); ?> (<?php echo e($userinf->realm_name); ?>)</option>
														<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
													<?php endif; ?>
                                                    <?php if($recruiterinfo != null): ?>
                                                         <option disabled>_________Персонажи связанной учетной записи_________</option>
                                                        <?php $__currentLoopData = $recruiterinfo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recruiterinf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($recruiterinf->guid.','.$recruiterinf->realm_id); ?>"><?php echo e($recruiterinf->name); ?> (<?php echo e($recruiterinf->realm_name); ?>)</option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-block btn-outline btn-primary">Подтвердить покупку</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

<script>
function calculate(elem) {
   var input = document.querySelectorAll('#' + elem.id);
   var res;
   for (let i = 0; i < input.length; i++) {
        input[i].addEventListener('input', function() {
           if (elem.id === 'cur_count') {
               if (cur_count.value !== '') {
                   res = cur_count.value * price.value;
                   bp_count.value = Math.ceil(res);                                                           
               }
           } else if (elem.id === 'bp_count') {
               if (bp_count.value !== '') {
                   res = bp_count.value / price.value;
                   cur_count.value = Math.ceil(res);
               }
           }
       })
   }
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>