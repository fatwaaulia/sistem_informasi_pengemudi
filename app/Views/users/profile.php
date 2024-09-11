<section>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h5 class="my-4"><?= isset($title) ? $title : '' ?></h5>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <form action="<?= $base_route . '/update' ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <?php
                        $user_session = model('Users')->where('id', session()->get('id_user'))->first();
                        if ($user_session['id_role'] == 3) :
                        ?>
                        <div class="mb-2">
                            <span class="fw-600">DATA PERUSAHAAN</span>
                        </div>
                        <div class="mb-3">
                            <label for="nama_perusahaan" class="form-label">Nama Perusahaan</label>
                            <input type="text" class="form-control" id="nama_perusahaan" name="nama_perusahaan" value="<?= $data['nama_perusahaan'] ?>" disabled>
                            <div class="invalid-feedback">
                                <?= cutString(validation_show_error('nama_perusahaan')) ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="alamat_perusahaan" class="form-label">Alamat Perusahaan</label>
                            <textarea class="form-control" id="alamat_perusahaan" name="alamat_perusahaan" rows="3" placeholder="masukkan alamat perusahaan" disabled><?= $data['alamat_perusahaan'] ?></textarea>
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
                            <label class="form-label">No. NIB Perusahaan</label>
                            <input type="text" class="form-control" value="<?= $data['no_nib_perusahaan'] ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="dokumen_akta_perusahaan" class="form-label">Dokumen Akta Perusahaan <span class="text-secondary"> (maks. 10 mb, pdf)</span></label>
                            <?php if ($data['dokumen_akta_perusahaan']) : ?>
                            <br> <a href="<?= base_url('assets/uploads/users/dokumen_akta_perusahaan/') . $data['dokumen_akta_perusahaan'] ?>">Lihat Dokumen</a>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                        <div class="mb-2">
                            <span class="fw-600">DATA PIC</span>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex">
                                <div class="position-relative">
                                    <?php
                                    $foto_profil = ($data['foto_profil'])
                                        ? base_url($upload_path . $data['foto_profil'])
                                        : base_url('assets/uploads/user-default.png');
                                    ?>
                                    <img src="<?= $foto_profil ?>" class="wh-150 img-style rounded-circle <?= validation_show_error('foto_profil') ? 'border border-danger' : '' ?>" id="frame">
                                    <div class="position-absolute" style="bottom:0px;right:0px">
                                        <button class="btn btn-secondary rounded-circle" style="padding:8px 10px" type="button" data-bs-toggle="modal" data-bs-target="#option">
                                            <i class="fa-solid fa-camera fa-lg"></i>
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="option" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <div data-bs-dismiss="modal">
                                                            <input type="file" class="form-control" name="foto_profil" accept="image/*" onchange="preview()">
                                                            <?php if ($data['foto_profil']) : ?>
                                                            <div class="mt-3">
                                                                <a href="#" class="text-secondary" data-bs-toggle="modal" data-bs-target="#deleteImage">
                                                                    <i class="fa-solid fa-trash-can fa-lg"></i>
                                                                    Hapus
                                                                </a>
                                                            </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="invalid-feedback">
                                <?= cutString(validation_show_error('foto_profil')) ?>
                            </div>
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
                            <input type="number" class="form-control <?= validation_show_error('no_ponsel') ? "is-invalid" : '' ?>" id="no_ponsel" name="no_ponsel" value="<?= old('no_ponsel') ?? $data['no_ponsel'] ?>" placeholder="6285xxx">
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
