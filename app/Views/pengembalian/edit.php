<!DOCTYPE html>
<html lang="en">
<?= $this->include('layout/header') ?>

<body class="sb-nav-fixed">
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
                    <!-- Form Ubah Pengembalian -->
                    <form action="/pengembalian/edit/<?= $result['ID_Pengembalian'] ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <input type="hidden" name="ID_Pengembalian" value="<?= $result['ID_Pengembalian'] ?>">
                    <?php if (in_groups(['Pelanggan'])) : ?>
                        <div class="mb-3 row">
                            <label for="ID_Transaksi" class="col-sm-2 col-form-label">Plat Motor</label>
                                <div class="col-sm-5">
                                    <select type="text" class="form-control" id="ID_Transaksi" name="ID_Transaksi">
                                        <?php
                                            $ini_id = $result['ID_Transaksi'];
                                            $motor = mysqli_query($connection, "SELECT t.ID_Transaksi, t.ID_Motor, m.Plat_Motor FROM transaksi t
                                            JOIN motor m ON t.ID_Motor = m.ID_Motor
                                            WHERE t.deleted_at IS NULL AND t.ID_Transaksi = $ini_id;");
                                        ?>
                                        <option value="<?php
                                            $get_motor = mysqli_fetch_assoc($motor);
                                            echo $get_motor['ID_Transaksi'];
                                        ?>"><?php
                                            echo $get_motor['Plat_Motor'];
                                        ?></option>
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
                            <select type="text" class="form-control" id="ID_Transaksi" name="ID_Transaksi">
                                <?php
                                    $ini_id = $result['ID_Transaksi'];
                                    $motor = mysqli_query($connection, "SELECT t.ID_Transaksi, t.ID_Motor, m.Plat_Motor FROM transaksi t
                                    JOIN motor m ON t.ID_Motor = m.ID_Motor
                                    WHERE t.deleted_at IS NULL AND t.ID_Transaksi != $ini_id;");
                                    $data = mysqli_query($connection, "SELECT t.ID_Transaksi, t.ID_Motor, m.Plat_Motor FROM transaksi t
                                    JOIN motor m ON t.ID_Motor = m.ID_Motor
                                    WHERE t.deleted_at IS NULL AND t.ID_Transaksi = $ini_id;");
                                ?>
                                <option value="<?php
                                    $get_data = mysqli_fetch_assoc($data);
                                    echo $get_data['ID_Transaksi'];
                                ?>"><?php
                                    echo $get_data['Plat_Motor']
                                ?></option>
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
                                <input type="text" class="form-control <?= $validation->hasError('Waktu_Keterlambatan') ? 'is-invalid' : '' ?> " id="Waktu_Keterlambatan" name="Waktu_Keterlambatan" value="<?= old('Waktu_Keterlambatan', $result['Waktu_Keterlambatan']) ?>">
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    <?= $validation->getError('Waktu_Keterlambatan') ?>
                                </div>
                            </div>
                        </div>
                    <?php if (in_groups(['Owner'])) : ?>
                        <div class="mb-3 row">
                            <label for="Tarif_Kerusakan" class="col-sm-2 col-form-label">Tarif Kerusakan</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control <?= $validation->hasError('Tarif_Kerusakan') ? 'is-invalid' : '' ?> " id="Tarif_Kerusakan" name="Tarif_Kerusakan" value="<?= old('Tarif_Kerusakan', $result['Tarif_Kerusakan']) ?>">
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    <?= $validation->getError('Tarif_Kerusakan') ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (in_groups(['Pelanggan'])) : ?>
                        <div class="mb-3 row">
                            <label for="Status" class="col-sm-2 col-form-label">Status</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="Status" name="Status" value="<?= $result['Status'] ?>"readonly>
                                </div>
                        </div>
                    <?php endif; ?>
                    <?php if (in_groups(['Owner'])) : ?>
                        <div class="mb-3 row">
                            <label for="Status" class="col-sm-2 col-form-label">Status</label>
                            <div class="col-sm-5">
                                <select type="text" class="form-control" id="Status" name="Status">
                                    <?php
                                        $ini_id = $result['ID_Pengembalian'];
                                        $pengembalian = mysqli_query($connection, "SELECT Status FROM pengembalian WHERE ID_Pengembalian = '$ini_id';");
                                        $get_pengembalian = mysqli_fetch_assoc($pengembalian);
                                        if($get_pengembalian['Status'] == "Selesai")
                                        {
                                    ?>
                                            <option value="Selesai">Selesai</option>
                                            <option value="Belum Selesai">Belum Selesai</option>
                                    <?php
                                        } else {
                                    ?>
                                            <option value="Belum Selesai">Belum Selesai</option>
                                            <option value="Selesai">Selesai
                                                <input type="hidden" name="Status_Transaksi" value="Sudah Membayar"></input>
                                                <input type="hidden" name="Status_Motor" value="Tersedia">
                                                <?php
                                                    $id_transaksi = $result['ID_Transaksi'];
                                                    $motor = mysqli_query($connection, "SELECT ID_Motor FROM transaksi WHERE ID_Transaksi = '$id_transaksi';");
                                                    $get_motor = mysqli_fetch_assoc($motor);
                                                ?>
                                                <input type="hidden" name="ID_Motor" value="<?= $get_motor['ID_Motor'] ?>">
                                            </option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    <?php endif; ?>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <div class="d-grid gap-2 d-md-block">
                                <a class="btn btn-dark" type="button" href="/pengembalian">Kembali</a>
                            </div>
                            <button class="btn btn-primary me-md-2" type="submit">Perbarui</button>
                            <button class="btn btn-danger" type="reset">Batal</button>
                        </div>
                    </form>
                    <!-- -->
                </div>
            </div>
        </div>
    </main>
    <?= $this->endSection() ?>