<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, DELETE, PUT');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
header('Access-Control-Allow-Credentials: true');

defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Model');
        $this->db->query("SET sql_mode = '' ");
    }

    public function getWaktu()
    {
        echo $this->Model->getWaktu();
    }

    public function manajemen()
    {
        if ($this->input->post('manajemen') !== NULL) {
            $form = strtolower($this->input->post('tbl'));
            if ($this->input->post('manajemen') == 'tambah') {
                foreach ($_POST as $key => $value) {
                    if ($key !== 'manajemen' && $key !== 'tbl') {
                        $data[$key] = $value;
                    }
                }

                $tambah = $this->Model->setTambah('tbl_' . $form, $data);

                echo json_encode(array($tambah, $data));
            } else
            if ($this->input->post('manajemen') == 'update') {
                foreach ($_POST as $key => $value) {
                    if ($key !== 'manajemen' && $key !== 'tbl' && $key !== 'where') {
                        $data[$key] = $value;
                    }
                }
                $where = $this->input->post('where');

                $update = $this->Model->setUpdate($data, $where, 'tbl_' . $form);

                echo json_encode(array($update, $data));
            } else
            if ($this->input->post('manajemen') == "hapus") {
                $where = $this->input->post('where');

                $hapus = $this->Model->setHapus('tbl_' . $form, $where);

                echo json_encode($hapus);
            }
        } else {
            redirect(base_url());
        }
    }

    public function manajemenOrder()
    {
        if ($this->input->post('manajemen') !== NULL) {
            if ($this->input->post('manajemen') == 'update') {
                $where = $this->input->post('where');

                foreach ($_POST as $key => $value) {
                    if ($key !== 'manajemen' && $key !== 'tbl' && $key !== 'where') {
                        $set[$key] = $value;
                    }
                }

                $history = json_encode(array($set['status'] => $this->Model->getWaktu()));
                $this->db->set("history", "JSON_MERGE_PATCH(history, '$history')", false);

                $this->db->set($set);

                $this->db->where($where);

                $update = $this->db->update("tbl_permintaan");

                if ($update) {
                    $res = $this->Model->ambilData('tbl_permintaan', 'kepada, status, history', '', $where)[0];

                    if ($set['status'] == 'Diterima') {
                        $this->Model->updateStokbyOrder($where['id'], $res['kepada']);
                    }
                    echo json_encode(array($update, $res));
                }
            }
        } else {
            redirect(base_url());
        }
    }

    public function getListDataPMI()
    {
        // $query = $this->Model->query("SELECT a.id, a.nama, COALESCE((SELECT SUM(b.jumlah) FROM tbl_stok b WHERE JSON_UNQUOTE(JSON_EXTRACT(b.keterangan, '$.status')) = 'Ditambahkan' AND b.user = a.id), 0) - COALESCE((SELECT SUM(b.jumlah) FROM tbl_stok b WHERE JSON_UNQUOTE(JSON_EXTRACT(b.keterangan, '$.status')) <> 'Ditambahkan' AND b.user = a.id), 0) as total FROM tbl_pmi a");
        $query = $this->Model->query("SELECT a.id, a.nama, COALESCE((SELECT SUM(b.jumlah) FROM tbl_stok b WHERE b.status = 'Ditambahkan' AND b.user = a.id), 0) - COALESCE((SELECT SUM(b.jumlah) FROM tbl_stok b WHERE b.status <> 'Ditambahkan' AND b.user = a.id), 0) as total FROM tbl_pmi a");

        echo json_encode($query);
    }

    public function getDataStok($user)
    {
        $query = $this->Model->query("SELECT a.gol_darah, COALESCE((SELECT SUM(b.jumlah) FROM tbl_stok b WHERE b.status = 'Ditambahkan' AND b.user = '$user' AND b.gol_darah = a.gol_darah), 0) - COALESCE((SELECT SUM(b.jumlah) FROM tbl_stok b WHERE b.status <> 'Ditambahkan' AND b.user = '$user' AND b.gol_darah = a.gol_darah), 0) as total FROM tbl_golongan_darah a");

        echo json_encode($query);
    }

    public function getHistoryStok($user)
    {
        $gol_darah = $this->input->get('gol_darah');

        $query = $this->Model->query("SELECT a.*, b.nama FROM tbl_stok a LEFT JOIN tbl_pendonor b ON a.pendonor = b.id WHERE a.user = '$user' AND a.gol_darah = '$gol_darah'");

        echo json_encode($query);
    }

    public function getLastUpdate($user)
    {
        $query = $this->Model->query("SELECT MAX(tanggal) as last_update FROM tbl_stok WHERE user = '$user'")[0]['last_update'];

        echo json_encode($query);
    }

    public function getTotalNotikasiPermintaan($user)
    {
        $query = $this->Model->query("SELECT COUNT(jumlah) as total FROM tbl_permintaan WHERE (status IS NULL OR status = 'Dikonfirmasi' OR status = 'Selesai') AND dari = '$user'")[0]['total'];

        echo json_encode($query);
    }

    public function getListPermintaan($user)
    {
        $query = $this->Model->query("SELECT a.id, a.gol_darah, a.jumlah, a.status, a.last_update, b.nama FROM tbl_permintaan a LEFT JOIN tbl_pmi b ON a.kepada = b.id WHERE dari = '$user' ORDER BY a.last_update DESC");

        echo json_encode($query);
    }

    public function getDataPermintaan($id = '')
    {
        if ($id != '') {
            $query = $this->Model->query("SELECT status, history as tanggalHistory FROM tbl_permintaan WHERE id = '$id'")[0];
        } else {
            $user = $this->input->get('user');
            $query = $this->Model->query("SELECT a.*, b.nama, b.telp, b.jenis_kelamin, b.token FROM tbl_permintaan a LEFT JOIN tbl_user b ON a.dari = b.id WHERE a.kepada = '$user' AND a.status IS NOT NULL ORDER BY last_update DESC");
        }

        echo json_encode($query);
    }

    public function getDataProfil($user)
    {
        $query = $this->Model->query("SELECT nama, username, telp, tgl_lahir, jenis_kelamin, email, password FROM tbl_user WHERE id = '$user'")[0];

        echo json_encode($query);
    }

    public function getDataPendonor($user)
    {
        $gol_darah =  $this->input->post('gol_darah');

        if ($gol_darah != '') {
            $select = 'id, nama';
            $where = array('gol_darah' => $gol_darah, 'pmi' => $user);
        } else {
            $select = '';
            $where = array('pmi' => $user);
        }
        $query = $this->Model->ambilData('tbl_pendonor', $select, '', $where);

        echo json_encode($query);
    }

    public function getTotalDarah($user)
    {
        $gol_darah = $this->input->get('gol_darah');

        $query = $this->Model->query("SELECT COALESCE((SELECT SUM(b.jumlah) FROM tbl_stok b WHERE b.status = 'Ditambahkan' AND b.user = '$user' AND b.gol_darah = a.gol_darah), 0) - COALESCE((SELECT SUM(b.jumlah) FROM tbl_stok b WHERE b.status <> 'Ditambahkan' AND b.user = '$user' AND b.gol_darah = a.gol_darah), 0) as total FROM tbl_stok a WHERE a.user = '$user' AND a.gol_darah = '$gol_darah'")[0]['total'];

        echo json_encode($query);
    }

    public function getDataPMI()
    {
        $query = $this->Model->query("SELECT * FROM tbl_pmi");

        echo json_encode($query);
    }

    public function getDataUser()
    {
        $query = $this->Model->query("SELECT * FROM tbl_user");

        echo json_encode($query);
    }

    public function kirimNotifikasi()
    {
        $title = $this->input->post('title');
        $body = $this->input->post('body');
        $token = $this->input->post('token');

        $this->Model->sendGCM($title, $body, $token);
    }

    public function uploadSuratPengantar()
    {
        $id = $this->input->post('id');

        $data['status'] = 'Order';
        $data['history'] = json_encode(['Order' => $this->Model->getWaktu()]);

        $data['file'] = basename($_FILES['file']["name"]);
        //Proses Upload
        $target_dir = "./file/" . $id . "/";
        $upload = $this->Model->uploadFile($target_dir);

        if ($upload == 1) {
            $update = $this->Model->setUpdate($data, array('id' => $id), 'tbl_permintaan');

            if ($update) {
                echo json_encode(array($update, $data));
            }
        }
    }

    public function login()
    {
        $user = $this->input->post('username');
        $pass = $this->input->post('password');

        $get = array(
            $this->db->get_where('tbl_user', array('username' => $user, 'password' => $pass))->result_array()
            // $this->db->get_where('tbl_pmi', array('username' => $user, 'password' => $pass))->result_array()
        );

        foreach ($get as $value) {
            $cek[] = $value;
        }

        if (count($cek[0]) >= 1) {
            $res = array(true, 'user', $cek[0][0]['id']);
            // } else
            // if (count($cek[1]) >= 1) {
            //     $res = array(true, 'pmi', $cek[1][0]['id']);
        } else {
            $res = array(false);
        }

        echo json_encode($res);
    }

    public function registrasi()
    {
        foreach ($_POST as $key => $value) {
            $data[$key] = $value;
        }

        //create ID
        $data['id'] = $this->Model->cekRow('tbl_user', 'id', 'USR', 6);

        $query = $this->Model->setTambah('tbl_user', $data);

        echo json_encode($query);
    }

    public function reset()
    {
        $smtp = $this->Model->ambilData('tbl_email');
        $email = $this->input->post('email');

        $kode = $this->Model->createKode($email);

        if ($kode[0]) {
            // Konfigurasi email
            $config = [
                'mailtype'  => 'text',
                'charset'   => 'utf-8',
                'protocol'  => 'smtp',
                'smtp_host' => 'ssl://smtp.gmail.com',
                'smtp_user' => $smtp[0]['email'],
                'smtp_pass' => $smtp[0]['password'],
                'smtp_port' => 465,
                'crlf'      => "\r\n",
                'newline'   => "\r\n"
            ];

            $this->load->library('email', $config);

            $this->email->from($smtp[0]['email'], 'Aplikasi Unit Transfusi Darah Palang Merah Indonesia');
            $this->email->to($email);
            $this->email->subject('Reset Password Aplikasi Unit Transfusi Darah Palang Merah Indonesia');

            // $link = BASE_URL('reset?') . http_build_query(['kode' => $kode[1]]);
            $this->email->message('Kode Reset : ' . $kode[1]);

            if ($this->email->send()) {
                echo json_encode(array(true));
                $this->Model->setTambah('tbl_recovery', $kode[2]);
            } else {
                echo json_encode(array(false, 'Email gagal dikirim'));
                show_error($this->email->print_debugger());
            }
        } else {
            echo json_encode($kode);
        }
    }

    public function cekKodeReset()
    {
        $kode = $this->input->post('kode');

        $data = $this->Model->query("SELECT email, kode FROM tbl_recovery WHERE expired >= NOW()");

        $res['valid'] = false;

        foreach ($data as $val) {
            if ($kode == $val['kode']) {
                $res['valid'] = true;
                $res['email'] = $val['email'];

                break;
            }
        }

        echo json_encode($res);
    }

    public function cekData()
    {
        $tbl = $this->input->post('tabel');
        $data = $this->input->post('data');

        $keys = array_column($data, 'name');
        $values = array_column($data, 'value');

        $where = array_combine($keys, $values);

        $cek = $this->Model->cekData("tbl_{$tbl}", $where);

        if ($cek > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    public function generate_id()
    {
        if ($this->input->post('tabel') !== NULL) {
            $tbl = $this->input->post('tabel');
            $kode = $this->input->post('kode');
            $panjang = $this->input->post('panjang');

            if ($this->input->post('kolom') !== NULL) {
                $kolom = $this->input->post('kolom');
            } else {
                $kolom = 'id';
            }

            $id = $this->Model->cekRow($tbl, $kolom, $kode, $panjang);

            echo json_encode($id);
        } else {
            redirect(base_url());
        }
    }
}
