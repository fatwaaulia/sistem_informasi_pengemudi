<style>
.header {
    background-image: linear-gradient(rgba(0, 0, 0, .5), rgba(0, 0, 0, .5)), url(<?= base_url('assets/img/sementara.jpg') ?>);
    height:50vh;
}
</style>
<div class="container-fluid header img-style">
    <!--  -->
</div>

<section class="container">
    <div class="row">
        <div class="col-lg-8">
            <div class="mb-4">
                <h2 class="wow fadeInUp"><?= $berita['judul'] ?></h2>
                <?php
                $created_at = dateFormatter($berita['created_at'], 'd MMMM yyyy');
                $penulis = model('Users')->where('id', $berita['id_penulis'])->first()['nama'];
                ?>
                <p class="wow fadeInUp">
                    <i class="fa-solid fa-calendar-days me-1"></i> <?= $created_at ?> | <?= $penulis ?>
                </p>
            </div>
            <img src="<?= base_url('assets/uploads/berita/') . $berita['sampul'] ?>" class="w-100" alt="<?= $berita['judul'] ?>">
            <div class="mt-4">
                <style>
                .konten span {
                    color: unset!important;
                    background: unset!important;
                }
                </style>
                <div class="konten">
                    <?= $berita['konten'] ?>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mt-5 mt-lg-0">
            <div class="row mb-2">
                <div class="col-lg-6">
                    <p class="fw-600 wow fadeInUp" style="border-left:4px solid var(--main-color);">&nbsp; Rekomendasi</p>
                </div>
            </div>
            <?php foreach ($berita_rekomendasi as $v) : ?>
            <div class="card mb-3" style="max-height:150px">
                <div class="row">
                    <div class="col-4">
                        <?php
                        $img = ($v['sampul'])
                            ? base_url('assets/uploads/berita/' . $v['sampul'])
                            : base_url('assets/uploads/default.png');
                        ?>
                        <a href="<?= base_url('berita/') . $v['slug'] ?>">
                            <img src="<?= base_url('assets/img/loading.gif') ?>" data-original="<?= $img ?>" class="w-100 img-style lazy" style="height:115.5px;border-radius:var(--border-radius) 0 0 var(--border-radius)" loading="lazy">
                        </a>
                    </div>
                    <div class="col-8 ps-1 py-3 pe-4">
                        <h6 class="text-one-line wow fadeInUp">
                            <a href="<?= base_url('berita/') . $v['slug'] ?>" class="text-dark"><?= $v['judul'] ?></a>
                        </h6>
                        <p class="wow fadeInUp">
                            <i class="fa-solid fa-calendar-days me-1"></i> <?= dateFormatter($v['created_at'], 'd MMMM yyyy'); ?>
                        </p>
                        <span class="text-one-line konten wow fadeInUp"><?= strip_tags($v['konten']) ?></span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<script src="http://webmap2.map.bdimg.com/yyfm/jQuery_1.x/1.10.2/js/jQuery_1.x.min.js"></script>
<script src="<?= base_url() ?>assets/js/lazyload.js"></script>
<script>
$('img.lazy').lazyload({
    threshold: 1000
});
</script>