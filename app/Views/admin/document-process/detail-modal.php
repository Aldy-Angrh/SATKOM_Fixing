<?php

if (count($data) > 0) {
    $keys = array_keys($data[0]);
} else {
    $keys = array();
}

if (!function_exists('formatedHeader')) {
    function formatedHeader($header)
    {
        $header = str_replace('_', ' ', $header);
        $header = ucwords($header);
        return $header;
    }
}

?>
<div class="table-responsive">
    <table id="table-process" class="table table-bordered table-striped">
        <thead>
            <tr>
                <?php foreach ($keys as $key) : ?>
                    <th><?= formatedHeader($key) ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php if (count($keys) == 0) : ?>
                <tr>
                    <td colspan="100%" class="text-center">Tidak ada data</td>
                </tr>
            <?php endif; ?>
            <?php foreach ($data as $row) : ?>
                <tr>
                    <?php foreach ($keys as $key) : ?>
                        <td><?= $row[$key] ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>