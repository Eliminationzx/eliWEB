<?php $__env->startSection('content'); ?>
<?php $__env->startSection('bodyclass'); ?>
<body>
<?php $__env->stopSection(); ?>
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Voting</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo e(route('personal')); ?>">Home</a>
                </li> 
                <li>
                    Account
                </li>  
                <li class="active">
                    <strong>Voting</strong>
                </li> 
            </ol>
        </div>
    </div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox">
				<div class="ibox-title">
					<h5>Voting System</h5>
				</div>
                    <div class="ibox-content">
                        <div class="project-list">
                            <div class="row">
                                <div class="col-lg-12">
								    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                        <i class="fa fa-info-circle"></i> Useful information
                                        </div>
                                        <div class="panel-body">
                                           Dear <?php echo e($data->name); ?>, for our project to be known to as many people as possible, its promotion in different ratings is necessary. Support the server by voting for it and you will be awarded the appropriate reward.
                                           <b>Note:</b> 
                                           <ul>
                                           <li>Your account name must be specified when voting - <b><?php echo e($data->name); ?></b>, otherwise the reward will not be charged.
                                           </li>The last votes are updated and rewards are credited every hour.
                                           <li>For the players who are in the top 5 by number of votes, the voting award is increased x2</li>.
                                           </ul>
                                        </div>
                                    </div>
                                    <?php if($data->vote > 0): ?>                                
                                    <div class="alert alert-success">                            
                                        <p>You've already done <?php echo e($data->vote); ?> vote(s) </p>.
                                    </div>
                                    <?php else: ?>
                                    <div class="alert alert-danger">                            
                                        You haven't voted for our project yet, do it now!
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
                                                        <span class="vote-info-reward"><?php echo e($topusers->contains('id', $data->id) ? $vote->reward * 2 : $vote->reward); ?> D for 1 V </span>
														</a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
								</div>
							    <div class="col-lg-4">
                                        <h2>Top 5 Voters</h2>
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
														  <b><?php echo e($topuser->vote); ?> V</b>                               
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
														   <?php echo e($topuser->vote); ?> V                              
														</td>
													</tr>
													<?php endif; ?>
													<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
												</tbody>
											</table>
										</div>
                                </div>
                                <div class="col-lg-4">
                                        <h2>Last votes</h2>
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
														   <?php echo e($log->vote_count); ?> V                                
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