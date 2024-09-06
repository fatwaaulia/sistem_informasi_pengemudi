<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form action="<?= $base_route . '/update/' . encode($data['id']) ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field(); ?>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="nama_aplikasi" class="form-label">Nama Aplikasi</label>
                                <input type="text" class="form-control <?= validation_show_error('nama_aplikasi') ? 'is-invalid' : '' ?>" id="nama_aplikasi" name="nama_aplikasi" value="<?= old('nama_aplikasi') ?? $data['nama_aplikasi'] ?>" placeholder="Masukkan nama aplikasi">
                                <div class="invalid-feedback">
                                    <?= validation_show_error('nama_aplikasi') ?>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="nama_perusahaan" class="form-label">Nama Perusahaan</label>
                                <input type="text" class="form-control <?= validation_show_error('nama_perusahaan') ? 'is-invalid' : '' ?>" id="nama_perusahaan" name="nama_perusahaan" value="<?= old('nama_perusahaan') ?? $data['nama_perusahaan'] ?>" placeholder="PT / Organisasi dsb.">
                                <div class="invalid-feedback">
                                    <?= validation_show_error('nama_perusahaan') ?>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control <?= validation_show_error('deskripsi') ? 'is-invalid' : '' ?>" id="deskripsi" name="deskripsi" rows="3" placeholder="Masukkan deskripsi"><?= old('deskripsi') ?? $data['deskripsi'] ?></textarea>
                                <div class="invalid-feedback">
                                    <?= validation_show_error('deskripsi') ?>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="no_hp" class="form-label">No. HP</label>
                                <div class="input-group">
                                    <span class="input-group-text">+62</span>
                                    <input type="number" class="form-control <?= validation_show_error('no_hp') ? 'is-invalid' : '' ?>" id="no_hp" name="no_hp" value="<?= old('no_hp') ?? $data['no_hp'] ?>" placeholder="8xx">
                                </div>
                                <div class="form-text">
                                    wajib terdaftar di whatsapp!
                                </div>
                                <div class="invalid-feedback">
                                    <?= validation_show_error('no_hp') ?>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea class="form-control <?= validation_show_error('alamat') ? 'is-invalid' : '' ?>" id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat"><?= old('alamat') ?? $data['alamat'] ?></textarea>
                                <div class="invalid-feedback">
                                    <?= validation_show_error('alamat') ?>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="maps" class="form-label">Maps</label>
                                <input type="text" class="form-control <?= validation_show_error('maps') ? 'is-invalid' : '' ?>" id="maps" name="maps" value="<?= old('maps') ?? $data['maps'] ?>" placeholder="https://www.google.com/maps/embed..">
                                <div class="invalid-feedback">
                                    <?= validation_show_error('maps') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="logo" class="form-label">Logo</label>
                                    <div class="position-relative">
                                        <?php
                                        if ($data['logo']) {
                                            $logo = base_url($upload_path . $data['logo']);
                                        } else {
                                            $logo = base_url('assets/uploads/default.png');
                                        }
                                        ?>
                                        <img src="<?= $logo ?>" class="w-100 h-100 img-style <?= validation_show_error('logo') ? 'border border-danger' : '' ?>" id="frame">
                                        <div class="position-absolute" style="bottom:0px;right:0px">
                                            <button class="btn btn-secondary rounded-circle" style="padding:8px 10px" type="button" onclick="document.getElementById('logo').click()">
                                                <i class="fa-solid fa-camera fa-lg"></i>
                                            </button>
                                            <input type="file" class="form-control d-none" id="logo" name="logo" accept="image/*" onchange="preview()">
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">
                                        <?= str_replace('logo,', '', validation_show_error('logo')) ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="favicon" class="form-label">Favicon</label>
                                    <div class="position-relative">
                                        <?php
                                        if ($data['favicon']) {
                                            $favicon = base_url($upload_path . $data['favicon']);
                                        } else {
                                            $favicon = base_url('assets/uploads/default.png');
                                        }
                                        ?>
                                        <img src="<?= $favicon ?>" class="w-100 img-style <?= validation_show_error('favicon') ? 'border border-danger' : '' ?>" id="frame2">
                                        <div class="position-absolute" style="bottom:0px;right:0px">
                                            <button class="btn btn-secondary rounded-circle" style="padding:8px 10px" type="button" onclick="document.getElementById('favicon').click()">
                                                <i class="fa-solid fa-camera fa-lg"></i>
                                            </button>
                                            <input type="file" class="form-control d-none" id="favicon" name="favicon" accept="image/*" onchange="preview2()">
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">
                                        <?= str_replace('favicon,', '', validation_show_error('favicon')) ?>
                                    </div>
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
