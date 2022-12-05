<?php

namespace App\Models;

use CodeIgniter\Model;

class PengembalianModel extends Model
{
    protected $table            = 'pengembalian';
    protected $primaryKey       = 'ID_Pengembalian';
    protected $useTimestamps    = true;
    protected $allowedFields    = [
        'ID_Transaksi', 'Total_Biaya', 'Tarif_Denda', 'Waktu_Keterlambatan', 'Tarif_Kerusakan', 'Status'
    ];
    protected $useSoftDeletes = true;

    // Detail, Edit, dan Edit Pengembalian
    public function getPengembalian($ID_Pengembalian = false)
    {
        $query = $this->table('pengembalian')
            ->where('deleted_at is null');

        if ($ID_Pengembalian == false)
            return $query->get()->getResultArray();
        return $query->where(['ID_Pengembalian' => $ID_Pengembalian])->first();
    }

    // Index Pengembalian
    public function getIndex()
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

        if($get_users['NIK'] != null){
            return $this->db->query("SELECT p.ID_Pengembalian, m.Plat_Motor, m.Tarif_Denda, p.ID_Transaksi, p.Total_Biaya, p.Tarif_Denda, p.Tarif_Kerusakan,
                p.Waktu_Keterlambatan, p.Status FROM pengembalian p
                JOIN transaksi t ON p.ID_Transaksi = t.ID_Transaksi
                JOIN motor m ON t.ID_Motor = m.ID_Motor
                JOIN users u ON t.ID_Pelanggan = u.id
                WHERE u.id = '$id' AND p.deleted_at IS NULL AND p.Status = 'Belum Selesai'
                GROUP BY p.ID_Pengembalian")->getResultArray();
        } else {
            return $this->db->query("SELECT p.ID_Pengembalian, m.Plat_Motor, m.Tarif_Denda, p.ID_Transaksi, p.Total_Biaya, p.Tarif_Denda, p.Tarif_Kerusakan,
                p.Waktu_Keterlambatan, p.Status FROM pengembalian p
                JOIN transaksi t ON p.ID_Transaksi = t.ID_Transaksi
                JOIN motor m ON t.ID_Motor = m.ID_Motor
                JOIN users u ON t.ID_Pelanggan = u.id
                WHERE p.deleted_at IS NULL AND p.Status = 'Belum Selesai'
                GROUP BY p.ID_Pengembalian")->getResultArray();
        }
    }

    // Index & Cetak Laporan
    public function getReport()
    {
        return $this->db->query("SELECT p.ID_Pengembalian, m.Plat_Motor, m.Tarif_Denda, p.ID_Transaksi, p.Total_Biaya, p.Tarif_Denda, p.Tarif_Kerusakan,
            p.Waktu_Keterlambatan, p.Status FROM pengembalian p
            JOIN transaksi t ON p.ID_Transaksi = t.ID_Transaksi
            JOIN motor m ON t.ID_Motor = m.ID_Motor
            WHERE p.deleted_at IS NULL AND p.Status = 'Selesai'
            GROUP BY p.ID_Pengembalian")->getResultArray();
    }

    // Detail Laporan
    public function getReport2($ID_Pengembalian)
    {
        return $this->db->query("SELECT p.ID_Pengembalian, m.Plat_Motor, m.Tarif_Denda, p.ID_Transaksi, p.Total_Biaya, p.Tarif_Denda, p.Tarif_Kerusakan,
            p.Waktu_Keterlambatan, p.Status FROM pengembalian p
            JOIN transaksi t ON p.ID_Transaksi = t.ID_Transaksi
            JOIN motor m ON t.ID_Motor = m.ID_Motor
            WHERE p.deleted_at IS NULL AND ID_Pengembalian = '$ID_Pengembalian'
            GROUP BY p.ID_Pengembalian")->getResultArray();
    }

    // Get value tarif (untuk bagian save di create & update)
    public function getTarif($ID_Transaksi)
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "thegoddess";
    
        $connection = mysqli_connect($servername, $username, $password, $dbname);
    
        if(!$connection){
            die("connection failed : " . mysqli_connect_error());
        }
    
        $tarif_akhir = 0;
    
        $tarif = mysqli_query($connection, "SELECT Tarif_Denda FROM motor WHERE deleted_at IS NULL AND ID_Motor = 
            (SELECT ID_Motor FROM transaksi WHERE ID_Transaksi = '$ID_Transaksi')");
        $get_tarif = mysqli_fetch_assoc($tarif);
        $tarif_akhir = $get_tarif['Tarif_Denda'];
        return $tarif_akhir;
    }

    // Get value ID (untuk bagian save di update)
    public function getId($ID_Pengembalian)
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "thegoddess";
    
        $connection = mysqli_connect($servername, $username, $password, $dbname);
    
        if(!$connection){
            die("connection failed : " . mysqli_connect_error());
        }
        
        $id = mysqli_query($connection, "SELECT ID_Transaksi FROM pengembalian WHERE ID_Pengembalian = '$ID_Pengembalian';");
        $get_id = mysqli_fetch_assoc($id);
        $id_akhir = $get_id['ID_Transaksi'];
        return $id_akhir;
    }

    // Cetak Nota Pengembalian
    public function getNota($ID_Pengembalian)
    {
        return $this->db->query("SELECT p.ID_Pengembalian, m.Plat_Motor, m.Tarif_Denda, p.ID_Transaksi, p.Total_Biaya, p.Tarif_Denda, p.Tarif_Kerusakan,
        p.Waktu_Keterlambatan, p.Status FROM pengembalian p
        JOIN transaksi t ON p.ID_Transaksi = t.ID_Transaksi
        JOIN motor m ON t.ID_Motor = m.ID_Motor
        JOIN users u ON t.ID_Pelanggan = u.id
        WHERE p.deleted_at IS NULL AND p.ID_Pengembalian = '$ID_Pengembalian'
        GROUP BY p.ID_Pengembalian")->getResultArray();
    }

    // Index & Cetak Laporan Spesifik
    public function getSpesificReport($Tanggal_Pengembalian, $Tanggal_Pengembalian2)
    {
        return $this->db->query("SELECT p.ID_Pengembalian, m.Plat_Motor, m.Tarif_Denda, p.ID_Transaksi, p.Total_Biaya, p.Tarif_Denda, p.Tarif_Kerusakan,
            p.Waktu_Keterlambatan, p.Status FROM pengembalian p
            JOIN transaksi t ON p.ID_Transaksi = t.ID_Transaksi
            JOIN motor m ON t.ID_Motor = m.ID_Motor
            WHERE p.deleted_at IS NULL AND p.Status = 'Selesai' AND t.Tanggal_Pengembalian BETWEEN '$Tanggal_Pengembalian' AND DATE_ADD('$Tanggal_Pengembalian2',INTERVAL 1 DAY)
            GROUP BY p.ID_Pengembalian")->getResultArray();
    }
}