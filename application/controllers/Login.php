<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Model');
        $this->db->query("SET sql_mode = '' ");

        if ($this->session->has_userdata('hasLogin')) {
            $level = $this->session->userdata('hasLogin');
            redirect($level . '/');
        }
    }

    public function index()
    {
        $this->load->view('login/index');
    }

    public function ceklogin()
    {
        $user = $this->input->post('username');
        $pass = $this->input->post('password');

        $get = array(
            $this->db->get_where('tbl_admin', array('username' => $user, 'password' => $pass))->result_array(),
            $this->db->get_where('tbl_pmi', array('username' => $user, 'password' => $pass))->result_array()
        );

        foreach ($get as $value) {
            $cek[] = $value;
        }

        if (count($cek[0]) >= 1) {
            $res = array(true, 'admin', $cek[0][0]['username']);
            $set = array("hasLogin" => 'admin', "id" => $cek[0][0]['username']);
            $this->session->set_userdata($set);
        } else
            if (count($cek[1]) >= 1) {
            $res = array(true, 'pmi', $cek[1][0]['id']);
            $set = array("hasLogin" => 'pmi', "id" => $cek[1][0]['id']);
            $this->session->set_userdata($set);
        } else {
            $res = array(false);
        }

        echo json_encode($res);
    }
}
