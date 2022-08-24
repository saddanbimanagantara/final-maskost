<?php $this->load->view('dist/_partials/header'); ?>

<div class="main-content">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Rekap Keuangan</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <div class="pricing">
                                <div class="pricing-title bg-success text-white">
                                    Saldo Masuk
                                </div>
                                <div class="pricing-padding">
                                    <div class="pricing-price">
                                        <h5><?= rupiah($rekap['saldo_masuk_settlement']['saldo_masuk']) ?></h5>
                                    </div>
                                    <span>Pending <?= rupiah($rekap['saldo_masuk_pending']['saldo_masuk']) ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="pricing">
                                <div class="pricing-title bg-primary text-white">
                                    Saldo DiTarik
                                </div>
                                <div class="pricing-padding">
                                    <div class="pricing-price">
                                        <h5><?= rupiah($rekap['saldo_withdraw_settlement']['saldo_withdraw']) ?></h5>
                                    </div>
                                    <span>Pending <?= rupiah($rekap['saldo_withdraw_pending']['saldo_withdraw']) ?> </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="pricing">
                                <div class="pricing-title bg-danger text-white">
                                    Sisa Saldo
                                </div>
                                <div class="pricing-padding">
                                    <div class="pricing-price">
                                        <h5><?= rupiah($rekap['saldo_masuk_settlement']['saldo_masuk'] - $rekap['saldo_withdraw_settlement']['saldo_withdraw']) ?></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm 12">
            <div class="card">
                <div class="card-header">
                    <h4>Chart Keuangan</h4>
                </div>
                <div class="card-body">
                    <canvas id="chartKeuangan"></canvas>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4>Aktivitas Keuangan</h4>
                    <div>
                        <a href="<?= base_url('juragan/keuangan/aktivitas') ?>" class="btn btn-sm btn-primary">Tarik Uang</a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="aktivitas-keuangan">
                        <thead>
                            <th class="text-center">#</th>
                            <th>Tanggal Aktivitas</th>
                            <th>Nominal</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($aktivitas as $aktivitas) :
                            ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= $aktivitas['date_updated'] ?></td>
                                    <?php
                                    if ($aktivitas['saldo_masuk']) {
                                    ?>
                                        <td><?= $aktivitas['saldo_masuk'] ?></td>
                                        <td><button class="btn btn-outline-success">Saldo Masuk</button></td>
                                    <?php
                                    } else if ($aktivitas['saldo_withdraw']) {
                                    ?>
                                        <td><?= $aktivitas['saldo_withdraw'] ?></td>
                                        <td><button class="btn btn-outline-primary">Saldo Withdraw</button></td>
                                    <?php
                                    }
                                    ?>
                                    <td>
                                        <?php
                                        if ($aktivitas['status'] === 'SETTLEMENT') {
                                            echo '<span class="badge badge-success">SETTLEMENT</span>';
                                        } else if ($aktivitas['status'] === 'PROCESSING') {
                                            echo '<span class="badge badge-warning">PROCESSING</span>';
                                        } else if ($aktivitas['status'] === 'CANCEL') {
                                            echo '<span class="badge badge-danger">BATAL</span>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('dist/_partials/footer'); ?>

<script>
    $(document).ready(function() {
        $('#aktivitas-keuangan').DataTable();
    })

    var ctx = document.getElementById("chartKeuangan").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["January", "February", "March", "April", "May", "June", "July", "August"],
            datasets: [{
                    label: 'Uang Masuk',
                    data: [
                        <?= $keuangan['januari']['saldo_masuk'] ?>,
                        <?= $keuangan['februari']['saldo_masuk'] ?>,
                        <?= $keuangan['maret']['saldo_masuk'] ?>,
                        <?= $keuangan['april']['saldo_masuk'] ?>,
                        <?= $keuangan['mei']['saldo_masuk'] ?>,
                        <?= $keuangan['juni']['saldo_masuk'] ?>,
                        <?= $keuangan['juli']['saldo_masuk'] ?>,
                        <?= $keuangan['agustus']['saldo_masuk'] ?>
                    ],
                    borderWidth: 2,
                    backgroundColor: 'rgba(99,237,112,.9)',
                    borderWidth: 0,
                    borderColor: 'transparent',
                    pointBorderWidth: 0,
                    pointRadius: 3.5,
                    pointBackgroundColor: 'transparent',
                    pointHoverBackgroundColor: 'rgba(99,237,112,.9)',
                },
                {
                    label: 'Uang Ditarik',
                    data: [
                        <?= $keuangan['januari']['saldo_withdraw'] ?>,
                        <?= $keuangan['februari']['saldo_withdraw'] ?>,
                        <?= $keuangan['maret']['saldo_withdraw'] ?>,
                        <?= $keuangan['april']['saldo_withdraw'] ?>,
                        <?= $keuangan['mei']['saldo_withdraw'] ?>,
                        <?= $keuangan['juni']['saldo_withdraw'] ?>,
                        <?= $keuangan['juli']['saldo_withdraw'] ?>,
                        <?= $keuangan['agustus']['saldo_withdraw'] ?>
                    ],
                    borderWidth: 2,
                    backgroundColor: 'rgba(103,119,239,.9)',
                    borderWidth: 0,
                    borderColor: 'transparent',
                    pointBorderWidth: 0,
                    pointRadius: 3.5,
                    pointBackgroundColor: 'transparent',
                    pointHoverBackgroundColor: 'rgba(103,119,239,.9)',
                }
            ]
        },
        options: {
            legend: {
                display: true
            },
            scales: {
                yAxes: [{
                    gridLines: {
                        // display: false,
                        drawBorder: false,
                        color: '#f2f2f2',
                    },
                    ticks: {
                        beginAtZero: true,
                        callback: function(value, index, values) {
                            return 'Rp' + formatRupiah(value) + ' ';
                        }
                    }
                }],
                xAxes: [{
                    ticks: {
                        display: true
                    },
                    gridLines: {
                        display: false
                    }
                }]
            },
        }
    });

    function formatRupiah(angka) {
        var number_string = angka.toString(),
            sisa = number_string.length % 3,
            rupiah = number_string.substr(0, sisa),
            ribuan = number_string.substr(sisa).match(/\d{3}/g);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        return rupiah;
    }
</script>