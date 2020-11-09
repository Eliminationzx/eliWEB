<?php $__env->startSection('content'); ?>
<?php $__env->startSection('bodyclass'); ?>
<body>
<?php $__env->stopSection(); ?>
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Premium status</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo e(route('personal')); ?>">Home</a>
                </li> 
                <li class="active">
                    <strong>Premium status</strong>
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
						<h5>Buying premium status</h5>
					</div>
                    <div class="ibox-content">
                        <div class="project-list">                                                    
							<div class="panel panel-primary">
								<div class="panel-heading">
								<i class="fa fa-info-circle"></i> Useful information
								</div>
								<div class="panel-body">
									<p>Premium status - special privilege on the project <?php echo e(config('app.name_prj')); ?></p>
									<h5>This privilege offers the following benefits:</h5>
									<ol>
									<li>Access to a special item that is only available to premium players - "Book of Power":</li>
										<ul> 
										<li> Mobile bank (1-3 rank)</li>
										<li> Mobile mailbox (1-3 rank)</li>
										<li>Separate effects reinforcing the character (bafa) (3 rank)</li>
										<li>Return rate without recovery time (1-3 grades)</li>
										<li>Open all flight paths (1-3 rank)</li>.
										<li>Daily discounts on random goods in personal cabinet (1-3 rank)</li>.
										<li>Free repair of equipment(1-3 rank)</li>
										<li>Ability Reset (3 ranks)</li>
										<li>Enhancement of weapon skills (2-3 ranks)</li>
										<li> Removal of the aura of weakness after resurrection (2-3 ranks)</li>
										<li>Remove the aura of deserter (2-3 rank)</li>
										</ul> 
									<li>Elevated X2 pumping flights from regular</li>
									<li>Superior X2 flights from regular</li>
									<li>Superior flights to X2 reputation from ordinary</li>
									</ol>
									For each purchase of premium status you receive special points that increase your premium rate.
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
											<select name="guid" data-placeholder="Select a character..." class="chosen-select"  tabindex="2">
												<?php $__currentLoopData = $userinfo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userinf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
													<option value="<?php echo e($userinf->guid.','.$userinf->realm_id); ?>"><?php echo e($userinf->name); ?> (<?php echo e($userinf->realm_name); ?>)</option>
												<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
											</select>
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<button type="submit" class="btn btn-primary">Send a book of power</button>
								</div>
							</div>
							</form>    
								<div class="alert alert-success">
								   <?php echo e($premiuminfo[0]['unsetdate'] < 0 ? 'Unlimited premium status ' . $premiuminfo[0]['premium_type'] . ' rank active' : 
									 'Premium status ' . $premiuminfo[0]['premium_type'] . ' rank active until ' . date("d.m.Y", $premiuminfo[0]['unsetdate'])); ?>

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
								 Premium status not activated
							</div>
						<?php endif; ?>
							<div class="row">						
									<form method="POST" action="/personal/premium"
									  class="form-horizontal" enctype="multipart/form-data">

										<input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
										<input type="hidden" name="premium" value="day">
											<div class="col-sm-4">
												<button type="submit" class="btn btn-block btn-outline btn-primary">Buy day for <?php echo e($price_day->value); ?> D</button>
											</div>
									 </form>
									<form method="POST" action="/personal/premium"
									  class="form-horizontal" enctype="multipart/form-data">


										<input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
										<input type="hidden" name="premium" value="month">
											<div class="col-sm-4">
												<button type="submit" class="btn btn-block btn-outline btn-primary">Buy month for <?php echo e($price_month->value); ?> D</button>
											</div>
									 </form>
									<form method="POST" action="/personal/premium"
									  class="form-horizontal" enctype="multipart/form-data">


										<input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
										<input type="hidden" name="premium" value="year">
											<div class="col-sm-4">
												<button type="submit" class="btn btn-block btn-outline btn-primary">Buy year for <?php echo e($price_year->value); ?> D</button>
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