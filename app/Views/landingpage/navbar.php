<style>
@keyframes smoothScroll {
    0% {transform: translateY(-40px);}
    100% {transform: translateY(0px);}
}
.smoothScroll { animation: smoothScroll .7s forwards; }
.navbar { box-shadow: 0px 2px 20px rgba(1, 41, 112, 0.1)!important; }
.nav-link { color: #000000!important }
.nav-link:hover { color:var(--main-color)!important; }
.nav-active {
    color:var(--main-color)!important;
    font-weight: 600;
}
.dropdown-menu .nav-active:active {
    color:white!important;
    background-color:var(--main-color)!important;
}
</style>
<?php
$app_settings = model('AppSettings')->find(1);
$logo = base_url('assets/uploads/app_settings/') . $app_settings['logo'];
$uri = service('uri');
$uri->setSilent(true);
?>

<nav class="navbar navbar-expand-lg bg-light position-absolute w-100" style="z-index:100">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="<?= base_url() ?>">
            <img src="<?= $logo ?>" style="height:45px" alt="<?= $app_settings['nama_aplikasi'] ?>">
            <h4 class="ms-2">SLIP</h4>
        </a>
        <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa-solid fa-bars my-1"></i>
        </button>
        <div class="collapse navbar-collapse justify-content-between py-3 py-md-0" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link <?= ($uri->getSegment(1) == '') ? 'nav-active' : '' ?>" href="<?= base_url() ?>">HOME</a>
            </div>
            <div class="navbar-nav">
                <?php 
                if(session()->get('isLogin')) :
                    $user = model('Users')->where('id', session()->get('id_user'))->first();
                    if ($user['foto_profil']) {
                        $foto_profil = base_url('assets/uploads/users/' . $user['foto_profil']);
                    } else {
                        $foto_profil = base_url('assets/uploads/user-default.png');
                    }
                 ?>
                <a href="<?= base_url('login') ?>" class="mt-3 mt-lg-0">
                    <img src="<?= $foto_profil ?>" alt="Profile" class="rounded-circle wh-40">
                    <span class="ps-2 text-black"><?= mb_strimwidth($user['nama'], 0, 15, "..."); ?></span>
                </a>
                <?php else : ?>
                <div class="d-flex justify-content-start mt-3 mt-lg-0">
                    <div><a href="<?= base_url('login') ?>" class="btn btn-primary me-2">Login</a></div>
                    <div><a href="<?= base_url('register') ?>" class="btn btn-primary">Register</a></div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<script>
$(document).scroll(() => {
    let scroll = $(document).scrollTop();
    if(scroll > 150) {
        $('.navbar').removeClass('position-absolute w-100');
        $('.navbar').addClass('fixed-top smoothScroll');
    } else {
        if (scroll < 10) {
            $('.navbar').addClass('position-absolute w-100');
            $('.navbar').removeClass('fixed-top smoothScroll');
        }
    }
});
</script>