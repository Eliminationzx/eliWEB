<?php $__env->startSection('content'); ?>
<?php $__env->startSection('bodyclass'); ?>
<body>
<?php $__env->stopSection(); ?>
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Премиум-статус</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo e(route('personal')); ?>">Главная</a>
                </li> 
                <li class="active">
                    <strong>Премиум-статус</strong>
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
						<h5>Покупка премиум-статуса</h5>
					</div>
                    <div class="ibox-content">
                        <div class="project-list">                                                    
							<div class="panel panel-primary">
								<div class="panel-heading">
								<i class="fa fa-info-circle"></i> Полезная информация
								</div>
								<div class="panel-body">
									<p>Премиум-статус - специальная привилегия на проекте <?php echo e(config('app.name_prj')); ?></p>
									<h5>Данная привилегия дает следующие преимущества:</h5>
									<ol>
									<li>Доступ к особому предмету, который доступен только премиум игрокам - "Книга силы":</li>
										<ul> 
										<li>Мобильный банк (1-3 ранг)</li>
										<li>Мобильный почтовый ящик (1-3 ранг)</li>
										<li>Различные эффекты усиливающие персонажа (бафы) (3 ранг)</li>
										<li>Камень возвращения без времени восстановления (1-3 ранг)</li>
										<li>Открыты все летные пути (1-3 ранг)</li>
										<li>Ежедневные скидки на случайные товары в личном кабинете (1-3 ранг)</li>
										<li>Бесплатная починка экипировки(1-3 ранг)</li>
										<li>Сброс способностей (3 ранг)</li>
										<li>Улучшение навыков владения оружием (2-3 ранг)</li>
										<li>Снятие ауры слабости после воскрешения (2-3 ранг)</li>
										<li>Снятие ауры дезертира (2-3 ранг)</li>
										</ul> 
									<li>Повышенные рейты на прокачку X2 от обычных</li>
									<li>Повышенные рейты на честь X2 от обычных</li>
									<li>Повышенные рейты на репутацию X2 от обычных</li>
									</ol>
									За каждую покупку премиум-статуса вы получаете специальные очки, которые повышают уровень вашего премиум-ранга.
								</div>
							</div>
							<?php if($premiuminfo != null and $premiuminfo[0]['active'] == 1): ?>
							<form method="POST" action="/personal/premium/senditem"
							  class="form-horizontal" enctype="multipart/form-data">

							<input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
							 <div class="form-group">
								<div class="col-sm-3">
									<div class="input-group col-sm-12">
										<div>
											<select name="guid" data-placeholder="Выберите персонажа..." class="chosen-select"  tabindex="2">
												<?php $__currentLoopData = $userinfo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userinf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
													<option value="<?php echo e($userinf->guid.','.$userinf->realm_id); ?>"><?php echo e($userinf->name); ?> (<?php echo e($userinf->realm_name); ?>)</option>
												<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
											</select>
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<button type="submit" class="btn btn-primary">Отправить книгу силы</button>
								</div>
							</div>
							</form>    
								<div class="alert alert-success">
								   <?php echo e($premiuminfo[0]['unsetdate'] < 0 ? 'Неограниченный премиум-статус ' . $premiuminfo[0]['premium_type'] . '-го ранга активирован' : 
									 'Премиум-статус ' . $premiuminfo[0]['premium_type'] . '-го ранга активирован и действителен до ' . date("d.m.Y", $premiuminfo[0]['unsetdate'])); ?>

								</div>
							   <div class="form-group">
									 <div class="progress progress-mini">
										<?php if($premiuminfo[0]['premium_type'] == 1): ?>
											<div style="width: <?php echo e($premiuminfo[0]['score'] / 100 * 100); ?>%;" class="progress-bar"></div>
										<?php elseif($premiuminfo[0]['premium_type'] == 2): ?>
											<div style="width: <?php echo e($premiuminfo[0]['score'] / 180 * 100); ?>%;" class="progress-bar"></div>
										<?php elseif($premiuminfo[0]['premium_type'] == 3): ?>
											<div style="width: 100%;" class="progress-bar"></div>
										<?php endif; ?>    
									 </div>
								</div>                                                              
						<?php else: ?>
							<div class="alert alert-danger">
								 Премиум-статус не активирован
							</div>
						<?php endif; ?>
							<div class="row">						
									<form method="POST" action="/personal/premium"
									  class="form-horizontal" enctype="multipart/form-data">

										<input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
										<input type="hidden" name="premium" value="day">
											<div class="col-sm-4">
												<button type="submit" class="btn btn-block btn-outline btn-primary">Купить на день за <?php echo e($price_day->value); ?> Н</button>
											</div>
									 </form>
									<form method="POST" action="/personal/premium"
									  class="form-horizontal" enctype="multipart/form-data">


										<input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
										<input type="hidden" name="premium" value="month">
											<div class="col-sm-4">
												<button type="submit" class="btn btn-block btn-outline btn-primary">Купить на месяц за <?php echo e($price_month->value); ?> Н</button>
											</div>
									 </form>
									<form method="POST" action="/personal/premium"
									  class="form-horizontal" enctype="multipart/form-data">


										<input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
										<input type="hidden" name="premium" value="year">
											<div class="col-sm-4">
												<button type="submit" class="btn btn-block btn-outline btn-primary">Купить на год за <?php echo e($price_year->value); ?> Н</button>
											</div>
									 </form>
							</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>