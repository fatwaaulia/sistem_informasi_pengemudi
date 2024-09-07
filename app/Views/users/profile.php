<section>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h5 class="my-4">Profil</h5>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="<?= $base_route . '/update' ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <div class="row">
                            <div class="col-lg-6">
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
                                                                </div>
                                                                <?php if ($data['foto_profil']) : ?>
                                                                <div class="mt-3">
                                                                    <a href="#" class="text-secondary" data-bs-toggle="modal" data-bs-target="#deleteImage">
                                                                        <i class="fa-solid fa-trash-can fa-lg"></i>
                                                                        Delete
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
                                    <div class="invalid-feedback">
                                        <?= cutString(validation_show_error('foto_profil')) ?>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control <?= validation_show_error('nama') ? 'is-invalid' : '' ?>" id="nama" name="nama" value="<?= old('nama') ?? $data['nama'] ?>" placeholder="masukkan nama lengkap">
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
                                    <label for="alamat" class="form-label">Alamat</label><span class="text-secondary"> (opsional)</span>
                                    <textarea class="form-control <?= validation_show_error('alamat') ? 'is-invalid' : '' ?>" id="alamat" name="alamat" rows="3" placeholder="masukkan alamat"><?= old('alamat') ?? $data['alamat'] ?></textarea>
                                    <div class="invalid-feedback">
                                        <?= cutString(validation_show_error('alamat')) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="no_ponsel" class="form-label">No. Ponsel</label><span class="text-secondary"> (opsional)</span>
                                    <input type="number" class="form-control <?= validation_show_error('no_ponsel') ? "is-invalid" : '' ?>" id="no_ponsel" name="no_ponsel" value="<?= old('no_ponsel') ?? $data['no_ponsel'] ?>" placeholder="08xx">
                                    <div class="invalid-feedback">
                                        <?= cutString(validation_show_error('no_ponsel')) ?>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control <?= validation_show_error('email') ? 'is-invalid' : '' ?>" id="email" name="email" value="<?= old('email') ?? $data['email'] ?>" placeholder="name@gmail.com">
                                    <div class="invalid-feedback">
                                        <?= cutString(validation_show_error('email')) ?>
                                    </div>
                                </div>
                                <hr>
                                <div class="mb-3">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#ubah_password">
                                        <i class="fa-solid fa-lock me-2"></i>
                                        <span class="align-middle">Ubah Password</span>
                                    </a>
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

<!-- Modal hapus foto profil -->
<div class="modal fade" id="deleteImage" tabindex="-1" aria-labelledby="deleteImageLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="deleteImageLabel">Confirm delete</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                    <p>Are you sure to delete photo?</p>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="<?= $base_route . '/delete/image' ?>" method="post">
                    <?= csrf_field(); ?>
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
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
