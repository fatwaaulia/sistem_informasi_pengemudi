<style>
.header {
    background-image: linear-gradient(rgba(13, 110, 253, .5), rgba(0, 0, 0, .5)), url(<?= base_url('assets/img/sementara.jpg') ?>);
    height: 100vh;
    display: flex;
    align-items: center;
    background-attachment: fixed;
}
</style>
<div class="container-fluid header img-style">
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <div class="position-relative text-white" id="headerTitle">
                    <h4>Bismillah</h4>
                    <h1 class="fw-600 mb-4"><?= model('AppSettings')->find(1)['nama_aplikasi']; ?></h1>
                    <p style="text-align:justify">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Possimus aspernatur quasi, magnam porro labore placeat! At reiciendis voluptates non perferendis suscipit rem placeat, voluptatum ea, saepe, eligendi error cum minima.</p>
                    <a href="#" class="btn btn-primary">Start Button</a>
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
        <div class="col-lg-6">
            <p class="fw-600 wow fadeInUp" style="border-left:4px solid var(--main-color)">&nbsp; Web App</p>
            <div class="text-justify wow fadeInUp">
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Possimus aspernatur quasi, magnam porro labore placeat! At reiciendis voluptates non perferendis suscipit rem placeat, voluptatum ea, saepe, eligendi error cum minima.</p>
            </div>
            <div class="fw-600 wow fadeInUp">
                24 - 27 November 2023 <br>
                KANTOR MORNING LAB <br>
                Jl. Diponegoro No. 345 Genteng, Kabupaten Banyuwangi, Jawa Timur
            </div>
        </div>
    </div>
</section>