<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<link rel="stylesheet" href="<?= base_url('/assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- init modal -->
<div class="modal fade" id="modal-form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modal-title" class="modal-title"></h3>
            </div>

            <div class="modal-body" id="modal-body">
                <form method="post" id="form-data">
                    <input type="hidden" name="id" id="model_id">
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control" name="name" id="model_name" placeholder="Administrator">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <!-- button submit -->
                <button type="button" class="btn btn-primary" id="btn-save">
                    <i class="fa fa-save"></i>
                    Simpan
                </button>
                <!-- button close -->
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- end modal -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header">
                    <!-- summary of this page -->
                    <h3 class="box-title"><?= $subtitle ?></h3>
                    <?php if (rbac_can("$url.store")) : ?>
                        <div class="box-tools">
                            <!-- open modal  -->
                            <button type="button" class="btn btn-primary" onclick="openModal('Tambah Data', '<?= rbac_url("$url.store") ?>')">
                                <i class="fa fa-plus fa-fw"></i> Tambahkan <?= $title ?>
                            </button>
                        </div>
                    <?php endif; ?>

                    <!-- /.box-tools -->
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <?php foreach ($fields as $key => $field) : ?>
                                        <th><?= $field['label'] ?></th>
                                    <?php endforeach ?>
                                    <th>Action</th>
                                </tr>
                            </thead>
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
    let table;

    const openModal = (title, url, data = null) => {
        $('#modal-title').html(title);
        $('#modal-form').modal('show');

        // set form url
        $('#form-data').attr('action', url);

        if (data) {
            for (const key in data) {
                $(`#model_${key}`).val(data[key]);
            }
        } else {
            $('#model_id').val('');
            $('#form-data').trigger('reset');
        }
    }
</script>
<script>
    const edit = (url, urlUpdate) => {
        $.ajax({
            url,
            type: 'GET',
            dataType: 'json',
            header: {
                'accept': 'application/json',
            },
            success: (res) => {
                openModal('Edit Data', urlUpdate, res);
            },
            error: (err) => {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                });
            }
        });
    }

    const save = (id = null) => {
        let url = $('#form-data').attr('action');
        $.ajax({
            url,
            type: id ? 'PUT' : 'POST',
            dataType: 'json',
            data: $('#form-data').serialize(),
            success: (res) => {
                handleResponse(res);
            },
            error: (err) => {
                // swal error notification
                Swal.fire(
                    'Error!',
                    'Something went wrong!',
                    'error'
                )
            }
        });
    }

    const destroy = (url) => {
        // confirm delete
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url,
                    type: 'DELETE',
                    dataType: 'json',
                    success: (res) => {
                        handleResponse(res);
                    },
                    error: (err) => {
                        // swal error notification
                        Swal.fire(
                            'Error!',
                            'Something went wrong!',
                            'error'
                        )
                    }
                });
            } else {
                Swal.fire(
                    'Batal',
                    'Data tidak jadi dihapus',
                    'error'
                )
            }
        });
    }

    const handleResponse = (res) => {
        if (res.status) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: res.message,
            });

            // if modal is open, close it
            $('#modal-form').modal('hide');

            // reload table
            if (table) {
                table.ajax.reload();
            }
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: res.message,
            });
        }
    }
</script>

<script>
    $(document).ready(function() {
        // datatable
        <?php if (rbac_can("$url.datatable")) : ?>
            table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '<?= rbac_url("$url.datatable") ?>',
                    type: 'GET',
                },
                orders: [
                    [2, 'desc']
                ],
                columnDefs: [{
                    targets: [0],
                    orderable: false
                }, ],
                columns: [{
                        data: 0,
                    },
                    <?php $i = 1;
                    foreach ($fields as $key => $field) : ?> {
                            data: <?= $i++ ?>,
                            visible: <?= $field['show'] ? 'true' : 'false' ?>,
                        },
                    <?php endforeach ?> {
                        data: <?= $i++ ?>,
                        visible: true,
                    },
                ],
                // finish loading
                drawCallback: function() {
                    $('.dtbl-edit').click(function() {
                        let urlShow = $(this).data('url-show');
                        let urlUpdate = $(this).data('url-update');
                        if (urlShow && urlUpdate) {
                            edit(urlShow, urlUpdate);
                        }
                    });

                    $('.dtbl-destroy').click(function() {
                        let url = $(this).data('url');
                        if (url) {
                            destroy(url);
                        }
                    });

                    $('.dtbl-redirect').click(function() {
                        let url = $(this).data('url');

                        if (url) {
                            window.location.href = url;
                        }
                    });
                }
            });
        <?php endif ?>

        $('#btn-save').click(function() {
            const id = $('#model_<?= $primary_key ?>').val();
            if (id) {
                save(id);
            } else {
                save();
            }
        });
    });
</script>
<?= $this->endSection() ?>