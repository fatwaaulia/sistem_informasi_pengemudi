<section>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h5 class="my-4"><?= isset($title) ? $title : '' ?></h5>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="card p-3 position-relative">
                <form action="<?= $base_route . '/proses' ?>" method="post">
                    <?= csrf_field(); ?>
                    <div class="mb-3">
                        <label for="nik" class="form-label">NIK</label>
                        <input type="number" class="form-control <?= validation_show_error('nik') ? 'is-invalid' : '' ?>" id="nik" name="nik" value="<?= $_GET['nik'] ?? '' ?>" placeholder="masukkan nik">
                        <div class="invalid-feedback">
                            <?= cutString(validation_show_error('nik')) ?>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3 float-end">Cek Temuan</button>
                </form>
                <?php if ($_GET['nik'] ?? '') : ?>
                <hr class="mt-4">
                <div class="mb-2">
                    <span class="fw-600">Hasil Pencarian</span>
                </div>
                <h3 class="mb-4"><?= $_GET['nik'] ?? '-' ?></h3>
                <div class="mb-2">
                    Status : <span class="<?= ($status == 'NIK ditemukan') ? 'text-success' : 'text-danger' ?>"><?= $status ?></span>
                </div>
                <div class="mb-2">
                    Nama : <?= $data['nama'] ?? '-' ?>
                </div>
                <div class="mb-2 text-justify">
                    Rincian : <?= $data['rincian'] ?? '-' ?>
                </div>
                <div class="mb-2">
                    Tanggal : <?= ($status == 'NIK ditemukan') ? date('d-m-Y H:i:s', strtotime($data['tanggal'])) : '-' ?>
                </div>
                <div class="mb-2">
                    Bukti :
                    <?php if ($status == 'NIK ditemukan') : ?>
                    <img src="<?= base_url('assets/uploads/temuan/') . $data['bukti'] ?>" class="w-100 img-style mt-2">
                    <?php else : echo '-'; endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
</section>
