<div class="page-header">
    <h1>Data hasil</h1>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <form class="form-inline">
            <input type="hidden" name="m" value="hasil" />
            <div class="form-group">
                <input class="form-control" type="text" placeholder="Pencarian. . ." name="q" value="<?= _get('q') ?>" />
            </div>
            <div class="form-group">
                <button class="btn btn-success"><span class="glyphicon glyphicon-refresh"></span> Cari</button>
            </div>
            <div class="form-group ">
                <a class="btn btn-default" href="cetak.php?m=hasil" target="_blank"><span class="glyphicon glyphicon-print"></span> Cetak</a>
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr class="nw">
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Produk</th>
                    <th>Persediaan</th>
                    <th>Permintaan</th>
                    <th>Produksi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <?php
            $q = esc_field(_get('q'));
            $pg = new Paging();
            $limit = 25;
            $offset = $pg->get_offset($limit, _get('page'));
            $from = " FROM tb_hasil k LEFT JOIN tb_produk b ON b.id_produk=k.id_produk";
            $where = " WHERE (nama_produk LIKE '%$q%')";
            $rows = $db->get_results("SELECT * $from $where ORDER BY id_hasil LIMIT $offset, $limit");
            $no = $offset;
            $jumrec = $db->get_var("SELECT COUNT(*) $from $where");
            foreach ($rows as $row) : ?>
                <tr>
                    <td><?= ++$no ?></td>
                    <td><?= date('M Y', strtotime($row->tanggal_hasil)) ?></td>
                    <td><?= $row->nama_produk ?></td>
                    <td><?= number_format($row->persediaan) ?></td>
                    <td><?= number_format($row->permintaan) ?></td>
                    <td><?= number_format($row->produksi) ?></td>
                    <td>
                        <a class="btn btn-xs btn-danger" href="aksi.php?act=hasil_hapus&ID=<?= $row->id_hasil ?>" onclick="return confirm('Hapus data?')"><span class="glyphicon glyphicon-trash"></span></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <div class="panel-footer">
        <ul class="pagination"><?= $pg->show("m=hasil&q=$q&page=", $jumrec, $limit, _get('page')) ?></ul>
    </div>
</div>