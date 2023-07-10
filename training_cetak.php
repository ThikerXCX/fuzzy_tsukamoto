<h1>Data training</h1>
<table class="table table-bordered table-hover table-striped">
    <thead>
        <tr class="nw">
            <th>No</th>
            <th>Tanggal</th>
            <th>Produk</th>
            <th>Bentuk</th>
            <th>Warna</th>
            <th>Ukuran</th>
            <th>Kondisi</th>
            <th>Tekstur</th>
            <th>Jenis Sarang</th>
            <th>Keterangan</th>     
        </tr>
    </thead>
    <?php
    $rows = $db->get_results("SELECT * FROM tb_training k LEFT JOIN tb_produk b ON b.id_produk=k.id_produk ORDER BY id_training");
    $no = 0;
    foreach ($rows as $row) : ?>
        <tr>
        <td><?= ++$no ?></td>
                    <td><?= date('M Y', strtotime($row->tanggal_training)) ?></td>
                    <td><?= $row->nama_produk ?></td>

                    <td>
                        <?php 
                            if($row->bentuk == 1){
                                echo "Kecil";
                            }elseif($row->bentuk == 2){
                                echo "Setengah Mangkok";
                            }else{
                                echo "Mangkok";
                            }
                        ?>
                    </td>
                    <td>
                        <?php 
                            if($row->warna == 1){
                                echo "Kuning Pekat";
                            }elseif($row->warna == 2){
                                echo "Kuning";
                            }else{
                                echo "Putih";
                            }
                        ?>
                    </td>
                    <td>
                        <?php 
                            if($row->ukuran == 1){
                                echo "Kecil";
                            }elseif($row->ukuran == 2){
                                echo "Sedang";
                            }else{
                                echo "Besar";
                            }
                        ?>
                    </td>
                    <td>
                        <?php 
                            if($row->kondisi == 1){
                                echo "Berbulu";
                            }elseif($row->kondisi == 2){
                                echo "Kotor";
                            }else{
                                echo "Bersih";
                            }
                        ?>
                    </td>
                    <td>
                        <?php 
                            if($row->tekstur == 1){
                                echo "Sangat keras";
                            }elseif($row->tekstur == 2){
                                echo "Lentur";
                            }else{
                                echo "Keras";
                            }
                        ?>
                    </td>
                    <td><?= $row->jenis_sarang ?></td>
                    <td>Rp. <?= number_format($row->keterangan) ?></td>
        </tr>
    <?php endforeach ?>
</table>