<h1>Data hasil</h1>
<table class="table table-bordered table-hover table-striped">
    <thead>
        <tr class="nw">
            <th>No</th>
            <th>Tanggal</th>
            <th>Produk</th>
            <th>Persediaan</th>
            <th>Permintaan</th>
            <th>Produksi</th>
        </tr>
    </thead>
    <?php
    $rows = $db->get_results("SELECT * FROM tb_hasil k LEFT JOIN tb_produk b ON b.id_produk=k.id_produk ORDER BY id_hasil");
    $no = 0;
    foreach ($rows as $row) : ?>
        <tr>
            <td><?= ++$no ?></td>
            <td><?= date('M Y', strtotime($row->tanggal_hasil)) ?></td>
            <td><?= $row->nama_produk ?></td>
            <td><?= number_format($row->persediaan) ?></td>
            <td><?= number_format($row->permintaan) ?></td>
            <td><?= number_format($row->produksi) ?></td>
        </tr>
    <?php endforeach ?>
</table>