<?php

namespace App\Controllers;

use \App\Models\PengembalianModel;
use \App\Models\TransaksiModel;
use \App\Models\MotorModel;
use TCPDF;

class Pengembalian extends BaseController
{
    private $pengembalianModel, $transaksiModel, $motorModel;
    public function __construct()
    {
        $this->pengembalianModel = new PengembalianModel();
        $this->transaksiModel = new TransaksiModel();
        $this->motorModel = new MotorModel();
    }

    public function index()
    {
        $dataPengembalian = $this->pengembalianModel->getIndex();
        $data = [
            'title' => 'Data Pengembalian',
            'result' => $dataPengembalian
        ];
        return view('pengembalian/index', $data);
    }

    public function detail($ID_Pengembalian)
    {
        $dataPengembalian = $this->pengembalianModel->getPengembalian($ID_Pengembalian);
        $data = [
            'title' => 'Detail Pengembalian',
            'result' => $dataPengembalian
        ];
        return view('pengembalian/detail', $data);
    }

    public function create()
    {
        session();
        $data = [
            'title' => 'Tambah Pengembalian',
            'result' => $this->transaksiModel->findAll(),
            'validation' => \Config\Services::validation()
        ];
        return view('/pengembalian/create', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'ID_Transaksi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Plat Motor harus diisi',
                ]
            ],
            'Waktu_Keterlambatan' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Waktu Keterlambatan harus diisi',
                    'integer' => 'Waktu Keterlambatan harus angka',
                ]
            ],
            'Tarif_Kerusakan' => [
                'rules' => 'required|decimal',
                'errors' => [
                    'required' => 'Tarif Kerusakan harus diisi',
                    'decimal' => 'Tarif Kerusakan harus angka',
                ]
            ],
        ])) {
            return redirect()->to('/pengembalian/create')->withInput();
        }

        $this->pengembalianModel->save([
            'ID_Transaksi' => $this->request->getVar('ID_Transaksi'),
            'Tarif_Denda' => $this->pengembalianModel->getTarif($this->request->getVar('ID_Transaksi')),
            'Total_Biaya' => $this->pengembalianModel->getTarif($this->request->getVar('ID_Transaksi')) * $this->request->getVar('Waktu_Keterlambatan') + $this->request->getVar('Tarif_Kerusakan'),
            'Waktu_Keterlambatan' => $this->request->getVar('Waktu_Keterlambatan'),
            'Tarif_Kerusakan' => $this->request->getVar('Tarif_Kerusakan'),
            'Status' => $this->request->getVar('Status')
        ]);

        session()->setFlashdata('msg', "Data berhasil ditambahkan !");
        
        return redirect()->to('/pengembalian');
    }

    public function edit($ID_Pengembalian)
    {
        $dataPengembalian = $this->pengembalianModel->getPengembalian($ID_Pengembalian);
        if (empty($dataPengembalian)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("ID pengembalian $ID_Pengembalian tidak ditemukan");
        }
        $data = [
            'title' => 'Ubah Pengembalian',
            'validation' => \Config\Services::validation(),
            'result' => $dataPengembalian
        ];
        return view('pengembalian/edit', $data);
    }

    public function update($ID_Pengembalian)
    {
        $dataOld = $this->pengembalianModel->getPengembalian($ID_Pengembalian); 
        if ($dataOld['ID_Transaksi'] == $this->request->getVar('ID_Transaksi')) {
            $rule = 'required';
        } else {
            $rule = 'required|is_unique[transaksi.ID_Motor]';
        }

        if (!$this->validate([
            'ID_Transaksi' => [
                'rules' => $rule,
                'errors' => [
                    'required' => 'Plat Motor harus diisi',
                    'is_unique' => 'Plat Motor sudah diisi',
                ]
            ],
            'Waktu_Keterlambatan' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Waktu Keterlambatan harus diisi',
                    'integer' => 'Waktu Keterlambatan harus angka',
                ]
            ],
            'Tarif_Kerusakan' => [
                'rules' => 'required|decimal',
                'errors' => [
                    'required' => 'Tarif Kerusakan harus diisi',
                    'decimal' => 'Tarif Kerusakan harus angka',
                ]
            ],
        ])) {
            return redirect()->to('/pengembalian/edit/' . $this->request->getVar('ID_Pengembalian'))->withInput();
        }

        $this->pengembalianModel->save([
            'ID_Pengembalian' => $ID_Pengembalian,
            'ID_Transaksi' => $this->pengembalianModel->getId($ID_Pengembalian),
            'Tarif_Denda' => $this->pengembalianModel->getTarif($this->request->getVar('ID_Transaksi')),
            'Total_Biaya' => $this->pengembalianModel->getTarif($this->request->getVar('ID_Transaksi')) * $this->request->getVar('Waktu_Keterlambatan') + $this->request->getVar('Tarif_Kerusakan'),
            'Waktu_Keterlambatan' => $this->request->getVar('Waktu_Keterlambatan'),
            'Tarif_Kerusakan' => $this->request->getVar('Tarif_Kerusakan'),
            'Status' => $this->request->getVar('Status')
        ]);

        $this->transaksiModel->save([
            'ID_Transaksi' => $this->request->getVar('ID_Transaksi'),
            'Status' => $this->request->getVar('Status_Transaksi'),
        ]);

        $this->motorModel->save([
            'ID_Motor' => $this->request->getVar('ID_Motor'),
            'Status' => $this->request->getVar('Status_Motor'),
        ]);

        session()->setFlashdata('msg', "Data berhasil diubah!");
        
        return redirect()->to('/pengembalian');
    }

    public function delete($ID_Pengembalian)
    {
        $dataPengembalian = $this->pengembalianModel->find($ID_Pengembalian);
        $this->pengembalianModel->delete($ID_Pengembalian);

        session()->setFlashdata('msg', "Data berhasil dihapus!");
        return redirect()->to('/pengembalian');
    }

    public function exportPDF($ID_Pengembalian)
    {
        $report = $this->pengembalianModel->getNota($ID_Pengembalian);
        $data   = [
            'title' => 'Nota Pengembalian',
            'result'    => $report,
        ];
        $html  = view('pengembalian/exportPDF', $data);

        $pdf   = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $pdf->writeHTML($html);
        $this->response->setContentType('application/pdf');
        $pdf->Output('nota-pengembalian.pdf', 'I');
    }
}