

<?php $__env->startSection('content'); ?>
<?php $__env->startSection('bodyclass'); ?>
<body>
<?php $__env->stopSection(); ?>
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Tienda</h2>
             <ol class="breadcrumb">
                <li>
                    <a href="<?php echo e(route('personal')); ?>">Inicio</a>
                </li>  
                <li class="active">
                    <strong>Tienda</strong>
                </li> 
             </ol>
        </div>
    </div>
    
    <div class="chat-message left">
       <form method="POST" action="<?php echo e(route('shop.search')); ?>"
              class="form-horizontal" enctype="multipart/form-data">
            <input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">

                    <div class="input-group">
                        <input type="text" name="searchstr" class="form-control" value="" placeholder="Enter name or item ID...">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-primary">Buscar
                            </button>
                        </span>
                    </div>
        </form>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">

        <div class="row">
            <div class="col-lg-12">

                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Search results (<?php echo e(count($shopitems)); ?>)</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="project-list">
                            <div class="row">
                                    <?php $__empty_1 = true; $__currentLoopData = $shopitems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shopitem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <div class="col-md-3" id="<?php echo e($shopitem['id']); ?>">
                                        <div class="ibox">
                                            <div class="ibox-content product-box">

                                                <div class="product-imitation">
                                                <wow-tooltip-content
                                                   data-id="<?php echo e($shopitem['id']); ?>" 
                                                   data-shopitem-quality-color="<?php echo e(empty($shopitem['quality']) ? '#9D9D9D' : $shopitem['quality']['color']); ?>"
                                                   data-shopitem-name="<?php echo e($shopitem['name']); ?>"
                                                   data-shopitem-bonding="<?php echo e(empty($shopitem['bonding']) ? '' : $shopitem['bonding']); ?>"
                                                   data-shopitem-invtype="<?php echo e(empty($shopitem['invtype']) ? '' : $shopitem['invtype']); ?>"
                                                   data-shopitem-armor="<?php echo e($shopitem['armor'] == 0 ? '' : 'Armadura: '.$shopitem['armor']); ?>"
                                                   data-shopitem-dmg_min1="<?php echo e($shopitem['dmg_min1'] == 0 ? '' : 'Daño: '.$shopitem['dmg_min1']); ?> <?php echo e($shopitem['dmg_max1'] == 0 ? '' : '- '.$shopitem['dmg_max1']); ?>"
                                                   data-shopitem-dmg_min2="<?php echo e($shopitem['dmg_min2'] == 0 ? '' : 'Daño: '.$shopitem['dmg_min2']); ?> <?php echo e($shopitem['dmg_max2'] == 0 ? '' : '- '.$shopitem['dmg_max2']); ?>"
                                                   data-shopitem-delay="<?php echo e($shopitem['delay'] == 0 ? '' : 'Veloc. '.$shopitem['delay']); ?>"
                                                   data-shopitem-dmgpersec="<?php echo e($shopitem['dmg_persec'] == 0 ? '' : '('.$shopitem['dmg_persec'].' daño por segundo)'); ?>"
                                                   data-shopitem-main-statvalue1="<?php echo e(!empty($shopitem['main_stat_value1']) ? '+'.$shopitem['main_stat_value1'].' '.$shopitem['main_stat_type1'] : ''); ?>"
                                                   data-shopitem-main-statvalue2="<?php echo e(!empty($shopitem['main_stat_value2']) ? '+'.$shopitem['main_stat_value2'].' '.$shopitem['main_stat_type2'] : ''); ?>"    
                                                   data-shopitem-main-statvalue3="<?php echo e(!empty($shopitem['main_stat_value3']) ? '+'.$shopitem['main_stat_value3'].' '.$shopitem['main_stat_type3'] : ''); ?>"
                                                   data-shopitem-main-statvalue4="<?php echo e(!empty($shopitem['main_stat_value4']) ? '+'.$shopitem['main_stat_value4'].' '.$shopitem['main_stat_type4'] : ''); ?>"
                                                   data-shopitem-main-statvalue5="<?php echo e(!empty($shopitem['main_stat_value5']) ? '+'.$shopitem['main_stat_value5'].' '.$shopitem['main_stat_type5'] : ''); ?>"
                                                   data-shopitem-main-statvalue6="<?php echo e(!empty($shopitem['main_stat_value6']) ? '+'.$shopitem['main_stat_value6'].' '.$shopitem['main_stat_type6'] : ''); ?>"
                                                   data-shopitem-main-statvalue7="<?php echo e(!empty($shopitem['main_stat_value7']) ? '+'.$shopitem['main_stat_value7'].' '.$shopitem['main_stat_type7'] : ''); ?>"
                                                   data-shopitem-main-statvalue8="<?php echo e(!empty($shopitem['main_stat_value8']) ? '+'.$shopitem['main_stat_value8'].' '.$shopitem['main_stat_type8'] : ''); ?>"
                                                   data-shopitem-main-statvalue9="<?php echo e(!empty($shopitem['main_stat_value9']) ? '+'.$shopitem['main_stat_value9'].' '.$shopitem['main_stat_type9'] : ''); ?>"
                                                   data-shopitem-main-statvalue10="<?php echo e(!empty($shopitem['main_stat_value10']) ? '+'.$shopitem['main_stat_value10'].' '.$shopitem['main_stat_type10'] : ''); ?>"
                                                   data-shopitem-bonus-statvalue1="<?php echo e(!empty($shopitem['bonus_stat_value1']) ? 'Equipar: '.$shopitem['bonus_stat_type1'].' +'.$shopitem['bonus_stat_value1'] : ''); ?>"       
                                                   data-shopitem-bonus-statvalue2="<?php echo e(!empty($shopitem['bonus_stat_value2']) ? 'Equipar: '.$shopitem['bonus_stat_type2'].' +'.$shopitem['bonus_stat_value2'] : ''); ?>"       
                                                   data-shopitem-bonus-statvalue3="<?php echo e(!empty($shopitem['bonus_stat_value3']) ? 'Equipar: '.$shopitem['bonus_stat_type3'].' +'.$shopitem['bonus_stat_value3'] : ''); ?>"       
                                                   data-shopitem-bonus-statvalue4="<?php echo e(!empty($shopitem['bonus_stat_value4']) ? 'Equipar: '.$shopitem['bonus_stat_type4'].' +'.$shopitem['bonus_stat_value4'] : ''); ?>"       
                                                   data-shopitem-bonus-statvalue5="<?php echo e(!empty($shopitem['bonus_stat_value5']) ? 'Equipar: '.$shopitem['bonus_stat_type5'].' +'.$shopitem['bonus_stat_value5'] : ''); ?>"
                                                   data-shopitem-bonus-statvalue6="<?php echo e(!empty($shopitem['bonus_stat_value6']) ? 'Equipar: '.$shopitem['bonus_stat_type6'].' +'.$shopitem['bonus_stat_value6'] : ''); ?>"       
                                                   data-shopitem-bonus-statvalue7="<?php echo e(!empty($shopitem['bonus_stat_value7']) ? 'Equipar: '.$shopitem['bonus_stat_type7'].' +'.$shopitem['bonus_stat_value7'] : ''); ?>"
                                                   data-shopitem-bonus-statvalue8="<?php echo e(!empty($shopitem['bonus_stat_value8']) ? 'Equipar: '.$shopitem['bonus_stat_type8'].' +'.$shopitem['bonus_stat_value8'] : ''); ?>"
                                                   data-shopitem-bonus-statvalue9="<?php echo e(!empty($shopitem['bonus_stat_value9']) ? 'Equipar: '.$shopitem['bonus_stat_type9'].' +'.$shopitem['bonus_stat_value9'] : ''); ?>"       
                                                   data-shopitem-bonus-statvalue10="<?php echo e(!empty($shopitem['bonus_stat_value10']) ? 'Equipar: '.$shopitem['bonus_stat_type10'].' +'.$shopitem['bonus_stat_value10'] : ''); ?>"
                                                   data-shopitem-skill="<?php echo e(empty($shopitem['skill']) ? '' : $shopitem['skill']); ?>"
                                                   data-shopitem-maxdurability="<?php echo e($shopitem['maxdurability'] == 0 ? '' : 'Durabilidad: '.$shopitem['maxdurability'].' / '.$shopitem['maxdurability']); ?>"
                                                   data-shopitem-itemlevel="<?php echo e($shopitem['itemlevel'] == 0 ? '' : 'Уровень предмета: '.$shopitem['itemlevel']); ?>"
                                                   data-shopitem-requiredlevel="<?php echo e($shopitem['requiredlevel'] == 0 ? '' : 'Требуемый уровень: '.$shopitem['requiredlevel']); ?>"
                                                   data-shopitem-allowableclass="<?php echo e(!empty($shopitem['allowableclass']) ? 'Классы: '.$shopitem['allowableclass'] : ''); ?>"
                                                   data-shopitem-allowablerace="<?php echo e(!empty($shopitem['allowablerace']) ? 'Расы: '.$shopitem['allowablerace'] : ''); ?>"
                                                   data-shopitem-spell1="<?php echo e(empty($shopitem['spell_1']) ? '' : $shopitem['spell_1']['Description_ru_ru']); ?>"
                                                   data-shopitem-spell2="<?php echo e(empty($shopitem['spell_2']) ? '' : $shopitem['spell_2']['Description_ru_ru']); ?>"
                                                   data-shopitem-spell3="<?php echo e(empty($shopitem['spell_3']) ? '' : $shopitem['spell_3']['Description_ru_ru']); ?>"
                                                   data-shopitem-spell4="<?php echo e(empty($shopitem['spell_4']) ? '' : $shopitem['spell_4']['Description_ru_ru']); ?>"
                                                   data-shopitem-spell5="<?php echo e(empty($shopitem['spell_5']) ? '' : $shopitem['spell_5']['Description_ru_ru']); ?>">
                                                        <img class="tooltip-icon-prev" src="https://wow.zamimg.com/images/wow/icons/large/<?php echo e($shopitem['icon']); ?>.jpg"/>
                                                   </wow-tooltip-content>
                                                </div>
                                                <div class="product-desc">
                                                    <span class="product-price">
                                                        <?php if($shopitem['rnd_discount'] > 0): ?>
                                                          <?php echo e('-'.$shopitem['rnd_discount'].'% '); ?><del><?php echo e($shopitem['price']); ?> PD</del> <?php echo e(ceil($shopitem['price'] * (100 - $shopitem['rnd_discount']) / 100)); ?> PD <?php echo e($shopitem['count'] > 1 ? 'for '.$shopitem['count'] : ''); ?> 
                                                        <?php else: ?>
                                                          <?php echo e($shopitem['price']); ?> PD <?php echo e($shopitem['count'] > 1 ? 'for '.$shopitem['count'] : ''); ?>  
                                                        <?php endif; ?>
                                                    </span>
                                                    <span class="product-name"><?php echo e(mb_strlen($shopitem['name']) > 20 ? mb_substr($shopitem['name'], 0, 20).'...' : $shopitem['name']); ?></span>
                                                    <span class="label label"> <?php echo e($shopitem['realm_name']); ?></span>
                                                    <div class="m-t text-righ">
                                                        <form action="<?php echo e(route('admin.shop.update')); ?>" method="POST" role="form">
                                                            <input type="hidden" name="id" value="<?php echo e($shopitem['id']); ?>">
                                                            <input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">

                                                            <?php if (\Entrust::can('update-shop')) : ?>
                                                            <button class="btn btn-xs btn-outline btn-primary ">Editar <i
                                                                        class="fa fa-long-arrow-right"></i></button>
                                                            <?php endif; // Entrust::can ?>

                                                            <?php if (\Entrust::can('delete-shop')) : ?>
                                                            <button class="btn btn-xs btn-outline btn-danger pull-right delete" data-element-id="<?php echo e($shopitem['id']); ?>" data-method-post="<?php echo e(route('admin.shop.delete')); ?>" onclick="return false;" >Eliminar <i
                                                                        class="fa fa-times"></i></button>
                                                            <?php endif; // Entrust::can ?>
                                                        </form>
                                                        <br>
                                                        <form action="<?php echo e(route('shop.payments')); ?>" method="POST" role="form">
                                                            <input type="hidden" name="id" value="<?php echo e($shopitem['id']); ?>">
                                                            <input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">

                                                            <button class="btn btn-xs btn-outline btn-block btn-primary ">Comprar</button>


                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <div class="col-md-12">
                                    <div class="alert alert-danger">
                                        Unfortunately, nothing was found at your request.
                                    </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>