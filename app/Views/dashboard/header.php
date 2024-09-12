<?php

$app_settings = model('AppSettings')->find(1);
$favicon = base_url('assets/uploads/app_settings/') . $app_settings['favicon'];
$title   = isset($title) ? $title : $app_settings['nama_aplikasi'];
$description = $app_settings['deskripsi'];

?>

<!DOCTYPE html>
<html id="html">
<head>
    <?= csrf_meta() ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:image" content="<?= $favicon ?>">
    <meta property="og:image:width" content="200">
    <meta property="og:image:height" content="200">
    <meta property="og:title" content="<?= $title ?>">
    <meta property="og:description" content="<?= $description ?>">
    <meta property="og:site_name" content="<?= $app_settings['nama_aplikasi'] ?>">
    <meta property="og:url" content="<?= current_url() ?>">
    <meta name="description" content="<?= $description ?>">
    <link rel="shortcut icon" href="<?= $favicon ?>" type="image/x-icon">
    <title><?= $title ?></title>

    <!-- source support -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/modules/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/modules/niceadmin/css/style.css">
    <script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/js/sweetalert2.js"></script>

    <!-- datatables -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/modules/datatables/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/modules/datatables/css/dataTables.dateTime.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/modules/datatables/css/buttons.dataTables.min.css">

    <!-- my style -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/main.css?v=1.0.1">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/dashboard.css?v=1.0.1">
</head>

<body>
    <div class="loader position-absolute top-50 start-50 translate-middle"></div>
    <script>setTimeout(() => $('.loader').fadeToggle());</script>

    <?= session()->getFlashdata('message') ?>

    <?php
    if (session()->isLogin === true) :
        echo $sidebar ?? '';
    ?>
    <main id="main" class="main">
        <?= $content ?? view('errors/page_404') ?>
    </main>
    <?php else : echo $content ?? view('errors/page_404'); endif; ?>
    
    <!-- source support -->
    <script src="<?= base_url() ?>assets/modules/niceadmin/js/main.js"></script>
    <script src="<?= base_url() ?>assets/modules/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- my script -->
    <script src="<?= base_url() ?>assets/js/main.js"></script>
    
    <!-- datatables -->
    <script src="<?= base_url() ?>assets/modules/datatables/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>assets/modules/datatables/js/dataTables.buttons.min.js"></script>
    <script src="<?= base_url() ?>assets/modules/datatables/js/jszip.min.js"></script>
    <script src="<?= base_url() ?>assets/modules/datatables/js/buttons.html5.min.js"></script>
    <script src="<?= base_url() ?>assets/modules/datatables/js/buttons.colVis.min.js"></script>
</body>
</html>
