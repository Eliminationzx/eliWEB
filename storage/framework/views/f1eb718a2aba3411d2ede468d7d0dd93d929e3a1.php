<?php $__env->startSection('content'); ?>
<?php $__env->startSection('bodyclass'); ?>
<body>
<?php $__env->stopSection(); ?>
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Подтверждение покупки</h2>
             <ol class="breadcrumb">
                <li>
                    <a href="<?php echo e(route('personal')); ?>">Главная</a>
                </li>  
                <li class="active">
                    <strong>Магазин</strong>
                </li> 
             </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">

        <div class="row">
            <div class="col-lg-12">

                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Форма подтверждения покупки</h5>
                    </div>
                    <div class="ibox-content">

                        <div class="project-list">
                            <?php if( session('status')): ?>
                                <div class="alert alert-<?php echo e(session('type')); ?>">
                                    <?php echo e(session('status')); ?>

                                </div>
                            <?php endif; ?>
                                <div class="alert alert-success">
                                 Вы собираетесь купить
                                 <a>
								 <wow-tooltip-content   
                                   data-id="<?php echo e($shopitem->id); ?>" 
                                   data-shopitem-quality-color="<?php echo e(empty($shopitem->quality) ? '#9D9D9D' : $shopitem->quality['color']); ?>"
                                   data-shopitem-name="<?php echo e($shopitem->name); ?>"
                                   data-shopitem-bonding="<?php echo e(empty($shopitem->bonding) ? '' : $shopitem->bonding); ?>"
                                   data-shopitem-invtype="<?php echo e(empty($shopitem->invtype) ? '' : $shopitem->invtype); ?>"
                                   data-shopitem-armor="<?php echo e($shopitem->armor == 0 ? '' : 'Броня: '.$shopitem->armor); ?>"
                                   data-shopitem-dmg_min1="<?php echo e($shopitem->dmg_min1 == 0 ? '' : 'Урон: '.$shopitem->dmg_min1); ?> <?php echo e($shopitem->dmg_max1 == 0 ? '' : '- '.$shopitem->dmg_max1); ?>"
                                   data-shopitem-dmg_min2="<?php echo e($shopitem->dmg_min2 == 0 ? '' : 'Урон: '.$shopitem->dmg_min2); ?> <?php echo e($shopitem->dmg_max2 == 0 ? '' : '- '.$shopitem->dmg_max2); ?>"
                                   data-shopitem-delay="<?php echo e($shopitem->delay == 0 ? '' : 'Скорость '.$shopitem->delay); ?>"
                                   data-shopitem-dmgpersec="<?php echo e($shopitem->dmg_persec == 0 ? '' : '('.$shopitem->dmg_persec.' ед. урона в секунду)'); ?>"
                                   data-shopitem-main-statvalue1="<?php echo e(!empty($shopitem->main_stat_value1) ? '+'.$shopitem->main_stat_value1.' '.$shopitem->main_stat_type1 : ''); ?>"
                                   data-shopitem-main-statvalue2="<?php echo e(!empty($shopitem->main_stat_value2) ? '+'.$shopitem->main_stat_value2.' '.$shopitem->main_stat_type2 : ''); ?>"    
                                   data-shopitem-main-statvalue3="<?php echo e(!empty($shopitem->main_stat_value3) ? '+'.$shopitem->main_stat_value3.' '.$shopitem->main_stat_type3 : ''); ?>"
                                   data-shopitem-main-statvalue4="<?php echo e(!empty($shopitem->main_stat_value4) ? '+'.$shopitem->main_stat_value4.' '.$shopitem->main_stat_type4 : ''); ?>"
                                   data-shopitem-main-statvalue5="<?php echo e(!empty($shopitem->main_stat_value5) ? '+'.$shopitem->main_stat_value5.' '.$shopitem->main_stat_type5 : ''); ?>"
                                   data-shopitem-main-statvalue6="<?php echo e(!empty($shopitem->main_stat_value6) ? '+'.$shopitem->main_stat_value6.' '.$shopitem->main_stat_type6 : ''); ?>"
                                   data-shopitem-main-statvalue7="<?php echo e(!empty($shopitem->main_stat_value7) ? '+'.$shopitem->main_stat_value7.' '.$shopitem->main_stat_type7 : ''); ?>"
                                   data-shopitem-main-statvalue8="<?php echo e(!empty($shopitem->main_stat_value8) ? '+'.$shopitem->main_stat_value8.' '.$shopitem->main_stat_type8 : ''); ?>"
                                   data-shopitem-main-statvalue9="<?php echo e(!empty($shopitem->main_stat_value9) ? '+'.$shopitem->main_stat_value9.' '.$shopitem->main_stat_type9 : ''); ?>"
                                   data-shopitem-main-statvalue10="<?php echo e(!empty($shopitem->main_stat_value10) ? '+'.$shopitem->main_stat_value10.' '.$shopitem->main_stat_type10 : ''); ?>"
                                   data-shopitem-bonus-statvalue1="<?php echo e(!empty($shopitem->bonus_stat_value1) ? 'Если на персонаже: '.$shopitem->bonus_stat_type1.' +'.$shopitem->bonus_stat_value1 : ''); ?>"       
                                   data-shopitem-bonus-statvalue2="<?php echo e(!empty($shopitem->bonus_stat_value2) ? 'Если на персонаже: '.$shopitem->bonus_stat_type2.' +'.$shopitem->bonus_stat_value2 : ''); ?>"       
                                   data-shopitem-bonus-statvalue3="<?php echo e(!empty($shopitem->bonus_stat_value3) ? 'Если на персонаже: '.$shopitem->bonus_stat_type3.' +'.$shopitem->bonus_stat_value3 : ''); ?>"       
                                   data-shopitem-bonus-statvalue4="<?php echo e(!empty($shopitem->bonus_stat_value4) ? 'Если на персонаже: '.$shopitem->bonus_stat_type4.' +'.$shopitem->bonus_stat_value4 : ''); ?>"       
                                   data-shopitem-bonus-statvalue5="<?php echo e(!empty($shopitem->bonus_stat_value5) ? 'Если на персонаже: '.$shopitem->bonus_stat_type5.' +'.$shopitem->bonus_stat_value5 : ''); ?>"
                                   data-shopitem-bonus-statvalue6="<?php echo e(!empty($shopitem->bonus_stat_value6) ? 'Если на персонаже: '.$shopitem->bonus_stat_type6.' +'.$shopitem->bonus_stat_value6 : ''); ?>"       
                                   data-shopitem-bonus-statvalue7="<?php echo e(!empty($shopitem->bonus_stat_value7) ? 'Если на персонаже: '.$shopitem->bonus_stat_type7.' +'.$shopitem->bonus_stat_value7 : ''); ?>"
                                   data-shopitem-bonus-statvalue8="<?php echo e(!empty($shopitem->bonus_stat_value8) ? 'Если на персонаже: '.$shopitem->bonus_stat_type8.' +'.$shopitem->bonus_stat_value8 : ''); ?>"
                                   data-shopitem-bonus-statvalue9="<?php echo e(!empty($shopitem->bonus_stat_value9) ? 'Если на персонаже: '.$shopitem->bonus_stat_type9.' +'.$shopitem->bonus_stat_value9 : ''); ?>"       
                                   data-shopitem-bonus-statvalue10="<?php echo e(!empty($shopitem->bonus_stat_value10) ? 'Если на персонаже: '.$shopitem->bonus_stat_type10.' +'.$shopitem->bonus_stat_value10 : ''); ?>"
                                   data-shopitem-skill="<?php echo e(empty($shopitem->skill) ? '' : $shopitem->skill); ?>"
                                   data-shopitem-maxdurability="<?php echo e($shopitem->maxdurability == 0 ? '' : 'Прочность: '.$shopitem->maxdurability.' / '.$shopitem->maxdurability); ?>"
                                   data-shopitem-itemlevel="<?php echo e($shopitem->itemlevel == 0 ? '' : 'Уровень предмета: '.$shopitem->itemlevel); ?>"
                                   data-shopitem-requiredlevel="<?php echo e($shopitem->requiredlevel == 0 ? '' : 'Требуемый уровень: '.$shopitem->requiredlevel); ?>"
                                   data-shopitem-allowableclass="<?php echo e(!empty($shopitem->allowableclass) ? 'Классы: '.$shopitem->allowableclass : ''); ?>"
                                   data-shopitem-allowablerace="<?php echo e(!empty($shopitem->allowablerace) ? 'Расы: '.$shopitem->allowablerace : ''); ?>"
                                   data-shopitem-spell1="<?php echo e(empty($shopitem->spell_1) ? '' : $shopitem->spell_1->Description_ru_ru); ?>"
                                   data-shopitem-spell2="<?php echo e(empty($shopitem->spell_2) ? '' : $shopitem->spell_2->Description_ru_ru); ?>"
                                   data-shopitem-spell3="<?php echo e(empty($shopitem->spell_3) ? '' : $shopitem->spell_3->Description_ru_ru); ?>"
                                   data-shopitem-spell4="<?php echo e(empty($shopitem->spell_4) ? '' : $shopitem->spell_4->Description_ru_ru); ?>"
                                   data-shopitem-spell5="<?php echo e(empty($shopitem->spell_5) ? '' : $shopitem->spell_5->Description_ru_ru); ?>">
                                       <?php echo e($shopitem->name); ?>

                                   </wow-tooltip-content>
								   </a>
                                   <tre>1</tre> шт за <trc><?php echo e($shopitem->price); ?></trc> Н
                                </div>
                                
                            <form method="POST" action="<?php echo e(route('shop.payments')); ?>"
                                  class="form-horizontal" enctype="multipart/form-data">

                                <input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
                                <input type="hidden" name="itemid" id="itemid" value="<?php echo e($shopitem->id); ?>">
                                <input type="hidden" id="price" value="<?php echo e($shopitem->price); ?>" type="text">

                                <div class="form-group">
                                      <label class="col-sm-3">Количество:</label>
                                      <div class="col-sm-9">
                                            <div class="input-group col-sm-12">
                                                <div>
                                                   <input type="text" id="itemcount" name="itemcount" class="form-control" value="" placeholder="Укажите количество от 1 до 100...">
                                                </div>
                                            </div>
                                      </div>
                                 </div>
                                                            
                                <div class="form-group">
                                    <label class="col-sm-3">Выберите персонажа:</label>
                                    <div class="col-sm-9">
                                        <div class="input-group col-sm-12">
                                            <div>
                                                <select name="guid" data-placeholder="Выберите персонажа..." class="chosen-select"  tabindex="2">
                                                    <?php if($userinfo != null): ?>
														<?php $__currentLoopData = $userinfo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userinf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
															<option value="<?php echo e($userinf->guid); ?>"><?php echo e($userinf->name); ?> (<?php echo e($userinf->realm_name); ?>)</option>
														<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
													<?php endif; ?>
                                                    <?php if($recruiterinfo != null): ?>
                                                         <option disabled>_________Персонажи связанной учетной записи_________</option>
                                                        <?php $__currentLoopData = $recruiterinfo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recruiterinf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($recruiterinf->guid); ?>"><?php echo e($recruiterinf->name); ?> (<?php echo e($recruiterinf->realm_name); ?>)</option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-block btn-outline btn-primary">Подтвердить</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

<script>
   var input = document.querySelectorAll('#itemcount');
   var div_trc = document.querySelector('trc');
   var div_tre = document.querySelector('tre');
   var res;
   for (let i = 0; i < input.length; i++) {
        input[i].addEventListener('input', function() {
            if (itemcount.value !== '') {
                res = itemcount.value * price.value;
                div_tre.textContent = Math.ceil(itemcount.value);
                div_trc.textContent = Math.ceil(res);
            }
        })
   }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>