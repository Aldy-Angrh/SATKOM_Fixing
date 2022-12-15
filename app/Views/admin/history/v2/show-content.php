<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<link rel="stylesheet" href="<?= base_url('/assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content'); ?>
<?php

if (!function_exists('snake2title')) {
    function snake2title($string)
    {
        $string = str_replace('_', ' ', $string);
        $string = ucwords($string);
        return $string;
    }
}

?>


<section class="content">

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">

                    <?php if (rbac_can("$url.index")) : ?>
                        <a class="btn btn-default" href="<?= rbac_url("$url.index") ?>">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                    <?php endif; ?>
                </div>


                <div class="box-body">
               
                        <div class="table-responsive">
                            <table id="table-process" class="table table-bordered table-striped">
                                <tbody>
                                    <?php foreach ($data as $key => $value) : ?>
                                        <tr>
                                            <th><?= snake2title($key) ?></th>
                                            <td><?= $value ?? '-' ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                 

                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>

<?= $this->endSection() ?>