<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>
<?= "$title" ?>
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<link rel="stylesheet" href="<?= base_url('/assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="content">
    <div class="row">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header">
                    <!-- summary of this page -->
                    <?php if (rbac_can("$url.index")) : ?>
                        <a class="btn btn-default" href="<?= rbac_url("$url.index") ?>">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                    <?php endif; ?>

                    <!-- /.box-tools -->
                </div>
                <div class="box-body">
                    <form action="" id="form-data">

                        <div class="form-group col-md-4">
                            <label for="name">Nama</label>
                            <input type="text" class="form-control" name="name" id="model_name" placeholder="John Doe" value="<?= $data->name ?>">
                        </div>
                        <div class="form-group  col-md-4">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="model_email" placeholder="john.doe@mail.com" value="<?= $data->email ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="phone_number">No HP</label>
                            <input type="text" class="form-control" name="phone_number" id="model_phone_number" placeholder="62856942093812"  value="<?= $data->phone_number ?>">
                        </div>
                        <div class="form-group  col-md-6">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" name="username" id="model_username" placeholder="john.doe" value="<?= $data->username ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" id="model_password" placeholder="*******">
                        </div>
                    </form>
                </div>
                <div class="box-footer">
                    <?php if (rbac_can("$url.store-profile")) : ?>
                        <button type="button" class="btn btn-primary" id="btn-save">Simpan</button>
                    <?php endif; ?>
                    <?php if (rbac_can("admin.dashboard")) : ?>
                        <a href="<?= rbac_url("admin.dashboard") ?>" class="btn btn-default">Dashboard</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box">
                <div class="box-body">
                    <img src="<?= base_url('assets/img/user/' . $data->photo_url) ?>" class="img-responsive" alt="User Image">
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
</script>

<script>
    $(document).ready(function() {
        <?php if (rbac_can("$url.store-profile")) : ?>
            $('#btn-save').click(function() {
                var data = $('#form-data').serialize();
                $.ajax({
                    url: "<?= rbac_url("$url.store-profile") ?>",
                    type: "POST",
                    data: data,
                    dataType: "JSON",
                    success: function(data) {
                        if (data.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: data.message,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // location.reload();
                                }
                            })
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: data.message,
                            })
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Terjadi kesalahan',
                        })
                    }
                });
            });
        <?php endif; ?>
    });
</script>
<?= $this->endSection() ?>