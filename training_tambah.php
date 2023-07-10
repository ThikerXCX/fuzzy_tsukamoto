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
                <label>Bentuk <span class="text-danger">*</span></label>
                <select class="form-control" name="bentuk" id="bentuk" value="<?= set_value('bentuk') ?>">
                <option value="1">Kecil</option>
                <option value="2">Setengah Mangkok</option>
                <option value="3">Mangkok</option>
                </select>
            </div>
            <div class="form-group">
                <label>Warna <span class="text-danger">*</span></label>
                <select class="form-control" name="warna" id="warna" value="<?= set_value('warna') ?>">
                <option value="1">Kuning Pekat</option>
                <option value="2">Kuning</option>
                <option value="3">Putih</option>
                </select>
            </div>
            <div class="form-group">
                <label>Ukuran <span class="text-danger">*</span></label>
                <select class="form-control" name="ukuran" id="ukuran" value="<?= set_value('ukuran') ?>">
                <option value="1">Kecil</option>
                <option value="2">Sedang</option>
                <option value="3">Besar</option>
                </select>
            </div>
            <div class="form-group">
                <label>Kondisi <span class="text-danger">*</span></label>
                <select class="form-control" name="kondisi" id="kondisi" value="<?= set_value('kondisi') ?>">
                <option value="1">Berbulu</option>
                <option value="2">Kotor</option>
                <option value="3">Bersih</option>
                </select>
            </div>
            <div class="form-group">
                <label>Tekstur <span class="text-danger">*</span></label>
                <select class="form-control" name="tekstur" id="tekstur" value="<?= set_value('tekstur') ?>">
                <option value="1">Sangat Keras</option>
                <option value="2">Lentur</option>
                <option value="3">Keras</option>
                </select>
            </div>
            <div class="form-group">
                <label>Jenis Sarang <span class="text-danger">*</span></label>
                <select class="form-control" name="jenis_sarang" id="jenis_sarang" value="<?= set_value('jenis_sarang') ?>">
                <option value="C">C</option>
                <option value="B">B</option>
                <option value="A">A</option>
                </select>
            </div>
            <div class="form-group">
                <label for="keterangan">
                    Jenis Sarang <span class="text-danger">*</span>
                </label>
                <input type="number" class="form-control" name="keterangan" id="keterangan" value="<?= set_value('keterangan')?>">
            </div>
            <div class="form-group">
                <button class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Simpan</button>
                <a class="btn btn-danger" href="?m=training"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
            </div>
        </div>
    </div>
</form>