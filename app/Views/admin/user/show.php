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
        <div class="col-md-12">
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
                    <div class="table-responsive">
                        <table id="table" class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>Nama</th>
                                    <td><?= $data->name ?></td>
                                </tr>
                                <tr>
                                    <th>Username</th>
                                    <td><?= $data->username ?></td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td><?= $data->email ?></td>
                                </tr>
                                <tr>
                                    <th>No HP</th>
                                    <td><?= $data->phone_number ?></td>
                                </tr>
                                <tr>
                                    <th>Role</th>
                                    <td>
                                            <span class="label label-primary"><?= $data->role->name ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <?php if ($data->is_active == 1) : ?>
                                            <span class="label label-success">Aktif</span>
                                        <?php else : ?>
                                            <span class="label label-danger">Tidak Aktif</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>

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
</script>

<script>
    $(document).ready(function() {});
</script>
<?= $this->endSection() ?>