<?php $__env->startSection('content'); ?>
<?php $__env->startSection('bodyclass'); ?>
<body>
<?php $__env->stopSection(); ?>
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-12">
            <h2>Добро пожаловать <?php echo e($data->name); ?></h2>
        </div>
        <div class="col-lg-6">
            <?php if($ipbaninfo != null): ?>
            <div class="widget style1 red-bg">
                <div class="row">
                    <div class="col-xs-2">
                        <i class="fa fa-desktop fa-5x"></i>
                    </div>

                    <div class="col-xs-10 text-right">
                        <h3>IP адрес:</h3>
                        <h2 class="font-bold"><?php echo e($ip); ?></h2>
                        <h3 class="font-bold"><?php echo e($ipbaninfo[0]['unbandate'] > 0 ? 'до '. date("d.m.Y", $ipbaninfo[0]['unbandate']) : 'пермаментно'); ?></h3>
                    </div>

                </div>
            </div>
            <?php else: ?>
                <div class="widget style1 gray-bg">
                    <div class="row">
                        <div class="col-xs-2">
                            <i class="fa fa-desktop fa-5x"></i>
                        </div>

                        <div class="col-xs-10 text-right">
                            <h3>IP адрес</h3>
                            <h2 class="font-bold"><?php echo e($ip); ?></h2>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-lg-6">
            <div class="widget style1 gray-bg">
                <div class="row">
                    <div class="col-xs-2">
                        <i class="fa fa-money fa-5x"></i>
                    </div>
                    
                    <div class="col-xs-10 text-right">
                        <h3>Текущий баланс</h3>   
                        <h2 class="font-bold"><?php echo e($data->donate); ?> Навлонов (Н) /  <?php echo e($data->vote); ?> Голосов (Г)</h2>
                        <a href="<?php echo e(route('donate')); ?>" class="btn btn-xs btn-outline btn-white"> пожертвовать </a>
                        <a href="<?php echo e(route('votes')); ?>" class="btn btn-xs btn-outline btn-white"> голосовать </a>
                    </div>

                </div>
            </div>
        </div>
        <?php if($recruiterdata != null): ?>
        <div class="col-lg-6">
            <div class="widget style1 gray-bg">
                <div class="row">
                    <div class="col-xs-2">
                        <i class="fa fa-compress fa-5x"></i>
                    </div>

                    <div class="col-xs-10 text-right">
                        <h3>Связанная учетная запись</h3>           
                        <h2 class="font-bold"><?php echo e($recruiterdata->name); ?></h2>
                    </div>

                </div>
            </div>
        </div>
        <?php endif; ?>
		<?php if($accountbaninfo != null): ?>
        <div class="col-lg-6">
	        <?php if($accountbaninfo[0]['active'] == 1): ?>
            <div class="widget style1 red-bg">
                <div class="row">
                    <div class="col-xs-2">
                        <i class="fa fa-ban fa-5x"></i>
                    </div>

                    <div class="col-xs-10 text-right">
                        <h3>Статус учетной записи</h3>
                        <h2 class="font-bold">заблокирована</h2>
                        <h3 class="font-bold"><?php echo e($accountbaninfo[0]['unbandate'] > 0 ? 'до '. date("d.m.Y", $accountbaninfo[0]['unbandate']) : 'пермаментно'); ?></h3>
                    </div>

                </div>
            </div>
            <?php else: ?>
            <div class="widget style1 navy-bg">
                <div class="row">
                    <div class="col-xs-2">
                        <i class="fa fa-check fa-5x"></i>
                    </div>

                    <div class="col-xs-10 text-right">
                        <h3>Статус учетной записи</h3>
                        <h2 class="font-bold">не заблокирована</h2>
                    </div>

                </div>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>		
        <div class="col-lg-6">
            <?php if($premiuminfo != null AND $premiuminfo[0]['active'] == 1): ?>
            <div class="widget style1 yellow-bg">
                <div class="row">
                    <div class="col-xs-2">
                        <i class="fa fa-star-o fa-5x"></i>
                    </div>

                    <div class="col-xs-10 text-right">
                        <h3>Премиум-статус <?php echo e($premiuminfo[0]['premium_type']); ?>-го ранга</h3>
                        <h2 class="font-bold">активирован</h2>
                        <h3 class="font-bold">до <?php echo e(date("d-m-Y H:i:s", $premiuminfo[0]['unsetdate'])); ?> </h3>
                    </div>

                </div>
            </div>
            <?php else: ?>
            <div class="widget style1 lazur-bg">
                <div class="row">
                    <div class="col-xs-2">
                        <i class="fa fa-star-o fa-5x"></i>
                    </div>

                    <div class="col-xs-10 text-right">
                        <h3>Премиум-статус</h3>
                        <h2 class="font-bold">не активирован</h2>
                    </div>

                </div>
            </div>
            <?php endif; ?>
        </div>   
        <?php if($accgameinfo != null): ?>		
        <div class="col-lg-6">
            <?php if($accgameinfo[0]['mutetime'] == 0): ?>
            <div class="widget style1 navy-bg">
                <div class="row">
                    <div class="col-xs-2">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>

                    <div class="col-xs-10 text-right">
                        <h3>Статус игрового чата</h3>
                        <h2 class="font-bold">доступен</h2>
                    </div>
                </div>

            </div>
            <?php else: ?>
            <div class="widget style1 red-bg">
                <div class="row">
                    <div class="col-xs-2">
                        <i class="fa fa-ban fa-5x"></i>
                    </div>

                    <div class="col-xs-10 text-right">
                        <h3>Статус игрового чата</h3>
                        <h2 class="font-bold">немота</h2>
                        <h3 class="font-bold"><?php echo e($accgameinfo[0]['mutetime'] < 0 ? 'навсегда' : 'на '. date("Hч iм sс", $accgameinfo[0]['mutetime'])); ?><h3>
                    </div>

                </div>
            </div>
            <?php endif; ?>
        </div>
		<?php endif; ?>
		<?php if($accgameinfo != null AND 
		     $sumplaytime != null AND
			 $accgameinfo[0]['last_login'] != null AND 
			 $accgameinfo[0]['last_ip'] != null): ?>
        <div class="col-lg-6">
            <div class="widget style1 gray-bg">
                <div class="row">
                    <div class="col-xs-2">
                        <i class="fa fa-clock-o fa-5x"></i>
                    </div>

                    <div class="col-xs-10 text-right">
						 <h3>Проведенное время в игре</h3>
						 <h2 class="font-bold"><?php echo e($sumplaytime); ?></h2>
						 <h4 class="font-bold">последний вход в игру <?php echo e($accgameinfo[0]['last_login']); ?> IP <?php echo e($accgameinfo[0]['last_ip']); ?></h4>
                    </div>

                </div>
            </div>
        </div>
		<?php endif; ?>
    </div>	
	
    <div class="chat-message left">
        <div class="message">
            <h2>Ваша реферальная ссылка</h2>
            <span class="message-content">
                    <div class="alert alert-success alert-dismissable" id="copytext"><?php echo e(config('app.url').'/register/'.$data->name); ?></div>
                <button class="btn btn-block btn-outline btn-primary" data-clipboard-target="#copytext"><i class="fa fa-copy"></i> Копировать ссылку</button>
                <a href="<?php echo e(route('referals')); ?>" class="btn btn-block btn-outline btn-primary">Условия реферальной системы</a>
            </span>
        </div>
    </div>
	
	<?php if($realminfos != null): ?>
	<div class="chat-message left">
        <div class="message">
            <h2>Статистика миров</h2>
            <span class="message-content">
                <?php $__currentLoopData = $realminfos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $realminfo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<b class="left"><?php echo e($realminfo->name.' ('.$realminfo->online.' / '.$realminfo->plr_max.')'); ?></b>
				<div class="progress progress-large">
				    <?php if($realminfo->status == 'offline'): ?>
						<div style="width: 100%" class="<?php echo e(($realminfo->status == 'online') ? 'progress-bar' : 'progress-bar progress-bar-danger'); ?>"></div>
					<?php else: ?>
						<div style="width:<?php echo e($realminfo->online / $realminfo->plr_max * 100); ?>%" class="progress-bar"></div>
				    <?php endif; ?>
				</div>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </span>
        </div>
    </div>
	<?php endif; ?>
	
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-title">
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <h5 style="color: #333234">Список персонажей (<?php echo e($userinfo == null ? 0 : count($userinfo)); ?>)</h5>
                                </a>
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>
						
                        <div class="ibox-content" style="display: yes;">
							<div class="project-list">
								<div class="row">
								<?php if($userinfo != null): ?>
								  <?php $__currentLoopData = $userinfo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userinfos): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
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
                </div>
            </div>
        <?php if($recruiterdata != null): ?>
        <div class="row">
        <div class="col-lg-12">
                <div class="ibox">
                        <div class="ibox-title">
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <h5 style="color: #333234">Список персонажей связанной учетной записи <?php echo e($recruiterdata->name); ?> (<?php echo e($recruiterinfo == null ? 0 : count($recruiterinfo)); ?>)</h5>
                                </a>
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>
						<div class="ibox-content" style="display: yes;">
							<div class="project-list">
								<div class="row">
								<?php if($recruiterinfo != null): ?>
								  <?php $__currentLoopData = $recruiterinfo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recruiterinfos): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
										<div class="col-md-3" id="<?php echo e($recruiterinfos->guid); ?>">
											<div class="ibox">
												<div class="ibox-content product-box">
													<div class="product-imitation" style="background: url(<?php echo e(URL::asset('admin/img/faction/'.$recruiterinfos->factionid.'.png')); ?>) left top no-repeat;"> 
                                                        <wow-tooltip-charinfo-content 
															data-charinfo-faction="<?php echo e('Фракция: '.($recruiterinfos->factionid == 0 ? 'Альянс' : 'Орда')); ?>"
															data-charinfo-race="<?php echo e('Раса: '.$recruiterinfos->race_name); ?>"
															data-charinfo-class="<?php echo e('Класс: '.$recruiterinfos->class_name); ?>"
															data-charinfo-level="<?php echo e('Уровень: '.$recruiterinfos->level.' / '.$recruiterinfos->realm_maxlvl); ?>"
															data-charinfo-gold="<?php echo e('Золото: '.round($recruiterinfos->money / 10000, 2)); ?>"
															data-charinfo-playtime="<?php echo e('Игровое время: '.$recruiterinfos->play_time); ?>">												
															<img alt="image" class="tooltip-icon-large-prev" src="<?php echo e(URL::asset('admin/img/race/'.$recruiterinfos->race.'_'.$recruiterinfos->gender.'.png')); ?>">
														</wow-tooltip-charinfo-content>
													</div>
													<div class="product-desc">
														<span class="product-price">
															<?php echo e($recruiterinfos->level); ?> уровень
														</span>
														<img alt="image" class="product-adt" src="<?php echo e(URL::asset('admin/img/class/'.$recruiterinfos->class.'.png')); ?>">
														<div class="dropdown product-name-simple">
														<?php echo e($recruiterinfos->name); ?>

															<a data-toggle="dropdown" class=" btn dropdown-toggle" href="#"><i class="fa fa-cogs"></i></a>
																<ul class="dropdown-menu animated fadeInLeft m-t-xs">
																	<?php if($server != 'vanilla'): ?>
																	<form method="POST" action="<?php echo e(route('characters.race')); ?>"
																		  class="form-horizontal" enctype="multipart/form-data">

																		<input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
																		<input type="hidden" name="guid" id="guid" value="<?php echo e($recruiterinfos->guid.','.$recruiterinfos->realm_id); ?>">
																		<button type="submit" class="btn btn-w-m btn-link btn-sm">Сменить расу за 150 навлонов</button>
																	</form>
																	<form method="POST" action="<?php echo e(route('characters.faction')); ?>"
																		  class="form-horizontal" enctype="multipart/form-data">

																		<input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
																		<input type="hidden" name="guid" id="guid" value="<?php echo e($recruiterinfos->guid.','.$recruiterinfos->realm_id); ?>">
																		<button type="submit" class="btn btn-w-m btn-link btn-sm">Сменить фракцию за 200 навлонов</button>
																	</form>
																	<form method="POST" action="<?php echo e(route('characters.name')); ?>"
																		  class="form-horizontal" enctype="multipart/form-data">

																		<input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
																		<input type="hidden" name="guid" id="guid" value="<?php echo e($recruiterinfos->guid.','.$recruiterinfos->realm_id); ?>">
																		<button type="submit" class="btn btn-w-m btn-link btn-sm">Сменить имя за 100 навлонов</button>
																	</form>
																	<form method="POST" action="<?php echo e(route('characters.repair')); ?>"
																		  class="form-horizontal" enctype="multipart/form-data">

																		<input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
																		<input type="hidden" name="guid" id="guid" value="<?php echo e($recruiterinfos->guid.','.$recruiterinfos->realm_id); ?>">
																		<button type="submit" class="btn btn-w-m btn-link btn-sm">Починить персонажа</button>
																	</form>
																	<?php endif; ?>
																</ul>
													    </div>
														<span class="label label"><?php echo e($recruiterinfos->realm_name); ?></span>
														<span class="label label-<?php echo e(($recruiterinfos->online == '1') ? 'primary' : 'danger'); ?>"><?php echo e(($recruiterinfos->online == '1') ? 'Онлайн' : 'Оффлайн'); ?></span>
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
        </div>
    </div>
    <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>