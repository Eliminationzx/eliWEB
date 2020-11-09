<?php $__env->startSection('content'); ?>
<?php $__env->startSection('bodyclass'); ?>
<body>
<?php $__env->stopSection(); ?>
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Голосование</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo e(route('personal')); ?>">Главная</a>
                </li> 
                <li>
                    Аккаунт
                </li>  
                <li class="active">
                    <strong>Голосование</strong>
                </li> 
            </ol>
        </div>
    </div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox">
				<div class="ibox-title">
					<h5>Система голосования</h5>
				</div>
                    <div class="ibox-content">
                        <div class="project-list">
                            <div class="row">
                                <div class="col-lg-12">
								    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                        <i class="fa fa-info-circle"></i> Полезная информация
                                        </div>
                                        <div class="panel-body">
                                           Уважаемый(ая) <?php echo e($data->name); ?>, чтобы о нашем проекте узнало как можно больше людей, необходимо его продвижение в различных рейтингах. Поддержите сервер голосованием за него и Вам будет начислена соответствующая награда.<br/>
                                           <b>Примечание:</b> 
                                           <ul>
                                           <li>При голосовании необходимо указывать имя вашего аккаунта - <b><?php echo e($data->name); ?></b>, в противном случае вознаграждение не будет начислено.</li>
                                           <li>Обновление последних голосов и начисление вознаграждений происходит каждый час.</li>
                                           <li>Для игроков, которые входят в топ 5 по количеству голосов, награда за голосование увеличена x2</li>
                                           </ul>
                                        </div>
                                    </div>
                                    <?php if($data->vote > 0): ?>                                
                                    <div class="alert alert-success">                            
                                        <p>Вы уже сделали <?php echo e($data->vote); ?> голос(ов)</p>
                                    </div>
                                    <?php else: ?>
                                    <div class="alert alert-danger">                            
                                        Вы ещё не проголосовали за наш проект, сделайте это сейчас!
                                    </div> 
                                    <?php endif; ?>        
                                </div>
                                <div class="col-lg-4">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <?php $__currentLoopData = $votes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vote): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td class="project-title">
                                                <?php echo e($vote->name); ?>                                     
                                                </td>
                                                <td class="project-title">
                                                <?php echo e($vote->descr); ?>                                     
                                                </td>
                                                <td class="project-title">
                                                    <div class="vote-info-block">
                                                        <a href="<?php echo e($vote->url); ?>" target="_blank">
														<img class="vote-info-banner" src="<?php echo e($vote->img); ?>"/>
                                                        <span class="vote-info-reward"><?php echo e($topusers->contains('id', $data->id) ? $vote->reward * 2 : $vote->reward); ?> Н за 1 Г </span>
														</a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
								</div>
							    <div class="col-lg-4">
                                        <h2>Топ 5 голосующих</h2>
										<div class="alert alert-info alert-dismissable">
											<table class="table table-hover">
												<tbody>
													<?php $__currentLoopData = $topusers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topuser): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
													<?php if($loop->index == 0): ?>
													<tr>
														<td class="project-title">
														   <b><?php echo e(($loop->index + 1)); ?></b>                                       
														</td>
														<td class="project-title">
														  <b><?php echo e($topuser->name); ?></b>                                     
														</td>
														<td class="project-title">
														  <b><?php echo e($topuser->vote); ?> Г</b>                               
														</td>
													</tr>
													<?php else: ?>
													<tr>
														<td class="project-title">
														   <?php echo e(($loop->index + 1)); ?>                                       
														</td>
														<td class="project-title">
														   <?php echo e($topuser->name); ?>                                       
														</td>
														<td class="project-title">
														   <?php echo e($topuser->vote); ?> Г                               
														</td>
													</tr>
													<?php endif; ?>
													<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
												</tbody>
											</table>
										</div>
                                </div>
                                <div class="col-lg-4">
                                        <h2>Последние голоса</h2>
										<div class="alert alert-info alert-dismissable">
											<table class="table table-hover">
												<tbody>
													<?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
													<tr>
														<td class="project-title">
														   <?php echo e($log->player_name); ?>                           
														</td>
														<td class="project-title">
														   <?php echo e($log->vote_name); ?>                                       
														</td>
														<td class="project-title">
														   <?php echo e($log->vote_time); ?>                                          
														</td>
														<td class="project-title">
														   <?php echo e($log->vote_count); ?> Г                                
														</td>
													</tr>
													<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
												</tbody>
											</table>
										</div>
                                </div>
                            </div>
                    </div>
                </div>
        </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>