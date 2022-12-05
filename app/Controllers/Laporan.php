<?php

namespace App\Controllers;

use \App\Models\TransaksiModel;
use \App\Models\PengembalianModel;
use TCPDF;

class Laporan extends BaseController
{
    private $transaksiModel, $pengembalianModel;
    public function __construct()
    {
        $this->transaksiModel = new TransaksiModel();
        $this->pengembalianModel = new PengembalianModel();
    }

    public function index()
    {
        $report = $this->transaksiModel->getReport();
        $data = [
            'title' => 'Laporan Transaksi',
            'result' => $report,
        ];
        return view('laporan/index', $data);
    }

    public function index2()
    {
        $report = $this->pengembalianModel->getReport();
        $data = [
            'title' => 'Laporan Pengembalian',
            'result' => $report,
        ];
        return view('laporan/index2', $data);
    }

    public function detail($ID_Transaksi)
    {
        $report = $this->transaksiModel->getReport2($ID_Transaksi);
        $data = [
            'title' => 'Detail Laporan Transaksi',
            'result' => $report,
        ];
        return view('laporan/detail', $data);
    }

    public function detail2($ID_Pengembalian)
    {
        $report = $this->pengembalianModel->getReport2($ID_Pengembalian);
        $data = [
            'title' => 'Detail Laporan Pengembalian',
            'result' => $report,
        ];
        return view('laporan/detail2', $data);
    }

    public function exportPDF()
    {
        $report = $this->transaksiModel->getReport();
        $data   = [
            'title' => 'Laporan Penjualan',
            'result'    => $report,
        ];
        $html  = view('laporan/exportPDF', $data);

        $pdf   = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $pdf->writeHTML($html);
        $this->response->setContentType('application/pdf');
        $pdf->Output('laporan-transaksi.pdf', 'I');
    }

    public function exportPDF2()
    {
        $report = $this->pengembalianModel->getReport();
        $data   = [
            'title' => 'Laporan Penjualan',
            'result'    => $report,
        ];
        $html  = view('laporan/exportPDF2', $data);

        $pdf   = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $pdf->writeHTML($html);
        $this->response->setContentType('application/pdf');
        $pdf->Output('laporan-pengembalian.pdf', 'I');
    }

    public function search()
    {
        $data = [
            'title' => 'Data Laporan Transaksi',
        ];
        return view('laporan/search', $data);
    }

    public function save()
    {
        $_SESSION["Transaksi"] = $this->request->getVar('Tanggal_Transaksi');
        $_SESSION["Transaksi2"] = $this->request->getVar('Tanggal_Transaksi2');

        return redirect()->to('/laporan/result/' . '' . $this->request->getVar('Tanggal_Transaksi') . '/' . $this->request->getVar('Tanggal_Transaksi2'));
    }

    public function indexspesifik($Tanggal_Transaksi, $Tanggal_Transaksi2)
    {
        $dataTransaksi = $this->transaksiModel->getSpesificReport($Tanggal_Transaksi, $Tanggal_Transaksi2);
        $data = [
            'title' => 'Data Transaksi',
            'result' => $dataTransaksi,
        ];
        return view('laporan/indexspesifik', $data);
    }

    public function exporttransaksi($Tanggal_Transaksi, $Tanggal_Transaksi2)
    {   
        $report = $this->transaksiModel->getSpesificReport($Tanggal_Transaksi, $Tanggal_Transaksi2);
        $data   = [
            'title' => 'Laporan Transaksi',
            'result'    => $report,
        ];
        $html  = view('laporan/exportPDF', $data);

        $pdf   = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $pdf->writeHTML($html);
        $this->response->setContentType('application/pdf');
        $pdf->Output('laporan-transaksi-spesifik.pdf', 'I');
    }

    public function search2()
    {
        $data = [
            'title' => 'Data Laporan Pengembalian',
        ];
        return view('laporan/search2', $data);
    }

    public function save2()
    {
        $_SESSION["Pengembalian"] = $this->request->getVar('Tanggal_Pengembalian');
        $_SESSION["Pengembalian2"] = $this->request->getVar('Tanggal_Pengembalian2');

        return redirect()->to('/lap/result/' . '' . $this->request->getVar('Tanggal_Pengembalian') . '/' . $this->request->getVar('Tanggal_Pengembalian2'));
    }

    public function indexspesifik2($Tanggal_Pengembalian, $Tanggal_Pengembalian2)
    {
        $dataPengembalian = $this->pengembalianModel->getSpesificReport($Tanggal_Pengembalian, $Tanggal_Pengembalian2);
        $data = [
            'title' => 'Data Pengembalian',
            'result' => $dataPengembalian,
        ];
        return view('laporan/indexspesifik2', $data);
    }

    public function exportpengembalian($Tanggal_Pengembalian, $Tanggal_Pengembalian2)
    {   
        $report = $this->pengembalianModel->getSpesificReport($Tanggal_Pengembalian, $Tanggal_Pengembalian2);
        $data   = [
            'title' => 'Laporan Pengembalian',
            'result'    => $report,
        ];
        $html  = view('laporan/exportPDF2', $data);

        $pdf   = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $pdf->writeHTML($html);
        $this->response->setContentType('application/pdf');
        $pdf->Output('laporan-pengembalian-spesifik.pdf', 'I');
    }
}