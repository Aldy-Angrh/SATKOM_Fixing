<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<link rel="stylesheet" href="<?= base_url('/assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header">
                    <!-- summary of this page -->
                    <h3 class="box-title"><?= $subtitle ?></h3>
                    <br>
                    <?php if (rbac_can("$url.refresh")) : ?>
                        <button type="button" class="btn btn-primary" id="refresh_token" style="margin-top: 1rem">
                            <i class="fa fa-refresh fa-fw"></i> Perbaharui Token <?= $title ?>
                        </button>
                    <?php endif; ?>

                    <!-- /.box-tools -->
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-stripped">
                            <thead>
                                <th>
                                    Token
                                </th>
                                <th>
                                    Tanggal Kadaluarsa
                                </th>
                                <th>
                                    Status
                                </th>
                            </thead>
                            <tbody>
                                <td id="data_token"></td>
                                <td id="data_kadaluarsa"></td>
                                <td id="data_status"></td>
                            </tbody>
                        </table>
                    </div>
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
    const fillData = (data) => {
        $('#data_token').html(data.token);
        $('#data_kadaluarsa').html(data.expired_time);
        if (data.expired_time < new Date().toISOString().slice(0, 19).replace('T', ' ')) {
            $('#data_status').html('<span class="label label-danger">Kadaluarsa</span>');
        } else {
            $('#data_status').html('<span class="label label-success">Aktif</span>');
        }
    }

    const initialLoad = () => {
        <?php if (rbac_can("$url.get")) : ?>
            $.ajax({
                url: "<?= base_url("admin/token-peruri/get") ?>",
                type: "GET",
                dataType: "JSON",
                success: (res) => {
                    if (res.status) {
                        fillData(res.data);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: res.message,
                        })
                    }
                },
                error: (err) => {
                    let msg = err.responseJSON.message ?? "Terjadi kesalahan pada server";
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: msg,
                    })
                }
            });
        <?php endif; ?>
    }

    $(document).ready(function() {
        <?php if (rbac_can("$url.refresh")) : ?>
            $('#refresh_token').on('click', () => {
                Swal.fire({
                    title: 'Perbaharui Token',
                    text: "Apakah anda yakin ingin memperbaharui token ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, perbaharui!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "<?= rbac_url("$url.refresh") ?>",
                            type: "POST",
                            dataType: "JSON",
                            success: function(data) {
                                if (data.status) {
                                    fillData(data.data);
                                    Swal.fire(
                                        'Berhasil!',
                                        'Token berhasil diperbaharui.',
                                        'success'
                                    )
                                } else {
                                    Swal.fire(
                                        'Gagal!',
                                        '<?= $title ?> gagal diperbaharui.',
                                        'error'
                                    )
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                let msg = jqXHR.responseJSON.message ?? '<?= $title ?> gagal diperbaharui.';
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: msg,
                                });
                            }
                        });
                    }
                })
            });
        <?php endif ?>

    });

    initialLoad();
</script>
<?= $this->endSection() ?>