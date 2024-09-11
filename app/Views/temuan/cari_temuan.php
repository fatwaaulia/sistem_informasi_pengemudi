<section>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h5 class="my-4"><?= isset($title) ? $title : '' ?></h5>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card p-3 position-relative">
                <form action="" method="get">
                    <div class="mb-3">
                        <label for="nik" class="form-label">NIK</label>
                        <input type="number" class="form-control" id="nik" name="nik" value="<?= $nik ?>" placeholder="masukkan nik" oninput="document.getElementById('valueNIK').innerText=this.value ? this.value : '~kosong~';" onkeydown="if(event.key === 'Enter') event.preventDefault();">
                    </div>
                    <div class="mb-3">
                        <label for="no_sim" class="form-label">No. SIM</label>
                        <input type="number" class="form-control" id="no_sim" name="no_sim" value="<?= $no_sim ?>" placeholder="masukkan nomor sim" oninput="document.getElementById('valueSIM').innerText=this.value ? this.value : '~kosong~';" onkeydown="if(event.key === 'Enter') event.preventDefault();">
                    </div>
                    <button type="button" class="btn btn-primary mt-3 float-end" data-bs-toggle="modal" data-bs-target="#cekTemuan">Cek Temuan</button>
                    <!-- Modal -->
                    <div class="modal fade" id="cekTemuan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Konfirmasi Pencarian</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Pencarian temuan akan mengurangi poinmu sebanyak <b class="text-danger">-1</b> point. Apakah kamu yakin melakukan pencarian temuan dengan NIK <b id="valueNIK">~kosong~</b> dan No. SIM <b id="valueSIM">~kosong~</b> ?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Iya, Cari</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <?php if ($nik OR $no_sim) : ?>
                <hr class="mt-4">
                <div class="mb-2">
                    <span class="fw-600">Hasil Pencarian</span>
                </div>
                <div>
                    Status : <span class="text-<?= ($status == 'NIK atau SIM tidak ditemukan') ? 'danger' : 'success' ?>"><?= $status ?></span>
                </div>
                <?php if ($status != 'NIK atau SIM tidak ditemukan') : ?>
                <a href="<?= base_url() . 'perusahaan/cari-temuan/unduh-pdf?nik=' . $nik . '&no_sim=' . $no_sim ?>" target="_blank" class="btn btn-primary mt-3">Unduh Pdf</a>
                <?php endif; ?>
                <hr>
                <?php foreach ($data as $v) : ?>
                <div class="mb-2">
                    NIK : <?= $v['nik'] ?>
                </div>
                <div class="mb-2">
                    Nama : <?= $v['nama'] ?>
                </div>
                <div class="mb-2">
                    No. SIM : <?= $v['no_sim'] ?>
                </div>
                <div class="mb-2">
                    Tgl. Lahir : <?= $v['tanggal_lahir'] != '0000-00-00' ? date('d-m-Y', strtotime($v['tanggal_lahir'])) : '' ?>
                </div>
                <div class="mb-2">
                    Alamat : <?= $v['alamat'] ?>
                </div>
                <div class="mb-2 text-justify">
                    Catatan Kejadian : <?= $v['catatan_kejadian'] ?>
                </div>
                <div class="mb-2">
                    Tanggal Kejadian : <?= $v['tanggal_kejadian'] != '0000-00-00' ? date('d-m-Y', strtotime($v['tanggal_kejadian'])) : '' ?>
                </div>
                <div class="mb-2">
                    Perusahaan Pelapor : <?= $v['nama_perusahaan'] ?>
                </div>
                <div class="mb-2">
                    Foto Sopir :
                    <?php if($v['foto_sopir']) : ?>
                    <img src="<?= base_url('assets/uploads/temuan/') . $v['foto_sopir'] ?>" class="wh-250 img-style mt-2">
                    <?php else : echo 'Tidak menyertakan foto'; endif; ?>
                </div>
                <hr>
                <?php endforeach; endif; ?>
            </div>
        </div>
    </div>
</div>
</section>
