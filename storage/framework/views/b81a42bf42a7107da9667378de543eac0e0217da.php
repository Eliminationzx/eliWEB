<?php $__env->startSection('content'); ?>
<?php $__env->startSection('bodyclass'); ?>
<body>
<?php $__env->stopSection(); ?>
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-12">
            <h2>Рефералы</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo e(route('personal')); ?>">Home</a>
                </li>  
                <li class="active">
                    <strong>Referals</strong>
                </li> 
            </ol>
        </div>
    </div>
    <div class="chat-message left">
        <div class="message">
			<h2>Terms of referral system</h2>
            <div class="alert alert-info" >
            Dear <?php echo e($data->name); ?>, in order to get <?php echo e($reward->value); ?> D to your account, you must fulfill 3 conditions:
            <ol>
             <li>Your friend must register using your referral link or manually enter your account name when you register.</li>
             <li>Your friend must reach the maximum level by any character</li>
             <li>Your friend must spend at least 12 hours in the game</li>
            </ol>
            After confirmation of fulfillment of all conditions in the personal cabinet, your account will be credited with <?php echo e($reward->value); ?> D.<br/>
            <b>Note</b>: System bonuses apply to linked accounts <a href="#" target="_blank"> Invite a friend</a>.
            </div>
            <h2>Your referral link</h2>
            <span class="message-content">
                <div class="alert alert-success alert-dismissable" id="copytext"><?php echo e(config('app.url').'/register/'.$data->name); ?></div>
                <button class="btn btn-block btn-outline btn-primary" data-clipboard-target="#copytext"><i class="fa fa-copy"></i> Copy link</button>
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
                        <h5>Your referrals (<?php echo e(count($referalsinfo)); ?>)</h5>
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
                                        <button type="submit" class="btn btn-success btn-xs">The system conditions are fulfilled, donation points have been calculated.</button>
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
															data-charinfo-faction="<?php echo e('Fraction: '.($userinfos->factionid == 0 ? 'Alliance' : 'Horde')); ?>"
															data-charinfo-race="<?php echo e('Race: '.$userinfos->race_name); ?>"
															data-charinfo-class="<?php echo e('Class: '.$userinfos->class_name); ?>"
															data-charinfo-level="<?php echo e('Level: '.$userinfos->level.' / '.$userinfos->realm_maxlvl); ?>"
															data-charinfo-gold="<?php echo e('Money: '.round($userinfos->money / 10000, 2)); ?>"
															data-charinfo-playtime="<?php echo e('Playing time: '.$userinfos->play_time); ?>">												
															<img alt="image" class="tooltip-icon-large-prev" src="<?php echo e(URL::asset('admin/img/race/'.$userinfos->race.'_'.$userinfos->gender.'.png')); ?>">
														</wow-tooltip-charinfo-content>
													</div>
													<div class="product-desc">
														<span class="product-price">
															<?php echo e($userinfos->level); ?> level
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
																		<button type="submit" class="btn btn-w-m btn-link btn-sm">Change race</button>
																	</form>
																	<form method="POST" action="<?php echo e(route('characters.faction')); ?>"
																		  class="form-horizontal" enctype="multipart/form-data">

																		<input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
																		<input type="hidden" name="guid" id="guid" value="<?php echo e($userinfos->guid.','.$userinfos->realm_id); ?>">
																		<button type="submit" class="btn btn-w-m btn-link btn-sm">Change fraction</button>
																	</form>
																	<form method="POST" action="<?php echo e(route('characters.name')); ?>"
																		  class="form-horizontal" enctype="multipart/form-data">

																		<input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
																		<input type="hidden" name="guid" id="guid" value="<?php echo e($userinfos->guid.','.$userinfos->realm_id); ?>">
																		<button type="submit" class="btn btn-w-m btn-link btn-sm">Change name</button>
																	</form>
																	<form method="POST" action="<?php echo e(route('characters.repair')); ?>"
																		  class="form-horizontal" enctype="multipart/form-data">

																		<input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
																		<input type="hidden" name="guid" id="guid" value="<?php echo e($userinfos->guid.','.$userinfos->realm_id); ?>">
																		<button type="submit" class="btn btn-w-m btn-link btn-sm">Repair</button>
																	</form>
																	<?php endif; ?>
																</ul>
													    </div>
														<span class="label label"><?php echo e($userinfos->realm_name); ?></span>
														<span class="label label-<?php echo e(($userinfos->online == '1') ? 'primary' : 'danger'); ?>"><?php echo e(($userinfos->online == '1') ? 'Online' : 'Offline'); ?></span>
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