

<?php $__env->startSection('content'); ?>
<?php $__env->startSection('bodyclass'); ?>
<body>
<?php $__env->stopSection(); ?>
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Votación</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo e(route('personal')); ?>">Inicio</a>
                </li> 
                <li>
                    Cuenta
                </li>  
                <li class="active">
                    <strong>Votación</strong>
                </li> 
            </ol>
        </div>
    </div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox">
				<div class="ibox-title">
					<h5>Sistema de votación</h5>
				</div>
                    <div class="ibox-content">
                        <div class="project-list">
                            <div class="row">
                                <div class="col-lg-12">
								    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                        <i class="fa fa-info-circle"></i> Información útil
                                        </div>
                                        <div class="panel-body">
                                           Estimado <?php echo e($data->name); ?>, para que nuestro proyecto sea conocido por la mayor cantidad de personas posible, es necesaria su promoción en diferentes TopSites. Apoya al servidor votando por él y se le otorgará la recompensa correspondiente.
                                           <b>Note:</b> 
                                           <ul>
                                               <li>Su nombre de cuenta debe especificarse al votar - <b><?php echo e($data->name); ?></b>, de lo contrario no se le cobrará la recompensa.</li>
                                               <li>Los últimos votos se actualizan y las recompensas se acreditan cada hora.</li>
                                               <li>Para los jugadores que se encuentran entre los 5 primeros por número de votos, el premio de votación aumenta x2.</li>
                                           </ul>
                                        </div>
                                    </div>
                                    <?php if($data->vote > 0): ?>                                
                                    <div class="alert alert-success">                            
                                        <p>Ya has realizado <?php echo e($data->vote); ?> voto(s).</p>
                                    </div>
                                    <?php else: ?>
                                    <div class="alert alert-danger">                            
                                        Aún no has votado por nuestro proyecto, ¡Pues hacerlo ahora!
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
                                                        <?php if($vote->isvoted == 1): ?>
                                                            <img class="vote-info-banner" src="<?php echo e($vote->img); ?>"/>
                                                            <span class="vote-info-voted">Votado</span>
                                                        <?php else: ?>                                                         
                                                            <a href="<?php echo e($vote->url); ?>" target="_blank">
                                                            <img class="vote-info-banner" src="<?php echo e($vote->img); ?>"/>
                                                            <span class="vote-info-reward"><?php echo e($topusers->contains('id', $data->id) && $vote->clickable_only == 0 ? $vote->reward * 2 : $vote->reward); ?> PD</span>
                                                            </a>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
								</div>
							    <div class="col-lg-4">
                                        <h2>Los 5 mejores votantes</h2>
										<div class="alert alert-info alert-dismissable">
											<table class="table table-hover">
												<tbody>
													<?php $__currentLoopData = $topusers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topuser): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
													<?php if($loop->index == 0): ?>
													<tr>
														<td class="project-title">
														   &#128081;                                      
														</td>
														<td class="project-title">
														  <b><?php echo e($topuser->name); ?></b>                                     
														</td>
														<td class="project-title">
														  <b><?php echo e($topuser->vote); ?> PV</b>                               
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
														   <?php echo e($topuser->vote); ?> PV                              
														</td>
													</tr>
													<?php endif; ?>
													<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
												</tbody>
											</table>
										</div>
                                </div>
                                <div class="col-lg-4">
                                        <h2>Ultimos votos</h2>
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
														   <?php echo e($log->vote_count); ?> PV                                
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