<?php

$menu = new \App\Models\Rbac\MenuModel();

$menu = $menu->select('id, name, controller, action, icon, order, parent_id')->findAll();

?>
<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<link rel="stylesheet" href="<?= base_url('/assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('css/iconpicker.css') ?>">
<link rel="stylesheet" href="<?= base_url('css/nestable.css') ?>">
</link>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Sortable Menu</h3>
                    <?php if (rbac_can("$url.store")) : ?>
                        <!-- button save sortable -->
                        <div class="box-tools">
                            <button type="button" class="btn btn-primary" id="btn-simpan-ordable">
                                <i class="fa fa-save fa-fw"></i> Simpan
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="box-body">
                    <div class="dd" id="orderable"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header">
                    <!-- summary of this page -->
                    <h3 class="box-title"><?= $subtitle ?></h3>
                </div>
                <div class="box-body">
                    <form method="post" id="form-data">
                        <input type="hidden" name="id" id="model_id">
                        <div class="form-group" id="form-group-name">
                            <label for="name">Nama</label>
                            <input type="text" class="form-control" name="name" id="model_name" placeholder="Nama">
                        </div>
                        <div class="form-group" id="form-group-controller">
                            <label for="controller">Kontroler</label>
                            <input type="text" class="form-control" name="controller" id="model_controller" placeholder="Controller">
                        </div>
                        <div class="form-group" id="form-group-action">
                            <label for="action">Aksi</label>
                            <input type="text" class="form-control" name="action" id="model_action" placeholder="Action">
                        </div>
                        <div class="form-group" id="form-group-icon">
                            <label for="icon">Ikon</label>
                            <input type="text" class="form-control iconpicker" name="icon" id="model_icon" placeholder="Ikon" autocomplete="off">
                        </div>
                    </form>
                </div>
                <div class="box-footer">
                    <?php if (rbac_can("$url.update")) : ?>
                        <button type="button" class="btn btn-primary mr-1 mb-1" id="btn-ubah">
                            <i class="fa fa-save"></i>
                            Ubah
                        </button>
                    <?php endif; ?>
                    <?php if (rbac_can("$url.store")) : ?>
                        <button type="button" class="btn btn-success mr-1 mb-1" id="btn-simpan">
                            <i class="fa fa-save"></i>
                            Simpan
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<!-- register datatable script -->
<script src="//code.jquery.com/jquery-migrate-3.0.0.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= base_url('js/iconpicker.js') ?>"></script>
<script src="<?= base_url('js/jquery.nestable.js') ?>"></script>
<script>
    let orderable, list_orderable;

    const openModal = (title, data = null) => {
        $('#modal-title').html(title);

        if (data) {
            for (const key in data) {
                $(`#model_${key}`).val(data[key]);
            }
        } else {
            $('#form-data').trigger('reset');
        }
    }
</script>
<script>
    const edit = (url) => {
        $.ajax({
            url,
            type: 'GET',
            dataType: 'json',
            success: (res) => {
                openModal('Edit Data', res);
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

    <?php if (rbac_can("$url.store")) : ?>
        const store = () => {
            $.ajax({
                url: `<?= rbac_url("$url.store") ?>`,
                type: 'POST',
                dataType: 'json',
                data: $('#form-data').serialize(),
                success: (res) => {
                    handleResponse(res);
                },
                error: (err) => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: err.responseJSON.message,
                    });
                }
            });
        }
    <?php endif; ?>

    <?php if (rbac_can("$url.update")) : ?>
        const update = (url) => {
            $.ajax({
                url,
                type: 'PUT',
                dataType: 'json',
                data: $('#form-data').serialize(),
                success: (res) => {
                    handleResponse(res);
                    // remove data url
                    $('#btn-ubah').attr('data-url', '');
                    $('#model_id').val('');
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
    <?php endif; ?>

    <?php if (rbac_can("$url.destroy")) : ?>
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
    <?php endif; ?>

    const handleResponse = (res) => {
        if (res.status) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: res.message,
            });

            // reset form
            $('#form-data').trigger('reset');

            // reload orderable
            firstInitOrderable();
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: res.message,
            });
        }
    }

    <?php if (rbac_can("$url.orderable")) : ?>
        var updateWhenOrder = function(e) {
            var list = e.length ? e : $(e.target);
            if (window.JSON) {
                list_orderable = window.JSON.stringify(list.nestable('serialize'));
            } else {
                console.log('JSON browser support required for this demo.');
            }
        };

        const buildOrderable = () => {
            orderable = $('#orderable')
                .nestable()
                .on('click', '.dd-edit', function() {
                    const urlUpdate = $(this).data('url-update');
                    const urlShow = $(this).data('url-show');
                    if (urlUpdate && urlShow) {
                        edit(urlShow);
                        $('#btn-ubah').attr('data-url', urlUpdate);
                    }
                })
                .on('click', '.dd-delete', function() {
                    const url = $(this).data('url');
                    if (url) {
                        destroy(url);
                    }
                })
                .on('change', updateWhenOrder);
        }

        const firstInitOrderable = () => {
            $.ajax({
                url: `<?= rbac_url($url . '.orderable') ?>`,
                type: 'GET',
                dataType: 'json',
                success: (res) => {
                    $('#orderable').html(res.html);
                    buildOrderable();
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
    <?php endif; ?>
</script>

<script>
    $(document).ready(function() {
        // icon picker 
        $('.iconpicker').iconpicker();

        <?php if (rbac_can("$url.store")) : ?>
            $('#btn-simpan').click(function() {
                store();
            });
        <?php endif; ?>

        <?php if (rbac_can("$url.update")) : ?>
            $('#btn-ubah').click(function() {
                let url = $('#btn-ubah').attr('data-url');
                if (!url) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Data tidak ditemukan',
                    });
                } else {
                    update(url);
                }
            });
        <?php endif; ?>

        $('#btn-simpan-ordable').on('click', () => {
            $.ajax({
                url: `<?= rbac_url("$url.update-order") ?>`,
                type: 'POST',
                dataType: 'json',
                data: {
                    data: list_orderable
                },
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
        });

    });

    <?php if (rbac_can("$url.orderable")) : ?>
        firstInitOrderable();
    <?php endif; ?>
</script>
<?= $this->endSection() ?>