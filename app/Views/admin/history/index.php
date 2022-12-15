<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<link rel="stylesheet" href="<?= base_url('/assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content'); ?>
<section class="content">

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Data</h3>
                    <div class="box-tools">
                        <div class="input-group input-group-sm hidden-xs" style="width: 150px;">
                            <!-- button export -->
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-default dropdown-toggle btn-block" data-toggle="dropdown">Export
                                    <span class="fa fa-caret-down"></span></button>
                                <ul class="dropdown-menu">
                                    <li><a href="<?= base_url('admin/history/export/excel') ?>">Excel</a></li>
                                    <li><a href="<?= base_url('admin/history/export/pdf') ?>">PDF</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-body">
                    <div class="table-responsive">
                        <?php if (rbac_can("$url.datatable")) : ?>
                            <table class="table table-hover" id="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>ID</th>
                                        <th>Nama File</th>
                                        <th>Deskripsi</th>
                                        <th>Status</th>
                                        <th>Dibuat pada</th>
                                        <th>Diubah pada</th>
                                        <th>Jumlah Berhasil</th>
                                        <th>Jumlah Gagal</th>
                                        <th>Aksi</th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>
                                            <!-- deskrips -->
                                            <input type="text" class="form-control" id="search-deskripsi" name="cfilter[deskripsi]" placeholder="Deskripsi">
                                        </th>
                                        <th>
                                            <!-- status -->
                                            <select class="form-control" id="search-status" name="cfilter[status]">
                                                <option value="">Semua</option>
                                                <option value="0">Diproses</option>
                                                <option value="1">Sukses</option>
                                            </select>
                                        </th>
                                        <th>
                                            <!-- daterange picker -->
                                            <input type="text" class="form-control daterange" id="search-created_at" name="cfilter[created]" placeholder="Dibuat pada">
                                        </th>
                                        <th>
                                            <!-- daterange picker -->
                                            <input type="text" class="form-control daterange" id="search-updated_at" name="cfilter[updated]" placeholder="Diubah pada">
                                        </th>
                                        <th></th>
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
    let table;
    $(document).ready(function() {
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
                            deskripsi: $('#search-deskripsi').val(),
                            status: $('#search-status').val(),
                            created_at: $('#search-created_at').val(),
                            updated_by: $('#search-updated_at').val(),
                        }
                    }
                },
                orders: [
                    [2, 'desc']
                ],
                columnDefs: [{
                        targets: [0, 7, 8],
                        orderable: false
                    },
                    {
                        targets: [0, 1, 7, 8],
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
                    }, {
                        data: <?= $i++ ?>,
                        visible: true,
                    }, {
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
            $('#search-deskripsi').on('keyup change', function() {
                table.ajax.reload();
            });
            $('#search-status').on('change', function() {
                table.ajax.reload();
            });

        <?php endif ?>
    });
</script>
<?= $this->endSection() ?>