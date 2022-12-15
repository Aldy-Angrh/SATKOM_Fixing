<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>
<?= "$title" ?>
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<link rel="stylesheet" href="<?= base_url('/assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- init modal -->
<div class="modal fade" id="modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modal-title" class="modal-title"></h3>
            </div>
            <div class="modal-body" id="modal-body">
            </div>
            <div class="modal-footer">
                <!-- button close -->
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- end modal -->
<section class="content">
    <div class="row">
        <div class="<?= (rbac_can("admin.v2.file-content.datatable")) ? 'col-md-5' : 'col-md-12' ?>">
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
                                    <th>Deskripsi</th>
                                    <td><?= $data['deskripsi'] ?></td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td><?= $data['status_label'] ?></td>
                                </tr>
                                <tr>
                                    <th>Dibuat pada</th>
                                    <td><?= $data['created_at'] ?></td>
                                </tr>
                                <tr>
                                    <th>Diubah pada</th>
                                    <td><?= $data['updated_at'] ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php if (rbac_can("admin.v2.file-content.datatable")) : ?>
            <div class="col-md-7">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3>Log Proses</h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="table-process" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>ID</th>
                                        <th>File ID</th>
                                        <th>Email Peserta</th>
                                        <th>Email Penandatangan</th>
                                        <th>Aksi</th>
                                        <th>Sign Date</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<!-- register datatable script -->
<script src="<?= base_url('assets/bower_components/datatables.net/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') ?>"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let table;

    $(document).ready(() => {
        <?php if (rbac_can("admin.v2.file-content.datatable")) : ?>
            table = $('#table-process').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": {
                    "url": "<?= rbac_url("admin.v2.file-content.datatable", $data['id']) ?>",
                    "type": "GET"
                },
                "columnDefs": [{
                    "targets": [0, 8],
                    "orderable": false
                }],
                // disable some column
                "columns": [{
                        // NO
                        data: 0,
                        visible: false,
                    },
                    {
                        // ID
                        data: 1,
                        visible: false,
                    },
                    {
                        // File ID
                        data: 2,
                        visible: false,
                    },
                    {
                        // Email Peserta
                        data: 3,
                        visible: true,
                    },
                    {
                        // Email Penandatangan
                        data: 4,
                        visible: true,
                    },
                    {
                        // Aksi
                        data: 5,
                        visible: true,
                    },
                    {
                        // Sign Date
                        data: 6,
                        visible: true,
                    },
                    {
                        // Status
                        data: 7,
                        visible: true,
                    },
                    {
                        // Aksi
                        data: 8,
                        visible: true,
                    },
                ],
                drawCallback: function() {
                    // redirect
                    $('.dtbl-post-action').on('click', function() {
                        let url = $(this).data('url');
                        // post action
                        Swal.fire({
                            title: 'Apakah anda yakin?',
                            text: "Anda tidak dapat mengembalikan aksi jika telah dijalankan!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya, Jalankan aksi!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: url,
                                    type: 'POST',
                                    dataType: 'json',
                                    success: function(response) {
                                        if (response.status) {
                                            Swal.fire(
                                                'Berhasil!',
                                                response.message,
                                                'success'
                                            ).then(() => {
                                                table.ajax.reload();
                                            });
                                        } else {
                                            Swal.fire(
                                                'Gagal!',
                                                response.message,
                                                'error'
                                            );
                                        }
                                    },
                                    error: function() {
                                        Swal.fire(
                                            'Gagal!',
                                            'Terjadi kesalahan pada server',
                                            'error'
                                        );
                                    }
                                });
                            }
                        });
                    });

                    // open modal
                    $('.dtbl-modal').on('click', (event) => {
                        // get data url
                        let url = $(event.currentTarget).data('url');

                        // fill modal
                        $.ajax({
                            url: url + '?modal=true',
                            type: 'GET',
                            dataType: 'json',
                            success: function(response) {
                                // fill modal
                                $('#modal-title').html(response.data.title);
                                $('#modal-body').html(response.data.content);
                                // show modal
                                $('#modal').modal('show');
                            }
                        });
                    });
                },
            });
        <?php endif ?>
    });
</script>
<?= $this->endSection() ?>