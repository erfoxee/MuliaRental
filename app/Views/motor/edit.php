<!DOCTYPE html>
<html lang="en">
<?= $this->include('layout/header') ?>

<body class="sb-nav-fixed">
    <?= $this->extend('layout/template') ?>

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

    <?= $this->section('content') ?>
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">DATA MOTOR</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Pengelolaan Data Motor</li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    <?= $title ?>
                </div>
                <div class="card-body">
                    <!-- Form Ubah Motor -->
                    <form action="/motor/edit/<?= $result['ID_Motor'] ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <input type="hidden" name="ID_Motor" value="<?= $result['ID_Motor'] ?>">
                        <div class="mb-3 row">
                            <label for="Plat_Motor" class="col-sm-2 col-form-label">Plat Motor</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control <?= $validation->hasError('Plat_Motor') ? 'is-invalid' : '' ?>"
                                id="Plat_Motor" name="Plat_Motor" value="<?= old('Plat_Motor',$result['Plat_Motor']) ?>">
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    <?= $validation->getError('Plat_Motor') ?>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="Jenis_Motor" class="col-sm-2 col-form-label">Jenis Motor</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control <?= $validation->hasError('Jenis_Motor') ? 'is-invalid' : '' ?>" 
                                id="Jenis_Motor" name="Jenis_Motor" value="<?= old('Jenis_Motor',$result['Jenis_Motor']) ?>">
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    <?= $validation->getError('Jenis_Motor') ?>
                                </div>
                            </div>
                            <label for="STNK" class="col-sm-2 col-form-label">STNK</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control <?= $validation->hasError('STNK') ? 'is-invalid' : '' ?>" 
                                id="STNK" name="STNK" value="<?= old('STNK',$result['STNK']) ?>">
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    <?= $validation->getError('STNK') ?>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="Jumlah_Motor" class="col-sm-2 col-form-label">Jumlah Motor</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control <?= $validation->hasError('Jumlah_Motor') ? 'is-invalid' : '' ?>" 
                                id="Jumlah_Motor" name="Jumlah_Motor" value="<?= old('Jumlah_Motor',$result['Jumlah_Motor']) ?>">
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    <?= $validation->getError('Jumlah_Motor') ?>
                                </div>
                            </div>
                            <label for="Merk_Motor" class="col-sm-2 col-form-label">Merk Motor</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control <?= $validation->hasError('Merk_Motor') ? 'is-invalid' : '' ?>" 
                                id="Merk_Motor" name="Merk_Motor" value="<?= old('Merk_Motor',$result['Merk_Motor']) ?>">
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    <?= $validation->getError('Merk_Motor') ?>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="Warna_Motor" class="col-sm-2 col-form-label">Warna Motor</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control <?= $validation->hasError('Warna_Motor') ? 'is-invalid' : '' ?>" 
                                id="Warna_Motor" name="Warna_Motor" value="<?= old('Warna_Motor',$result['Warna_Motor']) ?>">
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    <?= $validation->getError('Warna_Motor') ?>
                                </div>
                            </div>
                            <label for="Tarif" class="col-sm-2 col-form-label">Tarif</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control <?= $validation->hasError('Tarif') ? 'is-invalid' : '' ?>" 
                                id="Tarif" name="Tarif" value="<?= old('Tarif',$result['Tarif']) ?>">
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    <?= $validation->getError('Tarif') ?>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="Tarif_Denda" class="col-sm-2 col-form-label">Tarif Denda</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control <?= $validation->hasError('Tarif_Denda') ? 'is-invalid' : '' ?>" id="Tarif_Denda" name="Tarif_Denda" value="<?= old('Tarif_Denda', $result['Tarif_Denda']) ?>">
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    <?= $validation->getError('Tarif_Denda') ?>
                                </div>
                            </div>
                            <label for="Status" class="col-sm-2 col-form-label">Status</label>
                            <div class="col-sm-3">
                                <select type="text" class="form-control" id="Status" name="Status">
                                <?php
                                        $ini_id = $result['ID_Motor'];
                                        $motor = mysqli_query($connection, "SELECT Status FROM motor WHERE ID_Motor = '$ini_id';");
                                        $get_motor = mysqli_fetch_assoc($motor);
                                        if($get_motor['Status'] == "Tersedia")
                                        {
                                    ?>
                                            <option value="Tersedia">Tersedia</option>
                                            <option value="Tidak Tersedia">Tidak Tersedia</option>
                                    <?php
                                        } else {
                                    ?>
                                            <option value="Tidak Tersedia">Tidak Tersedia</option>
                                            <option value="Tersedia">Tersedia</option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="sampul" class="col-sm-2 col-form-label">Sampul</label>
                            <div class="col-sm-5">
                                <input type="hidden" name="sampullama" value="<?= $result['cover'] ?>">
                                <input type="file" class="form-control <?= $validation->hasError('sampul') ?
                                'is-invalid' : '' ?>" id="sampul" name="sampul" onchange="previewImage()">
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    <?= $validation->getError('sampul') ?>
                                </div>
                                <div class="col-sm-6 mt-2">
                                    <img src="/img/<?= $result['cover'] == "" ? "default.jpg" : $result['cover'] ?>" alt="" class="img-thumbnail img-preview">
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <div class="d-grid gap-2 d-md-block">
                                <a class="btn btn-dark" type="button" href="/motor">Kembali</a>
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