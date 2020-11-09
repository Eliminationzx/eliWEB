<?php $__env->startSection('content'); ?>
<?php $__env->startSection('bodyclass'); ?>
<body>
<?php $__env->stopSection(); ?>
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Пополнение баланса</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo e(route('personal')); ?>">Главная</a>
                </li> 
                <li>
                    Аккаунт
                </li>  
                <li class="active">
                    <strong>Пополнение баланса</strong>
                </li> 
            </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">

        <div class="row">
            <div class="col-lg-12">

                <div class="ibox">
				    <div class="ibox-title">
						<h5>Форма пополнения баланса</h5>
					</div>
                    <div class="ibox-content">

                        <div class="project-list">
                            <div class="col-lg-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                        <i class="fa fa-info-circle"></i> Полезная информация
                                        </div>
                                        <div class="panel-body">
                                        <ul>
                                            <li>1 навлон = 1 руб</li>
                                            <li>Минимальная сумма пополнения - 1 руб</li>
                                            <li>Оплата с помощью ЯД, банковской карты или моб. счета</li>
                                            <li>Бонусы поступают на счет мгновенно без комиссии</li>
                                        </ul>
                                        </div>
                                    </div>
									<div class="alert alert-success">
                                        На вашем счете <?php echo e($data->donate); ?> навлон(ов)
                                    </div>
                                </div>
                            <form method="POST" action="https://money.yandex.ru/quickpay/confirm.xml"
                                  class="form-horizontal" enctype="multipart/form-data">
                                <input type="hidden" name="receiver" value="<?php echo e(env('YANDEX_WALLET_ID')); ?>">
                                <input type="hidden" name="formcomment"
                                       value="Пополнение баланса в личном кабинете <?php echo e(config('app.name_prj')); ?>">
                                <input type="hidden" name="short-dest"
                                       value="Пополнение баланса в личном кабинете <?php echo e(config('app.name_prj')); ?>">
                                <input type="hidden" name="label" value="<?php echo e($data->id); ?>">
                                <input type="hidden" name="quickpay-form" value="shop">
                                <input type="hidden" name="targets" value="Пополнение баланса в личном кабинете <?php echo e(config('app.name_prj')); ?>">
                                <input type="hidden" name="successURL" value="<?php echo e(route('personal')); ?>">
                                <input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Выберите способ:</label>
                                    <div class="col-sm-10">
                                        <div class="input-group">
                                            <div class="i-checks"><label> <input type="radio" checked="" value="PC" name="paymentType"> <i></i> Яндекс.Деньгами </label></div>
                                            <div class="i-checks"><label> <input type="radio" value="AC" name="paymentType"> <i></i> Банковской картой </label></div>
                                            <div class="i-checks"><label> <input type="radio" value="MC" name="paymentType"> <i></i> С мобильного счета</label></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Сумма:</label>
                                    <div class="col-sm-10">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="sum" id="sum" required placeholder="Сумма...">
                                            <span class="input-group-btn">
                                                <button type="submit" class="btn btn-primary">Пополнить
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>