<?php


$aturan = get_aturan();

$row = $db->get_row("SELECT MIN(permintaan) AS x_min, AVG(permintaan) AS x_avg, MAX(permintaan) AS x_max, MIN(persediaan) AS y_min, AVG(persediaan) AS y_avg, MAX(persediaan) AS y_max, MIN(produksi) AS z_min, AVG(produksi) AS z_avg, MAX(produksi) AS z_max, 0 AS x, 0 AS y FROM tb_training WHERE tanggal_training>='$awal' AND tanggal_training<='$akhir' AND id_produk='$id_produk'");

$row->x = $permintaan;
$row->y = $persediaan;

$fuzzy = new Fuzzy($aturan, (array) $row);
$_SESSION['produksi'] = $fuzzy->total;
$_SESSION['post'] = $_POST;

?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Nilai Produk</h3>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <?php foreach ($row as $key => $val) : ?>
                <tr>
                    <td><?= $key ?></td>
                    <td><?= number_format($val) ?></td>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
</div>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Nilai Fuzzy (Input)</h3>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Kriteria</th>
                    <th>Himpunan</th>
                    <th>Nilai</th>
                </tr>
            </thead>
            <?php foreach ($fuzzy->nilai_fuzzy as $key => $val) : ?>
                <?php foreach ($val as $k => $v) : ?>
                    <tr>
                        <td><?= $KRITERIA[$key]->nama_kriteria ?></td>
                        <td><?= $HIMPUNAN[$k]->nama_himpunan ?></td>
                        <td><?= round($v, 4) ?></td>
                    </tr>
                <?php endforeach ?>
            <?php endforeach ?>
        </table>
    </div>
</div>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Aturan</h3>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Aturan</th>
                <th>&alpha;</th>
                <th>z</th>
                <th>&alpha;*z</th>
            </tr>
        </thead>
        <?php foreach ($fuzzy->rules as $key => $val) :
            $arr = array();
            foreach ($fuzzy->z[$key] as $k => $v) {
                $arr[] = number_format($v);
            } ?>
            <tr>
                <td><?= $key ?></td>
                <td><?= $val->to_string() ?></td>
                <td><?= round($fuzzy->miu[$key], 4) ?></td>
                <td>[<?= implode(', ', $arr) ?>]</td>
                <td><?= number_format($fuzzy->az[$key]) ?></td>
            </tr>
        <?php endforeach ?>
        <tfoot>
            <tr>
                <td colspan="2">Total</td>
                <td><?= number_format($fuzzy->miu_total) ?></td>
                <td>&nbsp;</td>
                <td><?= number_format($fuzzy->az_total) ?></td>
            </tr>
        </tfoot>
    </table>
    <div class="panel-footer">
        <p>Hasil: <?= number_format($fuzzy->total) ?></p>

        <a class="btn btn-xs btn-info" href="aksi.php?m=hasil_tambah&id_produk=<?= $id_produk ?>" onclick="return confirm('Simpan Hasil?')"><span class="glyphicon glyphicon-save"></span> Simpan Hasil</a>
    </div>
</div>