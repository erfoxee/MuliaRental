<html>

<head>
    <!-- Berisi CSS --> 
    <style>
        .title {
            text-align: center;
            font-family: Arial, Helvetica, sans-serif;
        }
        .left {
            text-align: left;
        }
        .right {
            text-align: right;
        }
        .border-table {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
            text-align: center;
            font-size: 12px;
        }
        .border-table th {
            border: 1px solid #000;
            background-color: #e1e3e9;
            font-weight: bold;
        }
        .border-table td {
            border: 1px solid #000;
        }
    </style>
</head>

<body>
    <main>
        <div class="title">
            <h1>NOTA TRANSAKSI</h1>
        </div>
        <div>
            <!-- Isi Laporan --> 
            <table class="border-table">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="17%">NIK</th>
                        <th width="10%">Plat Motor</th>
                        <th width="10%">Total Harga</th>
                        <th width="16%">Tanggal Transaksi</th>
                        <th width="16%">Tanggal Peminjaman</th>
                        <th width="16%">Tanggal Pengembalian</th>
                        <th width="10%">Jaminan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($result as $value) : ?>
                    <tr>
                        <td width="5%"><?= $no++ ?></td>
                        <td width="17%"><?= $value['NIK'] ?></td>
                        <td width="10%"><?= $value['Plat_Motor'] ?></td>
                        <td width="10%"><?= number_to_currency($value['Total_Harga'], 'IDR', 'id_ID', 2) ?></td>
                        <td width="16%"><?= $value['Tanggal_Transaksi'] ?></td>
                        <td width="16%"><?= $value['Tanggal_Peminjaman'] ?></td>
                        <td width="16%"><?= $value['Tanggal_Pengembalian'] ?></td>
                        <td width="10%"><?= $value['Jaminan'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <!-- --> 
        </div>
    </main>
</body>
</html>