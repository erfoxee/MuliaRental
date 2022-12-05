<?= $this->extend('layout/template') ?>

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
                <!-- Isi Detail -->
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <td>
                                <img src="<?= base_url('img/' . $result['cover']) ?>" alt="" width="350" height="350">
                            </td>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title"><?= $result['Plat_Motor'] ?></h5>
                                <p class="card-text">Jenis Motor : <?= $result['Jenis_Motor'] ?></p>
                                <p class="card-text">Jumlah Motor : <?= $result['Jumlah_Motor'] ?></p>
                                <p class="card-text">Merk Motor : <?= $result['Merk_Motor'] ?></p>
                                <p class="card-text">Warna Motor : <?= $result['Warna_Motor'] ?></p>
                                <p class="card-text">Tarif : <?= number_to_currency($result['Tarif'], 'IDR', 'id_ID', 2) ?></p>
                                <p class="card-text">Tarif Denda : <?= number_to_currency($result['Tarif_Denda'], 'IDR', 'id_ID', 2) ?></p>
                                <p class="card-text">STNK : <?= $result['STNK'] ?></p>
                                <p class="card-text">Status : <?= $result['Status'] ?></p>
                                <div class="d-grid gap-2 d-md-block">
                                    <a class="btn btn-dark" type="button" href="/motor">Kembali</a>
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