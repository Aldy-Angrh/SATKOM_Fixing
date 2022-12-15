<?php

use App\Models\User;

$userModel = new User;
$this->user = $userModel->getLoginUser();
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin Page</title>
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
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?= base_url('assets/dist/css/skins/_all-skins.min.css'); ?>">

  <?= $this->renderSection('css') ?>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="sidebar-mini wysihtml5-supported sidebar-mini-expand-feature skin-blue fixed">
  <div class="wrapper">

    <header class="main-header">
      <!-- Logo -->
      <a href="<?= base_url('/'); ?>" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>SAU</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>SAU</b> DIGITAL SIGN</span>
      </a>
      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="<?= base_url('assets/dist/img/avatar5.png'); ?>" class="user-image" alt="User Image">
                <span class="hidden-xs"><?= $this->user->name ?></span>
              </a>
              <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                  <img src="<?= base_url('assets/img/user.png'); ?>" class="img-circle" alt="User Image">

                  <p>
                    <?= $this->user->name ?>
                    <small><?= $this->user->role_id ?></small>
                  </p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                  <div class="pull-left">
                    <?php if (rbac_can('admin.user.profile')) : ?>
                      <a href="<?= rbac_url('admin.user.profile') ?>" class="btn btn-default btn-flat">Profile</a>
                    <?php endif; ?>
                  </div>
                  <div class="pull-right">
                    <button class="btn btn-default btn-flat" onclick="confirm('kamu akan logout. Lanjutkan?') && document.getElementById('logout').submit()">Sign out</button>
                  </div>
                </li>
                <form action="<?= base_url('admin/auth/logout') ?>" method="post" id="logout">

                </form>
              </ul>
            </li>
          </ul>
        </div>
      </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <?= $this->include('layouts/admin_sidebar') ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <section class="content-header">
        <h1>
          <?= $this->renderSection('title') ?>
          <?php if ($this->renderSection('subTitle') != null && $this->renderSection('subTitle') != "") { ?>
            <small><?= $this->renderSection('subTitle') ?></small>
          <?php } ?>
        </h1>
      </section>

      <!-- Main content -->
      <?= $this->renderSection('content') ?>
      <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
      <div class="pull-right hidden-xs">
        <b>Version</b> 1.0
      </div>
      <strong>Copyright &copy; <?= date('Y') ?> SAU-DIGITAL SIGN.</strong> All rights
      reserved.
    </footer>

  </div>
  <!-- ./wrapper -->

  <!-- jQuery 3 -->
  <script src="<?= base_url('assets/bower_components/jquery/dist/jquery.min.js'); ?>"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="<?= base_url('assets/bower_components/jquery-ui/jquery-ui.min.js'); ?>"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button);
  </script>
  <!-- Bootstrap 3.3.7 -->
  <script src="<?= base_url('assets/bower_components/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>
  <!-- Slimscroll -->
  <script src="<?= base_url('assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js'); ?>"></script>
  <!-- FastClick -->
  <script src="<?= base_url('assets/bower_components/fastclick/lib/fastclick.js'); ?>"></script>
  <!-- AdminLTE App -->
  <script src="<?= base_url('assets/dist/js/adminlte.min.js'); ?>"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="<?= base_url('assets/dist/js/demo.js'); ?>"></script>

  <script>
    $(document).ready(function() {
      $('.sidebar-menu').tree()
    })
  </script>

  <?= $this->renderSection('script') ?>
</body>

</html>