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
                    <form action="<?= $base_route . '/update/' . encode($data['id']) ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="nama_paket" class="form-label">Nama Paket</label>
                                    <input type="text" class="form-control <?= validation_show_error('nama_paket') ? 'is-invalid' : '' ?>" id="nama_paket" name="nama_paket" value="<?= old('nama_paket') ?? $data['nama_paket'] ?>" placeholder="masukkan nama paket">
                                    <div class="invalid-feedback">
                                        <?= cutString(validation_show_error('nama_paket')) ?>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="harga_normal" class="form-label">Harga Normal</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control <?= validation_show_error('harga_normal') ? 'is-invalid' : '' ?>" id="harga_normal" name="harga_normal" value="<?= old('harga_normal') ?? $data['harga_normal'] ?>" placeholder="299000" onkeydown="if(/[.,]/.test(event.key)) event.preventDefault();">
                                    </div>
                                    <div class="invalid-feedback">
                                        <?= cutString(validation_show_error('harga_normal')) ?>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="harga_promo" class="form-label">Harga Promo</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control <?= validation_show_error('harga_promo') ? 'is-invalid' : '' ?>" id="harga_promo" name="harga_promo" value="<?= old('harga_promo') ?? $data['harga_promo'] ?>" placeholder="249000" onkeydown="if(/[.,]/.test(event.key)) event.preventDefault();">
                                    </div>
                                    <div class="invalid-feedback">
                                        <?= cutString(validation_show_error('harga_promo')) ?>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="label" class="form-label">Label</label>
                                    <input type="text" class="form-control <?= validation_show_error('label') ? 'is-invalid' : '' ?>" id="label" name="label" value="<?= old('label') ?? $data['label'] ?>" placeholder="masukkan label">
                                    <div class="invalid-feedback">
                                        <?= cutString(validation_show_error('label')) ?>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <textarea class="form-control <?= validation_show_error('deskripsi') ? 'is-invalid' : '' ?>" id="deskripsi" name="deskripsi" rows="3" placeholder="masukkan deskripsi"><?= old('deskripsi') ?? $data['deskripsi'] ?></textarea>
                                    <div class="invalid-feedback">
                                        <?= cutString(validation_show_error('deskripsi')) ?>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="poin" class="form-label">Poin</label>
                                    <input type="number" class="form-control <?= validation_show_error('poin') ? 'is-invalid' : '' ?>" id="poin" name="poin" value="<?= old('poin') ?? $data['poin'] ?>" placeholder="masukkan poin">
                                    <div class="invalid-feedback">
                                        <?= cutString(validation_show_error('poin')) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3 float-end">Simpan Perubahan</button>
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
