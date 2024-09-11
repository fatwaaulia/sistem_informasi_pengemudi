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
                            <th>Tgl. Diterima</th>
                            <th>Nama Perusahaan</th>
                            <th>No. NIB Perusahaan</th>
                            <th>Nama PIC</th>
                            <th>No. Ponsel PIC</th>
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
            { data: 'checked_at' },
            { data: 'nama_perusahaan' },
            { data: 'no_nib_perusahaan' },
            { data: 'nama' },
            { data: 'no_ponsel' },
            { data: null, render: renderOpsi },
        ],
    });
});

function renderOpsi(data) {
    let route_edit_data = `<?= $base_route . '/detail/' ?>${data.id}`;
    return `
    <a href="${route_edit_data}" class="me-2" title="edit">
        <i class="fa-solid fa-circle-info fa-lg"></i>
    </a>`;
}
</script>
