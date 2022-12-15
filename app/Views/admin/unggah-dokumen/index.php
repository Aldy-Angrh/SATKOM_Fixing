<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="content">
    <!-- row reverse -->
    <div class="row">
        <div class="col-md-7">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Signers</h3>
                </div>
                <div class="box-body">
                    <!-- dynamic multiple input of signer -->
                    <div class="form-group">
                        <select class="form-control signers" name="data_signer[]" required style="margin-top: 1rem;">
                            <option value="">Pilih Penandatangan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control signers" name="data_signer[]" required style="margin-top: 1rem;">
                            <option value="">Pilih Penandatangan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control signers" name="data_signer[]" required style="margin-top: 1rem;">
                            <option value="">Pilih Penandatangan</option>
                        </select>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="box box-primary">
                <div class="box-header">
                    <!-- summary of this page -->
                    <h3 class="box-title"><?= $subtitle ?></h3>
                </div>
                <div class="box-body">
                    <div id="preview"></div>
                    <div class="form-group">
                        <label for="data-deskripsi">Deskripsi</label>
                        <input type="text" name="data_deskripsi" id="data_deskripsi" class="form-control" placeholder="Deskripsi">
                    </div>
                    <!-- form upload file -->
                    <div class="form-group">
                        <input type="file" class="form-control" accept="application/pdf" name="data_file" id="data_file" required>
                    </div>

                </div>
                <div class="box-footer">
                    <button type="button" class="btn btn-primary" id="upload_file" style="margin-top: 1rem">
                        <i class="fa fa-upload fa-fw"></i> Unggah Dokumen
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    const LoadSigner = () => {
        <?php if (rbac_can("admin.user.select2")) : ?>
            $('.signers').each((index, element) => {
                $(element).select2({
                    ajax: {
                        url: '<?= rbac_url("admin.user.select2") ?>',
                        data: (params) => {
                            return {
                                q: params.term,
                            }
                        },
                        dataType: 'json',
                        delay: 250,
                        minimumInputLength: 3,
                    },
                    placeholder: 'Pilih Penandatangan',
                });
            });
        <?php endif; ?>
    }
    $(document).ready(() => {})
    LoadSigner();
</script>
<?= $this->endSection() ?>