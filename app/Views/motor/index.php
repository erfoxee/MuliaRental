<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
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
            <h1 class="h3 mb-2 text-gray-800">DATA MOTOR</h1>
            <p class="mb-4">Data Motor Mulia Rental <a target="_blank"></a>.</p>

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Data Motor</h6>
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
                <?php if (in_groups(['Owner'])) : ?>
                    <a class="btn btn-primary mb-3" type="button" href="/motor/create">Tambah Motor</a>
                <?php endif; ?>
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Sampul</th>
                                    <th>Plat Motor</th>
                                    <th>Jenis Motor</th>
                                    <th>Tarif</th>
                                    <th>Tarif Denda</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Sampul</th>
                                    <th>Plat Motor</th>
                                    <th>Jenis Motor</th>
                                    <th>Tarif</th>
                                    <th>Tarif Denda</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php $no = 1;
                                foreach ($result as $value) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><img src = "img/<?= $value['cover'] ?>" alt="" width="100"></td>
                                    <td><?= $value['Plat_Motor'] ?></td>
                                    <td><?= $value['Jenis_Motor'] ?></td>
                                    <td><?= number_to_currency($value['Tarif'], 'IDR', 'id_ID', 2) ?></td>
                                    <td><?= number_to_currency($value['Tarif_Denda'], 'IDR', 'id_ID', 2) ?></td>
                                    <td><?= $value['Status'] ?></td>
                                    <td>
                                        <a class="btn btn-primary" href="/motor/<?= $value['ID_Motor']  ?>"role="button">Detail</a>
                                    <?php if (in_groups(['Owner'])) : ?>
                                        <a class="btn btn-warning" href="/motor/edit/<?= $value['ID_Motor'] ?>" role="button">Ubah</a>
                                        <form action="/motor/<?= $value['ID_Motor'] ?>" method="post" class="d-inline">
                                        <?= csrf_field() ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-danger" role="button"
                                            onclick="return confirm('Apakah anda yakin?')">Hapus</button>
                                        </form>
                                    <?php endif; ?>
                                    </td>
                                </button>
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