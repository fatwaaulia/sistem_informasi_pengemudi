<section>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h5 class="my-4"><?= isset($title) ? $title : '' ?></h5>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
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
                                                            <input type="file" class="form-control" name="foto_profil" accept=".png,.jpg,.jpeg" onchange="preview()">
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
                        <div class="mb-3">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#ubah_password">
                                <i class="fa-solid fa-lock me-2"></i>
                                <span class="align-middle">Ubah Password</span>
                            </a>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3 float-end">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</section>

<!-- Modal hapus foto profil -->
<div class="modal fade" id="deleteImage" tabindex="-1" aria-labelledby="deleteImageLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="deleteImageLabel">Konfirmasi hapus</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus data ini?</p>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="<?= $base_route . '/delete/image' ?>" method="post">
                    <?= csrf_field(); ?>
                    <button type="submit" class="btn btn-danger">Iya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal ubah password -->
<div class="modal fade" id="ubah_password" tabindex="-1" aria-labelledby="ubahPasswordLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="ubahPasswordLabel">Ubah Password</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= $base_route . '/update/password' ?>" method="post">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="oldpass" class="form-label">Password Saat Ini</label>
                        <div class="position-relative">
                            <input onkeyup="changeOldPass()" type="password" class="form-control" name="oldpass" value="<?= old('oldpass') ?>" id="oldpass" placeholder="Password saat ini">
                            <img src="<?= base_url('assets/icon/show.png') ?>" class="position-absolute" id="eye_oldpass">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password Baru</label>
                        <div class="mb-2 position-relative">
                            <input onkeyup="changePassword()" type="password" class="form-control" name="password" value="<?= old('password') ?>" id="password" placeholder="Password baru">
                            <div class="invalid-feedback">
                                <span id="msg_password"></span>
                            </div>
                            <img src="<?= base_url('assets/icon/show.png') ?>" class="position-absolute" id="eye_password">
                        </div>
                        <div class="position-relative">
                            <input onkeyup="changePassconf()" type="password" class="form-control" name="passconf" value="<?= old('passconf') ?>" id="passconf" placeholder="Confirm password">
                            <div class="invalid-feedback">
                                <span id="msg_passconf"></span>
                            </div>
                            <img src="<?= base_url('assets/icon/show.png') ?>" class="position-absolute" id="eye_passconf">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="simpan_password" disabled>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function toggleVisibility(inputElement, eyeElement) {
    const showIcon = "<?= base_url('assets/icon/show.png') ?>";
    const hideIcon = "<?= base_url('assets/icon/hide.png') ?>";
    inputElement.type = inputElement.type === 'password' ? 'text' : 'password';
    eyeElement.src = inputElement.type === 'password' ? showIcon : hideIcon;
}

const eyeOldpass = document.getElementById('eye_oldpass');
const oldpass = document.getElementById('oldpass');
eyeOldpass.addEventListener('click', () => {
    toggleVisibility(oldpass, eyeOldpass);
});

const eyePassword = document.getElementById('eye_password');
const password = document.getElementById('password');
eyePassword.addEventListener('click', () => {
    toggleVisibility(password, eyePassword);
});

const eyePassconf = document.getElementById('eye_passconf');
const passconf = document.getElementById('passconf');
eyePassconf.addEventListener('click', () => {
    toggleVisibility(passconf, eyePassconf);
});

function validatePassword() {
    const str_oldpass = $('#oldpass').val();
    const str_password = $('#password').val();
    const str_passconf = $('#passconf').val();

    const passwordLengthValid = str_password.length >= 8;
    const passwordMatch = str_passconf === str_password;

    if (passwordLengthValid && passwordMatch) {
        enableSaveButton(str_oldpass);
        resetInvalidFeedback();
    } else {
        if (!passwordLengthValid) {
            handleInvalidPassword('password', 'minimal 8 karakter');
        } else {
            resetInvalidFeedback('password');
        }

        if (!passwordMatch) {
            handleInvalidPassword('passconf', 'password tidak sama');
        } else {
            resetInvalidFeedback('passconf');
        }

        disableSaveButton();
    }
}

function handleInvalidPassword(inputId, message) {
    $(`#${inputId}`).addClass('is-invalid');
    $(`#msg_${inputId}`).html(message);
}

function resetInvalidFeedback(inputId = null) {
    if (inputId) {
        $(`#${inputId}`).removeClass('is-invalid');
        $(`#msg_${inputId}`).html('');
    } else {
        $('#password').removeClass('is-invalid');
        $('#msg_password').html('');
        $('#passconf').removeClass('is-invalid');
        $('#msg_passconf').html('');
    }
}

function enableSaveButton(str_oldpass) {
    $('#simpan_password').prop("disabled", !str_oldpass);
}

function disableSaveButton() {
    $('#simpan_password').prop("disabled", true);
}

$('#password').on('input', validatePassword);
$('#passconf').on('input', validatePassword);
</script>
