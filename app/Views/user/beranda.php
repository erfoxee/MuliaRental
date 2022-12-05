<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>

<div id="content">

    <!-- Topbar -->
    <?= $this->include('layout/topbar') ?>
    <!-- End of Topbar -->

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        </div>

    <?php if (in_groups(['Owner'])) : ?>
        <!-- Content Row -->
        <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Kerusakan (Tahunan)</div>
                            <?php foreach ($rusak as $value) : ?>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_to_currency($value['total'], 'IDR', 'id_ID', 2) ?></div>
                            <?php endforeach ?>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Transaksi (Tahunan)</div>
                                <?php foreach ($result as $value) : ?>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_to_currency($value['total'], 'IDR', 'id_ID', 2) ?></div>
                                <?php endforeach ?>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Pengembalian (Tahunan)</div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                    <?php foreach ($kembali as $value) : ?>
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= number_to_currency($value['total'], 'IDR', 'id_ID', 2) ?></div>
                                    <?php endforeach ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Motor Tersedia</div>
                            <?php foreach ($hasil as $value) : ?>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $value['total'] ?></div>
                            <?php endforeach ?>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-comments fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Row -->

        <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-6 col-lg-4">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Laporan Transaksi</h6>
                    </div>
                    <div class="col-sm-2 mt-4">
                        <input type="number" id="tahun-transaksi" class="form-control" value="<?= date('Y') ?>" onchange="chartTransaksi(), Pendapatan()">
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="chartTransaksi"></canvas>
                        </div>
                        <div class="d-grip gap-2 d-md-flex justify-content-md-end">
                            <button class="btn btn-outline-primary btn-sm" onclick="downloadChartTransaksi('PDF')">Unduh PDF</button>
                            <a id="download-transaksi" download="chart-transaksi.png">
                                <button class="btn btn-outline-secondary btn-sm" onclick="downloadChartTransaksi('PNG')">Unduh PNG</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bar Chart -->
            <div class="col-xl-6 col-lg-4">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Laporan Pengembalian</h6>
                    </div>
                    <div class="col-sm-2 mt-4">
                        <input type="number" id="tahun-pengembalian" class="form-control" value="<?= date('Y') ?>" onchange="chartPengembalian()">
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="chartPengembalian"></canvas>
                        </div>
                        <div class="d-grip gap-2 d-md-flex justify-content-md-end">
                            <button class="btn btn-outline-primary btn-sm" onclick="downloadChartPengembalian('PDF')">Unduh PDF</button>
                            <a id="download-pengembalian" download="chart-pengembalian.png">
                                <button class="btn btn-outline-secondary btn-sm" onclick="downloadChartPengembalian('PNG')">Unduh PNG</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <!-- Pie Chart -->
            <div class="col-xl-6 col-lg-4">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Jumlah Pelanggan</h6>
                    </div>
                    <div class="col-sm-2 mt-4">
                        <input type="number" id="tahun-pelanggan" class="form-control" value="<?= date('Y') ?>" onchange="chartPelanggan()">
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="chartPelanggan"></canvas>
                        </div>
                        <div class="d-grip gap-2 d-md-flex justify-content-md-end">
                            <button class="btn btn-outline-primary btn-sm" onclick="downloadChartPelanggan('PDF')">Unduh PDF</button>
                            <a id="download-pelanggan" download="chart-pelanggan.png">
                                <button class="btn btn-outline-secondary btn-sm" onclick="downloadChartPelanggan('PNG')">Unduh PNG</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pie Chart -->
            <div class="col-xl-6 col-lg-4">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Jumlah Transaksi</h6>
                    </div>
                    <div class="col-sm-2 mt-4">
                        <input type="number" id="tahun-jumlah" class="form-control" value="<?= date('Y') ?>" onchange="chartJumlah()">
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="chartJumlah"></canvas>
                        </div>
                        <div class="d-grip gap-2 d-md-flex justify-content-md-end">
                            <button class="btn btn-outline-primary btn-sm" onclick="downloadChartJumlah('PDF')">Unduh PDF</button>
                            <a id="download-jumlah" download="chart-jumlah.png">
                                <button class="btn btn-outline-secondary btn-sm" onclick="downloadChartJumlah('PNG')">Unduh PNG</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    </div>
    <!-- /.container-fluid -->

</div>

