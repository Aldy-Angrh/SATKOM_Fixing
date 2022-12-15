<?php

if(!function_exists('snake2title')) {
    function snake2title($string) {
        $string = str_replace('_', ' ', $string);
        $string = ucwords($string);
        return $string;
    }
}

?>
<div class="table-responsive">
    <table id="table-process" class="table table-bordered table-striped">
        <tbody>
            <?php foreach ($data as $key => $value) : ?>
                <tr>
                    <th><?= snake2title($key) ?></th>
                    <td><?= $value ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>