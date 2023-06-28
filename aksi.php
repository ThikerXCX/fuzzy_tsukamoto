<?php
require_once 'functions.php';

if ($mod == 'login') {
    $user = esc_field($_POST['user']);
    $pass = esc_field($_POST['pass']);

    $row = $db->get_row("SELECT * FROM tb_user WHERE user='$user' AND pass='$pass'");
    if ($row) {
        $_SESSION['login'] = $row->user;
        $_SESSION['ID'] = $row->id_user;
        redirect_js("index.php");
    } else {
        print_msg("Salah kombinasi username dan password.");
    }
} else if ($mod == 'password') {
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];
    $pass3 = $_POST['pass3'];

    $row = $db->get_row("SELECT * FROM tb_user WHERE user='$_SESSION[login]' AND pass='$pass1'");

    if ($pass1 == '' || $pass2 == '' || $pass3 == '')
        print_msg('Field bertanda * harus diisi.');
    elseif (!$row)
        print_msg('Password lama salah.');
    elseif ($pass2 != $pass3)
        print_msg('Password baru dan konfirmasi password baru tidak sama.');
    else {
        $db->query("UPDATE tb_user SET pass='$pass2' WHERE user='$_SESSION[login]'");
        print_msg('Password berhasil diubah.', 'success');
    }
} elseif ($act == 'logout') {
    unset($_SESSION['login']);
    header("location:index.php?m=login");
}

