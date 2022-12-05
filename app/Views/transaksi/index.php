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
            <h1 class="h3 mb-2 text-gray-800">DATA TRANSAKSI</h1>
            <p class="mb-4">Data Transaksi Mulia Rental <a target="_blank"></a>.</p>

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Data Transaksi</h6>
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
                    <a class="btn btn-primary mb-3" type="button" href="/transaksi/create">Tambah Transaksi</a>
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIK</th>
                                    <th>Plat Motor</th>
                                    <th>Total Harga</th>
                                    <th>Tanggal Transaksi</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>NIK</th>
                                    <th>Plat Motor</th>
                                    <th>Total Harga</th>
                                    <th>Tanggal Transaksi</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php $no = 1;
                                foreach ($result as $value) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $value['NIK'] ?></td>
                                    <td><?= $value['Plat_Motor'] ?></td>
                                    <td><?= number_to_currency($value['Total_Harga'], 'IDR', 'id_ID', 2) ?></td>
                                    <td><?= $value['Tanggal_Transaksi'] ?></td>
                                    <td><?= $value['Status'] ?></td>
                                    <td>
                                        <a class="btn btn-primary" href="/transaksi/<?= $value['ID_Transaksi']  ?>"role="button">Detail</a>
                                        <a class="btn btn-warning" href="/transaksi/edit/<?= $value['ID_Transaksi'] ?>" role="button">Ubah</a>
                                    <?php if (in_groups(['Owner'])) : ?>
                                        <form action="/transaksi/<?= $value['ID_Transaksi'] ?>" method="post" class="d-inline">
                                        <?= csrf_field() ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-danger" role="button"
                                            onclick="return confirm('Apakah anda yakin?')">Hapus</button>
                                        </form>
                                        <a class="btn btn-dark" type="button" href="/transaksi/exportpdf/<?= $value['ID_Transaksi'] ?>">Cetak Nota</a>
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