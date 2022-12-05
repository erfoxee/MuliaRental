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
            <h1 class="h3 mb-2 text-gray-800">CARI DATA LAPORAN</h1>
            <p class="mb-4">Cari Data Laporan Mulia Rental<a target="_blank"></a>.</p>

            <!-- Form Tambah Transaksi -->
            <form action="/laporan/search" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="mb-3 row">
                    <label for="Tanggal_Transaksi" class="col-sm-2 col-form-label">Dari</label>
                    <div class="col-sm-3">
                        <input type="date" class="form-control" id="Tanggal_Transaksi" name="Tanggal_Transaksi"></input>
                    </div>
                    <label for="Tanggal_Transaksi2" class="col-sm-2 col-form-label">Sampai</label>
                    <div class="col-sm-3">
                        <input type="date" class="form-control" id="Tanggal_Transaksi2" name="Tanggal_Transaksi2"></input>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <div class="d-grid gap-2 d-md-block">
                        <a class="btn btn-dark" type="button" href="/laporan">Kembali</a>
                    </div>
                    <button class="btn btn-primary me-md-2" type="submit">Cari</button>
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