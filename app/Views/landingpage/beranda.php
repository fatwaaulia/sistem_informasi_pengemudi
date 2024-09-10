<style>
.header {
    background-image: linear-gradient(rgba(0, 0, 0, .5), rgba(0, 0, 0, .5)), url(<?= base_url('assets/img/rhys-moult-7eaFIKeo1MQ-unsplash.jpg') ?>);
    height: 100vh;
    display: flex;
    align-items: center;
    justify-items: center;
    background-attachment: fixed;
}
</style>
<div class="container-fluid header img-style">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="position-relative text-white justify-items-center" id="headerTitle">
                    <h4>Selamat Datang di</h4>
                    <h1 class="fw-600 mb-4"><?= model('AppSettings')->find(1)['nama_aplikasi']; ?></h1>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).scroll(() => {
    $('#headerTitle').css({
        'bottom': -($(this).scrollTop() / 1.85) + "px"
    });
});
</script>
 
<link rel="stylesheet" href="<?= base_url('assets/modules/owlcarousel2/owl.carousel.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/modules/owlcarousel2/owl.theme.default.css') ?>">
<style>
.owl-carousel .nav-button {
    border-radius:50%!important;
    padding: 4px 10px!important;
}
.owl-carousel .owl-prev.disabled,
.owl-carousel .owl-next.disabled {
    pointer-events: none;
    opacity: 0.25;
}
.owl-carousel .owl-prev {
    position: absolute;
    top:65px;
    left:-15px;
}
.owl-carousel .owl-next {
    position: absolute;
    top: 65px;
    right: -15px;
}
.owl-theme .owl-nav [class*=owl-] {
    color: red;
    background: #F4F4F4;
    border-radius: 3px;
    transition:.3s;
}
.owl-theme .owl-nav [class*=owl-]:hover {
    color: #474747;
    background: #a0a6ab;
    border-radius: 3px;
}
</style>
<section class="pt-0">
    <div class="container-fluid bg-primary-subtle" style="background-image:url('<?= base_url('assets/img/bg-activity.png') ?>');background-repeat:no-repeat;padding-top:50px">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12">
                    <a href="<?= base_url('perusahaan/berlangganan') ?>" class="float-end">
                        <b>Lihat Semua Paket</b>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg-3 col-xl-3">
                    <img src="<?= base_url('assets/img/sopir-jempol-oke.png') ?>" alt="sopir-jempol-oke.png" class="w-100">
                </div>
                <div class="col-12 col-lg-9 offset-xl-1 col-xl-8 position-relative">
                    <div class="owl-carousel owl-activities owl-theme wow fadeInUp">
                        <?php
                        $paket_langganan = model('PaketLangganan')->findAll();
                        foreach($paket_langganan as $v) :
                        ?>
                        <div class="card card-paket-langganan d-flex flex-column flex-fill pt-4">
                            <?php if ($v['label']) : ?>
                            <div class="position-absolute text-white" style="right:0; top:0; border-radius: 0 var(--border-radius) 0 50px; background: linear-gradient(180deg, #f60 0%, #ff871d 100%);">
                                <div class="fw-500 wow fadeInUp" style="padding:8px 8px 8px 30px">
                                    <i class="fa-solid fa-chess-queen fa-lg me-1"></i>
                                    <?= $v['label'] ?>
                                </div>
                            </div>
                            <?php endif; ?>
                            <div class="card-body d-flex flex-column">
                                <div class="text-center">
                                    <h4 class="fw-600 text-primary-emphasis mb-4 wow fadeInUp"><?= $v['nama_paket'] ?></h4>
                                    <div class="wow fadeInUp">
                                        <?php if ($v['harga_normal'] > $v['harga_promo']) : ?>
                                        <span class="text-decoration-line-through text-secondary">Rp <?= number_format($v['harga_normal'], 0, ',', '.') ?></span>
                                        <span class="badge bg-danger-subtle text-danger">
                                            <?php
                                            $diskon = (($v['harga_normal'] - $v['harga_promo']) / $v['harga_normal']) * 100; 
                                            echo round($diskon) . '%';
                                            ?>
                                        </span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="d-flex justify-content-center text-primary-emphasis wow fadeInUp">
                                        Rp&nbsp;<h2 class="fw-600 text-primary-emphasis"><?= number_format($v['harga_promo'], 0, ',', '.'); ?></h2>
                                    </div>
                                    <p class="mt-3"><?= $v['deskripsi'] ?></p>
                                    <hr>
                                    <div class="d-flex justify-content-center">
                                        <h2 class="fw-600 mb-0"><?= $v['poin'] ?></h2>&nbsp;Poin
                                    </div>
                                </div>
                                <div class="mt-auto text-center">
                                    <small>*Berlaku hingga 1 tahun</small>
                                    <button class="btn btn-primary w-100 mt-3">Langganan</button>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="<?= base_url('assets/modules/owlcarousel2/owl.carousel.min.js') ?>"></script>
<script>
$(document).ready(function() {
    $('.owl-activities').owlCarousel({
        nav: true,
        navText: [
            '<div class="nav-button owl-prev" style="font-size:16px"> <i class="fa-solid fa-arrow-left"></i> </div>',
            '<div class="nav-button owl-next" style="font-size:16px"> <i class="fa-solid fa-arrow-right"></i> </div>'
        ],
        dots: false,
        stagePadding: 25,
        margin: 25,
        responsive: {
            0: {
                items: 1
            },
            768: {
                items: 2
            },
            992: {
                items: 2
            }
        }
    });
});
</script>

<section class="container position-relative bg-white">
    <div class="row gx-5">
        <div class="col-12 col-lg-6">
            <img src="<?= base_url('assets/img/pengendara-panggil-teknisi.png') ?>" alt="pengendara-panggil-teknisi.png" style="width:90%">
        </div>
        <div class="col-12 col-lg-6 align-content-center">
            <label class="mb-3">SLIP Indonesia</label>
            <h1 class="fw-700 mb-4">Temukan Driver Terbaik untuk Kesuksesan Ekspedisi Anda</h1>
            <p>Kami hadir dengan solusi pencarian driver profesional, membantu Anda meningkatkan kinerja perusahaan ekspedisi dengan layanan yang terpercaya dan berkualitas.</p>
        </div>
    </div>
</section>