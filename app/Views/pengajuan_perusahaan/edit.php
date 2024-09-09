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
            $alert = '';
            if ($data['status_pengajuan_perusahaan'] == 'Menunggu Verifikasi') {
                $alert = 'alert-primary';
            } elseif ($data['status_pengajuan_perusahaan'] == 'Aktif') {
                $alert = 'alert-success';
            } elseif ($data['status_pengajuan_perusahaan'] == 'Ditolak') {
                $action = $base_route . '/update';
                $alert = 'alert-danger';
            }
            ?>
            <div class="alert <?= $alert ?>" role="alert">
                Status : <b><?= $data['status_pengajuan_perusahaan'] ?></b> <br>
                Tgl. Pengajuan : <?= date('d-m-Y H:i:s', strtotime($data['submission_at'])) ?> <br>
            </div>
            <div class="card">
                <div class="card-body">
                    <form action="<?= $base_route . '/update/' . encode($data['id']) ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <div class="mb-2">
                            <span class="fw-600">DATA PERUSAHAAN</span>
                        </div>
                        <div class="mb-3">
                            <label for="nama_perusahaan" class="form-label">Nama Perusahaan</label>
                            <input type="text" class="form-control" id="nama_perusahaan" value="<?= $data['nama_perusahaan'] ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="alamat_perusahaan" class="form-label">Alamat Perusahaan</label>
                            <textarea class="form-control" id="alamat_perusahaan" rows="3" disabled><?= $data['alamat_perusahaan'] ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="no_telepon_perusahaan" class="form-label">No. Telepon Perusahaan</label>
                            <input type="number" class="form-control" id="no_telepon_perusahaan" value="<?= $data['no_telepon_perusahaan'] ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="email_perusahaan" class="form-label">Email Perusahaan</label>
                            <input type="email" class="form-control" id="email_perusahaan" name="email_perusahaan" value="<?= $data['email_perusahaan'] ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="no_akta_perusahaan" class="form-label">No. Akta Perusahaan</label>
                            <input type="text" class="form-control" id="no_akta_perusahaan" name="no_akta_perusahaan" value="<?= $data['no_akta_perusahaan'] ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="dokumen_akta_perusahaan" class="form-label">Dokumen Akta Perusahaan <span class="text-secondary"> (maks. 10 mb, pdf)</span></label>
                            <br>
                            <a href="<?= base_url('assets/uploads/users/dokumen_akta_perusahaan/') . $data['dokumen_akta_perusahaan'] ?>">Lihat Dokumen</a>
                        </div>
                        <div class="mb-2">
                            <span class="fw-600">DATA PIC</span>
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama PIC</label>
                            <input type="text" class="form-control" id="nama" value="<?= $data['nama'] ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select class="form-select" id="jenis_kelamin" disabled>
                                <option value="<?= $data['jenis_kelamin'] ?>"><?= $data['jenis_kelamin'] ?></option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="no_ponsel" class="form-label">No. Ponsel PIC</label>
                            <input type="number" class="form-control" id="no_ponsel" value="<?= $data['no_ponsel'] ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" value="<?= $data['email'] ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="status_pengajuan_perusahaan" class="form-label">Status Pengajuan Perusahaan</label>
                            <select class="form-select <?= validation_show_error('status_pengajuan_perusahaan') ? 'is-invalid' : '' ?>" id="status_pengajuan_perusahaan" name="status_pengajuan_perusahaan">
                                <?php
                                $status_pengajuan_perusahaan = ['Menunggu Verifikasi', 'Aktif', 'Ditolak'];
                                $selected = old('status_pengajuan_perusahaan', $data['status_pengajuan_perusahaan']);
                                foreach ($status_pengajuan_perusahaan as $v) :
                                ?>
                                <option value="<?= $v ?>" <?= $selected == $v ? 'selected' : '' ?>>
                                    <?= $v ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
                                <?= cutString(validation_show_error('status_pengajuan_perusahaan')) ?>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3 float-end">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
