<?php

$app_settings = model('AppSettings')->find(1);
$favicon = base_url('assets/uploads/app_settings/') . $app_settings['favicon'];
$title = isset($title) ? $title : $app_settings['nama_aplikasi'];
$description = $app_settings['deskripsi'];
$uri = service('request')->getUri();
$uri->setSilent(true);
if (($uri->getSegment(1) == 'berita') && (($uri->getSegment(2)) != null) ) {
    $berita = model('Berita')->where('slug', $uri->getSegment(2))->first();
    $favicon = base_url('assets/uploads/berita/' . $berita['sampul']);
    $description = strip_tags($berita['konten']);
}

?>

<!DOCTYPE html>
<html>
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
    <script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/js/sweetalert2.js"></script>
    <link rel="stylesheet" href="<?= base_url() ?>assets/modules/wowjs/animate.min.css">
    <script src="<?= base_url() ?>assets/modules/wowjs/wow.min.js"></script>
    <script>
        new WOW().init();
    </script>

    <!-- my style -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/main.css">
    <style>
    section {
        padding: 50px;
    }
    </style>
</head>

<body>
    <div class="loader position-absolute top-50 start-50 translate-middle"></div>
    <script>setTimeout(() => $('.loader').fadeToggle());</script>

    <?= session()->getFlashdata('message') ?>

    <?= $navbar ?? '' ?>
    <main>
        <?= $content ?? '' ?>
    </main>
    <?= $footer ?? '' ?>

    <!-- source support -->
    <script src="<?= base_url() ?>assets/modules/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- my script -->
    <script src="<?= base_url() ?>assets/js/main.js"></script>
</body>
</html>
