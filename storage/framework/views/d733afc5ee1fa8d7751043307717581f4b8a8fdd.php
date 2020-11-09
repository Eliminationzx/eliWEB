<?php $__env->startSection('content'); ?>
<?php $__env->startSection('bodyclass'); ?>
<body>
<?php $__env->stopSection(); ?>
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Пожертвование</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo e(route('personal')); ?>">Главная</a>
                </li> 
                <li>
                    Аккаунт
                </li>  
                <li class="active">
                    <strong>Пожертвование</strong>
                </li> 
            </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
      <?php if( session('status')): ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="alert alert-<?php echo e(session('type')); ?> alert-dismissable">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        <span class="alert-link"><?php echo e(session('status')); ?></span>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-lg-12">

                <div class="ibox">
				    <div class="ibox-title">
						<h5>Форма пожертвования</h5>
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
                                            <li>Администрация H2H благодарна за посильный вклад в развитие сервера. В ниших силах отблагодарить Вас за помощь начислив специальную валюту в размере 1:1.</li>
                                            <li>Пожертвование возможно сделать с помощью электронных денег, банковской картой и других, перечисленных ниже способов.</li>
                                            <li>Бонусы поступят на счет мгновенно.</li>
                                        </ul>
                                        </div>
                                    </div>
									<div class="alert alert-success">
                                        На вашем счету <?php echo e($data->donate); ?> навлон(ов)
                                    </div>
                                </div>
								<?php if(strpos(env('PAYMENT_URL'), 'free-kassa') !== false): ?>
								<form method="POST" action="<?php echo e(route('donate.execute')); ?>"
                                  class="form-horizontal" enctype="multipart/form-data">
								<input type="hidden" name="m" value="<?php echo e(env('PAYMENT_MERCHANT_ID')); ?>">
								<input type="hidden" name="em" value="<?php echo e($data->email); ?>">
							    <input type="hidden" name="phone" value="<?php echo e($data->phone); ?>">
								<input type="hidden" name="lang" value="ru">
								<input type="hidden" name="o" id="desc" value="<?php echo e($data->id); ?>">
								<input type="hidden" name="s" id="s" value="0">
                                <input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
								<div class="form-group">
                                    <label class="col-sm-2 control-label">Выберите способ:</label>
                                    <div class="col-sm-10">
                                        <div class="input-group">
                                            <div class="i-checks"><label> <input type="radio" checked="" value="94" name="i"> <i></i> Банковская карта VISA/MASTERCARD </label></div>
                                            <div class="i-checks"><label> <input type="radio" value="63" name="i"> <i></i> QIWI </label></div>
                                            <div class="i-checks"><label> <input type="radio" value="45" name="i"> <i></i> Яндекс деньги</label></div>
											<div class="i-checks"><label> <input type="radio" value="1" name="i"> <i></i> WebMoney WMR</label></div>
											<div class="i-checks"><label> <input type="radio" value="82" name="i"> <i></i> Мобильный платеж Мегафон</label></div>
											<div class="i-checks"><label> <input type="radio" value="84" name="i"> <i></i> Мобильный платеж МТС</label></div>
											<div class="i-checks"><label> <input type="radio" value="132" name="i"> <i></i> Мобильный платеж Tele2</label></div>
											<div class="i-checks"><label> <input type="radio" value="83" name="i"> <i></i> Мобильный платеж Билайн</label></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Сумма:</label>
                                    <div class="col-sm-10">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="oa" id="sum" required placeholder="Сумма...">
                                            <span class="input-group-btn">
                                                <button type="submit" class="btn btn-primary">Пожертвовать
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                </form>
								<?php elseif(strpos(env('PAYMENT_URL'), 'yandex') !== false): ?>
								<form method="POST" action="<?php echo e(env('PAYMENT_URL')); ?>"
                                  class="form-horizontal" enctype="multipart/form-data">
                                <input type="hidden" name="receiver" value="<?php echo e(env('PAYMENT_MERCHANT_ID')); ?>">
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
                                                <button type="submit" class="btn btn-primary">Пожертвовать
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
								</form>
								<?php endif; ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>