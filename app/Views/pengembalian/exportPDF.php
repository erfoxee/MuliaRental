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
            <h1>NOTA PENGEMBALIAN</h1>
        </div>
        <div>
            <!-- Isi Laporan --> 
            <table class="border-table">
                <thead>
                    <tr>
                        <th width="20%">Plat Motor</th>
                        <th width="20%">Total Biaya</th>
                        <th width="20%">Tarif Denda</th>
                        <th width="20%">Waktu Keterlambatan</th>
                        <th width="20%">Tarif Kerusakan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($result as $value) : ?>
                    <tr>
                        <td width="20%"><?= $value['Plat_Motor'] ?></td>
                        <td width="20%"><?= number_to_currency($value['Total_Biaya'], 'IDR', 'id_ID', 2) ?></td>
                        <td width="20%"><?= number_to_currency($value['Tarif_Denda'], 'IDR', 'id_ID', 2) ?></td>
                        <td width="20%"><?= $value['Waktu_Keterlambatan'] ?> Hari</td>
                        <td width="20%"><?= number_to_currency($value['Tarif_Kerusakan'], 'IDR', 'id_ID', 2) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <!-- --> 
        </div>
    </main>
</body>
</html>