<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<link rel="stylesheet" href="<?= base_url('/assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content'); ?>
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
                <button type="submit" class="btn btn-primary" id="btn-save">
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
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Data</h3>
                    <div class="box-tools">
                        <?php if (rbac_can("{$url}.export")) : ?>
                            <div class="input-group input-group-sm hidden-xs" style="width: 150px;">
                                <!-- button export -->
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-default dropdown-toggle btn-block" data-toggle="dropdown">Export
                                        <span class="fa fa-caret-down"></span></button>
                                    <ul class="dropdown-menu">
                                        <li><a href="<?= rbac_url("{$url}.export") ?>">Excel</a></li>
                                    </ul>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="box-body">
                    <div class="table-responsive">
                        <?php if (rbac_can("$url.datatable")) : ?>
                            <table class="table table-hover text-nowrap" id="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>ID</th>
                                        <th>File Csv</th>
                                        <th>Dokumen</th>

                                        <th>Email Peserta</th>
                                        <th>Nama Peserta</th>
                                        <th>Dikirim pada</th>
                                        <th>Disign pada</th>

                                        <th>Email Penandatangan</th>
                                        <th>Nama Penandatangan</th>
                                        <th>Dikirim pada</th>
                                        <th>Disign pada</th>

                                        <th>Status</th>
                                        <th>Result Code</th>
                                        <th>Result Desc</th>
                                        <th>Aksi</th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th>
                                            <input type="text" class="form-control" id="search-file_csv" name="cfilter[file_csv]" placeholder="Nama File">
                                        </th>
                                        <th>
                                            <!-- nama file -->
                                            <input type="text" class="form-control" id="search-file_name" name="cfilter[file_name]" placeholder="Nama File">
                                        </th>
                                        <th>
                                            <!-- nama peserta -->
                                            <input type="text" class="form-control" id="search-nama_peserta" name="cfilter[nama_peserta]" placeholder="Nama Peserta">
                                        </th>
                                        <th>
                                            <!-- email peserta-->
                                            <input type="text" class="form-control" id="search-email_peserta" name="cfilter[email_peserta]" placeholder="Email Peserta">
                                        </th>

                                        <th>
                                            <!-- daterange picker -->
                                            <input type="text" class="form-control daterange" id="search-send_at" name="cfilter[send_date]" placeholder="Dikirm pada">
                                        </th>
                                        <th>
                                            <!-- daterange picker -->
                                            <input type="text" class="form-control daterange" id="search-sign_at" name="cfilter[sign_date]" placeholder="Disign pada">
                                        </th>

                                        <th>
                                            <!-- email -->
                                            <input type="text" class="form-control" id="search-email_penandatangan" name="cfilter[email_penandatangan]" placeholder="Email">
                                        </th>
                                        <th>
                                            <!-- email -->
                                            <input type="text" class="form-control" id="search-nama_penandatangan" name="cfilter[nama_penandatangan]" placeholder="Email">
                                        </th>

                                        <th>
                                            <!-- daterange picker -->
                                            <input type="text" class="form-control daterange" id="search-penandatangan_send_at" name="cfilter[penandatangan_send_date]" placeholder="Dikirm pada">
                                        </th>
                                        <th>
                                            <!-- daterange picker -->
                                            <input type="text" class="form-control daterange" id="search-penandatangan_sign_at" name="cfilter[penandatangan_sign_date]" placeholder="Disign pada">
                                        </th>

                                        <th>
                                            <!-- status -->
                                            <select class="form-control" id="search-status" name="cfilter[status]">
                                            </select>
                                        </th>


                                        <th>
                                            <input type="text" class="form-control" id="search-result_code" name="cfilter[result_code]" placeholder="Result Code">
                                        </th>
                                        <th>
                                            <input type="text" class="form-control" id="search-result_desc" name="cfilter[result_desc]" placeholder="Result Desc">
                                        </th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                            </table>
                        <?php endif ?>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>

<?= $this->endSection(); ?>

<?= $this->section('script') ?>
<!-- register datatable script -->
<script src="<?= base_url('assets/bower_components/datatables.net/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') ?>"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script> -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


