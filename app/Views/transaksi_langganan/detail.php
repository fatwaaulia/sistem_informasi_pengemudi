<section>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h5 class="my-4"><?= isset($title) ? $title : '' ?></h5>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <?php
            $alert_status = 'alert-primary';
            if ($transaksi_langganan['status'] == 'Menunggu Pembayaran') {
                $alert_status = 'alert-primary';
            } elseif ($transaksi_langganan['status'] == 'Lunas') {
                $alert_status = 'alert-success';
            }
            elseif ($transaksi_langganan['status'] == 'Kedaluwarsa') {
                $alert_status = 'alert-danger';
            }
            ?>
            <div class="alert <?= $alert_status ?>" role="alert">
                Status : <b><?= $transaksi_langganan['status'] ?></b> <br>
                Tgl. Transaksi : <?= date('d-m-Y H:i:s', strtotime($transaksi_langganan['created_at'])) ?> <br>
                Tgl. Kedaluwarsa : <?= $transaksi_langganan['expired_at'] ? date('d-m-Y H:i:s', strtotime($transaksi_langganan['expired_at'])) : '-' ?> <br>
                Tgl. Terbayar : <?= $transaksi_langganan['paid_at'] ? date('d-m-Y H:i:s', strtotime($transaksi_langganan['paid_at'])) : '-' ?> <br>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <span>
                            <?= $transaksi_langganan['kode']; ?>
                        </span>
                    </div>
                    <table class="table w-100">
                        <thead>
                            <tr>
                                <th class="text-primary-emphasis">Paket Langganan</th>
                                <th class="text-primary-emphasis">Biaya</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <h5><?= $transaksi_langganan['nama_paket'] ?></h5>
                                    <?= $transaksi_langganan['poin'] ?> Poin <br>
                                    <span class="text-secondary">
                                        <?= $transaksi_langganan['deskripsi'] ?>
                                    </span>
                                    <br>
                                    <small>*Berlaku hingga 1 tahun</small>
                                </td>
                                <td>
                                    <?php if ($transaksi_langganan['harga_normal'] > $transaksi_langganan['harga_promo']) : ?>
                                    <small class="text-decoration-line-through text-secondary">
                                        Rp <?= number_format($transaksi_langganan['harga_normal'], 0, ',', '.') ?>
                                    </small> <br>
                                    <?php endif; ?>
                                    Rp <?= number_format($transaksi_langganan['harga_promo'], 0, ',', '.') ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-end">Total</td>
                                <td>
                                    <h5 class="fw-600">Rp <?= number_format($transaksi_langganan['harga_promo'], 0, ',', '.') ?></h5>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <?php if ($transaksi_langganan['status'] == 'Menunggu Pembayaran') : ?>
                    <a href="<?= $transaksi_langganan['invoice_url'] ?>" class="btn btn-primary float-end px-4">Bayar Sekarang</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
