<!DOCTYPE html>
<html>
<head>
    <link rel="shortcut icon" href="<?= base_url() . 'assets/uploads/app_settings/favicon.png' ?>" type="image/x-icon">
    <title>SISTEM LAYANAN INFORMASI PENGEMUDI - <?= $temuan[0]['nik'] ?></title>
    <style>
    body, h1, h2, h3, h4, h5, h6, p, span, a, div, button, label {
        font-family: sans-serif!important;
    }
    .fw-400 {font-weight:400}
    .fw-600 {font-weight:600}
    body {
        font-size:18px;
    }
    td {
        padding: 0;
    } 
    </style>
</head>
<body>
    <table width="910" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td width="10%"></td>
            <td width="30%">
                <h1 class="fw-600">INFORMASI PENGEMUDI</h1>
            </td>
        </tr>
    </table>

    <table width="910" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:10px;">
        <tr>
            <td width="20%">
                <img src="<?= base_url() . 'assets/uploads/temuan/' . $temuan[0]['foto_sopir'] ?>" width="80%">
            </td>
            <td width="20%">
                <p style="margin:10px 0; padding:0;" class="fw-600">NIK</p>
                <p style="margin:10px 0; padding:0;" class="fw-600">No. SIM</p>
                <p style="margin:10px 0; padding:0;" class="fw-600">Nama</p>
                <p style="margin:10px 0; padding:0;" class="fw-600">Tanggal Lahir</p>
                <p style="margin:10px 0; padding:0;" class="fw-600">Alamat</p>
                <p style="margin:10px 0; padding:0;" class="fw-600">Telp / HP</p>
            </td>
            <td width="60%">
                <h2 class="fw-600" style="color:#004aa9;margin:10px 0; padding:0;">: <?= $temuan[0]['nik'] ?></h2>
                <p style="margin:10px 0; padding:0;">: <?= $temuan[0]['no_sim'] ?></p>
                <p style="margin:10px 0; padding:0;">: <?= $temuan[0]['nama'] ?></p>
                <p style="margin:10px 0; padding:0;">: <?= ($temuan[0]['tanggal_lahir'] != '0000-00-00') ? date('d/m/Y', strtotime($temuan[0]['tanggal_lahir'])) : '' ?></p>
                <p style="margin:10px 0; padding:0;">: <?= $temuan[0]['alamat'] ?></p>
                <p style="margin:10px 0; padding:0;">: <?= $temuan[0]['no_ponsel'] ?></p>
            </td>
        </tr>
    </table>

    <?php foreach ($temuan as $v) : ?>
    <table width="910" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:40px;">
        <tr>
            <td width="30%">
                <h3 class="fw-600" style="color:#004aa9; margin:0; padding:0;">Catatan Laporan</h3>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <hr style="border: 0; border-top: 2px solid #004aa9;">
            </td>
        </tr>
        <tr>
            <td width="30%">
                <p style="margin:10px 0; padding:0;"><?= $v['catatan_kejadian'] ?></p>
            </td>
        </tr>
        <tr>
            <td width="100%" style="text-align:right">
                <p style="margin:10px 0; padding:0;"><b>Pelapor</b> : <?= $v['nama_perusahaan'] ?></p>
                <p style="margin:10px 0; padding:0;"><b>Tanggal Kejadian </b> : <?= ($v['tanggal_kejadian'] != '0000-00-00') ? date('d/m/Y', strtotime($v['tanggal_kejadian'])) : '' ?></p>
            </td>
        </tr>
    </table>
    <?php endforeach; ?>

    <table width="910" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:40px;">
        <tr>
            <td colspan="4">
                <hr style="border: 0; border-top: 2px solid #004aa9;">
            </td>
        </tr>
        <tr>
            <td width="50%">
                <p style="margin:10px 0; padding:0;"><i>Tanggal Cetak : <?= date('d/m/Y') ?></i></p>
            </td>
            <td width="50%">
                <p style="margin:10px 0; padding:0;text-align:right;"><i>SISTEM LAYANAN INFORMASI PENGEMUDI</i></p>
            </td>
        </tr>
    </table>

    <script>
    window.onload = function() {
        window.print();
    };
    </script>
</body>
</html>