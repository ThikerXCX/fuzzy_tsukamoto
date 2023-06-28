<h1>Data produk</h1>
<table class="table table-bordered table-hover table-striped">
    <thead>
        <tr class="nw">
            <th>No</th>
            <th>Nama</th>
        </tr>
    </thead>
    <?php
    $rows = $db->get_results("SELECT * FROM tb_produk ORDER BY id_produk");
    $no = 0;
    foreach ($rows as $row) : ?>
        <tr>
            <td><?= ++$no ?></td>
            <td><?= $row->nama_produk ?></td>
        </tr>
    <?php endforeach ?>
</table>