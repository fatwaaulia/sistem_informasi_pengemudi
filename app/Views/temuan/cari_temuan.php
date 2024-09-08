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
                <form action="" method="get">
                    <div class="mb-3">
                        <label for="nik" class="form-label">NIK</label>
                        <input type="number" class="form-control <?= validation_show_error('nik') ? 'is-invalid' : '' ?>" id="nik" name="nik" value="<?= $nik ?>" placeholder="masukkan nik" required>
                        <div class="invalid-feedback">
                            <?= cutString(validation_show_error('nik')) ?>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3 float-end">Cek Temuan</button>
                </form>
                <?php if ($nik) : ?>
                <hr class="mt-4">
                <div class="mb-2">
                    <span class="fw-600">Hasil Pencarian</span>
                </div>
                <h3 class="mb-4"><?= $nik ?></h3>
                <div class="mb-2">
                    Status : <span class="<?= ($status == 'NIK ditemukan') ? 'text-success' : 'text-danger' ?>"><?= $status ?></span>
                </div>
                <?php if ($data) : ?>
                <div class="mb-2">
                    Nama : <?= $data['nama'] ?>
                </div>
                <div class="mb-2 text-justify">
                    Rincian : <?= $data['rincian'] ?>
                </div>
                <div class="mb-2">
                    Tanggal : <?= date('d-m-Y', strtotime($data['tanggal'])) ?>
                </div>
                <div class="mb-2">
                    Bukti :
                    <img src="<?= base_url('assets/uploads/temuan/') . $data['bukti'] ?>" class="w-100 img-style mt-2">
                </div>
                <?php endif; endif; ?>
            </div>
        </div>
    </div>
</div>
</section>
