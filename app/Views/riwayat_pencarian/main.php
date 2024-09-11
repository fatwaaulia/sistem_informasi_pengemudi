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
                            <th>Nama Perusahaan</th>
                            <th>Waktu Pencarian</th>
                            <th>NIK</th>
                            <th>Nama Lengkap</th>
                            <th>Catatan Kejadian</th>
                            <th>Tanggal Kejadian</th>
                            <th>Foto Sopir</th>
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
            { data: 'nama_perusahaan' },
            { data: 'created_at' },
            { data: null, render: renderNIK },
            { data: null, render: data => (data.id_temuan) ? JSON.parse(data.nama).join('<br>') : '' },
            { data: null, render: data => (data.id_temuan) ? JSON.parse(data.catatan_kejadian).join('<br>') : '' },
            { data: null, render: data => (data.id_temuan) ? JSON.parse(data.tanggal_kejadian).join('<br>') : '' },
            { data: null, render: renderFotoSopir },
        ],
    });
});

function renderNIK(data) {
    return `<span class="${data.id_temuan != '' ? 'text-success' : 'text-danger'}">${data.nik}</span>`;
}

function renderFotoSopir(data) {
    if (!data.id_temuan) return '';
    let dir = '<?= base_url() ?>assets/uploads/temuan/';

    return JSON.parse(data.foto_sopir).map(foto => `
    <a data-fancybox="foto" href="${dir + foto}">
        <img src="${dir + foto}" class="wh-40 img-style" loading="lazy">
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
