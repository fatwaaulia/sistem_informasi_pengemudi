<?php
$app_settings = model('AppSettings')->find(1);
$logo = base_url('assets/uploads/app_settings/') . $app_settings['logo'];
?>

<style>
footer a {color: white;}
footer a:hover {color: white;}
</style>
<footer class="container-fluid px-0 text-white pt-3 pb-3 bg-dark">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 py-1">
                <span>Copyright © 2024 | Web App</span>
            </div>
            <div class="col-lg-6 py-1 text-end">
                <a href="<?= base_url() ?>kebijakan-privasi" class="me-2">Kebijakan Privasi</a>
                <a href="<?= base_url() ?>syarat-ketentuan" class="me-2">Syarat dan Ketentuan</a>
                <a href="https://wa.me/6285526250131" target="_blank">Hubungi Kami</a>
            </div>
        </div>
    </div>
</footer>
