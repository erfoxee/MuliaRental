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

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Mulia Rental - Tables</title>
</head>

<body id="page-top">
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <?= $this->include('layout/topbar') ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">TAMBAH DATA PENGEMBALIAN</h1>
            <p class="mb-4">Tambah Data Pengembalian Mulia Rental<a target="_blank"></a>.</p>

            <!-- Form Tambah Pengembalian -->
            <form action="/pengembalian/create" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
            <?php if (in_groups(['Pelanggan'])) : ?>
                <div class="mb-3 row">
                    <label for="ID_Transaksi" class="col-sm-2 col-form-label">Plat Motor</label>
                    <div class="col-sm-5">
                        <select type="text" class="form-control <?= $validation->hasError('ID_Transaksi') ? 'is-invalid' : '' ?> " id="ID_Transaksi" name="ID_Transaksi">
                            <?php
                                $id = session()->get('logged_in');
                                $motor = mysqli_query($connection, "SELECT t.ID_Transaksi, t.ID_Motor, u.NIK, m.Plat_Motor, m.ID_Motor FROM transaksi t
                                JOIN motor m ON m.ID_Motor = t.ID_Motor
                                JOIN users u ON u.id = t.ID_Pelanggan
                                WHERE t.deleted_at IS NULL AND u.id = '$id' AND t.Status = 'Belum Membayar';");
                            ?>
                            <option value=""></option>
                            <?php
                                while($get_motor = mysqli_fetch_array($motor)){
                            ?>
                            <option value="<?php
                                echo $get_motor['ID_Transaksi'];
                            ?>"><?php
                                echo $get_motor['Plat_Motor'];
                            ?></option>
                            <?php
                                }
                            ?>
                        </select>
                        <div id="validationServer03Feedback" class="invalid-feedback">
                            <?= $validation->getError('ID_Transaksi') ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (in_groups(['Owner'])) : ?>
                <div class="mb-3 row">
                    <label for="ID_Transaksi" class="col-sm-2 col-form-label">Plat Motor</label>
                    <div class="col-sm-5">
                        <select type="text" class="form-control <?= $validation->hasError('ID_Transaksi') ? 'is-invalid' : '' ?> " id="ID_Transaksi" name="ID_Transaksi">
                            <?php
                                $motor = mysqli_query($connection, "SELECT t.ID_Transaksi, t.ID_Motor, u.NIK, m.Plat_Motor, m.ID_Motor FROM transaksi t
                                JOIN motor m ON m.ID_Motor = t.ID_Motor
                                JOIN users u ON u.id = t.ID_Pelanggan
                                WHERE t.deleted_at IS NULL AND t.Status = 'Belum Membayar'");
                            ?>
                            <option value=""></option>
                            <?php
                                while($get_motor = mysqli_fetch_array($motor)){
                            ?>
                            <option value="<?php
                                echo $get_motor['ID_Transaksi'];
                            ?>"><?php
                                echo $get_motor['Plat_Motor'];
                            ?></option>
                            <?php
                                }
                            ?>
                        </select>
                        <div id="validationServer03Feedback" class="invalid-feedback">
                            <?= $validation->getError('ID_Transaksi') ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
                <div class="mb-3 row">
                    <label for="Waktu_Keterlambatan" class="col-sm-2 col-form-label">Waktu Keterlambatan</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control <?= $validation->hasError('Waktu_Keterlambatan') ? 'is-invalid' : '' ?> " id="Waktu_Keterlambatan" name="Waktu_Keterlambatan" value="<?= old('Waktu_Keterlambatan') ?>">
                        <div id="validationServer03Feedback" class="invalid-feedback">
                            <?= $validation->getError('Waktu_Keterlambatan') ?>
                        </div>
                    </div>
                </div>
            <?php if (in_groups(['Owner'])) : ?>
                <div class="mb-3 row">
                    <label for="Tarif_Kerusakan" class="col-sm-2 col-form-label">Tarif Kerusakan</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control <?= $validation->hasError('Tarif_Kerusakan') ? 'is-invalid' : '' ?> " id="Tarif_Kerusakan" name="Tarif_Kerusakan" value="<?= old('Tarif_Kerusakan') ?>">
                        <div id="validationServer03Feedback" class="invalid-feedback">
                            <?= $validation->getError('Tarif_Kerusakan') ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
                <input type="hidden" name="Status" value="Belum Selesai">

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <div class="d-grid gap-2 d-md-block">
                        <a class="btn btn-dark" type="button" href="/pengembalian">Kembali</a>
                    </div>
                    <button class="btn btn-primary me-md-2" type="submit">Simpan</button>
                    <button class="btn btn-danger" type="reset">Batal</button>
                </div>
            </form>
            <!-- -->
        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
</body>

</html>
<?= $this->endSection() ?>