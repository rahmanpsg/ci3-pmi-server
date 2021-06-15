<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Admin extends CI_Controller
{
    public $id, $nama;
    function __construct()
    {
        parent::__construct();
        $this->load->model('Model');
        $this->db->query("SET sql_mode = '' ");

        if (!$this->session->has_userdata('hasLogin')) {
            redirect('login');
        } else
        if ($this->session->userdata('hasLogin') !== 'admin') {
            $level = $this->session->userdata('hasLogin');
            redirect("$level/");
        }

        $this->id = $this->session->userdata('id');
        $this->nama = $this->Model->ambilData('tbl_admin', 'nama', '', ['username' => $this->id])[0]['nama'];
    }

    public function index()
    {
        $this->load->view('admin/index');
    }

    public function pmi()
    {
        $data['TBL_URL'] = base_url('api/getDataPMI/');
        $this->load->view('admin/pmi', $data);
    }

    public function user()
    {
        $data['TBL_URL'] = base_url('api/getDataUser/');
        $this->load->view('admin/user', $data);
    }
}
