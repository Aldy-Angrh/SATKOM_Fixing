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

<div class="table-responsive">

    <form method="post" id="form-data" action="">
        <table id="table-process" class="table table-bordered table-striped">
            <tbody>
                <!-- <tr>
                    <th>Id</th>
                    <td><?= $data['id'] ?></td>
                </tr> -->
                <tr>
                    <th>Status</th>
                    <td><?= $data['status'] ?></td>
                </tr>
                <input type="hidden" name="id" id="model_id" value="<?= $data['id'] ?>">
                <tr>
                    <th>Email Penandatangan</th>
                    <td><input type="text" value="<?= $data['email_penandatangan'] ?>" id="model_email_penandatangan" name="email_penandatangan" required class="form-control"></td>
                </tr>
                <tr>
                    <th>Email Peserta</th>
                    <td><input type="text" value="<?= $data['email_peserta'] ?>" id="model_email_peserta" name="email_peserta" required class="form-control"></td>
                </tr>
            </tbody>
        </table>
        <form>
</div>