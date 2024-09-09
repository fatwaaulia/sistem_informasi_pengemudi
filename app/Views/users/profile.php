<section>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h5 class="my-4"><?= isset($title) ? $title : '' ?></h5>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <?php
            if ($data['status_pengajuan_perusahaan'] != 'Pending') :
                $pengajuan = true;
                $alert = '';
                if ($data['status_pengajuan_perusahaan'] == 'Menunggu Verifikasi') {
                    $alert = 'alert-primary';
                } elseif ($data['status_pengajuan_perusahaan'] == 'Aktif') {
                    $alert = 'alert-success';
                } elseif ($data['status_pengajuan_perusahaan'] == 'Ditolak') {
                    $alert = 'alert-danger';
                }
            ?>
            <div class="alert <?= $alert ?>" role="alert">
                Status : <b><?= $data['status_pengajuan_perusahaan'] ?></b> <br>
                Tgl. Pengajuan : <?= date('d-m-Y H:i:s', strtotime($data['submission_at'])) ?> <br>
                Tgl. Diterima : <?= $data['checked_at'] ? date('d-m-Y H:i:s', strtotime($data['checked_at'])) : '-' ?> <br>
                <?php if ($data['status_pengajuan_perusahaan'] == 'Menunggu Verifikasi') : ?>
                <a href="https://wa.me/6285526250131" target="_blank">
                    <i class="fa-solid fa-phone me-1 mt-2"></i>
                    Hubungi Admin
                </a>
                <?php endif; ?>
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
                            <input type="text" class="form-control <?= validation_show_error('nama_perusahaan') ? 'is-invalid' : '' ?>" id="nama_perusahaan" name="nama_perusahaan" value="<?= old('nama_perusahaan') ?? $data['nama_perusahaan'] ?>" placeholder="masukkan nama perusahaan">
                            <div class="invalid-feedback">
                                <?= cutString(validation_show_error('nama_perusahaan')) ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="alamat_perusahaan" class="form-label">Alamat Perusahaan</label>
                            <textarea class="form-control <?= validation_show_error('alamat_perusahaan') ? 'is-invalid' : '' ?>" id="alamat_perusahaan" name="alamat_perusahaan" rows="3" placeholder="masukkan alamat perusahaan"><?= old('alamat_perusahaan') ?? $data['alamat_perusahaan'] ?></textarea>
                            <div class="invalid-feedback">
                                <?= cutString(validation_show_error('alamat_perusahaan')) ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="no_telepon_perusahaan" class="form-label">No. Telepon Perusahaan</label>
                            <input type="number" class="form-control <?= validation_show_error('no_telepon_perusahaan') ? "is-invalid" : '' ?>" id="no_telepon_perusahaan" name="no_telepon_perusahaan" value="<?= old('no_telepon_perusahaan') ?? $data['no_telepon_perusahaan'] ?>" placeholder="08xx">
                            <div class="invalid-feedback">
                                <?= cutString(validation_show_error('no_telepon_perusahaan')) ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="email_perusahaan" class="form-label">Email Perusahaan</label>
                            <input type="email" class="form-control <?= validation_show_error('email_perusahaan') ? "is-invalid" : '' ?>" id="email_perusahaan" name="email_perusahaan" value="<?= old('email_perusahaan') ?? $data['email_perusahaan'] ?>" placeholder="name@perusahaan.com">
                            <div class="invalid-feedback">
                                <?= cutString(validation_show_error('email_perusahaan')) ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No. Akta Perusahaan</label>
                            <input type="text" class="form-control" value="<?= $data['no_akta_perusahaan'] ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="dokumen_akta_perusahaan" class="form-label">Dokumen Akta Perusahaan <span class="text-secondary"> (maks. 10 mb, pdf)</span></label>
                            <?php if ($data['dokumen_akta_perusahaan']) : ?>
                            <br> <a href="<?= base_url('assets/uploads/users/dokumen_akta_perusahaan/') . $data['dokumen_akta_perusahaan'] ?>">Lihat Dokumen</a>
                            <?php endif; ?>
                        </div>
                        <div class="mb-2">
                            <span class="fw-600">DATA PIC</span>
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama PIC</label>
                            <input type="text" class="form-control <?= validation_show_error('nama') ? 'is-invalid' : '' ?>" id="nama" name="nama" value="<?= old('nama') ?? $data['nama'] ?>" placeholder="masukkan nama pic">
                            <div class="invalid-feedback">
                                <?= cutString(validation_show_error('nama')) ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select class="form-select <?= validation_show_error('jenis_kelamin') ? 'is-invalid' : '' ?>" id="jenis_kelamin" name="jenis_kelamin">
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
                            <input type="number" class="form-control <?= validation_show_error('no_ponsel') ? "is-invalid" : '' ?>" id="no_ponsel" name="no_ponsel" value="<?= old('no_ponsel') ?? $data['no_ponsel'] ?>" placeholder="08xx">
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
                        <button type="submit" class="btn btn-primary mt-3 float-end">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
