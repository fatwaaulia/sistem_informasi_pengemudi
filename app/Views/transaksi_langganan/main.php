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
                            <th>Kode</th>
                            <th>Tgl. Transaksi</th>
                            <th>Status</th>
                            <th>Paket</th>
                            <th>Harga</th>
                            <th>Poin</th>
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
            { data: 'kode' },
            { data: 'created_at' },
            { data: 'status' },
            { data: 'nama_paket' },
            { data: 'harga_promo' },
            { data: 'poin' },
            { data: null, render: renderOpsi },
        ],
    });
});

function renderOpsi(data) {
    let route_edit_data = `<?= $base_route . '/detail?code=' ?>${data.kode}`;
    return `
    <a href="${route_edit_data}" class="me-2" title="edit">
        <i class="fa-solid fa-circle-info fa-lg"></i>
    </a>`;
}
</script>
