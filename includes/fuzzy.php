<?php

function generate_aturan()
{
    global $KRITERIA_HIMPUNAN;
    end($KRITERIA_HIMPUNAN);
    $kode_target = key($KRITERIA_HIMPUNAN);

    $arr = $KRITERIA_HIMPUNAN;
    array_pop($arr);

    $a = 0;
    $aturan = array();
    foreach ($arr as $key => $val) {
        $aturan = _generate_aturan($aturan, $key, $val);
    }

    $val_target = $KRITERIA_HIMPUNAN[$kode_target];

    $fields = array();
    foreach ($aturan as $key => $val) {
        $val[$kode_target] = array_rand($val_target);
        foreach ($val as $k => $v) {
            $fields[] = array(
                'no_aturan' => $key + 1,
                'kode_kriteria' => $k,
                'kode_himpunan' => $v,
                'operator' => 'AND',
            );
        }
    }
    global $db;
    $db->multi_query('tb_aturan', $fields);
    //echo '<pre>' . print_r($aturan, 1) . '</pre>';
}
function _generate_aturan($aturan, $key, $val)
{
    if ($aturan) {
        $arr  = array();
        foreach ($aturan as $k => $v) {
            foreach ($val as $a => $b) {
                $v[$key] = $a;
                $arr[] = $v;
            }
        }
        return $arr;
    }
    $arr  = array();
    foreach ($val as $k => $v) {
        $arr[] = array($key => $k);
    }
    //echo '<pre>' . print_r($arr, 1) . '</pre>';
    return $arr;
}
class Fuzzy
{
    public $rules;
    public $himpunan;
    public $input;

    public $nilai_fuzzy;
    public $miu;
    public $z;
    public $az;
    public $miu_total;
    public $az_total;
    public $total;


    /**
     * konstruktor
     * @param $rules int Basis aturan
     * @param $data  int Data nilai produk
     **/
    function __construct($rules, $data)
    {
        $this->rules = $rules;
        $this->himpunan = array(
            'C01' => array('min' => $data['x_min'], 'avg' => $data['x_avg'], 'max' => $data['x_max']),
            'C02' => array('min' => $data['y_min'], 'avg' => $data['y_avg'], 'max' => $data['y_max']),
            'C03' => array('min' => $data['z_min'], 'avg' => $data['z_avg'], 'max' => $data['z_max']),
        );
        $this->input = array(
            'C01' => $data['x'],
            'C02' => $data['y'],
        );

        $this->get_nilai_fuzzy();
        $this->get_miu();
        $this->get_total();
    }

    function get_total()
    {
        foreach ($this->miu as $key => $val) {
            $arr = array();
            foreach ($this->z[$key] as $k => $v) {
                $arr[$k] = $v * $val;
            }
            $this->az[$key] = array_sum($arr) / count($arr);
        }
        $this->miu_total = array_sum($this->miu);
        $this->az_total = array_sum($this->az);
        $this->total = $this->miu_total == 0 ? 0 : $this->az_total / $this->miu_total;
    }

    function get_miu()
    {
        foreach ($this->rules as $key => $val) {
            $arr = array();
            foreach ($val->input as $k => $v) {
                $arr[$v] = $this->nilai_fuzzy[$k][$v];
            }
            $this->miu[$key] = min($arr);

            $output = current($val->output);

            if ($output == 'C03-01') {
                $this->z[$key][] = $this->himpunan['C03']['avg'] - $this->miu[$key] * ($this->himpunan['C03']['avg'] - $this->himpunan['C03']['min']);
            } elseif ($output == 'C03-02') {
                $this->z[$key][] =  $this->miu[$key] * ($this->himpunan['C03']['avg'] - $this->himpunan['C03']['min']) + $this->himpunan['C03']['min'];
                $this->z[$key][] = $this->himpunan['C03']['max'] - $this->miu[$key] * ($this->himpunan['C03']['max'] - $this->himpunan['C03']['avg']);
            } else {
                $this->z[$key][] =  $this->miu[$key] * ($this->himpunan['C03']['max'] - $this->himpunan['C03']['avg']) + $this->himpunan['C03']['avg'];
            }
        }
    }

    function get_nilai_fuzzy()
    {
        foreach ($this->input as $key => $val) {
            //sedikit
            if ($val <= $this->himpunan[$key]['min'])
                $this->nilai_fuzzy[$key][$key . '-01'] = 1;
            elseif ($val <= $this->himpunan[$key]['avg'])
                $this->nilai_fuzzy[$key][$key . '-01'] = ($this->himpunan[$key]['avg'] - $val) / ($this->himpunan[$key]['avg'] - $this->himpunan[$key]['min']);
            else
                $this->nilai_fuzzy[$key][$key . '-01'] = 0; //sedikit

            //sedang
            if ($val <= $this->himpunan[$key]['min'])
                $this->nilai_fuzzy[$key][$key . '-02'] = 0;
            elseif ($val <= $this->himpunan[$key]['avg'])
                $this->nilai_fuzzy[$key][$key . '-02'] = ($val - $this->himpunan[$key]['min']) / ($this->himpunan[$key]['avg'] - $this->himpunan[$key]['min']);
            elseif ($val <= $this->himpunan[$key]['max'])
                $this->nilai_fuzzy[$key][$key . '-02'] = ($this->himpunan[$key]['max'] - $val) / ($this->himpunan[$key]['max'] - $this->himpunan[$key]['avg']);
            else
                $this->nilai_fuzzy[$key][$key . '-02'] = 0;

            //tinggi
            if ($val <= $this->himpunan[$key]['avg'])
                $this->nilai_fuzzy[$key][$key . '-03'] = 0;
            elseif ($val <= $this->himpunan[$key]['max'])
                $this->nilai_fuzzy[$key][$key . '-03'] = ($val - $this->himpunan[$key]['avg']) / ($this->himpunan[$key]['max'] - $this->himpunan[$key]['avg']);
            else
                $this->nilai_fuzzy[$key][$key . '-03'] = 1;
        }
    }
}

class Rule
{
    public $no_aturan;
    public $operator;
    public $input;
    public $output;

    function __construct($rows)
    {
        global $TARGET;
        foreach ($rows as $row) {
            $this->no_aturan = $row->no_aturan;
            $this->operator = $row->operator;

            if ($row->kode_kriteria == $TARGET) {
                $this->output[$row->kode_kriteria] = $row->kode_himpunan;
            } else {
                $this->input[$row->kode_kriteria] = $row->kode_himpunan;
            }
        }
    }

    function to_string()
    {
        global $HIMPUNAN, $KRITERIA;
        $str = 'IF';
        $arr = array();
        foreach ($this->input as $key => $val) {
            $arr[] = '<code>' . $KRITERIA[$key]->nama_kriteria . '</code> = <code>' . $HIMPUNAN[$val]->nama_himpunan . '</code>';
        }
        $str .= ' ' . implode(' ' . $this->operator . ' ', $arr);
        $str .= ' THEN <code>' . $KRITERIA[key($this->output)]->nama_kriteria . '</code> = <code>' . $HIMPUNAN[current($this->output)]->nama_himpunan . '</code>';

        return $str;
    }
}
