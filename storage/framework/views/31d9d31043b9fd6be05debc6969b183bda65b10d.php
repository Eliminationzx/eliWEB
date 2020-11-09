<?php if($paginator->hasPages()): ?>




    <ul class="pagination pull-right">
        
        <?php if($paginator->onFirstPage()): ?>
            <li class="footable-page-arrow disabled">
                <a data-page="prev">&laquo;</a>
            </li>
        <?php else: ?>
            <li class="footable-page-arrow">
            <a href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev">&laquo;</a>
            </li>
        <?php endif; ?>

        
        <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            
            <?php if(is_string($element)): ?>
                <li class="footable-page">
                    <a><?php echo e($element); ?></a>
                </li>
            <?php endif; ?>

            
            <?php if(is_array($element)): ?>
                <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($page == $paginator->currentPage()): ?>
                        <li class="footable-page active">
                        <a ><?php echo e($page); ?></a>
                        </li>
                    <?php else: ?>
                        <li class="footable-page">
                        <a href="<?php echo e($url); ?>"><?php echo e($page); ?></a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        
        <?php if($paginator->hasMorePages()): ?>
            <li class="footable-page-arrow">
            <a href="<?php echo e($paginator->nextPageUrl()); ?>" >&raquo;</a>
            </li>
        <?php else: ?>
            <li class="footable-page-arrow disabled">
                <a data-page="first">&raquo;</a>
            </li>
        <?php endif; ?>
    </ul>
<?php endif; ?>
