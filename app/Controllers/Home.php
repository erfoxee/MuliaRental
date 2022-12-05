<?php

namespace App\Controllers;

use App\Models\BerandaModel;

class Home extends BaseController
{
    public function __construct()
    {
        $this->beranda = new BerandaModel();
    }

    public function index()
    {
        // return view('admin/overview');
        $pendapatan = $this->beranda->reportPendapatan();
        $hasil = $this->beranda->getStatus();
        $rusak = $this->beranda->getRusak();
        $kembali = $this->beranda->getPengembalian();
        $data = [
            'title' => 'Beranda',
            'result' => $pendapatan,
            'hasil' => $hasil,
            'rusak' => $rusak,
            'kembali' => $kembali
        ];
        return view('user/beranda', $data);
    }

    public function showChartTransaksi()
    {
        // $tahun = date('Y');
        $tahun = $this->request->getVar('tahun');
        $reportTrans = $this->beranda->reportTransaksi($tahun);
        $response = [
            'status' => false,
            'data' => $reportTrans
        ];
        echo json_encode($response);
    }

    public function showChartPengembalian()
    {
        $tahun = $this->request->getVar('tahun');
        $reportPengem = $this->beranda->reportPengembalian($tahun);
        $response = [
            'status' => false,
            'data' => $reportPengem
        ];
        echo json_encode($response);
    }

    public function showChartPelanggan()
    {
        $tahun = $this->request->getVar('tahun');
        $reportPelanggan = $this->beranda->reportPelanggan($tahun);
        $response = [
            'status' => false,
            'data' => $reportPelanggan
        ];
        echo json_encode($response);
    }

    public function showChartJumlah()
    {
        $tahun = $this->request->getVar('tahun');
        $reportJumlah = $this->beranda->reportJumlah($tahun);
        $response = [
            'status' => false,
            'data' => $reportJumlah
        ];
        echo json_encode($response);
    }
}
