<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <table>
                                <tr>
                                    <td>Kirim Email</td>
                                    <td>: <a href="#" data-bs-toggle="modal" data-bs-target="#kirimEmail">Periksa</a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <!--  -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="kirimEmail" tabindex="-1" aria-labelledby="kirimEmailLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="kirimEmailLabel">Kirim Email</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= $base_route . '/send-email' ?>" method="post">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email yang dituju</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="name@gmail.com" required>
                        <div class="invalid-feedback">
                            <?= validation_show_error('email') ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="pin" class="form-label">PIN</label>
                        <input type="number" class="form-control" id="pin" name="pin" placeholder="masukkan pin" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>