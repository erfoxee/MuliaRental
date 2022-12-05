<?php

namespace App\Models;

use CodeIgniter\Model;

class MotorModel extends Model
{
    protected $table            = 'motor';
    protected $primaryKey       = 'ID_Motor';
    protected $useTimestamps    = true;
    protected $allowedFields    = [
        'Plat_Motor', 'Jenis_Motor', 'Jumlah_Motor', 'cover', 'Merk_Motor', 'Warna_Motor', 'Tarif', 'Tarif_Denda', 'STNK', 'Status'
    ];
    protected $useSoftDeletes = true;

    public function getMotor($ID_Motor = false)
    {
        $query = $this->table('motor')
            ->where('deleted_at is null');

        if ($ID_Motor == false)
            return $query->get()->getResultArray();
        return $query->where(['ID_Motor' => $ID_Motor])->first();
    }

    // Get value tarif (untuk bagian transaksi)
    public function getTarif($ID_Motor, $durasi){
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "thegoddess";
    
        $connection = mysqli_connect($servername, $username, $password, $dbname);
    
        if(!$connection){
            die("connection failed : " . mysqli_connect_error());
        }
    
        $tarif_akhir = 0;
    
        $tarif = mysqli_query($connection, "SELECT Tarif FROM motor WHERE ID_Motor = '$ID_Motor' AND deleted_at IS NULL");
        $get_tarif = mysqli_fetch_assoc($tarif);
        $tarif_akhir = $durasi * $get_tarif['Tarif'];
        return $tarif_akhir;
    }

    public function getHarga()
    {
        return $this->db->query("SELECT Tarif FROM motor")->getResultArray();
    }
}