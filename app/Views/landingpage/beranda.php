<style>
.header {
    min-height: 90vh;
    background-image: linear-gradient(25deg, #17153B 50%, #2E236C 90%, #433D8B 110%);
    border-radius: 0 0 0 150px;
    padding-top: 180px;
    padding-left: 50px;
    padding-right: 50px;
}

h1 {
    line-height: 130%;
}
h5 {
    line-height: 150%;
}
.owl-stage-outer { 
overflow: visible;
}

 .owl-item {
   opacity: 0;
   transition: opacity 500ms;
}
.owl-item.active {
  opacity: 1;
}
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 mt-3">
            <div class="owl-carousel owl-header owl-theme">
                <?php
                $data_slider = [
                    [
                        'judul' => 'Sistem Terintegrasi Data Pelanggaran Pengemudi',
                        'deskripsi' => 'Temukan informasi pelanggaran pengemudi dari seluruh Indonesia untuk membantu Anda memilih pengemudi terbaik bagi perusahaan Anda.',
                        'gambar' => '1.png',
                    ],
                    [
                        'judul' => 'Ajukan Data Pelanggaran Pengemudi',
                        'deskripsi' => 'Anda juga dapat berkontribusi dengan menambahkan data pelanggaran pengemudi, yang akan tersedia bagi seluruh perusahaan ekspedisi terdaftar di Indonesia.',
                        'gambar' => '2.png',
                    ],
                    [
                        'judul' => 'Akses 24/7, Kapanpun & Dimanapun',
                        'deskripsi' => 'Nikmati kemudahan layanan kami yang dapat diakses kapan saja dan di mana saja, selama 24 jam setiap hari.',
                        'gambar' => '3.png',
                    ],
                ];
                foreach($data_slider as $v) :
                ?>
                <div class="header">
                    <div class="row">
                        <div class="col-12 col-lg-5">
                            <h1 class="text-danger fw-600"><?= $v['judul'] ?></h1>
                            <h5 class="text-white mt-3"><?= $v['deskripsi'] ?></h5>
                        </div>
                        <div class="col-12 col-lg-6 position-relative" style="min-height:70vh">
                            <img src="<?= base_url('assets/img/slider/'. $v['gambar']) ?>" class="position-absolute" style="bottom:0; right:0px; width:80%;">
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
 
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
    top:70px;
    left:-15px;
}
.owl-carousel .owl-next {
    position: absolute;
    top: 70px;
    right: -15px;
}

.card-paket-langganan {
    transition: .3s;
}
.card-paket-langganan:hover {
    color: #052c65!important;
    background-color: #cfe2ff;
}
.card-paket-langganan:hover p,
.card-paket-langganan:hover h2,
.card-paket-langganan:hover h4,
.card-paket-langganan:hover div {
    color: #052c65!important;
}
</style>
<section class="container-fluid bg-secondary-subtle py-5">
    <div class="container">
        <div class="row">
            <div class="offset-1 col-9 offset-lg-0 col-lg-3 offset-xl-0 col-xl-3">
                <img src="<?= base_url('assets/img/sopir-jempol-oke.png') ?>" alt="sopir-jempol-oke.png" class="w-100 mb-4 mb-md-0">
                <h5>SLIP Indonesia</h5>
                <h3>Satu Layanan, Beragam Manfaat!</h3>
            </div>
            <div class="col-12 col-lg-9 offset-xl-1 col-xl-8">
                <div class="text-end mb-3">
                <a href="<?= base_url('perusahaan/berlangganan') ?>"  style="margin-right: 30px">
                    <b>Lihat Semua Paket</b>
                </a>
                </div>
                <div class="owl-carousel owl-paket-layanan owl-theme">
                    <?php
                    $paket_langganan = model('PaketLangganan')->findAll();
                    foreach($paket_langganan as $v) :
                    ?>
                    <div class="card card-paket-langganan pt-4" style="min-height:380px">
                        <?php if ($v['label']) : ?>
                        <div class="position-absolute text-white" style="right:0; top:0; border-radius: 0 var(--border-radius) 0 50px; background: linear-gradient(180deg, #f60 0%, #ff871d 100%);">
                            <div class="fw-500 wow fadeInUp" style="padding:8px 8px 8px 30px">
                                <i class="fa-solid fa-chess-queen fa-lg me-1"></i>
                                <?= $v['label'] ?>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="card-body">
                            <div class="text-center">
                                <h4 class="fw-600 text-primary-emphasis mb-4 wow fadeInUp"><?= $v['nama_paket'] ?></h4>
                                <div class="wow fadeInUp">
                                    <?php
                                    $diskon = 0;
                                    $hidden_diskon = 'visibility:hidden';
                                    if ($v['harga_normal'] > $v['harga_promo']) {
                                        $diskon = (($v['harga_normal'] - $v['harga_promo']) / $v['harga_normal']) * 100;
                                        $hidden_diskon = '';
                                    }
                                    ?>
                                    <div style="<?= $hidden_diskon ?>">
                                        <span class="text-decoration-line-through text-secondary">Rp <?= number_format($v['harga_normal'], 0, ',', '.') ?></span>
                                        <span class="badge bg-danger-subtle text-danger">
                                            <?= round($diskon) . '%'; ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center text-primary-emphasis wow fadeInUp">
                                    Rp&nbsp;<h2 class="fw-600 text-primary-emphasis"><?= number_format($v['harga_promo'], 0, ',', '.'); ?></h2>
                                </div>
                                <p class="mt-3 wow fadeInUp"><?= $v['deskripsi'] ?></p>
                                <hr>
                                <div class="d-flex justify-content-center wow fadeInUp">
                                    <h2 class="fw-600 mb-0"><?= $v['poin'] ?></h2>&nbsp;Poin
                                </div>
                            </div>
                            <div class="text-center">
                                <small class="wow fadeInUp">*Berlaku hingga 1 tahun</small>
                                <a href="<?= base_url() . 'perusahaan/berlangganan' ?>" class="btn btn-primary w-100 mt-3">Langganan</a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

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

<link rel="stylesheet" href="<?= base_url('assets/modules/owlcarousel2/owl.carousel.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/modules/owlcarousel2/owl.theme.default.css') ?>">
<script src="<?= base_url('assets/modules/owlcarousel2/owl.carousel.min.js') ?>"></script>
<script>
$(document).ready(function() {
    $('.owl-paket-layanan').owlCarousel({
        nav: true,
        navText: [
            '<div class="nav-button owl-prev text-danger" style="font-size:16px"> <i class="fa-solid fa-arrow-left"></i> </div>',
            '<div class="nav-button owl-next text-danger" style="font-size:16px"> <i class="fa-solid fa-arrow-right"></i> </div>'
        ],
        dots: false,
        stagePadding: 25,
        margin: 25,
        autoHeight: true,
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
    $('.owl-header').owlCarousel({
        autoplay:true,
        loop:true,
        autoplayTimeout:7000,
        nav: true,
        dots: false,
        stagePadding: 25,
        margin: 25,
        responsive: {
            0: {
                items: 1
            },
            768: {
                items: 1
            },
            992: {
                items: 1
            }
        }
    });
});
</script>