/** kriteria */
elseif ($mod == 'kriteria_tambah') {
    $kode_kriteria = $_POST['kode_kriteria'];
    $nama_kriteria = $_POST['nama_kriteria'];
    $batas_bawah = $_POST['batas_bawah'];
    $batas_atas = $_POST['batas_atas'];

    if (!$kode_kriteria || !$nama_kriteria || $batas_bawah == '' || $batas_atas == '')
        print_msg("Field bertanda * tidak boleh kosong!");
    elseif ($db->get_results("SELECT * FROM tb_kriteria WHERE kode_kriteria='$kode_kriteria'"))
        print_msg("Kode sudah ada!");
    elseif ($batas_bawah < 0 || $batas_atas < 0)
        print_msg("Batas minimal 0!");
    elseif ($batas_bawah >= $batas_atas)
        print_msg("Batas atas harus lebih besar dari batas bawah!");
    else {
        $db->query("INSERT INTO tb_kriteria (kode_kriteria, nama_kriteria, batas_bawah, batas_atas) 
            VALUES ('$kode_kriteria', '$nama_kriteria', '$batas_bawah', '$batas_atas')");
        $db->query("INSERT INTO tb_rel_produk (id_produk, kode_kriteria, nilai) 
            SELECT id_produk, '$kode_kriteria', 0 FROM tb_produk");

        update_kriteria();
        redirect_js("index.php?m=kriteria");
    }
} else if ($mod == 'kriteria_ubah') {
    $nama_kriteria = $_POST['nama_kriteria'];
    $batas_bawah = $_POST['batas_bawah'];
    $batas_atas = $_POST['batas_atas'];

    if (!$nama_kriteria  || $batas_bawah == '' || $batas_atas == '')
        print_msg("Field bertanda * tidak boleh kosong!");
    elseif ($batas_bawah < 0 || $batas_atas < 0)
        print_msg("Batas bawah minimal 0!");
    elseif ($batas_bawah >= $batas_atas)
        print_msg("Batas atas harus lebih besar dari batas bawah!");
    else {
        $db->query("UPDATE tb_kriteria 
            SET nama_kriteria='$nama_kriteria', batas_bawah='$batas_bawah', batas_atas='$batas_atas'
            WHERE kode_kriteria='$_GET[ID]'");

        update_kriteria();
        redirect_js("index.php?m=kriteria");
    }
} else if ($act == 'kriteria_hapus') {
    $db->query("DELETE FROM tb_kriteria WHERE kode_kriteria='$_GET[ID]'");
    $db->query("DELETE FROM tb_rel_produk WHERE kode_kriteria='$_GET[ID]'");
    $db->query("DELETE FROM tb_aturan WHERE kode_kriteria='$_GET[ID]'");

    update_kriteria();
    header("location:index.php?m=kriteria");
}

/** RELASI ALTERNATIF */
else if ($act == 'rel_produk_ubah') {
    foreach ($_POST as $key => $value) {
        $ID = str_replace('ID-', '', $key);
        $db->query("UPDATE tb_rel_produk SET nilai='$value' WHERE ID='$ID'");
    }
    header("location:index.php?m=rel_produk");
} else if ($mod == 'kriteria_himpunan') {
    if (_post('tambah_himpunan')) {
        $kode_himpunan = $_POST['kode_himpunan'];
        $nama_himpunan = $_POST['nama_himpunan'];
        $n1 = $_POST['n1'];
        $n2 = $_POST['n2'];
        $n3 = $_POST['n3'];
        $n4 = $_POST['n4'];

        if ($kode_himpunan == '' || $nama_himpunan == '' || $n1 == '' || $n2 == '' || $n3 == '' || $n4 == '') {
            print_msg("Semua Field harus diisi!");
        } else {
            $db->query("INSERT INTO tb_himpunan (kode_himpunan, kode_kriteria, nama_himpunan, n1, n2, n3, n4)
                VALUES ('$kode_himpunan', '$_GET[ID]', '$nama_himpunan', '$n1', '$n2', '$n3', '$n4' )");
            print_msg('Himpunan berhasil ditambah!', 'success');
        }
    } else if ($_POST['simpan_himpunan']) {
        $data = $_POST['data'];
        foreach ($data as $key => $val) {
            $db->query("UPDATE tb_himpunan SET nama_himpunan='$val[nama_himpunan]', n1='$val[n1]', n2='$val[n2]', n3='$val[n3]', n4='$val[n4]' WHERE kode_himpunan='$key'");
        }
        print_msg('Himpunan berhasil disimpan!', 'success');
    }
} else if ($mod == 'himpunan_hapus') {
    $db->query("DELETE FROM tb_himpunan WHERE kode_himpunan='$_GET[ID]'");
    header("location:index.php?m=kriteria_himpunan&ID=$_GET[kode_kriteria]");
} else if ($act == 'aturan_hapus') {
    $db->query("DELETE FROM tb_aturan WHERE no_aturan='$_GET[ID]'");
    header("location:index.php?m=aturan");
} else if ($mod == 'aturan_generate') {
    $db->query("TRUNCATE tb_aturan");
    generate_aturan();
    header("location:index.php?m=aturan");
}

/** MASTER DATA */

/** produk */
elseif ($mod == 'produk_tambah') {
    $nama_produk = $_POST['nama_produk'];

    if ($nama_produk == '')
        print_msg("Field bertanda * tidak boleh kosong!");
    else {
        $db->query("INSERT INTO tb_produk (nama_produk) VALUES ('$nama_produk')");
        redirect_js("index.php?m=produk");
    }
} else if ($mod == 'produk_ubah') {
    $nama_produk = $_POST['nama_produk'];

    if ($nama_produk == '')
        print_msg("Field bertanda * tidak boleh kosong!");
    else {
        $db->query("UPDATE tb_produk SET nama_produk='$nama_produk' WHERE id_produk='$_GET[ID]'");
        redirect_js("index.php?m=produk");
    }
} else if ($act == 'produk_hapus') {
    $db->query("DELETE FROM tb_produk WHERE id_produk='$_GET[ID]'");
    header("location:index.php?m=produk");
}

/** training */
elseif ($mod == 'training_tambah') {
    $tanggal_training = $_POST['tanggal_training'];
    $id_produk = $_POST['id_produk'];
    $persediaan = $_POST['persediaan'];
    $permintaan = $_POST['permintaan'];
    $produksi = $_POST['produksi'];
    if ($tanggal_training == '' || $id_produk == '' || $persediaan == '' || $permintaan == '' || $produksi == '')
        print_msg("Field bertanda * tidak boleh kosong!");
    else {
        $db->query("INSERT INTO tb_training (tanggal_training, id_produk, persediaan, permintaan, produksi) VALUES ('$tanggal_training', '$id_produk', '$persediaan', '$permintaan', '$produksi')");
        redirect_js("index.php?m=training");
    }
} else if ($mod == 'training_ubah') {
    $tanggal_training = $_POST['tanggal_training'];
    $id_produk = $_POST['id_produk'];
    $persediaan = $_POST['persediaan'];
    $permintaan = $_POST['permintaan'];
    $produksi = $_POST['produksi'];
    if ($tanggal_training == '' || $id_produk == '' || $persediaan == '' || $permintaan == '' || $produksi == '')
        print_msg("Field bertanda * tidak boleh kosong!");
    else {
        $db->query("UPDATE tb_training SET tanggal_training='$tanggal_training', id_produk='$id_produk', persediaan='$persediaan', permintaan='$permintaan', produksi='$produksi' WHERE id_training='$_GET[ID]'");
        redirect_js("index.php?m=training");
    }
} else if ($act == 'training_hapus') {
    $db->query("DELETE FROM tb_training WHERE id_training='$_GET[ID]'");
    header("location:index.php?m=training");
}
/** hasil */
elseif ($mod == 'hasil_tambah') {
    $_POST = $_SESSION['post'];
    $produksi = $_SESSION['produksi'];
    $tanggal_hasil = $_POST['tanggal_hasil'];
    $id_produk = $_POST['id_produk'];
    $persediaan = $_POST['persediaan'];
    $permintaan = $_POST['permintaan'];
    if ($tanggal_hasil == '' || $id_produk == '' || $persediaan == '' || $permintaan == '' || $produksi == '')
        print_msg("Field bertanda * tidak boleh kosong!");
    else {
        $db->query("INSERT INTO tb_hasil (tanggal_hasil, id_produk, persediaan, permintaan, produksi) VALUES ('$tanggal_hasil', '$id_produk', '$persediaan', '$permintaan', '$produksi')");
        redirect_js("index.php?m=hasil");
    }
} else if ($act == 'hasil_hapus') {
    $db->query("DELETE FROM tb_hasil WHERE id_hasil='$_GET[ID]'");
    header("location:index.php?m=hasil");
}
