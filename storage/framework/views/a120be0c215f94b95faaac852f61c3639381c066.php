<?php $__env->startSection('content'); ?>
<?php $__env->startSection('bodyclass'); ?>
<body>
<?php $__env->stopSection(); ?>
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Испытание удачи</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo e(route('personal')); ?>">Главная</a>
                </li> 
                <li class="active">
                    <strong>Испытание удачи</strong>
                </li> 
            </ol>
        </div>
    </div>
	
	<div class="chat-message left">
        <div class="message">
		    <h2>Информация об игре</h2>
            <div class="alert alert-info" >
				   <ol>
					<li>Цена спина - <?php echo e($spin_cost->value); ?> Н</li>
					<li>Максимальная награда "Легендарный выигрыш" - <?php echo e($spin_reward->value * 10); ?> Н</li>
					<li>Минимальная награда награда - <?php echo e($spin_reward->value); ?> Н</li>
					<li>Условия игры:
						<ul>
							<li>Совпадение трех "Тауренов ETC" = ЛЕГЕНДАРНЫЙ ВЫИГРЫШ(<?php echo e($spin_reward->value * 10); ?> Н)</li>
							<li>Совпадение двух "Тауренов ETC" + любой третий слот = выигрыш (<?php echo e($spin_reward->value * 2); ?> Н)</li>
							<li>Совпадение одного "Таурена ETC" + два любых одинаковых слота = минимальный выигрыш (<?php echo e($spin_reward->value); ?> Н)</li>
							<li>Совпадение трех любых (кроме "Тауренов ETC") одинаковых слота = минимальный выигрыш (<?php echo e($spin_reward->value); ?> Н)</li>
						</ul>
					</li>
				   </ol>
            </div>
		</div>	
		<div class="spin-box animated fadeInRight">
			<div id="status"><status>ИСПЫТАЙТЕ УДАЧУ</status> <img src="<?php echo e(URL::asset('admin/js/spin/icons/audioOn.png')); ?>" id="audio" class="option1" onclick="toggleAudio()" /></div>
			<div id="Slots">
				<?php for($i=1; $i <= 3; $i++): ?>
					<div id="slot<?php echo e($i); ?>" class="a1"></div>
				<?php endfor; ?>
			</div>
			<div class="infos">
				 <span id="spininfo"><spininfo>0</spininfo> <i class="fa fa-refresh fa-1x"></i></span>
				 <span id="wininfo"><wininfo>0</wininfo> <i class="fa fa-star fa-1x"></i></span>
				 <span id="superwininfo"><superwininfo>0</superwininfo> <i class="fa fa-star fa-1x"></i><i class="fa fa-star fa-1x"></i><i class="fa fa-star fa-1x"></i></span>
				 <span id="donateinfo"><donateinfo><?php echo e($data->donate); ?></donateinfo> н</span>
			</div>
			<div class="btn-spin" id="spinbtn" onclick="doSpin();">КРУТИТЬ!</div>
		</div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>