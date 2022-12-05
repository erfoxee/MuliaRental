<?php

namespace App\Controllers;

use \App\Models\TransaksiModel;
use \App\Models\MotorModel;
use TCPDF;

class Transaksi extends BaseController
{
    private $transaksiModel, $motorModel;
    public function __construct()
    {
        $this->transaksiModel = new TransaksiModel();
        $this->motorModel = new MotorModel();
    }

    public function index()
    {
        $dataTransaksi = $this->transaksiModel->getTransaksi();
        $data = [
            'title' => 'Data Transaksi',
            'result' => $dataTransaksi,
        ];
        return view('transaksi/index', $data);
    }

    public function detail($ID_Transaksi)
    {
        $dataTransaksi = $this->transaksiModel->getTransaksi2($ID_Transaksi);
        $data = [
            'title' => 'Detail Transaksi',
            'result' => $dataTransaksi
        ];
        return view('transaksi/detail', $data);
    }

    public function create()
    {
        session();
        $data = [
            'title' => 'Tambah Transaksi',
            'validation' => \Config\Services::validation(),
        ];
        return view('/transaksi/create', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'ID_Pelanggan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'NIK harus diisi',
                ]
            ],
            'ID_Motor' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Plat Motor harus diisi',
                ]
            ],
            'Tanggal_Transaksi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Transaksi harus diisi',
                ]
            ],
            'Tanggal_Peminjaman' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Peminjaman harus diisi',
                ]
            ],
            'Tanggal_Pengembalian' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Pengembalian harus diisi',
                ]
            ],
            'Jaminan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi',
                ]
            ],
        ])) {
            return redirect()->to('/transaksi/create')->withInput();
        }

        $start = $this->request->getVar('Tanggal_Peminjaman');
        $end = $this->request->getVar('Tanggal_Pengembalian');
        $diff = strtotime($end) - strtotime($start);
        $durasi = $diff / (60 * 60 * 24);

        $this->transaksiModel->save([
            'ID_Pelanggan' => $this->request->getVar('ID_Pelanggan'),
            'ID_Motor' => $this->request->getVar('ID_Motor'),
            'Total_Harga' =>  $this->motorModel->getTarif($this->request->getVar('ID_Motor'), $durasi),
            'Tanggal_Transaksi' => $this->request->getVar('Tanggal_Transaksi'),
            'Tanggal_Peminjaman' => $this->request->getVar('Tanggal_Peminjaman'),
            'Tanggal_Pengembalian' => $this->request->getVar('Tanggal_Pengembalian'),
            'Durasi' => $durasi,
            'Status' => $this->request->getVar('Status'),
            'Jaminan' => $this->request->getVar('Jaminan'),
        ]);

        $this->motorModel->save([
            'ID_Motor' => $this->request->getVar('ID_Motor'),
            'Status' => $this->request->getVar('Status_Motor'),
        ]);

        session()->setFlashdata('msg', "Data berhasil ditambahkan !");
        
        return redirect()->to('/transaksi');
    }

    public function edit($ID_Transaksi)
    {
        $dataTransaksi = $this->transaksiModel->getTransaksi3($ID_Transaksi);
        if (empty($dataTransaksi)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("ID transaksi $ID_Transaksi tidak ditemukan");
        }
        $data = [
            'title' => 'Ubah Transaksi',
            'validation' => \Config\Services::validation(),
            'result' => $dataTransaksi
        ];
        return view('transaksi/edit', $data);
    }

    public function update($ID_Transaksi)
    {
        if (!$this->validate([
            'ID_Pelanggan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'NIK harus diisi',
                ]
            ],
            'ID_Motor' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Plat Motor harus diisi',
                ]
            ],
            'Tanggal_Transaksi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Transaksi harus diisi',
                ]
            ],
            'Tanggal_Peminjaman' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Peminjaman harus diisi',
                ]
            ],
            'Tanggal_Pengembalian' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Pengembalian harus diisi',
                ]
            ],
            'Durasi' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'integer' => '{field} harus angka',
                ]
            ],
            'Jaminan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi',
                ]
            ],
        ])) {
            return redirect()->to('/transaksi/edit/' . $this->request->getVar('ID_Transaksi'))->withInput();
        }

        $this->transaksiModel->save([
            'ID_Transaksi' => $ID_Transaksi,
            'ID_Pelanggan' => $this->request->getVar('ID_Pelanggan'),
            'ID_Motor' => $this->request->getVar('ID_Motor'),
            'Total_Harga' =>  $this->motorModel->getTarif($this->request->getVar('ID_Motor'), $this->request->getVar('Durasi')),
            'Tanggal_Transaksi' => $this->request->getVar('Tanggal_Transaksi'),
            'Tanggal_Peminjaman' => $this->request->getVar('Tanggal_Peminjaman'),
            'Tanggal_Pengembalian' => $this->request->getVar('Tanggal_Pengembalian'),
            'Durasi' => $this->request->getVar('Durasi'),
            'Status' => $this->request->getVar('Status'),
            'Jaminan' => $this->request->getVar('Jaminan'),
        ]);

        session()->setFlashdata('msg', "Data berhasil diubah!");
        
        return redirect()->to('/transaksi');
    }

    public function delete($ID_Transaksi)
    {
        $dataTransaksi = $this->transaksiModel->find($ID_Transaksi);
        $this->transaksiModel->delete($ID_Transaksi);

        session()->setFlashdata('msg', "Data berhasil dihapus!");
        return redirect()->to('/transaksi');
    }

    public function exportPDF($ID_Transaksi)
    {
        $report = $this->transaksiModel->getNota($ID_Transaksi);
        $data   = [
            'title' => 'Nota Transaksi',
            'result'    => $report,
        ];
        $html  = view('transaksi/exportPDF', $data);

        $pdf   = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $pdf->writeHTML($html);
        $this->response->setContentType('application/pdf');
        $pdf->Output('nota-transaksi.pdf', 'I');
    }
}