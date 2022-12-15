<?php


if (!file_exists('snake_case')) {
    function snake_case($string, $delimiter = '_')
    {
        $replace = '$1' . $delimiter . '$2';

        return strtolower(preg_replace(
            '/(?<=\d)(?=[A-Za-z])|(?<=[A-Za-z])(?=\d)|(?<=[a-z])(?=[A-Z])/',
            $replace,
            $string
        ));
    }
}
