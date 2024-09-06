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
                                    <div class="col-md-6 position-relative">
                                        <img src="<?= base_url('assets/uploads/default.png') ?>" class="w-100 img-style <?= validation_show_error('gambar') ? 'border border-danger' : '' ?>" id="frame">
                                        <div class="position-absolute" style="bottom:0px;right:0px">
                                            <button class="btn btn-secondary rounded-circle" style="padding:8px 10px" type="button" onclick="document.getElementById('gambar').click()">
                                                <i class="fa-solid fa-camera fa-lg"></i>
                                            </button>
                                            <input type="file" class="form-control d-none" id="gambar" name="gambar" accept="image/*" onchange="preview()">
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">
                                        <?= cutString(validation_show_error('gambar')) ?>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" class="form-control <?= validation_show_error('nama') ? 'is-invalid' : '' ?>" id="nama" name="nama" value="<?= old('nama') ?>" placeholder="masukkan nama">
                                    <div class="invalid-feedback">
                                        <?= cutString(validation_show_error('nama')) ?>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="harga" class="form-label">Harga</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control <?= validation_show_error('harga') ? 'is-invalid' : '' ?>" id="harga" name="harga" value="<?= old('harga') ?>" placeholder="299000" onkeydown="if(/[.,]/.test(event.key)) event.preventDefault();">
                                    </div>
                                    <div class="invalid-feedback">
                                        <?= cutString(validation_show_error('harga')) ?>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <textarea class="form-control <?= validation_show_error('deskripsi') ? 'is-invalid' : '' ?>" id="deskripsi" name="deskripsi" rows="3" placeholder="masukkan deskripsi"><?= old('deskripsi') ?></textarea>
                                    <div class="invalid-feedback">
                                        <?= cutString(validation_show_error('deskripsi')) ?>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="dokumen_pendukung" class="form-label">Dokumen Pendukung <span class="text-secondary"> (maks. 2 mb, pdf)</span></label>
                                    <input type="file" class="form-control <?= validation_show_error('dokumen_pendukung') ? 'is-invalid' : '' ?>" id="dokumen_pendukung" name="dokumen_pendukung" accept="application/pdf">
                                    <div class="form-text">
                                        Perhatikan Syarat dan Ketentuan!
                                    </div>
                                    <div class="invalid-feedback">
                                        <?= cutString(validation_show_error('dokumen_pendukung')) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-2">
                                    <span class="fw-600">Waktu</span>
                                </div>
                                <div class="mb-3">
                                    <label for="tanggal_kegiatan" class="form-label">Tanggal Kegiatan</label>
                                    <input type="date" class="form-control <?= validation_show_error('tanggal_kegiatan') ? 'is-invalid' : '' ?>" id="tanggal_kegiatan" name="tanggal_kegiatan" value="<?= old('tanggal_kegiatan') ?>">
                                    <div class="invalid-feedback">
                                        <?= cutString(validation_show_error('tanggal_kegiatan')) ?>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <span class="fw-600">pilihan</span>
                                </div>
                                <div class="mb-3">
                                    <label for="select_multiple" class="form-label">Select Multiple</label>
                                    <select class="form-select <?= validation_show_error('select_multiple') ? 'is-invalid' : '' ?>" id="select_multiple" name="select_multiple[]" multiple>
                                        <?php
                                        $multiple = ['Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh'];
                                        $selected = old('select_multiple', []);
                                        foreach ($multiple as $v) :
                                        ?>
                                        <option value="<?= $v ?>" <?= in_array($v, $selected) ? 'selected' : '' ?>>
                                            <?= $v ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?= cutString(validation_show_error('select_multiple')) ?>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="checkbox" class="form-label">Checkbox</label>
                                    <?php
                                    $checkbox = ['checkbox 1', 'checkbox 2', 'checkbox 3'];
                                    $checked = old('checkbox', []);
                                    foreach($checkbox as $v) :
                                    ?>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="<?= $v ?>" name="checkbox[]" value="<?= $v ?>" <?= in_array($v, $checked) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="<?= $v ?>">
                                            <?= $v ?>
                                        </label>
                                    </div>
                                    <?php endforeach; ?>
                                    <div class="invalid-feedback">
                                        <?= cutString(validation_show_error('checkbox')) ?>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="radio" class="form-label">Radio</label>
                                    <?php
                                    $radio = ['radio 1', 'radio 2', 'radio 3'];
                                    $checked = old('radio');
                                    foreach($radio as $v) :
                                    ?>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="<?= $v ?>" name="radio" value="<?= $v ?>" <?= $checked ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="<?= $v ?>">
                                            <?= $v ?>
                                        </label>
                                    </div>
                                    <?php endforeach; ?>
                                    <div class="invalid-feedback">
                                        <?= cutString(validation_show_error('radio')) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3 float-end">Tambahkan</button>
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
