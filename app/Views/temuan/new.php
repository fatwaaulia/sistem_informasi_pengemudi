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
                                    <label for="no_sim" class="form-label">No. SIM</label>
                                    <input type="text" class="form-control <?= validation_show_error('no_sim') ? 'is-invalid' : '' ?>" id="no_sim" name="no_sim" value="<?= old('no_sim') ?>" placeholder="masukkan nomor sim">
                                    <div class="invalid-feedback">
                                        <?= cutString(validation_show_error('no_sim')) ?>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="no_ponsel" class="form-label">No. Ponsel</label>
                                    <input type="number" class="form-control <?= validation_show_error('no_ponsel') ? "is-invalid" : '' ?>" id="no_ponsel" name="no_ponsel" value="<?= old('no_ponsel') ?>" placeholder="6285xxx">
                                    <div class="invalid-feedback">
                                        <?= cutString(validation_show_error('no_ponsel')) ?>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                    <input type="date" class="form-control <?= validation_show_error('tanggal_lahir') ? 'is-invalid' : '' ?>" id="tanggal_lahir" name="tanggal_lahir" value="<?= old('tanggal_lahir') ?>">
                                    <div class="invalid-feedback">
                                        <?= cutString(validation_show_error('tanggal_lahir')) ?>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <textarea class="form-control <?= validation_show_error('alamat') ? 'is-invalid' : '' ?>" id="alamat" name="alamat" rows="3" placeholder="masukkan alamat"><?= old('alamat') ?></textarea>
                                    <div class="invalid-feedback">
                                        <?= cutString(validation_show_error('alamat')) ?>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="catatan_kejadian" class="form-label">Catatan Kejadian</label>
                                    <textarea class="form-control <?= validation_show_error('catatan_kejadian') ? 'is-invalid' : '' ?>" id="catatan_kejadian" name="catatan_kejadian" rows="3" placeholder="masukkan catatan kejadian"><?= old('catatan_kejadian') ?></textarea>
                                    <div class="invalid-feedback">
                                        <?= cutString(validation_show_error('catatan_kejadian')) ?>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="tanggal_kejadian" class="form-label">Tanggal Kejadian</label>
                                    <input type="date" class="form-control <?= validation_show_error('tanggal_kejadian') ? 'is-invalid' : '' ?>" id="tanggal_kejadian" name="tanggal_kejadian" value="<?= old('tanggal_kejadian') ?>">
                                    <div class="invalid-feedback">
                                        <?= cutString(validation_show_error('tanggal_kejadian')) ?>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="foto_sopir" class="form-label">Foto Sopir <span class="text-secondary"> (maks. 10 mb, .png/.jpg/.jpeg)</span></label>
                                    <div class="col-md-6 position-relative">
                                        <img src="<?= base_url('assets/uploads/default.png') ?>" class="w-100 img-style <?= validation_show_error('foto_sopir') ? 'border border-danger' : '' ?>" id="frame">
                                        <div class="position-absolute" style="bottom:0px;right:0px">
                                            <button class="btn btn-secondary rounded-circle" style="padding:8px 10px" type="button" onclick="document.getElementById('foto_sopir').click()">
                                                <i class="fa-solid fa-camera fa-lg"></i>
                                            </button>
                                            <input type="file" class="form-control d-none" id="foto_sopir" name="foto_sopir" accept="image/*" onchange="preview()">
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">
                                        <?= cutString(validation_show_error('foto_sopir')) ?>
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