<script>
    const save = (id) => {
        let url = $('#form-data').attr('action');
        $.ajax({
            url,
            type: 'PUT',
            dataType: 'json',
            data: $('#form-data').serialize(),
            id: $(this).attr("model_id"),
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

    const handleResponse = (res) => {
        if (res.status) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: res.message,
            });

            // if modal is open, close it
            $('#modal').modal('hide');

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

    let table;
    $(document).ready(function() {
        // fill select status
        $.ajax({
            url: "<?= base_url("admin/v2/history/status") ?>",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                let html =
                    `<option value="">-- Pilih Status --</option>`;
                // parse object to array
                let arr = Object.entries(data);
                // loop array
                arr.forEach(function(item) {
                    html += `<option value="${item[0]}">${item[1]}</option>`;
                });
                $('#search-status').html(html);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });

        // datatable
        <?php if (rbac_can("$url.datatable")) : ?>
            table = $('#table').DataTable({
                orderCellsTop: true,
                fixedHeader: true,
                processing: true,
                serverSide: true,
                searching: false,
                ajax: {
                    url: '<?= rbac_url("$url.datatable") ?>',
                    type: 'GET',
                    data: function(d) {
                        d.cfilter = {
                            file_csv: $('#search-file_csv').val(),
                            file_name: $('#search-file_name').val(),
                            status: $('#search-status').val(),
                            send_date: $('#search-send_at').val(),
                            sign_date: $('#search-sign_at').val(),
                            penandatangan_send_date: $('#search-penandatangan_send_at').val(),
                            penandatangan_sign_date: $('#search-penandatangan_sign_at').val(),
                            email_penandatangan: $('#search-email_penandatangan').val(),
                            nama_penandatangan: $('#search-nama_penandatangan').val(),
                            email_peserta: $('#search-email_peserta').val(),
                            nama_peserta: $('#search-nama_peserta').val(),
                            result_code: $('#search-result_code').val(),
                            result_desc: $('#search-result_desc').val(),
                        }
                    }
                },
                orders: [
                    [5, 'desc']
                ],
                columnDefs: [{
                        targets: [0, 5],
                        orderable: false
                    },
                    {
                        targets: [0, 1, 5],
                        searchable: false
                    },
                ],
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
                    $('.dtbl-redirect').click(function() {
                        let url = $(this).data('url');
                        if (url) {
                            window.location.href = url;
                        }
                    });

                    // redirect
                    $('.dtbl-post-action').on('click', function() {
                        let url = $(this).data('url');
                        console.log(url)
                        if (!url) {
                            return;
                        }
                        // post action
                        if (!url) {
                            return;
                        }

                        // fill modal
                        $.ajax({
                            url: url + '?modal=true',
                            type: 'GET',
                            dataType: 'json',
                            success: function(response) {
                                // fill modal
                                $('#modal-title').html(response.data.title);
                                $('#modal-body').html(response.data.content);
                                $('#form-data').attr('action', response.data.url);
                                // show modal
                                $('#modal').modal('show');
                            }
                        });
                    });

                    $('.dtbl-post-action-exp').on('click', function() {
                        let url = $(this).data('url');

                        if (!url) {
                            return;
                        }
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

                        console.log(url)

                        if (!url) {
                            return;
                        }

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
                }
            });

            // initialize date range picker without default value
            $('.daterange').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                }
            }, function(start, end, label) {
                // set value to input
                $(this.element).val(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
                table.ajax.reload();
            });

            // filter
            $('#search-file_csv').on('keyup change', function() {
                table.ajax.reload();
            });
            $('#search-file_name').on('keyup change', function() {
                table.ajax.reload();
            });
            $('#search-email_peserta').on('keyup change', function() {
                table.ajax.reload();
            });
            $('#search-result_code').on('keyup change', function() {
                table.ajax.reload();
            });
            $('#search-result_desc').on('keyup change', function() {
                table.ajax.reload();
            });
            $('#search-email_penandatangan').on('keyup change', function() {
                table.ajax.reload();
            });
            $('#search-status').on('change', function() {
                table.ajax.reload();
            });

        <?php endif ?>

        $('#btn-save').click(function() {
            const id = $('#model_id').val();
            save(id);
        });
    });
</script>
<?= $this->endSection() ?>