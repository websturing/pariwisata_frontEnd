<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Dinas kebudayaan Dan pariwisata Kota Tanjungpinang</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="<?php echo e(url('public/starAdmin/assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(url('public/starAdmin/assets/vendors/iconfonts/ionicons/css/ionicons.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(url('public/starAdmin/assets/vendors/iconfonts/typicons/src/font/typicons.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(url('public/starAdmin/assets/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(url('public/starAdmin/assets/vendors/css/vendor.bundle.base.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(url('public/starAdmin/assets/vendors/css/vendor.bundle.addons.css')); ?>">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="<?php echo e(url('public/starAdmin/assets/css/shared/style.css')); ?>">
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="<?php echo e(url('public/starAdmin/assets/css/demo_1/style.css')); ?>">
    <!-- End Layout styles -->
    <link rel="shortcut icon" href="<?php echo e(url('public/starAdmin/assets/images/fav.png')); ?>" />
</head>

<body>
    <div class="container-scroller">
        <div id="app">
            <router-view :key="$route.fullPath"></router-view>
        </div>
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="<?php echo e(url('public/starAdmin/assets/vendors/js/vendor.bundle.base.js')); ?>"></script>
    <!-- endinject -->
    <!-- Plugin js for this page-->
    <!-- End plugin js for this page-->
    <!-- inject:js -->
    <script src="<?php echo e(url('public/starAdmin/assets/js/shared/off-canvas.js')); ?>"></script>
    <script src="<?php echo e(url('public/starAdmin/assets/js/shared/misc.js')); ?>"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="<?php echo e(url('public/js/jquery.validate.min.js')); ?>"></script>
    <script src="<?php echo e(url('public/js/app.js')); ?>"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    
</body>
<style>
    .item-purchase-banner {
        display: none;
    }

    .username,
    .password {
        color: red;
        margin-top: 5px;
        font-size: 10px;
    }

</style>

</html>
<?php /**PATH C:\laragon\www\pariwisataLaravel\resources\views/panel/login.blade.php ENDPATH**/ ?>