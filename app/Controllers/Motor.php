<?php

namespace App\Controllers;

use \App\Models\MotorModel;
use PDO;

class Motor extends BaseController
{
    private $motorModel;
    public function __construct()
    {
        $this->motorModel = new MotorModel();
    }

    public function index()
    {
        $dataMotor = $this->motorModel->findAll();
        $data = [
            'title' => 'Data Motor',
            'result' => $dataMotor
        ];
        return view('motor/index', $data);
    }

    public function detail($ID_Motor)
    {
        $dataMotor = $this->motorModel->getMotor($ID_Motor);
        $data = [
            'title' => 'Detail Motor',
            'result' => $dataMotor
        ];
        return view('motor/detail', $data);
    }

    public function create()
    {
        session();
        $data = [
            'title' => 'Tambah Motor',
            'validation' => \Config\Services::validation()
        ];
        return view('/motor/create', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'Plat_Motor' => [
                'rules' => 'required|is_unique[motor.Plat_Motor]',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'is_unique' => '{field} sudah ada',
                ]
            ],
            'Jenis_Motor' => 'required',
            'Jumlah_Motor' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'integer' => '{field} harus angka',
                ]
            ],
            'sampul' => [
                'rules' => 'max_size[sampul,1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Gambar tidak boleh lebih dari !MB!',
                    'is_image' => 'Yang anda pilih bukan gambar!',
                    'mime_in' => 'Yang anda pilih bukan gambar!',
                ]
            ],
            'Merk_Motor' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi',
                ]
            ],
            'Warna_Motor' => 'required',
            'Tarif' => [
                'rules' => 'required|decimal',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'decimal' => '{field} harus angka',
                ]
            ],
            'STNK' => 'required',
        ])) {
            return redirect()->to('/motor/create')->withInput();
        }

        // Mengambil File Sampul
        $fileSampul = $this->request->getFile('sampul');
        if ($fileSampul->getError() == 4){
            $namaFile = $this->defaultImage;
        } else {
            // Generate Nama file
            $namaFile = $fileSampul->getRandomName();
            // Pindahkan File ke Folder img di public
            $fileSampul->move('img', $namaFile);
        }

        $this->motorModel->save([
            'Plat_Motor' => $this->request->getVar('Plat_Motor'),
            'Jenis_Motor' => $this->request->getVar('Jenis_Motor'),
            'Jumlah_Motor' => $this->request->getVar('Jumlah_Motor'),
            'Merk_Motor' => $this->request->getVar('Merk_Motor'),
            'Warna_Motor' => $this->request->getVar('Warna_Motor'),
            'Tarif' => $this->request->getVar('Tarif'),
            'Tarif_Denda' => $this->request->getVar('Tarif_Denda'),
            'STNK' => $this->request->getVar('STNK'),
            'Status' => $this->request->getVar('Status'),
            'cover' => $namaFile
        ]);

        session()->setFlashdata('msg', "Data berhasil ditambahkan !");
        
        return redirect()->to('/motor');
    }

    public function edit($ID_Motor)
    {
        $dataMotor = $this->motorModel->getMotor($ID_Motor);
        if (empty($dataMotor)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("ID motor $ID_Motor tidak ditemukan");
        }
        $data = [
            'title' => 'Ubah Motor',
            'validation' => \Config\Services::validation(),
            'result' => $dataMotor
        ];
        return view('motor/edit', $data);
    }

    public function update($ID_Motor)
    {
        $dataOld = $this->motorModel->getMotor($ID_Motor);
        if($dataOld['Plat_Motor'] == $this->request->getVar('Plat_Motor')){
            $rule_Plat_Motor = 'required';
        } else {
            $rule_Plat_Motor = 'required|is_unique[motor.Plat_Motor]';
        }

        if (!$this->validate([
            'Plat_Motor' => [
                'rules' => $rule_Plat_Motor,
                'errors' => [
                    'required' => '{field} harus diisi',
                    'is_unique' => '{field} sudah diisi',
                ]
            ],
            'Jenis_Motor' => 'required',
            'Jumlah_Motor' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'integer' => '{field} harus angka',
                ]
            ],
            'sampul' => [
                'rules' => 'max_size[sampul,1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Gambar tidak boleh lebih dari !MB!',
                    'is_image' => 'Yang anda pilih bukan gambar!',
                    'mime_in' => 'Yang anda pilih bukan gambar!',
                ]
            ],
            'Merk_Motor' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi',
                ]
            ],
            'Warna_Motor' => 'required',
            'Tarif' => [
                'rules' => 'required|decimal',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'decimal' => '{field} harus angka',
                ]
            ],
            'Tarif_Denda' => [
                'rules' => 'required|decimal',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'decimal' => '{field} harus angka',
                ]
                ],
            'STNK' => 'required',
        ])) {
            return redirect()->to('/motor/edit/' . $this->request->getVar('ID_Motor'))->withInput();
        }

        $namaFileLama = $this->request->getVar('sampullama');
        // Mengambil File Sampul
        $fileSampul = $this->request->getFile('sampul');
        // Cek gambar, apakah masih gambar lama
        if ($fileSampul->getError() == 4) {
            $namaFile = $namaFileLama;
        } else {
            // Generate Nama File
            $namaFile = $fileSampul->getRandomName();
            // Pindahkan File ke Folder Img di Public
            $fileSampul->move('img', $namaFile);

            // Jika sampulnya default
            if ($namaFileLama != $this->defaultImage) {
                // Hapus Gambar
                unlink('img/' . $namaFileLama);
            }
        }

        $this->motorModel->save([
            'ID_Motor' => $ID_Motor,
            'Plat_Motor' => $this->request->getVar('Plat_Motor'),
            'Jenis_Motor' => $this->request->getVar('Jenis_Motor'),
            'Jumlah_Motor' => $this->request->getVar('Jumlah_Motor'),
            'Merk_Motor' => $this->request->getVar('Merk_Motor'),
            'Warna_Motor' => $this->request->getVar('Warna_Motor'),
            'Tarif' => $this->request->getVar('Tarif'),
            'Tarif_Denda' => $this->request->getVar('Tarif_Denda'),
            'STNK' => $this->request->getVar('STNK'),
            'Status' => $this->request->getVar('Status'),
            'cover' => $namaFile
        ]);

        session()->setFlashdata('msg', "Data berhasil diubah!");
        
        return redirect()->to('/motor');
    }

    public function delete($ID_Motor)
    {
        $dataMotor = $this->motorModel->find($ID_Motor);
        $this->motorModel->delete($ID_Motor);

        if ($dataMotor['cover'] != $this->defaultImage) {
            // Hapus gambar
            unlink('img/' . $dataMotor['cover']);
        }

        session()->setFlashdata('msg', "Data berhasil dihapus!");
        return redirect()->to('/motor');
    }
}