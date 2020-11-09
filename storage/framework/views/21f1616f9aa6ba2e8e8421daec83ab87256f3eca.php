<?php $__env->startSection('content'); ?>
<?php $__env->startSection('bodyclass'); ?>
<body>
<?php $__env->stopSection(); ?>
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-12">
            <h2>Рефералы</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo e(route('personal')); ?>">Главная</a>
                </li>  
                <li class="active">
                    <strong>Рефералы</strong>
                </li> 
            </ol>
        </div>
    </div>
    <div class="chat-message left">
        <div class="message">
			<h2>Условия реферальной системы</h2>
            <div class="alert alert-info" >
            Уважаемый(ая) <?php echo e($data->name); ?>, для того чтобы получить <?php echo e($reward->value); ?> навлон(ов) на свой счёт, необходимо выполнить 3 условия:
            <ol>
             <li>Ваш друг должен пройти регистрацию по вашей реферальной ссылке либо указать вручную имя вашего аккаунта при регистрации</li>
             <li>Ваш друг должен достичь максимального уровня любым персонажем</li>
             <li>Ваш друг должен провести не менее 12 часов в игре</li>
            </ol>
            После подтверждения выполнения всех условий в личном кабинете на ваш счет будет начислено <?php echo e($reward->value); ?> навлон(ов).<br/>
            <b>Примечание</b>: Для связанных учетных записей действуют бонусы системы <a href="#" target="_blank"> Пригласи друга</a>.
            </div>
            <h2>Ваша реферальная ссылка</h2>
            <span class="message-content">
                <div class="alert alert-success alert-dismissable" id="copytext"><?php echo e(config('app.url').'/register/'.$data->name); ?></div>
                <button class="btn btn-block btn-outline btn-primary" data-clipboard-target="#copytext"><i class="fa fa-copy"></i> Копировать ссылку</button>
            </span>
        </div>
    </div>

    <?php if($referalsinfo != null): ?>
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
                        <h5>Ваши рефералы (<?php echo e(count($referalsinfo)); ?>)</h5>
                    </div>
                    <div class="ibox-content">

                    <div class="project-list">
                    <?php $__currentLoopData = $referalsinfo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $referalsinf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="ibox">
                        <div class="ibox-title">
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <h5 style="color: #333234"><?php echo e($referalsinf['names']); ?></h5>
                                </a>
                                <?php if($referalsinf['complete']): ?>
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                                        <button type="submit" class="btn btn-success btn-xs">Условия системы выполнены, навлоны начислены</button>
                                    </a>
                                <?php endif; ?>
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content" style="display: none;">

                            <div class="project-list">
                               <div class="row">
								<?php if($referalsinf['userinfo'] != null): ?>
								  <?php $__currentLoopData = $referalsinf['userinfo']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userinfos): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<div class="col-md-3" id="<?php echo e($userinfos->guid); ?>">
											<div class="ibox">
												<div class="ibox-content product-box">
													<div class="product-imitation" style="background: url(<?php echo e(URL::asset('admin/img/faction/'.$userinfos->factionid.'.png')); ?>) left top no-repeat;"> 
                                                        <wow-tooltip-charinfo-content 
															data-charinfo-faction="<?php echo e('Фракция: '.($userinfos->factionid == 0 ? 'Альянс' : 'Орда')); ?>"
															data-charinfo-race="<?php echo e('Раса: '.$userinfos->race_name); ?>"
															data-charinfo-class="<?php echo e('Класс: '.$userinfos->class_name); ?>"
															data-charinfo-level="<?php echo e('Уровень: '.$userinfos->level.' / '.$userinfos->realm_maxlvl); ?>"
															data-charinfo-gold="<?php echo e('Золото: '.round($userinfos->money / 10000, 2)); ?>"
															data-charinfo-playtime="<?php echo e('Игровое время: '.$userinfos->play_time); ?>">												
															<img alt="image" class="tooltip-icon-large-prev" src="<?php echo e(URL::asset('admin/img/race/'.$userinfos->race.'_'.$userinfos->gender.'.png')); ?>">
														</wow-tooltip-charinfo-content>
													</div>
													<div class="product-desc">
														<span class="product-price">
															<?php echo e($userinfos->level); ?> уровень
														</span>
														<img alt="image" class="product-adt" src="<?php echo e(URL::asset('admin/img/class/'.$userinfos->class.'.png')); ?>">
														<div class="dropdown product-name-simple">
														<?php echo e($userinfos->name); ?>

															<a data-toggle="dropdown" class=" btn dropdown-toggle" href="#"><i class="fa fa-cogs"></i></a>
																<ul class="dropdown-menu animated fadeInLeft m-t-xs">
																	<?php if($server != 'vanilla'): ?>
																	<form method="POST" action="<?php echo e(route('characters.race')); ?>"
																		  class="form-horizontal" enctype="multipart/form-data">

																		<input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
																		<input type="hidden" name="guid" id="guid" value="<?php echo e($userinfos->guid.','.$userinfos->realm_id); ?>">
																		<button type="submit" class="btn btn-w-m btn-link btn-sm">Сменить расу за 150 навлонов</button>
																	</form>
																	<form method="POST" action="<?php echo e(route('characters.faction')); ?>"
																		  class="form-horizontal" enctype="multipart/form-data">

																		<input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
																		<input type="hidden" name="guid" id="guid" value="<?php echo e($userinfos->guid.','.$userinfos->realm_id); ?>">
																		<button type="submit" class="btn btn-w-m btn-link btn-sm">Сменить фракцию за 200 навлонов</button>
																	</form>
																	<form method="POST" action="<?php echo e(route('characters.name')); ?>"
																		  class="form-horizontal" enctype="multipart/form-data">

																		<input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
																		<input type="hidden" name="guid" id="guid" value="<?php echo e($userinfos->guid.','.$userinfos->realm_id); ?>">
																		<button type="submit" class="btn btn-w-m btn-link btn-sm">Сменить имя за 100 навлонов</button>
																	</form>
																	<form method="POST" action="<?php echo e(route('characters.repair')); ?>"
																		  class="form-horizontal" enctype="multipart/form-data">

																		<input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
																		<input type="hidden" name="guid" id="guid" value="<?php echo e($userinfos->guid.','.$userinfos->realm_id); ?>">
																		<button type="submit" class="btn btn-w-m btn-link btn-sm">Починить персонажа</button>
																	</form>
																	<?php endif; ?>
																</ul>
													    </div>
														<span class="label label"><?php echo e($userinfos->realm_name); ?></span>
														<span class="label label-<?php echo e(($userinfos->online == '1') ? 'primary' : 'danger'); ?>"><?php echo e(($userinfos->online == '1') ? 'Онлайн' : 'Оффлайн'); ?></span>
													</div>
												</div>
											</div>
										</div>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<?php endif; ?>
								</div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>