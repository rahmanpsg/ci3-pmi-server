<?php
class Pmi extends CI_Controller
{
    public $id, $nama, $notifikasi, $alamat;
    function __construct()
    {
        parent::__construct();
        $this->load->model('Model');
        $this->db->query("SET sql_mode = '' ");

        if (!$this->session->has_userdata('hasLogin')) {
            redirect('login');
        } else
        if ($this->session->userdata('hasLogin') !== 'pmi') {
            $level = $this->session->userdata('hasLogin');
            redirect("$level/");
        }

        $this->id = $this->session->userdata('id');
        $data = $this->Model->ambilData('tbl_pmi', 'nama, alamat', '', ['id' => $this->id]);
        $this->nama = $data[0]['nama'];
        $this->alamat = $data[0]['alamat'];
        $this->notifikasi = $this->Model->getNotifikasi($this->id);
    }

    public function index()
    {
        $this->load->view('pmi/index');
    }

    public function pendonor()
    {
        $data['TBL_URL'] = base_url('api/getDataPendonor/') . $this->id;
        $data['dataGolDarah'] = $this->Model->ambilData('tbl_golongan_darah');
        $data['dataTotal'] = $this->Model->query("SELECT pendonor, COUNT(id) total FROM tbl_stok GROUp BY pendonor");
        $this->load->view('pmi/pendonor', $data);
    }

    public function stok()
    {
        $data['TBL_URL'] = base_url('api/getDataStok/') . $this->id;
        $data['dataGolDarah'] = $this->Model->ambilData('tbl_golongan_darah');
        $this->load->view('pmi/stok', $data);
    }

    public function permintaan()
    {
        $data['TBL_URL'] = base_url('api/getDataPermintaan?') . http_build_query(['user' => $this->id]);
        $this->load->view('pmi/permintaan', $data);
    }

    public function laporan()
    {
        $this->load->view('pmi/laporan');
    }
}
