<div class="page-header">
    <h1>Perhitungan</h1>
</div>
<?php
$awal = set_value('awal', $db->get_var("SELECT MIN(tanggal_training) FROM tb_training"));
$akhir = set_value('akhir', $db->get_var("SELECT MAX(tanggal_training) FROM tb_training"));
?>
<form method="post">
    <div class="row">
        <div class="col-sm-6">
            <?php if ($_POST) include 'aksi.php' ?>
            <div class="form-group">
                <label>Awal Training<span class="text-danger">*</span></label>
                <input class="form-control" type="date" name="awal" value="<?= $awal ?>" />
            </div>
            <div class="form-group">
                <label>Akhir Training<span class="text-danger">*</span></label>
                <input class="form-control" type="date" name="akhir" value="<?= $akhir ?>" />
            </div>
            <div class="form-group">
                <label>Tanggal Perhitungan <span class="text-danger">*</span></label>
                <input class="form-control" type="date" name="tanggal_hasil" value="<?= set_value('tanggal_hasil', date('Y-m-d')) ?>" />
            </div>
            <div class="form-group">
                <label>Produk <span class="text-danger">*</span></label>
                <select class="form-control" name="id_produk">
                    <?= get_produk_option(set_value('id_produk')) ?>
                </select>
            </div>
            <div class="form-group">
                <label>Permintaan <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="permintaan" value="<?= set_value('permintaan') ?>" required />
            </div>
            <div class="form-group">
                <label>Persediaan <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="persediaan" value="<?= set_value('persediaan') ?>" required />
            </div>
            <div class="form-group">
                <button class="btn btn-primary"><span class="glyphicon glyphicon-signal"></span> Hitung</button>
            </div>
        </div>
    </div>
</form>
<?php
if ($_POST) {
    $id_produk = $_POST['id_produk'];
    $persediaan = $_POST['persediaan'];
    $permintaan = $_POST['permintaan'];
    include 'hitung_hasil.php';
}
?>