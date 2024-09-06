<section>
<div class="container">
	<div class="row justify-content-center align-items-center vh-100">
		<div class="col-xxl-4 col-lg-4 col-md-6 col-12">
			<div class="card my-4 pt-3 pb-1">
				<div class="card-body">
					<div class="text-center">
						<h3 class="mb-1 fw-600">Masuk</h3>
						<p>Silakan masuk ke akun Anda.</p>
					</div>
					<hr>
					<form action="<?= base_url('login-process') ?>" method="POST">
						<?= csrf_field(); ?>
						<div class="mb-3">
							<label for="email" class="form-label">Email</label>
							<input type="email" class="form-control <?= validation_show_error('email') ? "is-invalid" : '' ?>" id="email" name="email" value="<?= old('email') ?>" placeholder="name@gmail.com" autofocus autocomplete="off">
							<div class="invalid-feedback">
								<?= cutString(validation_show_error('email')) ?>
							</div>
						</div>
						<div class="mb-3">
							<div class="position-relative">
								<input type="password" class="form-control <?= validation_show_error('password') ? "is-invalid" : '' ?>" id="password" name="password" placeholder="password" autocomplete="off">
								<div class="invalid-feedback">
									<?= cutString(validation_show_error('password')) ?>
								</div>
								<img src="<?= base_url('assets/icon/show.png') ?>" class="position-absolute" id="eye_password">
							</div>
						</div>
						<button class="btn btn-primary w-100" type="submit">Masuk</button>
					</form>
					<div class="text-center mt-3">
						<span>Belum punya akun?</span>
						<a href="<?= base_url('register') ?>">Daftar</a>
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
    inputElement.type = password.type === 'password' ? 'text' : 'password';
    eyeElement.src = password.type === 'password' ? showIcon : hideIcon;
}

const eyePassword = document.getElementById('eye_password');
const password = document.getElementById('password');
eyePassword.addEventListener('click', () => {
    toggleVisibility(password, eyePassword);
});

sessionStorage.removeItem("sidebarScrollPosition");
</script>