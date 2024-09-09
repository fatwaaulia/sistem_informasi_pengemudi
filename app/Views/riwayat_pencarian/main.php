<section>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h5 class="my-4"><?= isset($title) ? $title : '' ?></h5>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card p-3 position-relative">
                <table class="display nowrap w-100" id="myTable">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Waktu Pencarian</th>
                            <th>NIK</th>
                            <th>Nama Lengkap</th>
                            <th>Rincian</th>
                            <th>Tanggal Temuan</th>
                            <th>Bukti</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    $('#myTable').DataTable({
        ajax: '<?= $get_data ?>',
        processing: true,
        serverSide: true,
        scrollX: true,
        columns: [
            { data: 'no_urut' },
            { data: 'created_at' },
            { data: null, render: renderNIK },
            { data: null, render: data => (data.id_temuan) ? JSON.parse(data.nama).join('<br>') : '' },
            { data: null, render: data => (data.id_temuan) ? JSON.parse(data.rincian).join('<br>') : '' },
            { data: null, render: data => (data.id_temuan) ? JSON.parse(data.tanggal).join('<br>') : '' },
            { data: null, render: renderBukti },
        ],
    });
});

function renderNIK(data) {
    return `<span class="${data.id_temuan != '' ? 'text-success' : 'text-danger'}">${data.nik}</span>`;
}

function renderBukti(data) {
    if (!data.id_temuan) return '';
    let dir = '<?= base_url() ?>assets/uploads/temuan/';

    return JSON.parse(data.bukti).map(gambar => `
    <a data-fancybox="bukti" href="${dir + gambar}">
        <img src="${dir + gambar}" class="wh-40 img-style" loading="lazy">
    </a>`);
}
</script>

<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css">
<script>
Fancybox.bind("[data-fancybox]", {
    Toolbar: {
        display: {
            left: ['infobar'],
            middle: [''],
            right: ['close'],
        },
    },
});
</script>
