<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php

if (!function_exists('nestedChildren')) {
    function nestedChildren($menu, $level = 1)
    {
        $template = "";
        $nextlevel = $level + 1;
        $checked  = ($menu['has_access']) ? 'checked' : '';

        if (count($menu['children'])) :
            if ($level == 1) :
                $template .= "<ul class='list-unstyled' style='margin-left: {$level}rem'>";
                // $template .= "<div class='form-group'>";
                $template .= "<label>";
                $template .= "<input type='checkbox' class='flat-red' id='menu-{$menu['id']}' name='menu[]' value='{$menu['id']}' style='margin-right: 1rem;' $checked>";
                $template .= $menu['name'];
                $template .= "</label>";
            // $template .= '</div>';
            endif;
            $template .= "<ul class='list-unstyled' style='margin-left: {$nextlevel}rem'>";
            foreach ($menu['children'] as $subMenu) :
                $checked  = ($subMenu['has_access']) ? 'checked' : '';

                $template .= '<li>';
                $template .= '<label>';
                $template .= "<input type='checkbox' class='flat-red' id='menu-{$subMenu['id']}' name='sub_menu[]' value='{$subMenu['id']}' style='margin-right: 1rem;' $checked>";
                $template .= $subMenu['name'];
                $template .= '</label>';
                $template .= '</li>';
                if ($subMenu['children']) {
                    $template .= nestedChildren($subMenu, $nextlevel);
                }
            endforeach;
            $template .= '</ul>';
            if ($level == 1) :
                $template .= '</ul>';
            endif;
        else :
            $template .= "<ul class='list-unstyled' style='margin-left: {$level}rem'>";
            // $template .= "<div class='form-group'>";
            $template .= "<label>";
            $template .= "<input type='checkbox' class='flat-red' id='menu-{$menu['id']}' name='menu[]' value='{$menu['id']}' style='margin-right: 1rem;' $checked>";
            $template .= $menu['name'];
            $template .= "</label>";
            // $template .= '</div>';
            $template .= '</ul>';
        endif;

        return $template;
    }
}

?>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header">
                    <!-- summary of this page -->
                    <h3 class="box-title"><?= $subtitle ?></h3>
                </div>
                <div class="box-body">
                    <!-- nested checkbox of menu -->
                    <?php foreach ($menus as $menu) : ?>
                        <?= nestedChildren($menu) ?>
                    <?php endforeach; ?>
                </div>
                <div class="box-footer">

                    <?php if (rbac_can("$url.save-menu")) : ?>
                        <!-- save button -->
                        <button type="submit" class="btn btn-primary" id="btn-save">Simpan</button>
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
</script>

<script>
    $(document).ready(function() {
        <?php if (rbac_can("$url.save-menu")) : ?>
            $('#btn-save').click(function() {
                const id = $('#model_<?= $primary_key ?>').val();
                const menu = $('input[name="menu[]"]:checked').map(function() {
                    return this.value;
                }).get();
                const sub_menu = $('input[name="sub_menu[]"]:checked').map(function() {
                    return this.value;
                }).get();

                // merge menu and sub_menu
                const data = [
                    ...menu,
                    ...sub_menu
                ];

                $.ajax({
                    url: "<?= rbac_url("$url.save-menu", $role->id) ?>",
                    type: "POST",
                    data: {
                        data: data
                    },
                    dataType: "JSON",
                    success: function(data) {
                        if (data.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: data.message,
                                showConfirmButton: false,
                                timer: 1500
                            }).then((result) => {
                                // refresh page
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: data.message,
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
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
    });
</script>
<?= $this->endSection() ?>