<script>
    $(document).ready(function() {
        chartTransaksi()
        chartPengembalian()
        chartPelanggan()
        chartJumlah()
    });

    // Transaksi
    function setLineChart(dataset) {
        // Area Chart Example
        var ctx = document.getElementById("chartTransaksi");
        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des"],
                datasets: [{
                    label: "Total",
                    lineTension: 0.3,
                    backgroundColor: "rgba(2,117,216,0.2)",
                    borderColor: "rgba(2,117,216,1)",
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(2,117,216,1)",
                    pointBorderColor: "rgba(255,255,255,0.8)",
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(2,117,216,1)",
                    pointHitRadius: 50,
                    pointBorderWidth: 2,
                    data: dataset,
                }],
            },
            options: {
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'date'
                        },
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            maxTicksLimit: 7
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            maxTicksLimit: 5
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, .125)",
                        }
                    }],
                },
                legend: {
                    display: false
                }
            }
        });
    }

    function chartTransaksi() {
        var tahun = $('#tahun-transaksi').val();
        $.ajax({
            url: "/chart-transaksi",
            method: "POST",
            data: {
                'tahun': tahun,
            },
            success: function(response) {
                var result = JSON.parse(response)

                dataset = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                $.each(result.data, function(i, val) {
                    dataset[val.month - 1] = val.total
                });
                setLineChart(dataset)
            }
        })
    }

    // Pengembalian
    function setBarChart(dataset) {
        // Bar Chart Example
        var ctx = document.getElementById("chartPengembalian");
        var myLineChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des"],
                datasets: [{
                    label: "Total",
                    backgroundColor: "rgba(2,117,216,1)",
                    borderColor: "rgba(2,117,216,1)",
                    data: dataset,
                }],
            },
            options: {
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'month'
                        },
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            maxTicksLimit: 6
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            maxTicksLimit: 5
                        },
                        gridLines: {
                            display: true
                        }
                    }],
                },
                legend: {
                    display: false
                }
            }
        });
    }

    function chartPengembalian() {
        var tahun = $('#tahun-pengembalian').val();
        $.ajax({
            url: "/chart-pengembalian",
            method: "POST",
            data: {
                'tahun': tahun,
            },
            success: function(response) {
                var result = JSON.parse(response)

                dataset = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                $.each(result.data, function(i, val) {
                    dataset[val.month - 1] = val.total
                });
                setBarChart(dataset)
            }
        });
    }

    function setPieChart(dataset) {
        // Pie Chart Example
        var ctx = document.getElementById("chartPelanggan");
        var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des"],
            datasets: [{
            data: dataset,
            backgroundColor: ['#007bff', '#dc3545', '#ffc107', '#28a745', '#4e73dd', '#36b9cc', '#858796' ,'#B01E68', '#FFE15D', '#3B3486', '#A3C7D6', '#000000'],
            }],
        },
        });
    }

    function chartPelanggan() {
        var tahun = $('#tahun-pelanggan').val();
        $.ajax({
            url: "/chart-pelanggan",
            method: "POST",
            data: {
                'tahun': tahun,
            },
            success: function(response) {
                var result = JSON.parse(response)

                dataset = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                $.each(result.data, function(i, val) {
                    dataset[val.month - 1] = val.total
                });
                setPieChart(dataset)
            }
        });
    }

    function setPieChartJumlah(dataset) {
        // Pie Chart Example
        var ctx = document.getElementById("chartJumlah");
        var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des"],
            datasets: [{
            data: dataset,
            backgroundColor: ['#007bff', '#dc3545', '#ffc107', '#28a745', '#4e73dd', '#36b9cc', '#858796' ,'#B01E68', '#FFE15D', '#3B3486', '#A3C7D6', '#000000'],
            }],
        },
        });
    }

    function chartJumlah(dataset) {
        var tahun = $('#tahun-jumlah').val();
        $.ajax({
            url: "/chart-jumlah",
            method: "POST",
            data: {
                'tahun': tahun,
            },
            success: function(response) {
                var result = JSON.parse(response)

                dataset = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                $.each(result.data, function(i, val) {
                    dataset[val.month - 1] = val.total
                });
                setPieChartJumlah(dataset)
            }
        });
    }

    function downloadChartImg(download, chart) {
        var img = chart.toDataURL("image/jpg", 1.0).replace("image/jpg", "image/octet-stream")
        download.setAttribute("href", img)
    }

    function downloadChartPDF(chart, name) {
        html2canvas(chart, {
            onrendered: function(canvas) {
                var img = canvas.toDataURL("image/jpg", 1.0)
                var doc = new jsPDF('p', 'pt', 'A4')
                var lebarKonten = canvas.width
                var tinggiKonten = canvas.height
                var tinggiPage = lebarKonten / 592.28 * 841.89
                var leftHeight = tinggiKonten
                var position = 0
                var imgWidth = 595.28
                var imgHeight = 592.28 / lebarKonten * tinggiKonten
                if (leftHeight < tinggiPage) {
                    doc.addImage(img, 'PNG', 0, 0, imgWidth, imgHeight)
                } else {
                    while (leftHeight > 0) {
                        doc.addImage(img, 'PNG', 0, position, imgWidth, imgHeight)
                        leftHeight -= tinggiPage
                        position -= 841.89
                        if (leftHeight > 0) {
                            pdf.addPage()
                        }
                    }
                }
                doc.save(name)
            }
        });
    }

    function downloadChartTransaksi(type) {
        var download = document.getElementById('download-transaksi')
        var chart = document.getElementById('chartTransaksi')

        if (type == "PNG") {
            downloadChartImg(download, chart)
        } else {
            downloadChartPDF(chart, "Chart-Transaksi.pdf")
        }
    }

    function downloadChartPengembalian(type) {
        var download = document.getElementById('download-pengembalian')
        var chart = document.getElementById('chartPengembalian')

        if (type == "PNG") {
            downloadChartImg(download, chart)
        } else {
            downloadChartPDF(chart, "Chart-Pengembalian.pdf")
        }
    }

    function downloadChartPelanggan(type) {
        var download = document.getElementById('download-pelanggan')
        var chart = document.getElementById('chartPelanggan')

        if (type == "PNG") {
            downloadChartImg(download, chart)
        } else {
            downloadChartPDF(chart, "Chart-Pelanggan.pdf")
        }
    }

    function downloadChartJumlah(type) {
        var download = document.getElementById('download-jumlah')
        var chart = document.getElementById('chartJumlah')

        if (type == "PNG") {
            downloadChartImg(download, chart)
        } else {
            downloadChartPDF(chart, "Chart-Jumlah.pdf")
        }
    }
</script>
<?= $this->endSection() ?>