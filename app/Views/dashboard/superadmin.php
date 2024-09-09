<?php
$user_session = model('Users')->where('id', session()->get('id_user'))->first();
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card mt-4" style="background: linear-gradient(60deg, rgb(57 32 150) 0%, #2196F3 100%);">
                <div class="card-body text-white">
                    <h3 class="fw-600">Selamat datang <?= implode(' ', array_slice(explode(' ', $user_session['nama']), 0, 3)); ?>!</h3>
                    <p>Akses cepat dan pengelolaan informasi secara efisien.</p>
                </div>
                <div>
                    <svg class="waves mb-0" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
                        <defs>
                            <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
                        </defs>
                        <g class="parallax">
                            <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(255,255,255,0.7" />
                            <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(255,255,255,0.5)" />
                            <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(255,255,255,0.3)" />
                            <use xlink:href="#gentle-wave" x="48" y="7" fill="rgba(255,255,255,0.7)" />
                        </g>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xxl-3 col-lg-4 col-md-6 col-sm-6">
            <div class="card mb-3">
                <div class="card-body text-center" style="border-bottom:4px solid var(--bs-primary); border-radius:var(--border-radius)">
                    <p class="fw-500 d-block mb-2">
                        <i class="fa-solid fa-building me-1"></i>
                        Perusahaan Aktif
                    </p>
                    <?php
                    $users = model('Users')->where([
                                'id_role' => 3,
                                'status_pengajuan_perusahaan' => 'Aktif'])
                            ->findAll();
                    ?>
                    <h3 class="mb-0"><?= count($users) ?></h3>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-lg-4 col-md-6 col-sm-6">
            <div class="card mb-3">
                <div class="card-body text-center" style="border-bottom:4px solid var(--bs-primary); border-radius:var(--border-radius)">
                    <p class="fw-500 d-block mb-2">
                        <i class="fa-solid fa-file me-1"></i>
                        Pengajuan Perusahaan
                    </p>
                    <?php
                    $pengajuan_perusahaan = model('Users')->where([
                                'id_role' => 3,
                                'status_pengajuan_perusahaan' => 'Menunggu Verifikasi'])
                            ->findAll();
                    ?>
                    <h3 class="mb-0"><?= count($pengajuan_perusahaan) ?></h3>
                </div>
            </div>
        </div>
    </div>
</div>
