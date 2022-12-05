<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'ID_Transaksi';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'ID_Pelanggan', 'ID_Motor', 'Total_Harga', 'Tanggal_Transaksi', 'Tanggal_Peminjaman', 
        'Tanggal_Pengembalian', 'Durasi', 'Status', 'Jaminan'
    ];

    protected $useSoftDeletes = true;

    // Index Transaksi
    public function getTransaksi()
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "thegoddess";

        $connection = mysqli_connect($servername, $username, $password, $dbname);

        if(!$connection){
            die("connection failed : " . mysqli_connect_error());
        }

        $id = session()->get('logged_in');
        $users = mysqli_query($connection, "SELECT id, NIK FROM users WHERE id = '$id';");
        $get_users = mysqli_fetch_assoc($users);

        if($get_users['NIK'] != null)
        {
            return $this->db->query("SELECT t.ID_Transaksi, 
            m.ID_Motor, m.Plat_Motor, u.id, u.NIK, 
            t.Total_Harga, t.Tanggal_Transaksi, t.Tanggal_Peminjaman, t.Tanggal_Pengembalian, t.Durasi, 
            t.Status, t.Jaminan FROM transaksi t
            JOIN motor m ON m.ID_Motor = t.ID_Motor
            JOIN users u ON u.id = t.ID_Pelanggan
            WHERE u.id = '$id' AND t.deleted_at IS NULL AND t.Status = 'Belum Membayar'
            GROUP BY t.ID_Transaksi")->getResultArray();
        } else {
            return $this->db->query("SELECT t.ID_Transaksi, 
            m.ID_Motor, m.Plat_Motor, u.id, u.NIK, 
            t.Total_Harga, t.Tanggal_Transaksi, t.Tanggal_Peminjaman, t.Tanggal_Pengembalian, t.Durasi, 
            t.Status, t.Jaminan FROM transaksi t
            JOIN motor m ON m.ID_Motor = t.ID_Motor
            JOIN users u ON u.id = t.ID_Pelanggan
            WHERE t.deleted_at IS NULL AND t.Status = 'Belum Membayar'
            GROUP BY t.ID_Transaksi")->getResultArray();
        }
    }

    // Detail Transaksi
    public function getTransaksi2($ID_Transaksi)
    {
        return $this->db->query("SELECT t.ID_Transaksi, u.id, u.NIK, m.Plat_Motor, 
        t.Total_Harga, t.Tanggal_Transaksi, t.Tanggal_Peminjaman, t.Tanggal_Pengembalian, t.Durasi, 
        t.Status, t.Jaminan FROM transaksi t
        JOIN motor m ON m.ID_Motor = t.ID_Motor
        JOIN users u ON u.id = t.ID_Pelanggan
        WHERE t.ID_Transaksi = $ID_Transaksi AND t.deleted_at IS NULL
        GROUP BY t.ID_Transaksi")->getResultArray();
    }

    // Edit Transaksi
    public function getTransaksi3($ID_Transaksi = false)
    {
        $query = $this->table('transaksi')
            ->where('deleted_at is null');

        if ($ID_Transaksi == false)
            return $query->get()->getResultArray();
        return $query->where(['ID_Transaksi' => $ID_Transaksi])->first();
    }

    // Index & Cetak Laporan
    public function getReport()
    {
        return $this->db->query("SELECT t.ID_Transaksi, u.id, u.NIK, 
        m.ID_Motor, m.Plat_Motor, 
        t.Total_Harga, t.Tanggal_Transaksi, t.Tanggal_Peminjaman, t.Tanggal_Pengembalian, t.Durasi, 
        t.Status, t.Jaminan FROM transaksi t
        JOIN motor m ON m.ID_Motor = t.ID_Motor
        JOIN users u ON u.id = t.ID_Pelanggan
        WHERE t.deleted_at IS NULL AND t.Status = 'Sudah Membayar'
        GROUP BY t.ID_Transaksi")->getResultArray();
    }

    // Detail Laporan
    public function getReport2($ID_Transaksi)
    {
        return $this->db->query("SELECT t.ID_Transaksi, u.id, u.NIK, m.Plat_Motor, 
        t.Total_Harga, t.Tanggal_Transaksi, t.Tanggal_Peminjaman, t.Tanggal_Pengembalian, t.Durasi, 
        t.Status, t.Jaminan FROM transaksi t
        JOIN motor m ON m.ID_Motor = t.ID_Motor
        JOIN users u ON u.id = t.ID_Pelanggan
        WHERE t.ID_Transaksi = '$ID_Transaksi' AND t.deleted_at IS NULL
        GROUP BY t.ID_Transaksi")->getResultArray();
    }

    // Cetak Nota Transaksi
    public function getNota($ID_Transaksi)
    {
        return $this->db->query("SELECT t.ID_Transaksi, 
            m.ID_Motor, m.Plat_Motor, u.id, u.NIK, 
            t.Total_Harga, t.Tanggal_Transaksi, t.Tanggal_Peminjaman, t.Tanggal_Pengembalian, t.Durasi, 
            t.Status, t.Jaminan FROM transaksi t
            JOIN motor m ON m.ID_Motor = t.ID_Motor
            JOIN users u ON u.id = t.ID_Pelanggan
            WHERE t.deleted_at IS NULL AND t.ID_Transaksi = '$ID_Transaksi'
            GROUP BY t.ID_Transaksi")->getResultArray();
    }

    // Index & Cetak Laporan Spesifik
    public function getSpesificReport($Tanggal_Transaksi, $Tanggal_Transaksi2)
    {
        return $this->db->query("SELECT t.ID_Transaksi, u.id, u.NIK, 
        m.ID_Motor, m.Plat_Motor, 
        t.Total_Harga, t.Tanggal_Transaksi, t.Tanggal_Peminjaman, t.Tanggal_Pengembalian, t.Durasi, 
        t.Status, t.Jaminan FROM transaksi t
        JOIN motor m ON m.ID_Motor = t.ID_Motor
        JOIN users u ON u.id = t.ID_Pelanggan
        WHERE t.deleted_at IS NULL AND t.Status = 'Sudah Membayar' AND t.Tanggal_Transaksi BETWEEN '$Tanggal_Transaksi' AND DATE_ADD('$Tanggal_Transaksi2',INTERVAL 1 DAY)
        GROUP BY t.ID_Transaksi")->getResultArray();
    }
}