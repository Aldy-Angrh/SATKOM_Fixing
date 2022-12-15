<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="<?= base_url('assets/dist/img/avatar5.png'); ?>" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p><?= $this->user->name ?></p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>

    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <?= \App\Models\Rbac\MenuModel::generateMenu() ?>
      <li>
        <a href="#" onclick="confirm('kamu akan logout. Lanjutkan?') && document.getElementById('logout').submit()">
          <i class="fa fa-sign-out"></i> <span>Logout</span>
        </a>
      </li>
    </ul>


  </section>
  <!-- /.sidebar -->
</aside>