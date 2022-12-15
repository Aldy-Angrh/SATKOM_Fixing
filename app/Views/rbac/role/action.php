<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header">
                    <!-- summary of this page -->
                    <h3 class="box-title"><?= $subtitle ?></h3>
                </div>
                <div class="box-body">
                    <!-- nested checkbox of registeredControllers and action -->
                    <?php foreach ($registeredControllers as $rc) : ?>
                        <div class="form-group">
                            <label>
                                <?= $rc['controller'] ?>
                            </label>
                            <ul class="list-unstyled" style="margin-left: 1rem">
                                <!-- select all -->
                                <li style="display: inline-block;padding: 1rem">
                                    <label>
                                        <input type="checkbox" class="select-all" data-controller="<?= $rc['controller'] ?>">
                                        Select All
                                    </label>
                                </li>
                                <?php foreach ($rc['actions'] as $action) : ?>
                                    <li style="display: inline-block;padding: 1rem">
                                        <label>
                                            <input type="checkbox" data-controller="<?= $rc['controller'] ?>" class="flat-red" id="<?= implode('.', explode(' ', trim(strtolower($rc['controller'])))) . '_' . $action['fn'] ?>" name="action[]" value="<?= $action['id'] ?>" <?= ($action['has_access']) ? 'checked' : '' ?>>
                                            <?= ucwords($action['name']) ?>
                                        </label>
                                    </li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="box-footer">
                    <!-- select all checkbox -->
                    <button type="button" class="btn btn-primary" id="btn-select-all">
                        <i class="fa fa-check-square-o"></i>
                        Select All
                    </button>
                    <!-- unselect all checkbox -->
                    <button type="button" class="btn btn-danger" id="btn-unselect-all">
                        <i class="fa fa-square-o"></i>
                        Unselect All
                    </button>

                    <?php if (rbac_can("$url.update-action")) : ?>
                        <button type="button" class="btn btn-primary" id="btn-save">
                            <i class="fa fa-save fa-fw"></i> Simpan
                        </button>
                    <?php endif; ?>

                    <?php if (rbac_can("$url.index")) : ?>
                        <!-- index button -->
                        <a href="<?= rbac_url("$url.index") ?>" class="btn btn-default">Kembali</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<!-- register datatable script -->
<script src="<?= base_url('assets/bower_components/datatables.net/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') ?>"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        <?php if (rbac_can("$url.update-action")) : ?>
            $('#btn-save').click(function() {
                let data = {
                    data: []
                };

                $('input[name="action[]"]:checked').each(function() {
                    data.data.push($(this).val());
                });

                $.ajax({
                    url: '<?= rbac_url("$url.update-action", $role->id) ?>',
                    type: 'POST',
                    data,
                    dataType: 'json',
                    success: function(res) {
                        if (res.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: res.message,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                // reload page
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: res.message,
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    },
                    error: function(err) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Terjadi kesalahan',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                });
            });
        <?php endif; ?>

        $('#btn-select-all').click(function() {
            $('input[name="action[]"]').prop('checked', true);
        });

        $('#btn-unselect-all').click(function() {
            $('input[name="action[]"]').prop('checked', false);
        });

        // group select checkbox
        $('.select-all').click(function() {
            let controller = $(this).data('controller');
            let checked = $(this).prop('checked');

            if (checked) {
                $(`input[data-controller="${controller}"]`).prop('checked', true);
            } else {
                $(`input[data-controller="${controller}"]`).prop('checked', false);
            }
        });
    });
</script>
<?= $this->endSection() ?>