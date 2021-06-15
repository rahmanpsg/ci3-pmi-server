<?php

/**
 * 
 */
class Model extends CI_Model
{
    public function getPage($url, $i = 1)
    {
        $segments = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
        $numSegments = count($segments);

        if ($numSegments > 1) {
            $currentSegment = $segments[$numSegments - $i];
        } else {
            $currentSegment = $segments[$numSegments - 1];
        }

        $classActive = $url == $currentSegment ? 'active' : '';

        return $classActive;
    }

    function updateStokbyOrder($IDorder, $user)
    {
        $idStok = $this->Model->cekRow('tbl_stok', 'id', 'STK', 6);

        $this->db->query("INSERT INTO tbl_stok (id, gol_darah, user, jumlah, status) SELECT '$idStok',gol_darah, '$user', jumlah, 'Digunakan' FROM tbl_permintaan WHERE id = '$IDorder'");
    }

    function query($query)
    {
        $res = $this->db->query($query)->result_array();
        return $res;
    }

    function ambilData($tbl, $select = '*', $join = [], $where = [], $order = '')
    {
        $this->db->select($select);
        $this->db->from($tbl);
        if (!empty($join)) {
            foreach ($join as $val) {
                $this->db->join($val['tbl'], $val['on'], 'left');
            }
        }
        if (!empty($where)) {
            $this->db->where($where);
        }
        if ($order != '') {
            $this->db->order_by($order);
        }
        $res = $this->db->get()->result_array();

        return $res;
    }

    function setTambah($table, $data)
    {
        return $this->db->insert($table, $data);
    }

    function setUpdate($data, $where, $table)
    {
        $this->db->set($data);
        $this->db->where($where);
        return $this->db->update($table);
    }

    function setHapus($table, $data)
    {
        return $this->db->delete($table, $data);
    }

    function cekData($tbl, $where)
    {
        $this->db->select('count(*) as total');
        $res = $this->db->get_where($tbl, $where);
        return $res->result_array()[0]['total'];
    }

    function cekTotalData($tbl)
    {
        $this->db->select('count(*) as total');
        $res = $this->db->get($tbl);
        return $res->result_array()[0]['total'];
    }

    function cekRow($table, $kolom, $val, $panjang)
    {
        $query = "SELECT * FROM $table";
        $row = $this->db->query($query)->num_rows() + 1;

        do {
            $no = str_pad($row, $panjang, '0', STR_PAD_LEFT);
            $id = $val . '-' . $no;
            $cek = "SELECT * FROM $table where $kolom = '$id'";
            $query_cek = $this->db->query($cek)->num_rows();
            $row++;
        } while ($query_cek > 0);
        return $id;
    }

    function sendGCM($title, $body, $token)
    {
        $config = $this->ambilData('tbl_firebase')[0];
        $url = $config['URL'];

        $serverKey = $config['API_KEY'];

        $notification = array('title' => $title, 'text' => $body, 'sound' => 'default', 'badge' => '1');

        $arrayToSend = array('to' => $token, 'notification' => $notification, 'priority' => 'high');

        $json = json_encode($arrayToSend);

        $headers = array();

        $headers[] = 'Content-Type: application/json';

        $headers[] = 'Authorization: key=' . $serverKey;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //Send the request
        curl_exec($ch);

        curl_close($ch);
    }

    function getWaktu()
    {
        date_default_timezone_set('Asia/Makassar');
        $waktu = date('Y-m-d H:i:s');

        return $waktu;
    }

    function uploadFile($target_dir)
    {
        $fileExtension = ['JPEG', 'JPG', 'PNG'];

        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $uploadOk = 1;
        foreach ($_FILES as $key => $value) {
            $target_file = $target_dir . basename($_FILES[$key]["name"]);
            $FileType = pathinfo($target_file, PATHINFO_EXTENSION);

            // Check file size
            if ($_FILES[$key]["size"] > 2048000) {
                echo json_encode(array(false, "File " . basename($_FILES[$key]["name"]) . " terlalu besar (Max 2MB)"));
                $uploadOk = 0;
                break;
            } else
            if (!in_array(strtoupper($FileType), $fileExtension)) {
                echo json_encode(array(false, "Format file harus (" . join(', ', $fileExtension) . ")"));
                $uploadOk = 0;
                break;
            } else
            if (move_uploaded_file($_FILES[$key]["tmp_name"], $target_file)) {
                $uploadOk = 1;
                break;
            } else {
                $uploadOk = 0;
                echo json_encode(array(false, "File gagal diupload"));
                break;
            }
        }

        return $uploadOk;
    }

    function createKode($email)
    {
        date_default_timezone_set('Asia/Makassar');

        $cek = $this->cekData('tbl_recovery', array('email' => $email, 'expired >=' => date("Y-m-d H:i:s")));
        if ($cek == 0) {
            $karakter = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789';
            $kode = '';
            for ($i = 0; $i < 6; $i++) {
                $pos = rand(0, strlen($karakter) - 1);
                $kode .= $karakter[$pos];
            }

            $expired = date("Y-m-d H:i:s", strtotime("+1 minutes"));

            $data = [
                'email' => $email,
                'kode' => $kode,
                'expired' => $expired
            ];

            return array(true, $kode, $data);
        } else {
            return array(false, 'Email reset telah dikirim sebelumnya, harap coba lagi beberapa saat');
        }
    }

    function getNotifikasi($user)
    {
        $cekMasuk = $this->query("SELECT COUNT(jumlah) as total FROM tbl_permintaan WHERE kepada = '$user' AND status = 'Order'")[0]['total'];

        return $cekMasuk;
    }

    function tanggal_indo($tanggal)
    {
        $bulan = array(
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $split    = explode('-', $tanggal);
        $tgl_indo = $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0] . ' ' . (isset($split[3]) ? $split[3] : '');

        return $tgl_indo;
    }
}
