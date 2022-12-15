<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SAU - DIGITAL SIGN | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?= base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css'); ?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url('assets/bower_components/font-awesome/css/font-awesome.min.css'); ?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?= base_url('assets/bower_components/Ionicons/css/ionicons.min.css'); ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('assets/dist/css/AdminLTE.min.css'); ?>">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?= base_url('assets/plugins/iCheck/square/blue.css'); ?>">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
      <div style="flex: 1;flex-direction: row;justify-content: space-between">
        <img src="<?= base_url('/img/sau.png'); ?>" alt="Logo" style="width: 75px;height:auto;display:inline-block!important;" align="left">
        <img src="<?= base_url('/img/bri.png'); ?>" alt="Logo" style="width: 75px;height:auto;display:inline-block!important;" align="right">
      </div>
      <img src="<?= base_url('/img/ds.png'); ?>" alt="Logo" style="width: 100%;height:auto;display:inline-block!important;padding: 3rem;" align="center">

      <p class="login-box-msg">Sign in to start your session</p>

      <form action="<?= base_url('admin/auth/login'); ?>" method="post">
        <?php
        if (session()->has('errors')) { ?>
          <div class="callout callout-danger" style="padding: 5px;">
            <ul style="padding-left: 20px;">
              <?php foreach (session()->getFlashdata('errors') as $key => $valueError) { ?>
                <li>
                  <p><?= $valueError ?></p>
                </li>
              <?php } ?>
            </ul>
          </div>
        <?php } ?>
        <div class="form-group has-feedback">
          <input type="text" class="form-control" placeholder="username" name="username" value="<?= old('username') ?>">
          <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="password" class="form-control" placeholder="Password" name="password">
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-xs-12">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

    </div>
    <!-- /.login-box-body -->
  </div>
  <!-- /.login-box -->

  <!-- jQuery 3 -->
  <script src="<?= base_url('assets/bower_components/jquery/dist/jquery.min.js'); ?>"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="<?= base_url('assets/bower_components/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>
  <!-- iCheck -->
  <script src="<?= base_url('assets/plugins/iCheck/icheck.min.js'); ?>"></script>
  <script>
    $(function() {
      $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' /* optional */
      });
    });
  </script>
</body>

</html>