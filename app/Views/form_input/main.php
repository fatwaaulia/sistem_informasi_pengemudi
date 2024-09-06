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
                <div class="row mb-3">
                    <div class="col-12 d-flex justify-content-end align-items-end">
                        <a href="<?= $base_route . '/new' ?>" class="btn btn-primary">
                            <i class="fa-solid fa-plus fa-sm"></i> New
                        </a>
                    </div>
                </div>
                <table class="display nowrap w-100" id="myTable">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Gambar</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Dokumen Pendukung</th>
                            <th>Tanggal Kegiatan</th>
                            <th>Select Multiple</th>
                            <th>Checkbox</th>
                            <th>Radio</th>
                            <th>Opsi</th>
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
            { data: null, render: renderGambar },
            { data: 'nama' },
            { data: 'harga' },
            { data: null, render: renderDokumenPendukung },
            { data: 'tanggal_kegiatan' },
            { data: 'select_multiple' },
            { data: 'checkbox' },
            { data: 'radio' },
            { data: null, render: renderOpsi },
        ],
    });
});

function renderGambar(data) {
    return `<img src="${data.gambar}" class="wh-40 img-style" loading="lazy">`;
}

function renderDokumenPendukung(data) {
    return `<a href="<?= base_url($upload_path) ?>${data.dokumen_pendukung}">${data.dokumen_pendukung}</a>`;
}

function renderOpsi(data) {
    let route_edit_data = `<?= $base_route . '/edit/' ?>${data.id}`;
    let route_hapus_data = `<?= $base_route . '/delete/' ?>${data.id}`;
    return `
    <a href="${route_edit_data}" class="me-2" title="edit">
        <i class="fa-regular fa-pen-to-square fa-lg"></i>
    </a>
    <a href="#" data-bs-toggle="modal" data-bs-target="#hapus_data${data.id}" title="delete">
        <i class="fa-regular fa-trash-can fa-lg text-danger"></i>
    </a>
    <div class="modal fade" id="hapus_data${data.id}" tabindex="-1" aria-labelledby="hapusDataLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="hapusDataLabel">Konfirmasi hapus</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus data ini?</p>
                    <table>
                        <tr>
                            <td>Nama</td>
                            <td>: ${data.nama}</td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="${route_hapus_data}" method="post">
                        <?= csrf_field(); ?>
                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>`;
}
</script>
