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
        <div class="<?= (rbac_can("admin.document-process.datatable")) ? 'col-md-5' : 'col-md-12' ?>">
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
        <?php if (rbac_can("admin.document-process.datatable")) : ?>
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
                                        <th>Email Pemilik</th>
                                        <th>Nama Pemilik</th>
                                        <th>File ID</th>
                                        <th>Status</th>
                                        <th>Dibuat pada</th>
                                        <th>created_by</th>
                                        <th>Diubah pada</th>
                                        <th>updated_by</th>
                                        <th>deleted_at</th>
                                        <th>deleted_by</th>
                                        <th>Description</th>
                                        <th>Data</th>
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
        <?php if (rbac_can("admin.document-process.datatable")) : ?>
            table = $('#table-process').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": {
                    "url": "<?= rbac_url("admin.document-process.datatable", $data['id']) ?>",
                    "type": "GET"
                },
                "columnDefs": [{
                    "targets": [0, 13],
                    "orderable": false
                }],
                // disable some column
                "columns": [{
                        // NO
                        data: 0,
                    },
                    {
                        // ID
                        data: 1,
                        visible: false
                    },
                    {
                        // EMAIL FILE OWNER
                        data: 2,
                    },
                    {
                        // NAME OWNER
                        data: 5,
                    },
                    {
                        // FILE ID
                        data: 4,
                        visible: false
                    },
                    {
                        // STATUS
                        data: 3,
                    },
                    {
                        // CREATED AT
                        data: 6,
                        visible: false
                    },
                    {
                        // CREATED BY
                        data: 7,
                        visible: false
                    },
                    {
                        // UPDATED AT
                        data: 8,
                        visible: false
                    },
                    {
                        // UPDATED BY
                        data: 9,
                        visible: false
                    },
                    {
                        // DELETED AT
                        data: 10,
                        visible: false
                    },
                    {
                        // DELETED BY
                        data: 11,
                        visible: false
                    },
                    {
                        // DESCRIPTION
                        data: 12,
                        visible: false
                    },
                    {
                        // Data
                        data: 13,
                        // visible: false
                    },
                    {
                        // Aksi
                        data: 14,
                    },

                ],
                drawCallback: function() {
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