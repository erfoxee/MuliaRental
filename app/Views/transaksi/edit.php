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
            <h1 class="mt-4">DATA TRANSAKSI</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Pengelolaan Data Transaksi</li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    <?= $title ?>
                </div>
                <div class="card-body">
                    <!-- Form Ubah Transaksi -->
                    <form action="/transaksi/edit/<?= $result['ID_Transaksi'] ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <input type="hidden" name="ID_Transaksi" value="<?= $result['ID_Transaksi'] ?>">
                    <?php if (in_groups(['Pelanggan'])) : ?>
                        <div class="mb-3 row">
                            <label for="ID_Pelanggan" class="col-sm-2 col-form-label">NIK</label>
                            <div class="col-sm-5">
                                <select type="text" class="form-control" id="ID_Pelanggan" name="ID_Pelanggan">
                                    <?php
                                        $ini_id = $result['ID_Transaksi'];
                                        $users = mysqli_query($connection, "SELECT id, NIK FROM users WHERE deleted_at IS NULL AND NIK IS NOT NULL AND id = (SELECT ID_Pelanggan FROM transaksi WHERE ID_Transaksi = $ini_id);");
                                    ?>
                                    <option value="<?php
                                        $get_users = mysqli_fetch_assoc($users);
                                        echo $get_users['id'];
                                    ?>"><?php
                                        echo $get_users['NIK'];
                                    ?></option>
                                </select>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (in_groups(['Owner'])) : ?>
                        <div class="mb-3 row">
                            <label for="ID_Pelanggan" class="col-sm-2 col-form-label">NIK</label>
                            <div class="col-sm-5">
                                <select type="text" class="form-control" id="ID_Pelanggan" name="ID_Pelanggan">
                                    <?php
                                        $ini_id = $result['ID_Transaksi'];
                                        $users = mysqli_query($connection, "SELECT id, NIK FROM users WHERE deleted_at IS NULL AND NIK IS NOT NULL AND id != (SELECT ID_Pelanggan FROM transaksi WHERE ID_Transaksi = $ini_id);");
                                        $data = mysqli_query($connection, "SELECT id, NIK FROM users WHERE deleted_at IS NULL AND NIK IS NOT NULL AND id = (SELECT ID_Pelanggan FROM transaksi WHERE ID_Transaksi = $ini_id);");
                                    ?>
                                    <option value="<?php
                                        $get_data = mysqli_fetch_assoc($data);
                                        echo $get_data['id'];
                                    ?>"><?php
                                        echo $get_data['NIK'];
                                    ?></option>
                                    <?php
                                        while($get_users = mysqli_fetch_array($users)){
                                    ?>
                                    <option value="<?php
                                        echo $get_users['id'];
                                    ?>"><?php
                                        echo $get_users['NIK'];
                                    ?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (in_groups(['Pelanggan'])) : ?>
                        <div class="mb-3 row">
                            <label for="ID_Motor" class="col-sm-2 col-form-label">Plat Motor</label>
                            <div class="col-sm-5">
                                <select type="text" class="form-control" id="ID_Motor" name="ID_Motor">
                                    <?php
                                        $ini_id = $result['ID_Transaksi'];
                                        $motor = mysqli_query($connection, "SELECT ID_Motor, Plat_Motor FROM motor WHERE deleted_at IS NULL AND Status = 'Tidak Tersedia' AND ID_Motor = (SELECT ID_Motor FROM transaksi WHERE ID_Transaksi = $ini_id);");
                                    ?>
                                    <option value="<?php
                                        $get_motor = mysqli_fetch_assoc($motor);
                                        echo $get_motor['ID_Motor'];
                                    ?>"><?php
                                        echo $get_motor['Plat_Motor'];
                                    ?></option>
                                </select>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (in_groups(['Owner'])) : ?>
                        <div class="mb-3 row">
                            <label for="ID_Motor" class="col-sm-2 col-form-label">Plat Motor</label>
                            <div class="col-sm-5">
                                <select type="text" class="form-control" id="ID_Motor" name="ID_Motor">
                                    <?php
                                        $ini_id = $result['ID_Transaksi'];
                                        $motor = mysqli_query($connection, "SELECT ID_Motor, Plat_Motor FROM motor WHERE deleted_at IS NULL AND Status = 'Tidak Tersedia' AND ID_Motor != (SELECT ID_Motor FROM transaksi WHERE ID_Transaksi = $ini_id);");
                                        $data = mysqli_query($connection, "SELECT ID_Motor, Plat_Motor FROM motor WHERE deleted_at IS NULL AND Status = 'Tidak Tersedia' AND ID_Motor = (SELECT ID_Motor FROM transaksi WHERE ID_Transaksi = $ini_id);");
                                    ?>
                                    <option value="<?php
                                        $get_data = mysqli_fetch_assoc($data);
                                        echo $get_data['ID_Motor'];
                                    ?>"><?php
                                        echo $get_data['Plat_Motor'];
                                    ?></option>
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
                            </div>
                        </div>
                    <?php endif; ?>
                        <div class="mb-3 row">
                            <label for="Tanggal_Peminjaman" class="col-sm-2 col-form-label">Tanggal Peminjaman</label>
                            <div class="col-sm-5">
                                <input type="date" class="form-control <?= $validation->hasError('Tanggal_Peminjaman') ? 'is-invalid' : '' ?> " id="Tanggal_Peminjaman" name="Tanggal_Peminjaman" value="<?= old('Tanggal_Peminjaman', $result['Tanggal_Peminjaman']) ?>">
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    <?= $validation->getError('Tanggal_Peminjaman') ?>
                                </div>
                            </div>
                            <label for="Tanggal_Pengembalian" class="col-sm-2 col-form-label">Tanggal Pengembalian</label>
                            <div class="col-sm-3">
                                <input type="date" class="form-control <?= $validation->hasError('Tanggal_Pengembalian') ? 'is-invalid' : '' ?>" id="Tanggal_Pengembalian" name="Tanggal_Pengembalian" value="<?= old('Tanggal_Pengembalian', $result['Tanggal_Pengembalian']) ?>">
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    <?= $validation->getError('Tanggal_Pengembalian') ?>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="Jaminan" class="col-sm-2 col-form-label">Jaminan</label>
                            <div class="col-sm-3">
                                <select type="text" class="form-control" id="Status" name="Jaminan">
                                    <?php
                                        $ini_id = $result['ID_Transaksi'];
                                        $transaksi = mysqli_query($connection, "SELECT Jaminan FROM transaksi WHERE ID_Transaksi = '$ini_id';");
                                        $get_transaksi = mysqli_fetch_assoc($transaksi);
                                        if($get_transaksi['Jaminan'] == "KTP")
                                        {
                                    ?>
                                            <option value="KTP">KTP</option>
                                            <option value="STNK">STNK</option>
                                    <?php
                                        } else {
                                    ?>
                                            <option value="STNK">STNK</option>
                                            <option value="KTP">KTP</option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <?php if (in_groups(['Pelanggan'])) : ?>
                        <div class="mb-3 row">
                            <label for="Status" class="col-sm-2 col-form-label">Status</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="Status" name="Status" value="<?= $result['Status'] ?>" readonly>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if (in_groups(['Owner'])) : ?>
                        <div class="mb-3 row">
                            <label for="Status" class="col-sm-2 col-form-label">Status</label>
                            <div class="col-sm-3">
                                <select type="text" class="form-control" id="Status" name="Status">
                                    <?php
                                        $ini_id = $result['ID_Transaksi'];
                                        $transaksi = mysqli_query($connection, "SELECT Status FROM transaksi WHERE ID_Transaksi = '$ini_id';");
                                        $get_transaksi = mysqli_fetch_assoc($transaksi);
                                        if($get_transaksi['Status'] == "Sudah Membayar")
                                        {
                                    ?>
                                            <option value="Sudah Membayar">Sudah Membayar</option>
                                            <option value="Belum Membayar">Belum Membayar</option>
                                    <?php
                                        } else {
                                    ?>
                                            <option value="Belum Membayar">Belum Membayar</option>
                                            <option value="Sudah Membayar">Sudah Membayar</option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <div class="d-grid gap-2 d-md-block">
                                <a class="btn btn-dark" type="button" href="/transaksi">Kembali</a>
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