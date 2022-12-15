<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="content">
  <div class="row">
    <div class="col-md-4 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-aqua"><i class="fa fa-file"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">File Total</span>
          <span class="info-box-number"><?= $file_count ?> <small>file</small></span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-4 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-green"><i class="fa fa-file"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">File Berhasil</span>
          <span class="info-box-number"><?= $file_success_count ?> <small>file</small></span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <!-- fix for small devices only -->
    <div class="clearfix visible-sm-block"></div>

    <div class="col-md-4 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-red"><i class="fa fa-file"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">File Gagal</span>
          <span class="info-box-number"><?= $file_failed_count ?> <small>file</small></span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
  </div>
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Data</h3>
        </div>

        <div class="box-body">
          <div class="table-responsive">
            <?php if (rbac_can("$url.datatable")) : ?>
              <table class="table table-hover" id="table">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>ID</th>
                    <th>Nama File</th>
                    <th>Deskripsi</th>
                    <th>Dibuat pada</th>
                    <th>Diubah pada</th>
                  </tr>
                </thead>
              </table>
            <?php endif ?>
          </div>
        </div>

      </div>

    </div>
  </div>

  <div class="row">

  </div>

</section>
<?= $this->endSection() ?>


<?= $this->section('script') ?>
<!-- register datatable script -->
<script src="<?= base_url('assets/bower_components/datatables.net/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') ?>"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script> -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


<script>
  let table;
  $(document).ready(function() {
    // datatable
    <?php if (rbac_can("$url.datatable")) : ?>
      table = $('#table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: '<?= rbac_url("$url.datatable") ?>',
          type: 'GET',
        },
        orders: [
          [2, 'desc']
        ],
        columnDefs: [{
            targets: [2, 3, 4],
            orderable: true
          },
          {
            targets: [2, 3, 4],
            searchable: true
          },
        ],
        columns: [{
            data: 0,
          },
          <?php $i = 1;
          foreach ($fields as $key => $field) : ?> {
              data: <?= $i++ ?>,
              visible: <?= $field['show'] ? 'true' : 'false' ?>,
            },
          <?php endforeach ?> {
            data: <?= $i++ ?>,
            visible: false,
          }, {
            data: <?= $i++ ?>,
            visible: false,
          }
        ],
        // finish loading
        drawCallback: function() {
          $('.dtbl-redirect').click(function() {
            let url = $(this).data('url');
            if (url) {
              window.location.href = url;
            }
          });
        }
      });

    <?php endif ?>
  });
</script>
<?= $this->endSection() ?>