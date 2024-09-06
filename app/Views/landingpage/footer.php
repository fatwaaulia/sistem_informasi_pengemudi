<?php
$app_settings = model('AppSettings')->find(1);
$logo = base_url('assets/uploads/app_settings/') . $app_settings['logo'];
?>

<style>
footer a {color: white;}
footer a:hover {color: white;}
</style>
<footer class="container-fluid px-0 text-white pt-5 pb-3 bg-dark">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 pb-4">
                <img src="<?= $logo; ?>" class="w-50 w-md-25 w-lg-50" alt="logo">
            </div>
            <div class="col-lg-3 pb-3">
                <h5 class="mb-3">Web App</h5>
                <div class="mb-2">
                    <a href="/" class="text-slider-left">> Beranda</a>
                </div>
            </div>
            <div class="col-lg-3 pb-3">
                <h5 class="mb-3">Media & Informasi</h5>
                <div class="mb-2">
                    <a href="<?= base_url('berita') ?>" class="text-slider-left">> Berita</a>
                </div>
            </div>
            <style>
            .sosial-media img {
                filter: grayscale(100%);
                transition: .3s;
            }
            .sosial-media:hover img {
                filter: grayscale(0%);
            }
            </style>
            <div class="col-lg-3 pb-3">
                <h5 class="mb-3">Lokasi</h5>
                <div class="mb-2">
                    <div>
                        <i class="fa-solid fa-location-dot me-2"></i>
                        <?= $app_settings['nama_perusahaan'] ?>
                    </div>
                    <div><?= $app_settings['alamat'] ?></div>
                </div>
            </div>
        </div>
        <hr style="opacity: .25;">
        <div class="row">
            <div class="col-lg-12 py-1">
                <span>Copyright © 2024 | Web App</span>
            </div>
        </div>
    </div>
</footer>

<style>
.btn-scroll-to-top,
.btn-scroll-to-top:focus {
    position: fixed;
    bottom: 2%;
    right: 3%;
    border: 2px solid white!important;
    transition: .3s;
}
.btn-scroll-to-top:hover {
    border: 2px solid white!important;
    bottom: 3%;
}
</style>
<button class="btn btn-primary btn-scroll-to-top d-none" style="z-index:999;" onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
    <i class="fa-solid fa-arrow-up"></i>
</button>
<script>
$(document).scroll(() => {
    let scroll = $(document).scrollTop();
    if(scroll > 300) {
        $('.btn-scroll-to-top').removeClass('d-none');
    } else {
        $('.btn-scroll-to-top').addClass('d-none');
    }
});
</script>
