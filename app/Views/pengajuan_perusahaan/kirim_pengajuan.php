<section>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h5 class="my-4"><?= isset($title) ? $title : '' ?></h5>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <?php
            $pengajuan = false;
            $alert = '';
            $text_alert = '';
            $action = '#';

            if ($data['status_pengajuan_perusahaan'] == 'Menunggu Verifikasi') {
                $pengajuan = true;
                $action = $base_route . '/update';
                $alert = 'alert-warning';
                $btn_alert = 'btn-warning';
            } elseif ($data['status_pengajuan_perusahaan'] == 'Aktif') {
                $pengajuan = true;
                $action = '#';
                $alert = 'alert-success';
                $btn_alert = 'btn-success';
            } elseif ($data['status_pengajuan_perusahaan'] == 'Ditolak') {
                $action = $base_route . '/update';
                $alert = 'alert-danger';
                $btn_alert = 'btn-danger';
            }

            if ($data['status_pengajuan_perusahaan'] != 'Pending') :
            ?>
            <div class="alert <?= $alert ?>" role="alert">
                Status : <b><?= $data['status_pengajuan_perusahaan'] ?></b> <br>
                Tgl. Pengajuan : <?= date('d-m-Y H:i:s', strtotime($data['submission_at'])) ?> <br>
                Tgl. Diterima : <?= $data['checked_at'] ? date('d-m-Y H:i:s', strtotime($data['checked_at'])) : '-' ?>
                
                <div class="mt-2">
                    <a href="https://wa.me/6285526250131" class="btn <?= $btn_alert ?>" target="_blank">
                        <i class="fa-solid fa-phone me-1 mt-2"></i>
                        Hubungi Admin
                    </a>
                </div>
            </div>
            <?php endif; ?>
            <div class="card">
                <div class="card-body">
                    <form action="<?= $base_route . '/update' ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <div class="mb-2">
                            <span class="fw-600">DATA PERUSAHAAN</span>
                        </div>
                        <div class="mb-3">
                            <label for="nama_perusahaan" class="form-label">Nama Perusahaan</label>
                            <input type="text" class="form-control <?= validation_show_error('nama_perusahaan') ? 'is-invalid' : '' ?>" id="nama_perusahaan" name="nama_perusahaan" value="<?= old('nama_perusahaan') ?? $data['nama_perusahaan'] ?>" placeholder="masukkan nama perusahaan" <?= $pengajuan ? 'disabled' : '' ?> >
                            <div class="invalid-feedback">
                                <?= cutString(validation_show_error('nama_perusahaan')) ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="alamat_perusahaan" class="form-label">Alamat Perusahaan</label>
                            <textarea class="form-control <?= validation_show_error('alamat_perusahaan') ? 'is-invalid' : '' ?>" id="alamat_perusahaan" name="alamat_perusahaan" rows="3" placeholder="masukkan alamat perusahaan" <?= $pengajuan ? 'disabled' : '' ?>><?= old('alamat_perusahaan') ?? $data['alamat_perusahaan'] ?></textarea>
                            <div class="invalid-feedback">
                                <?= cutString(validation_show_error('alamat_perusahaan')) ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="negara_perusahaan" class="form-label">Negara Perusahaan</label>
                            <input type="text" class="form-control <?= validation_show_error('negara_perusahaan') ? "is-invalid" : '' ?>" id="negara_perusahaan" name="negara_perusahaan" value="<?= old('negara_perusahaan') ?? $data['negara_perusahaan'] ?>" placeholder="masukkan negara perusahaan" <?= $pengajuan ? 'disabled' : '' ?>>
                            <div class="invalid-feedback">
                                <?= cutString(validation_show_error('negara_perusahaan')) ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="kota_perusahaan" class="form-label">Kota Perusahaan</label>
                            <input type="text" class="form-control <?= validation_show_error('kota_perusahaan') ? "is-invalid" : '' ?>" id="kota_perusahaan" name="kota_perusahaan" value="<?= old('kota_perusahaan') ?? $data['kota_perusahaan'] ?>" placeholder="masukkan kota perusahaan" <?= $pengajuan ? 'disabled' : '' ?>>
                            <div class="invalid-feedback">
                                <?= cutString(validation_show_error('kota_perusahaan')) ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="kode_pos_perusahaan" class="form-label">Kode Pos Perusahaan</label>
                            <input type="text" class="form-control <?= validation_show_error('kode_pos_perusahaan') ? "is-invalid" : '' ?>" id="kode_pos_perusahaan" name="kode_pos_perusahaan" value="<?= old('kode_pos_perusahaan') ?? $data['kode_pos_perusahaan'] ?>" placeholder="masukkan kode pos perusahaan" <?= $pengajuan ? 'disabled' : '' ?>>
                            <div class="invalid-feedback">
                                <?= cutString(validation_show_error('kode_pos_perusahaan')) ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="no_telepon_perusahaan" class="form-label">No. Telepon Perusahaan</label>
                            <input type="number" class="form-control <?= validation_show_error('no_telepon_perusahaan') ? "is-invalid" : '' ?>" id="no_telepon_perusahaan" name="no_telepon_perusahaan" value="<?= old('no_telepon_perusahaan') ?? $data['no_telepon_perusahaan'] ?>" placeholder="6285xxx" <?= $pengajuan ? 'disabled' : '' ?>>
                            <div class="invalid-feedback">
                                <?= cutString(validation_show_error('no_telepon_perusahaan')) ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="email_perusahaan" class="form-label">Email Perusahaan</label>
                            <input type="email" class="form-control <?= validation_show_error('email_perusahaan') ? "is-invalid" : '' ?>" id="email_perusahaan" name="email_perusahaan" value="<?= old('email_perusahaan') ?? $data['email_perusahaan'] ?>" placeholder="name@perusahaan.com" <?= $pengajuan ? 'disabled' : '' ?>>
                            <div class="invalid-feedback">
                                <?= cutString(validation_show_error('email_perusahaan')) ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="no_nib_perusahaan" class="form-label">No. NIB Perusahaan</label>
                            <input type="text" class="form-control <?= validation_show_error('no_nib_perusahaan') ? "is-invalid" : '' ?>" id="no_nib_perusahaan" name="no_nib_perusahaan" value="<?= old('no_nib_perusahaan') ?? $data['no_nib_perusahaan'] ?>" placeholder="masukkan nomor nib perusahaan" <?= $pengajuan ? 'disabled' : '' ?>>
                            <div class="invalid-feedback">
                                <?= cutString(validation_show_error('no_nib_perusahaan')) ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="dokumen_akta_perusahaan" class="form-label">Dokumen Akta Perusahaan <span class="text-secondary"> (maks. 10 mb, pdf)</span></label>
                            <input type="file" class="form-control <?= validation_show_error('dokumen_akta_perusahaan') ? 'is-invalid' : '' ?>" id="dokumen_akta_perusahaan" name="dokumen_akta_perusahaan" accept="application/pdf" <?= $pengajuan ? 'disabled' : '' ?>>
                            <div class="invalid-feedback">
                                <?= cutString(validation_show_error('dokumen_akta_perusahaan')) ?>
                            </div>
                            <?php if ($data['dokumen_akta_perusahaan']) : ?>
                            <a href="<?= base_url('assets/uploads/users/dokumen_akta_perusahaan/') . $data['dokumen_akta_perusahaan'] ?>">Lihat Dokumen</a>
                            <?php endif; ?>
                        </div>
                        <div class="mb-2">
                            <span class="fw-600">DATA PIC</span>
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama PIC</label>
                            <input type="text" class="form-control <?= validation_show_error('nama') ? 'is-invalid' : '' ?>" id="nama" name="nama" value="<?= old('nama') ?? $data['nama'] ?>" placeholder="masukkan nama pic" <?= $pengajuan ? 'disabled' : '' ?>>
                            <div class="invalid-feedback">
                                <?= cutString(validation_show_error('nama')) ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select class="form-select <?= validation_show_error('jenis_kelamin') ? 'is-invalid' : '' ?>" id="jenis_kelamin" name="jenis_kelamin" <?= $pengajuan ? 'disabled' : '' ?>>
                                <?php
                                $jenis_kelamin = ['Laki-laki', 'Perempuan'];
                                $selected = old('jenis_kelamin', $data['jenis_kelamin']);
                                foreach ($jenis_kelamin as $v) :
                                ?>
                                <option value="<?= $v ?>" <?= $selected == $v ? 'selected' : '' ?>>
                                    <?= $v ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
                                <?= cutString(validation_show_error('jenis_kelamin')) ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="no_ponsel" class="form-label">No. Ponsel PIC</label>
                            <input type="number" class="form-control <?= validation_show_error('no_ponsel') ? "is-invalid" : '' ?>" id="no_ponsel" name="no_ponsel" value="<?= old('no_ponsel') ?? $data['no_ponsel'] ?>" placeholder="6285xxx" <?= $pengajuan ? 'disabled' : '' ?>>
                            <div class="invalid-feedback">
                                <?= cutString(validation_show_error('no_ponsel')) ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" value="<?= $data['email'] ?>" disabled>
                            <div class="invalid-feedback">
                                <?= cutString(validation_show_error('email')) ?>
                            </div>
                        </div>
                        <?php if (!$pengajuan) : ?>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="memastikanDataBenar" required>
                                <label class="form-check-label" for="memastikanDataBenar">
                                    Saya memastikan data perusahaan diatas sudah benar.
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3 float-end">Ajukan <?= $data['status_pengajuan_perusahaan'] == 'Ditolak' ? 'Ulang' : 'Perusahaan'; ?></button>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
