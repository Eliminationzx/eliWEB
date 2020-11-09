<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo e(config('app.name_prj')); ?> | 404 Not Found</title>

    <link href="<?php echo e(URL::asset('admin/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(URL::asset('admin/font-awesome/css/font-awesome.css')); ?>" rel="stylesheet">

    <link href="<?php echo e(URL::asset('admin/css/animate.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(URL::asset('admin/css/style.css')); ?>" rel="stylesheet">

</head>

<body class="gray-bg">


<div class="middle-box text-center animated fadeInDown">
    <h1>404</h1>
    <h3 class="font-bold">Страница которую вы ищите не существует</h3>

    <div class="error-desc">
        <a href="<?php echo e(route('home')); ?>" class="btn btn-primary m-t">На главную</a>
    </div>
</div>

<!-- Mainly scripts -->
<script src="<?php echo e(URL::asset('admin/js/jquery-3.1.1.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('admin/js/bootstrap.min.js')); ?>"></script>

</body>

</html>
