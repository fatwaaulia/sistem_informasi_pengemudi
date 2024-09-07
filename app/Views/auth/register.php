<section>
<div class="container">
	<div class="row justify-content-center align-items-center vh-100">
		<div class="col-xxl-4 col-lg-4 col-md-6 col-12">
			<div class="card my-4 pt-3 pb-1">
				<div class="card-body">
					<div class="text-center">
						<h3 class="mb-2 fw-600">Pendaftaran Akun</h3>
						<p>Buat akun cepat dan mudah.</p>
					</div>
					<hr>
					<form action="<?= base_url('register-process') ?>" method="POST">
						<?= csrf_field(); ?>
						<div class="mb-3">
							<label for="nama_perusahaan" class="form-label">Nama Perusahaan</label>
							<input type="nama" class="form-control <?= validation_show_error('nama_perusahaan') ? "is-invalid" : '' ?>" id="nama_perusahaan" name="nama_perusahaan" value="<?= old('nama_perusahaan') ?>" placeholder="nama perusahaan" autocomplete="off" autofocus>
							<div class="invalid-feedback">
								<?= cutString(validation_show_error('nama_perusahaan')) ?>
							</div>
						</div>
						<div class="mb-3">
							<label for="nama" class="form-label">Nama PIC</label>
							<input type="text" class="form-control <?= validation_show_error('nama') ? "is-invalid" : '' ?>" id="nama" name="nama" value="<?= old('nama') ?>" placeholder="nama pic">
							<div class="invalid-feedback">
								<?= cutString(validation_show_error('nama')) ?>
							</div>
						</div>
						<div class="mb-3">
							<label for="no_ponsel" class="form-label">No. Ponsel PIC</label>
							<input type="number" class="form-control <?= validation_show_error('no_ponsel') ? "is-invalid" : '' ?>" id="no_ponsel" name="no_ponsel" value="<?= old('no_ponsel') ?>" placeholder="08xx">
							<div class="invalid-feedback">
								<?= cutString(validation_show_error('no_ponsel')) ?>
							</div>
						</div>
						<div class="mb-3">
							<label for="email" class="form-label">Email</label>
							<input type="email" class="form-control <?= validation_show_error('email') ? "is-invalid" : '' ?>" id="email" name="email" value="<?= old('email') ?>" placeholder="name@gmail.com" autocomplete="off">
							<div class="invalid-feedback">
								<?= cutString(validation_show_error('email')) ?>
							</div>
						</div>
						<div class="mb-3">
							<label for="password" class="form-label">Password</label>
							<div class="mb-2 position-relative">
								<input type="password" class="form-control <?= validation_show_error('password') ? "is-invalid" : '' ?>" name="password" id="password" value="<?= old('password') ?>" placeholder="password" autocomplete="off">
								<div class="invalid-feedback">
									<?= cutString(validation_show_error('password')) ?>
								</div>
								<img src="<?= base_url('assets/icon/show.png') ?>" class="position-absolute" id="eye_password">
							</div>
							<div class="position-relative">
								<input type="password" class="form-control <?= validation_show_error('passconf') ? "is-invalid" : '' ?>" name="passconf" id="passconf" value="<?= old('passconf') ?>" placeholder="confirm password" autocomplete="off">
								<div class="invalid-feedback">
									<?= cutString(validation_show_error('passconf')) ?>
								</div>
								<img src="<?= base_url('assets/icon/show.png') ?>" class="position-absolute" id="eye_passconf">
							</div>
						</div>
						<button class="btn btn-primary w-100" type="submit">Daftar</button>
					</form>
					<div class="text-center mt-3">
						<span>Sudah punya akun?</span>
						<a href="<?= base_url('login') ?>">Masuk</a>
					</div>
				</div>
			</div>			
		</div>
	</div>
</div>
</section>

<script>
function toggleVisibility(inputElement, eyeElement) {
    const showIcon = "<?= base_url('assets/icon/show.png') ?>";
    const hideIcon = "<?= base_url('assets/icon/hide.png') ?>";
    inputElement.type = inputElement.type === 'password' ? 'text' : 'password';
    eyeElement.src = inputElement.type === 'password' ? showIcon : hideIcon;
}

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
</script>