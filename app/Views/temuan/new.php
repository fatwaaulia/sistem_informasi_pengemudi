<section>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h5 class="my-4"><?= isset($title) ? $title : '' ?></h5>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="<?= $base_route . '/create' ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="nik" class="form-label">NIK</label>
                                    <input type="number" class="form-control <?= validation_show_error('nik') ? 'is-invalid' : '' ?>" id="nik" name="nik" value="<?= old('nik') ?>" placeholder="masukkan nik">
                                    <div class="invalid-feedback">
                                        <?= cutString(validation_show_error('nik')) ?>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control <?= validation_show_error('nama') ? 'is-invalid' : '' ?>" id="nama" name="nama" value="<?= old('nama') ?>" placeholder="masukkan nama lengkap">
                                    <div class="invalid-feedback">
                                        <?= cutString(validation_show_error('nama')) ?>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="rincian" class="form-label">Rincian</label>
                                    <textarea class="form-control <?= validation_show_error('rincian') ? 'is-invalid' : '' ?>" id="rincian" name="rincian" rows="3" placeholder="masukkan rincian"><?= old('rincian') ?></textarea>
                                    <div class="invalid-feedback">
                                        <?= cutString(validation_show_error('rincian')) ?>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="tanggal" class="form-label">Tanggal Temuan</label>
                                    <input type="date" class="form-control <?= validation_show_error('tanggal') ? 'is-invalid' : '' ?>" id="tanggal" name="tanggal" value="<?= old('tanggal') ?>">
                                    <div class="invalid-feedback">
                                        <?= cutString(validation_show_error('tanggal')) ?>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="bukti" class="form-label">Bukti</label>
                                    <div class="col-md-6 position-relative">
                                        <img src="<?= base_url('assets/uploads/default.png') ?>" class="w-100 img-style <?= validation_show_error('bukti') ? 'border border-danger' : '' ?>" id="frame">
                                        <div class="position-absolute" style="bottom:0px;right:0px">
                                            <button class="btn btn-secondary rounded-circle" style="padding:8px 10px" type="button" onclick="document.getElementById('bukti').click()">
                                                <i class="fa-solid fa-camera fa-lg"></i>
                                            </button>
                                            <input type="file" class="form-control d-none" id="bukti" name="bukti" accept="image/*" onchange="preview()">
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">
                                        <?= cutString(validation_show_error('bukti')) ?>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-3 float-end">Tambahkan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</section>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$('#select_multiple').select2({
    placeholder: 'pilih',
});
</script>
