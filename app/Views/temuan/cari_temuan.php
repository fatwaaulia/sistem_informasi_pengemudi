<section>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h5 class="my-4"><?= isset($title) ? $title : '' ?></h5>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="card p-3 position-relative">
                <form action="" method="get">
                    <div class="mb-3">
                        <label for="nik" class="form-label">NIK</label>
                        <input type="number" class="form-control <?= validation_show_error('nik') ? 'is-invalid' : '' ?>" id="nik" name="nik" value="<?= $nik ?>" placeholder="masukkan nik" oninput="document.getElementById('modalNIK').innerText=this.value ? this.value : '~tidak boleh kosong~';" onkeydown="if(event.key === 'Enter') event.preventDefault();" required>
                        <div class="invalid-feedback">
                            <?= cutString(validation_show_error('nik')) ?>
                        </div>
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
                                    <p>Pencarian temuan akan mengurangi poinmu sebanyak <b class="text-danger">-1</b> point. Apakah kamu yakin melakukan pencarian temuan dengan NIK <b id="modalNIK">~tidak boleh kosong~</b> ?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Iya, Cari</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <?php if ($nik) : ?>
                <hr class="mt-4">
                <div class="mb-2">
                    <span class="fw-600">Hasil Pencarian</span>
                </div>
                <h3 class="mb-4"><?= $nik ?></h3>
                <div>
                    Status : <span class="<?= ($status == 'NIK ditemukan') ? 'text-success' : 'text-danger' ?>"><?= $status ?></span>
                </div>
                <hr>
                <?php foreach ($data as $v) : ?>
                <div class="mb-2">
                    NIK : <?= $v['nik'] ?>
                </div>
                <div class="mb-2">
                    Nama : <?= $v['nama'] ?>
                </div>
                <div class="mb-2 text-justify">
                    Rincian : <?= $v['rincian'] ?>
                </div>
                <div class="mb-2">
                    Tanggal : <?= date('d-m-Y', strtotime($v['tanggal'])) ?>
                </div>
                <div class="mb-2">
                    Bukti :
                    <img src="<?= base_url('assets/uploads/temuan/') . $v['bukti'] ?>" class="w-100 img-style mt-2">
                </div>
                <hr>
                <?php endforeach; endif; ?>
            </div>
        </div>
    </div>
</div>
</section>
