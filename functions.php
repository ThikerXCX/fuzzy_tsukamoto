<?php
error_reporting(~E_NOTICE);
session_start();

include 'config.php';
include 'includes/db.php';
$db = new DB($config['server'], $config['username'], $config['password'], $config['database_name']);
include 'includes/general.php';
include 'includes/paging.php';
include 'includes/fuzzy.php';

function _post($key, $val = null)
{
    global $_POST;
    if (isset($_POST[$key]))
        return $_POST[$key];
    else
        return $val;
}

function _get($key, $val = null)
{
    global $_GET;
    if (isset($_GET[$key]))
        return $_GET[$key];
    else
        return $val;
}

function _session($key, $val = null)
{
    global $_SESSION;
    if (isset($_SESSION[$key]))
        return $_SESSION[$key];
    else
        return $val;
}

$mod = _get('m');
$act = _get('act');

$rows = $db->get_results("SELECT id_produk, nama_produk FROM tb_produk ORDER BY id_produk");
foreach ($rows as $row) {
    $ALTERNATIF[$row->id_produk] = $row->nama_produk;
}

$rows = $db->get_results("SELECT * FROM tb_himpunan ORDER BY kode_himpunan");
$HIMPUNAN = array();
$KRITERIA_HIMPUNAN = array();
$ATRIBUT = array();

foreach ($rows as $row) {
    $HIMPUNAN[$row->kode_himpunan] = $row;
    $KRITERIA_HIMPUNAN[$row->kode_kriteria][$row->kode_himpunan] = $row;
}
$TARGET = '';
$rows = $db->get_results("SELECT * FROM tb_kriteria ORDER BY kode_kriteria");
foreach ($rows as $row) {
    $KRITERIA[$row->kode_kriteria] = $row;
    $TARGET = $row->kode_kriteria;
}

/** ============================== */

function get_aturan()
{
    global $db;
    $rows = $db->get_results("SELECT * FROM tb_aturan ORDER BY no_aturan, kode_kriteria");
    $arr = array();
    foreach ($rows as $row) {
        $arr[$row->no_aturan][$row->kode_kriteria] = $row;
    }

    $arr2 = array();
    foreach ($arr as $key => $val) {
        $arr2[$key] = new Rule($val);
    }
    //echo '<pre>' . print_r($arr2, 1) . '</pre>';
    return $arr2;
}

function get_hasil_option($selected)
{
    global $TARGET, $KRITERIA_HIMPUNAN;
    $a = '';
    foreach ($KRITERIA_HIMPUNAN[$TARGET] as $key => $val) {
        if ($key == $selected)
            $a .= "<option value='$key' selected>$val->nama_himpunan</option>";
        else
            $a .= "<option value='$key'>$val->nama_himpunan</option>";
    }
    return $a;
}

function get_himpunan_option($kode_kriteria, $selected)
{
    global $KRITERIA_HIMPUNAN;
    $a = '';
    foreach ($KRITERIA_HIMPUNAN[$kode_kriteria] as $key => $val) {
        if ($key == $selected)
            $a .= "<option value='$key' selected>$val->nama_himpunan</option>";
        else
            $a .= "<option value='$key'>$val->nama_himpunan</option>";
    }
    return $a;
}

function get_operator_option($selected)
{
    $arr = array('AND' => 'AND', 'OR' => 'OR');
    $a = '';
    foreach ($arr as $key => $val) {
        if ($key == $selected)
            $a .= "<option value='$key' selected>$val</option>";
        else
            $a .= "<option value='$key'>$val</option>";
    }
    return $a;
}


function get_rekap_option($selected)
{
    $arr = array('Semua' => 'Semua', 'Stok Kurang' => 'Stok Kurang');
    $a = '';
    foreach ($arr as $key => $val) {
        if ($key == $selected)
            $a .= "<option value='$key' selected>$val</option>";
        else
            $a .= "<option value='$key'>$val</option>";
    }
    return $a;
}

function get_produk_option($selected = '')
{
    global $db;
    $rows = $db->get_results("SELECT id_produk, nama_produk FROM tb_produk ORDER BY nama_produk");
    $a = '';
    foreach ($rows as $row) {
        if ($row->id_produk == $selected)
            $a .= "<option value='$row->id_produk' selected>$row->nama_produk</option>";
        else
            $a .= "<option value='$row->id_produk'>$row->nama_produk</option>";
    }
    return $a;
}

function dd($arr)
{
    echo '<pre>' . print_r($arr, 1) . '</pre>';
}
