<section>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h5 class="my-4"><?= isset($title) ? $title : '' ?></h5>
        </div>
    </div>
    <style>
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
    <div class="row mb-5">
        <?php foreach ($paket_langganan as $key => $v) : ?>
            <div class="col-12 col-md-6 col-lg-6 col-xl-4 d-flex">
            <div class="card card-paket-langganan d-flex flex-column flex-fill">
                <?php if ($v['label']) : ?>
                <div class="position-absolute text-white" style="right:0; border-radius: 0 var(--border-radius) 0 50px; background: linear-gradient(180deg, #f60 0%, #ff871d 100%);">
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
                        <button class="btn btn-primary w-100 mt-3" data-bs-toggle="modal" data-bs-target="#berlangganan<?= $key+1 ?>">Langganan</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="berlangganan<?= $key+1 ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Tinjau Langganan Anda</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table w-100">
                            <thead>
                                <tr>
                                    <th class="text-primary-emphasis">Paket Langganan</th>
                                    <th class="text-primary-emphasis">Biaya</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <h5><?= $v['nama_paket'] ?></h5>
                                        <?= $v['poin'] ?> Poin <br>
                                        <span class="text-secondary">
                                            <?= $v['deskripsi'] ?>
                                        </span>
                                        <br>
                                        <small>*Berlaku hingga 1 tahun</small>
                                    </td>
                                    <td>
                                        <?php if ($v['harga_normal'] > $v['harga_promo']) : ?>
                                        <small class="text-decoration-line-through text-secondary">
                                            Rp <?= number_format($v['harga_normal'], 0, ',', '.') ?>
                                        </small> <br>
                                        <?php endif; ?>
                                        Rp <?= number_format($v['harga_promo'], 0, ',', '.') ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-end">Total</td>
                                    <td>
                                        <h5 class="fw-600">Rp <?= number_format($v['harga_promo'], 0, ',', '.') ?></h5>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <form action="<?= base_url('perusahaan/transaksi-langganan/create') ?>" method="post">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="id_paket" value="<?= $v['id'] ?>">
                            <button type="submit" class="btn btn-primary">Berlangganan Sekarang</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<section>
