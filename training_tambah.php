<div class="page-header">
    <h1>Tambah training</h1>
</div>
<form method="post">
    <div class="row">
        <div class="col-sm-6">
            <?php if ($_POST) include 'aksi.php' ?>
            <div class="form-group">
                <label>Tanggal <span class="text-danger">*</span></label>
                <input class="form-control" type="date" name="tanggal_training" value="<?= set_value('tanggal_training', date('Y-m-d')) ?>" />
            </div>
            <div class="form-group">
                <label>Produk <span class="text-danger">*</span></label>
                <select class="form-control" name="id_produk">
                    <?= get_produk_option(set_value('id_produk')) ?>
                </select>
            </div>
            <div class="form-group">
                <label>Permintaan <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="permintaan" value="<?= set_value('permintaan') ?>" />
            </div>
            <div class="form-group">
                <label>Persediaan <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="persediaan" value="<?= set_value('persediaan') ?>" />
            </div>
            <div class="form-group">
                <label>Produksi <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="produksi" value="<?= set_value('produksi') ?>" />
            </div>
            <div class="form-group">
                <button class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Simpan</button>
                <a class="btn btn-danger" href="?m=training"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
            </div>
        </div>
    </div>
</form>