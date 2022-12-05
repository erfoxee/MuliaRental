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
            <h1 class="h3 mb-2 text-gray-800">DATA USER</h1>
            <p class="mb-4">Data User Mulia Rental <a target="_blank"></a>.</p>

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Data User</h6>
                    <!-- Start Flash Data -->
                    <?php if (session()->getFlashdata('msg')) : ?>
                        <div class="alert alert-success" role="alert">
                            <?=session()->getFlashdata('msg') ?>
                        </div>
                    <?php endif; ?>
                    <!-- End Flash Data -->
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                    <a class="btn btn-primary mb-3" type="button" href="/users/create">Tambah Owner</a>
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Role</th>
                                    <th>NIK</th>
                                    <th>Nama Depan</th>
                                    <th>Nama Belakang</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Role</th>
                                    <th>NIK</th>
                                    <th>Nama Depan</th>
                                    <th>Nama Belakang</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Aksi</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php foreach ($result as $value) : ?>
                                <tr>
                                    <td>
                                        <?php
                                            $role = mysqli_query($connection, "SELECT name FROM auth_groups WHERE id =
                                                (SELECT group_id FROM auth_groups_users WHERE user_id =
                                                    (SELECT id FROM users WHERE username = '$value->username')
                                                );
                                            ");
                                            $get_role = mysqli_fetch_assoc($role);
                                            echo $get_role['name'];
                                        ?>
                                        </td>
                                    <td><?= $value->NIK ?></td>
                                    <td><?= $value->firstname ?></td>
                                    <td><?= $value->lastname ?></td>
                                    <td><?= $value->username ?></td>
                                    <td><?= $value->email ?></td>
                                    <td>
                                        <form action="/users/<?= $value->id ?>" method="post"
                                        class="d-inline">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-danger"
                                            role="button" onclick="return confirm('Apakah anda yakin?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
</body>

</html>
<?= $this->endSection() ?>