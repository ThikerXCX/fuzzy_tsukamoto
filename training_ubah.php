<?php
$row = $db->get_row("SELECT * FROM tb_training WHERE id_training='$_GET[ID]'");
?>
<div class="page-header">
    <h1>Ubah training</h1>
</div>
<form method="post">
    <div class="row">
        <div class="col-sm-6">
            <?php if ($_POST) include 'aksi.php' ?>
            <div class="form-group">
                <label>Tanggal <span class="text-danger">*</span></label>
                <input class="form-control" type="date" name="tanggal_training" value="<?= set_value('tanggal_training', $row->tanggal_training) ?>" />
            </div>
            <div class="form-group">
                <label>Produk <span class="text-danger">*</span></label>
                <select class="form-control" name="id_produk">
                    <?= get_produk_option(set_value('id_produk', $row->id_produk)) ?>
                </select>
            </div>
            <div class="form-group">
                <label>Bentuk <span class="text-danger">*</span></label>
                <select class="form-control" name="bentuk" id="bentuk" >
                <option value="1" <?php echo $row->bentuk == 1 ?"Selected":"" ?>>Kecil</option>
                <option value="2" <?php echo $row->bentuk == 2 ?"Selected":"" ?>>Setengah Mangkok</option>
                <option value="3" <?php echo $row->bentuk == 3 ?"Selected":"" ?>>Mangkok</option>
                </select>
            </div>
            <div class="form-group">
                <label>Warna <span class="text-danger">*</span></label>
                <select class="form-control" name="warna" id="warna" value="<?= set_value('warna') ?>">
                <option value="1" <?php echo $row->bentuk == 1 ?"Selected":"" ?>>Kuning Pekat</option>
                <option value="2" <?php echo $row->bentuk == 2 ?"Selected":"" ?>>Kuning</option>
                <option value="3" <?php echo $row->bentuk == 3 ?"Selected":"" ?>>Putih</option>
                </select>
            </div>
            <div class="form-group">
                <label>Ukuran <span class="text-danger">*</span></label>
                <select class="form-control" name="ukuran" id="ukuran" value="<?= set_value('ukuran') ?>">
                <option value="1" <?php echo $row->bentuk == 1 ?"Selected":"" ?>>Kecil</option>
                <option value="2" <?php echo $row->bentuk == 2 ?"Selected":"" ?>>Sedang</option>
                <option value="3" <?php echo $row->bentuk == 3 ?"Selected":"" ?>>Besar</option>
                </select>
            </div>
            <div class="form-group">
                <label>Kondisi <span class="text-danger">*</span></label>
                <select class="form-control" name="kondisi" id="kondisi" value="<?= set_value('kondisi') ?>">
                <option value="1" <?php echo $row->bentuk == 1 ?"Selected":"" ?>>Berbulu</option>
                <option value="2" <?php echo $row->bentuk == 2 ?"Selected":"" ?>>Kotor</option>
                <option value="3" <?php echo $row->bentuk == 3 ?"Selected":"" ?>>Bersih</option>
                </select>
            </div>
            <div class="form-group">
                <label>Tekstur <span class="text-danger">*</span></label>
                <select class="form-control" name="tekstur" id="tekstur" value="<?= set_value('tekstur') ?>">
                <option value="1" <?php echo $row->bentuk == 1 ?"Selected":"" ?>>Sangat Keras</option>
                <option value="2" <?php echo $row->bentuk == 2 ?"Selected":"" ?>>Lentur</option>
                <option value="3" <?php echo $row->bentuk == 3 ?"Selected":"" ?>>Keras</option>
                </select>
            </div>
            <div class="form-group">
                <label>Jenis Sarang <span class="text-danger">*</span></label>
                <select class="form-control" name="jenis_sarang" id="jenis_sarang" value="<?= set_value('jenis_sarang') ?>">
                <option value="c" <?php echo $row->bentuk == 'c' ?"Selected":"" ?>>C</option>
                <option value="b" <?php echo $row->bentuk == 'b' ?"Selected":"" ?>>B</option>
                <option value="a"<?php echo $row->bentuk == "a" ?"Selected":"" ?>>A</option>
                </select>
            </div>
            <div class="form-group">
                <label for="keterangan">
                    Jenis Sarang <span class="text-danger">*</span>
                </label>
                <input type="number" class="form-control" name="keterangan" id="keterangan" value="<?= set_value('keterangan',$row->keterangan)?>">
            </div>
            <div class="form-group">
                <button class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Simpan</button>
                <a class="btn btn-danger" href="?m=training"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
            </div>
        </div>
    </div>
</form>