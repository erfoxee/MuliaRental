<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
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
                <!-- Isi Detail -->
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src = https://media.discordapp.net/attachments/761218897454039055/1035186901327560735/unknown-removebg-preview.png width="500" height="400">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <?php foreach ($result as $value) : ?>
                                    <p class="card-text">NIK : <?= $value['NIK'] ?></p>
                                    <p class="card-text">Plat Motor : <?= $value['Plat_Motor'] ?></p>
                                    <p class="card-text">Total Harga : <?= number_to_currency($value['Total_Harga'], 'IDR', 'id_ID', 2) ?></p>
                                    <p class="card-text">Tanggal Transaksi : <?= $value['Tanggal_Transaksi'] ?></p>
                                    <p class="card-text">Tanggal Peminjaman : <?= $value['Tanggal_Peminjaman'] ?></p>
                                    <p class="card-text">Tanggal Pengembalian : <?= $value['Tanggal_Pengembalian'] ?></p>
                                    <p class="card-text">Durasi : <?= $value['Durasi'] ?> Jam</p>
                                    <p class="card-text">Status : <?= $value['Status'] ?></p>
                                    <p class="card-text">Jaminan : <?= $value['Jaminan'] ?></p>
                                <?php endforeach ?>
                                <div class="d-grid gap-2 d-md-block">
                                    <a class="btn btn-dark" type="button" href="/laporan">Kembali</a>
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