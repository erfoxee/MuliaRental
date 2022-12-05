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
            <h1 class="h3 mb-2 text-gray-800">TAMBAH DATA TRANSAKSI</h1>
            <p class="mb-4">Tambah Data Transaksi Mulia Rental<a target="_blank"></a>.</p>

            <!-- Form Tambah Transaksi -->
            <form action="/transaksi/create" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
            <?php if (in_groups(['Pelanggan'])) : ?>
                <div class="mb-3 row">
                    <label for="ID_Pelanggan" class="col-sm-2 col-form-label">NIK</label>
                    <div class="col-sm-5">
                        <select type="text" class="form-control" id="ID_Pelanggan" name="ID_Pelanggan">
                            <?php
                                $id = session()->get('logged_in');
                                $pelanggan = mysqli_query($connection, "SELECT id, NIK FROM users WHERE deleted_at IS NULL AND NIK IS NOT NULL AND id = '$id';");
                            ?>
                            <option value="<?php
                                $get_pelanggan = mysqli_fetch_assoc($pelanggan);
                                echo $get_pelanggan['id'];
                            ?>"><?php
                                echo $get_pelanggan['NIK'];
                            ?></option>
                        </select>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (in_groups(['Owner'])) : ?>
                <div class="mb-3 row">
                    <label for="ID_Pelanggan" class="col-sm-2 col-form-label">NIK</label>
                    <div class="col-sm-5">
                        <select type="text" class="form-control <?= $validation->hasError('ID_Pelanggan') ? 'is-invalid' : '' ?> " id="ID_Pelanggan" name="ID_Pelanggan">
                            <?php
                                $pelanggan = mysqli_query($connection, "SELECT id, NIK, firstname, lastname FROM users WHERE NIK IS NOT NULL AND deleted_at IS NULL;");
                            ?>
                            <option value=""></option>
                            <?php
                                while($get_pelanggan = mysqli_fetch_array($pelanggan)){
                            ?>
                            <option value="<?php
                                echo $get_pelanggan['id'] . ' - ' . $get_pelanggan['firstname'] . ' ' . $get_pelanggan['lastname'];
                            ?>"><?php
                                echo $get_pelanggan['NIK'] . ' - ' . $get_pelanggan['firstname'] . ' ' . $get_pelanggan['lastname'];
                            ?></option>
                            <?php
                                }
                            ?>
                        </select>
                        <div id="validationServer03Feedback" class="invalid-feedback">
                            <?= $validation->getError('ID_Pelanggan') ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
                <div class="mb-3 row">
                    <label for="ID_Motor" class="col-sm-2 col-form-label">Plat Motor</label>
                    <div class="col-sm-5">
                        <select type="text" class="form-control <?= $validation->hasError('ID_Motor') ? 'is-invalid' : '' ?> " id="ID_Motor" name="ID_Motor">
                            <?php
                                $motor = mysqli_query($connection, "SELECT ID_Motor, Plat_Motor FROM motor WHERE deleted_at IS NULL AND Status = 'Tersedia';");
                            ?>
                            <option value=""></option>
                            <?php
                            while($get_motor = mysqli_fetch_array($motor)){
                            ?>
                            <option value="<?php
                                echo $get_motor['ID_Motor'];
                            ?>"><?php
                                echo $get_motor['Plat_Motor'];
                            ?></option>
                            <?php
                                }
                            ?>
                        </select>
                        <div id="validationServer03Feedback" class="invalid-feedback">
                            <?= $validation->getError('ID_Motor') ?>
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="Tanggal_Peminjaman" class="col-sm-2 col-form-label">Tanggal Peminjaman</label>
                    <div class="col-sm-5">
                        <input type="date" class="form-control <?= $validation->hasError('Tanggal_Peminjaman') ? 'is-invalid' : '' ?> " id="Tanggal_Peminjaman" name="Tanggal_Peminjaman" value="<?= old('Tanggal_Peminjaman') ?>">
                        <div id="validationServer03Feedback" class="invalid-feedback">
                            <?= $validation->getError('Tanggal_Peminjaman') ?>
                        </div>
                    </div>
                    <label for="Tanggal_Pengembalian" class="col-sm-2 col-form-label">Tanggal Pengembalian</label>
                    <div class="col-sm-3">
                        <input type="date" class="form-control <?= $validation->hasError('Tanggal_Pengembalian') ? 'is-invalid' : '' ?>" id="Tanggal_Pengembalian" name="Tanggal_Pengembalian" value="<?= old('Tanggal_Pengembalian') ?>">
                        <div id="validationServer03Feedback" class="invalid-feedback">
                            <?= $validation->getError('Tanggal_Pengembalian') ?>
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="Tanggal_Transaksi" class="col-sm-2 col-form-label">Tanggal Transaksi</label>
                    <div class="col-sm-5">
                        <input type="date" class="form-control <?= $validation->hasError('Tanggal_Transaksi') ? 'is-invalid' : '' ?> " id="Tanggal_Transaksi" name="Tanggal_Transaksi" value="<?= old('Tanggal_Transaksi') ?>">
                        <div id="validationServer03Feedback" class="invalid-feedback">
                            <?= $validation->getError('Tanggal_Transaksi') ?>
                        </div>
                    </div>
                    <label for="Jaminan" class="col-sm-2 col-form-label">Jaminan</label>
                    <div class="col-sm-3">
                        <select type="text" class="form-control <?= $validation->hasError('Jaminan') ? 'is-invalid' : '' ?> " id="Jaminan" name="Jaminan">
                            <option value=""></option>
                            <option value="KTP">KTP</option>
                            <option value="STNK">STNK</option>
                        </select>
                        <div id="validationServer03Feedback" class="invalid-feedback">
                            <?= $validation->getError('Jaminan') ?>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="Status" value="Belum Membayar">
                <input type="hidden" name="Status_Motor" value="Tidak Tersedia">

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <div class="d-grid gap-2 d-md-block">
                        <a class="btn btn-dark" type="button" href="/transaksi">Kembali</a>
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