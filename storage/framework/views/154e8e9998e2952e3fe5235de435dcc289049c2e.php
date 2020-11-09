

<?php $__env->startSection('content'); ?>
<?php $__env->startSection('bodyclass'); ?>
<body>
<?php $__env->stopSection(); ?>
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Donación</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo e(route('personal')); ?>">Inicio</a>
                </li> 
                <li>
                    Cuenta
                </li>  
                <li class="active">
                    <strong>Donación</strong>
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
						<h5>Formulario de donación</h5>
					</div>
                    <div class="ibox-content">

                        <div class="project-list">
                            <div class="col-lg-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                        <i class="fa fa-info-circle"></i> Información útil
                                        </div>
                                        <div class="panel-body">
                                        <ul>
                                            <li>Nuestra administración agradece su contribución al desarrollo del servidor.</li>
                                            <li>La donación puede hacerse con dinero electrónico, tarjeta bancaria y otros medios enumerados a continuación.</li>
                                            <li>Los bonos serán acreditados tan pronto sea posible.</li>
                                        </ul>
                                        <h3>¿Quieres saber que métodos de donación hay en tu país?  Mándanos un mensaje al  <a class="btn btn-primary" href="https://www.facebook.com/WoWTalesServer/" role="button">Fanpage</a></h3>
                                        </div>
                                    </div>
									<div class="alert alert-success">
                                        En tu cuenta hay <?php echo e($data->donate); ?> Puntos de Donación (PD)
                                    </div>
                                </div>
                                <h2>Donacion via <span class="badge badge-secondary">PayPal</span></h2>
                                <div class="alert alert-info" role="alert">
                                    1 <?php echo e($currency->value); ?> = <?php echo e(ceil(1/$price->value)); ?> Puntos De Donación (PD)
                                </div>
								<form method="POST" class="form-horizontal" enctype="multipart/form-data">
                                <input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
								<input type="hidden" id="price" value="<?php echo e($price->value); ?>" type="text">							
								<div class="form-group">
                                    <label class="col-sm-3">Monto de donación en (<?php echo e($currency->value); ?>):</label>
                                    <div class="col-sm-9">
                                        <div class="input-group col-sm-12">
                                            <div>
                                                <input type="text" onfocus="calculate(this)" class="form-control" name="m_count" id="m_count" value="" placeholder="Monto en dolares">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3">Número de puntos de donación (PD):</label>
                                    <div class="col-sm-9">
                                        <div class="input-group col-sm-12">
                                            <div>
                                                <input type="text" onfocus="calculate(this)" class="form-control" name="d_count" id="d_count" value="" placeholder="Puntos de donacion">
                                            </div>
                                        </div>
                                    </div>
                                </div>
								<button type="submit" class="btn btn-primary">Donar</button>
								</form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
<script>
function calculate(elem) {
   var input = document.querySelectorAll('#' + elem.id);
   var res;
   for (let i = 0; i < input.length; i++) {
        input[i].addEventListener('input', function() {
           if (elem.id === 'd_count') {
               if (d_count.value !== '') {
                   res = d_count.value * price.value;
                   m_count.value = Math.round(res);                                                           
               }
           } else if (elem.id === 'm_count') {
               if (m_count.value !== '') {
                   res = m_count.value / price.value;
                   d_count.value = Math.round(res);
               }
           }
       })
   }
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>