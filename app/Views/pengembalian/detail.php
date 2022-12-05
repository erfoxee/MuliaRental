<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "thegoddess";

    $connection = mysqli_connect($servername, $username, $password, $dbname);

    if(!$connection){
        die("connection failed : " . mysqli_connect_error());
    }
?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">DATA PENGEMBALIAN</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Pengelolaan Data Pengembalian</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                <?= $title ?>
            </div>
            <div class="card-body">
                <!-- Isi Detail -->
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src = https://media.discordapp.net/attachments/761218897454039055/1035186901327560735/unknown-removebg-preview.png width="300" height="200">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">Plat Motor : 
                                    <?php 
                                        $id_transaksi = $result['ID_Transaksi'];
                                        $motor = mysqli_query($connection, "SELECT Plat_Motor FROM motor WHERE ID_Motor = 
                                            (SELECT ID_Motor FROM transaksi WHERE ID_Transaksi = $id_transaksi);");
                                    ?>
                                    <?php
                                        $get_motor = mysqli_fetch_assoc($motor);
                                        echo $get_motor['Plat_Motor'];
                                    ?>
                                </h5>
                                <p class="card-text">Total Biaya : <?= number_to_currency($result['Total_Biaya'], 'IDR', 'id_ID', 2) ?></p>
                                <p class="card-text">Tarif Denda : <?= number_to_currency($result['Tarif_Denda'], 'IDR', 'id_ID', 2) ?></p>
                                <p class="card-text">Waktu Keterlambatan : <?= $result['Waktu_Keterlambatan'] ?> Hari</p>
                                <p class="card-text">Status : <?= $result['Status'] ?></p>
                                <p class="card-text">Tarif Kerusakan : <?= number_to_currency($result['Tarif_Kerusakan'], 'IDR', 'id_ID', 2) ?></p>
                                <div class="d-grid gap-2 d-md-block">
                                    <a class="btn btn-dark" type="button" href="/pengembalian">Kembali</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--  -->
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>