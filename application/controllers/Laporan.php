<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Model');
        $this->db->query("SET sql_mode = '' ");
    }

    public function cetakPendonor()
    {
        $user = $this->input->get('user');

        $select = "a.*, (SELECT COUNT(b.pendonor) FROM tbl_stok b WHERE b.pendonor = a.id) as total";

        $filter = $this->input->get('filter');
        $where = "a.pmi = '$user' ";

        if ($filter != '') {
            $where .= "AND a.gol_darah = '" . str_replace(' ', '+', $filter) . "'";
        }

        $data = $this->Model->ambilData('tbl_pendonor a', $select, '', $where);

        $profil = $this->getProfil($user);

        $this->load->library('Pdf');

        $pdf = new Pdf('L', 'mm', 'LEGAL');

        $pdf->setFontSubsetting(true);

        $pdf->AddPage();

        $image_file = base_url('assets/img/logo.png');
        $pdf->Image($image_file, 80, 6, 20, 20, 'PNG', '', '', true, 150, '', false, false, 0, false, false, false);

        // Set font
        $pdf->SetFont('helvetica', 'B', 25);
        // Title
        $pdf->SetXY(0, 0);
        $pdf->Cell(0, 25, 'UNIT TRANSFUSI DARAH', 0, true, 'C', 0);
        $pdf->SetXY(0, 2);
        $pdf->Cell(0, 40, 'PALANG MERAH INDONESIA', 0, false, 'C', 0);

        $pdf->SetDrawColor(150, 150, 150);
        $pdf->SetLineWidth(1);
        $pdf->Line(5, 31, 210 - 5, 31);
        $pdf->SetLineWidth(0);
        $pdf->Line(5, 32, 210 - 5, 32);
        $pdf->Ln(1);

        $pdf->SetDrawColor(150, 150, 150);
        $pdf->SetLineWidth(1);
        $pdf->Line(5, 31, 350, 31);
        $pdf->SetLineWidth(0);
        $pdf->Line(5, 32, 350, 32);
        $pdf->Ln(1);

        $pdf->ln(35);

        $pdf->SetFont('helvetica', 'B', 12, '', true);
        $pdf->cell(0, 0, 'LAPORAN DAFTAR PENDONOR DARAH ' . strtoupper($profil['nama']), 0, 1, 'C');
        $pdf->SetFont('helvetica', '', 12, '', true);
        $pdf->cell(0, 0, 'Tanggal : ' . $this->Model->tanggal_indo(explode(' ', $this->Model->getWaktu())[0]), 0, 1, 'C');

        $pdf->ln();

        // ================================================================================
        $pdf->SetFont('Times', 'B', 12);
        $pdf->cell(15);
        $pdf->Cell(10, 11, 'NO', 1, 0, 'C');
        $pdf->Cell(40, 11, 'ID', 1, 0, 'C');
        $pdf->cell(50, 11, 'NAMA', 1, 0, 'C');
        $pdf->Cell(40, 11, 'JENIS KELAMIN', 1, 0, 'C');
        $pdf->Cell(60, 11, 'ALAMAT', 1, 0, 'C');
        $pdf->Cell(50, 11, 'GOLONGAN DARAH', 1, 0, 'C');
        $pdf->Cell(50, 11, 'TOTAL DONOR', 1, 1, 'C');

        $pdf->SetFont('Times', '', 12);

        $no = 1;
        foreach ($data as $val) {
            $pdf->cell(15);
            $pdf->Cell(10, 11, $no++, 1, 0, 'C');
            $pdf->Cell(40, 11, $val['id'], 1, 0, 'C');
            $pdf->Cell(50, 11, $val['nama'], 1, 0);
            $pdf->Cell(40, 11, $val['jenis_kelamin'], 1, 0);
            $pdf->Cell(60, 11, $val['alamat'], 1, 0);
            $pdf->Cell(50, 11, $val['gol_darah'], 1, 0, 'C');
            $pdf->Cell(50, 11, $val['total'] . ' kali', 1, 1, 'C');
        }


        $pdf->Output("laporan Pendonor.pdf", 'I');
    }

    public function cetakStok()
    {
        $user = $this->input->get('user');

        $select = "a.*";

        $filter = $this->input->get('filter');
        $where = "a.user = '$user'";

        if ($filter != '') {
            $where .= " AND status = '$filter'";
        }

        $data = $this->Model->ambilData('tbl_stok a', $select, '', $where);

        $profil = $this->getProfil($user);

        $this->load->library('Pdf');

        $pdf = new Pdf('L', 'mm', 'LEGAL');

        $pdf->setFontSubsetting(true);

        $pdf->AddPage();

        $image_file = base_url('assets/img/logo.png');
        $pdf->Image($image_file, 80, 6, 20, 20, 'PNG', '', '', true, 150, '', false, false, 0, false, false, false);

        // Set font
        $pdf->SetFont('helvetica', 'B', 25);
        // Title
        $pdf->SetXY(0, 0);
        $pdf->Cell(0, 25, 'UNIT TRANSFUSI DARAH', 0, true, 'C', 0);
        $pdf->SetXY(0, 2);
        $pdf->Cell(0, 40, 'PALANG MERAH INDONESIA', 0, false, 'C', 0);

        $pdf->SetDrawColor(150, 150, 150);
        $pdf->SetLineWidth(1);
        $pdf->Line(5, 31, 210 - 5, 31);
        $pdf->SetLineWidth(0);
        $pdf->Line(5, 32, 210 - 5, 32);
        $pdf->Ln(1);

        $pdf->SetDrawColor(150, 150, 150);
        $pdf->SetLineWidth(1);
        $pdf->Line(5, 31, 350, 31);
        $pdf->SetLineWidth(0);
        $pdf->Line(5, 32, 350, 32);
        $pdf->Ln(1);

        $pdf->ln(35);

        $pdf->SetFont('helvetica', 'B', 12, '', true);
        $pdf->cell(0, 0, 'LAPORAN DAFTAR STOK DARAH ' . strtoupper($profil['nama']), 0, 1, 'C');
        $pdf->SetFont('helvetica', '', 12, '', true);
        $pdf->cell(0, 0, 'Tanggal : ' . $this->Model->tanggal_indo(explode(' ', $this->Model->getWaktu())[0]), 0, 1, 'C');

        $pdf->ln();

        // ================================================================================
        $pdf->SetFont('Times', 'B', 12);
        $pdf->cell(10);
        $pdf->Cell(10, 11, 'NO', 1, 0, 'C');
        $pdf->Cell(70, 11, 'ID', 1, 0, 'C');
        $pdf->Cell(70, 11, 'GOLONGAN DARAH', 1, 0, 'C');
        $pdf->cell(40, 11, 'JUMLAH', 1, 0, 'C');
        $pdf->Cell(70, 11, 'STATUS', 1, 0, 'C');
        $pdf->Cell(50, 11, 'TANGGAL', 1, 1, 'C');

        $pdf->SetFont('Times', '', 12);

        $no = 1;
        foreach ($data as $val) {
            $pdf->cell(10);
            $pdf->Cell(10, 11, $no++, 1, 0, 'C');
            $pdf->Cell(70, 11, $val['id'], 1, 0, 'C');
            $pdf->Cell(70, 11, $val['gol_darah'], 1, 0, 'C');
            $pdf->Cell(40, 11, $val['jumlah'] . ' kantong', 1, 0, 'C');
            $pdf->Cell(70, 11, $val['status'], 1, 0, 'C');
            $pdf->Cell(50, 11, $val['tanggal'], 1, 1, 'C');
        }


        $pdf->Output("laporan Stok Darah.pdf", 'I');
    }

    public function cetakPermintaan()
    {
        $user = $this->input->get('user');

        $where = "status IS NOT NULL AND kepada = '$user'";

        $select = "a.*";

        $data = $this->Model->ambilData('tbl_permintaan a', $select, '', $where);

        $profil = $this->getProfil($user);

        $this->load->library('Pdf');

        $pdf = new Pdf('L', 'mm', 'LEGAL');

        $pdf->setFontSubsetting(true);

        $pdf->AddPage();

        $image_file = base_url('assets/img/logo.png');
        $pdf->Image($image_file, 80, 6, 20, 20, 'PNG', '', '', true, 150, '', false, false, 0, false, false, false);

        // Set font
        $pdf->SetFont('helvetica', 'B', 25);
        // Title
        $pdf->SetXY(0, 0);
        $pdf->Cell(0, 25, 'UNIT TRANSFUSI DARAH', 0, true, 'C', 0);
        $pdf->SetXY(0, 2);
        $pdf->Cell(0, 40, 'PALANG MERAH INDONESIA', 0, false, 'C', 0);

        $pdf->SetDrawColor(150, 150, 150);
        $pdf->SetLineWidth(1);
        $pdf->Line(5, 31, 210 - 5, 31);
        $pdf->SetLineWidth(0);
        $pdf->Line(5, 32, 210 - 5, 32);
        $pdf->Ln(1);

        $pdf->SetDrawColor(150, 150, 150);
        $pdf->SetLineWidth(1);
        $pdf->Line(5, 31, 350, 31);
        $pdf->SetLineWidth(0);
        $pdf->Line(5, 32, 350, 32);
        $pdf->Ln(1);

        $pdf->ln(35);

        $pdf->SetFont('helvetica', 'B', 12, '', true);
        $pdf->cell(0, 0, 'LAPORAN DAFTAR PERMINTAAN DARAH ' . strtoupper($profil['nama']), 0, 1, 'C');
        $pdf->SetFont('helvetica', '', 12, '', true);
        $pdf->cell(0, 0, 'Tanggal : ' . $this->Model->tanggal_indo(explode(' ', $this->Model->getWaktu())[0]), 0, 1, 'C');

        $pdf->ln();

        // ================================================================================
        $pdf->SetFont('Times', 'B', 12);
        $pdf->cell(50);
        $pdf->Cell(10, 11, 'NO', 1, 0, 'C');
        $pdf->Cell(40, 11, 'ID', 1, 0, 'C');
        $pdf->cell(90, 11, 'GOLONGAN DARAH', 1, 0, 'C');
        $pdf->Cell(50, 11, 'JUMLAH', 1, 0, 'C');
        $pdf->Cell(50, 11, 'STATUS', 1, 1, 'C');

        $no = 1;
        foreach ($data as $val) {
            $pdf->SetFont('Times', '', 12);
            $pdf->cell(50);
            $pdf->Cell(10, 11, $no++, 1, 0, 'C');
            $pdf->Cell(40, 11, $val['id'], 1, 0);
            $pdf->Cell(90, 11, $val['gol_darah'], 1, 0, 'C');
            $pdf->Cell(50, 11, $val['jumlah'] . ' kantong', 1, 0, 'C');
            $pdf->Cell(50, 11, $val['status'], 1, 1, 'C');

            $i = 1;
            $pdf->SetFont('Times', '', 10);
            foreach (json_decode($val['history']) as $key => $value) {
                $pdf->cell(50);
                $pdf->Cell(10, 11, '', 1, 0, 'C', true);
                $pdf->Cell(10, 11, '#' . $i++, 1, 0, 'C');
                $pdf->Cell(220, 11, 'Tanggal ' . $key . ' : ' . $value, 1, 1);
            }
        }


        $pdf->Output("laporan Permintaan Darah.pdf", 'I');
    }

    public function getProfil($user)
    {
        return $this->Model->query("SELECT * FROM tbl_pmi WHERE id = '$user'")[0];
    }
}
