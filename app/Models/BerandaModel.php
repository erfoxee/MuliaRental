<?php

namespace App\Models;

use CodeIgniter\Model;

class BerandaModel extends Model
{
    public function reportTransaksi($tahun)
    {
        return $this->db->query("SELECT MONTH(t.Tanggal_Transaksi) month, SUM(t.Total_Harga) total FROM transaksi t
        WHERE YEAR(t.Tanggal_Transaksi) = '$tahun'
        GROUP BY MONTH(t.Tanggal_Transaksi)
        ORDER BY MONTH(t.Tanggal_Transaksi);")->getResultArray();
    }

    public function reportPengembalian($tahun)
    {
        return $this->db->query("SELECT MONTH(t.Tanggal_Pengembalian) month, SUM(p.Total_Biaya) total FROM pengembalian p
        JOIN transaksi t ON t.ID_Transaksi = p.ID_Transaksi
        WHERE YEAR(t.Tanggal_Pengembalian) = '$tahun'
        GROUP BY MONTH(t.Tanggal_Pengembalian)
        ORDER BY MONTH(t.Tanggal_Pengembalian);")->getResultArray();
    }

    public function reportPelanggan($tahun)
    {
        return $this->db->query("SELECT MONTH(Tanggal_Transaksi) month, COUNT(DISTINCT ID_Pelanggan) total FROM transaksi
        WHERE YEAR(Tanggal_Transaksi) = '$tahun'
        GROUP BY MONTH(Tanggal_Transaksi)
        ORDER BY MONTH(Tanggal_Transaksi);")->getResultArray();
    }

    public function reportJumlah($tahun)
    {
        return $this->db->query("SELECT MONTH(Tanggal_Transaksi) month, COUNT(ID_Transaksi) total FROM transaksi
        WHERE YEAR(Tanggal_Transaksi) = '$tahun'
        GROUP BY MONTH(Tanggal_Transaksi)
        ORDER BY MONTH(Tanggal_Transaksi);")->getResultArray();
    }

    public function reportPendapatan()
    {
        $tahun = date('Y');
        return $this->db->query("SELECT YEAR(Tanggal_Transaksi) year, SUM(Total_Harga) total FROM transaksi
        WHERE YEAR(Tanggal_Transaksi) = '$tahun';")->getResultArray();
    }

    public function getPengembalian()
    {
        $tahun = date('Y');
        return $this->db->query("SELECT YEAR(t.Tanggal_Pengembalian) year, SUM(p.Tarif_Denda * p.Waktu_Keterlambatan) total FROM pengembalian p
        JOIN transaksi t ON t.ID_Transaksi = p.ID_Transaksi
        WHERE YEAR(t.Tanggal_Pengembalian) = '$tahun';")->getResultArray();
    }

    public function getStatus()
    {
        return $this->db->query("SELECT COUNT(ID_Motor) total FROM motor
        WHERE Status = 'Tersedia'")->getResultArray();
    }

    public function getRusak()
    {
        $tahun = date('Y');
        return $this->db->query("SELECT YEAR(t.Tanggal_Transaksi) year, SUM(p.Tarif_Kerusakan) total FROM pengembalian p
        JOIN transaksi t ON t.ID_Transaksi = p.ID_Transaksi
        WHERE YEAR(t.Tanggal_Transaksi) = '$tahun';")->getResultArray();
    }
}