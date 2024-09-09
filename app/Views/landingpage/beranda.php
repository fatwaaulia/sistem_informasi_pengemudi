<style>
.header {
    background-image: linear-gradient(rgba(0, 0, 0, .5), rgba(0, 0, 0, .5)), url(<?= base_url('assets/img/rhys-moult-7eaFIKeo1MQ-unsplash.jpg') ?>);
    height: 100vh;
    display: flex;
    align-items: center;
    justify-items: center;
    background-attachment: fixed;
}
</style>
<div class="container-fluid header img-style">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="position-relative text-white justify-items-center" id="headerTitle">
                    <h4>Selamat Datang di</h4>
                    <h1 class="fw-600 mb-4"><?= model('AppSettings')->find(1)['nama_aplikasi']; ?></h1>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).scroll(() => {
    $('#headerTitle').css({
        'bottom': -($(this).scrollTop() / 1.85) + "px"
    });
});
</script>

<section class="container position-relative bg-white">
    <div class="row">
        <div class="col-12 text-center">
            <h2 class="fw-700">LAYANAN</h2>
            <p>Lorem ipsum dolor sit amet consectetur.</p>
        </div>
    </div>
</section>