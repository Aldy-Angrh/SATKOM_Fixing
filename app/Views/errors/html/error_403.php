<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex">

    <title>Whoops!</title>

    <style type="text/css">
        <?= preg_replace('#[\r\n\t ]+#', ' ', file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'debug.css')) ?>
    </style>
</head>

<body>

    <div class="container text-center">

        <h1 class="headline">
            403
        </h1>

        <p class="lead">
            <?= $message ?? 'You don\'t have permission to access this page.' ?>
        </p>

    </div>

</body>

</html>