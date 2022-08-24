<?php $this->load->view('dist/_partials/header') ?>
<div class="main-content">
    <section class="web-information">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card card-statistic-2">
                    <div class="card-stats">
                        <div class="card-stats-title">Kamar</div>
                        <div class="card-stats-items">
                            <div class="card-stats-item">
                                <div class="card-stats-item-count"><?= $jumlahAvailable ?></div>
                                <div class="card-stats-item-label">Availabe</div>
                            </div>
                            <div class="card-stats-item">
                                <div class="card-stats-item-count"><?= $jumlahSold ?></div>
                                <div class="card-stats-item-label">Sold</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fa-solid fa-bed text-white"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Kepemilikan Kost</h4>
                        </div>
                        <div class="card-body">
                            <?= $jumlah_kamar ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-5 col-sm-12">
                <div class="card card-statistic-2">
                    <div class="card-stats">
                        <div class="card-stats-title">Saldo (Rp)</div>
                        <div class="card-stats-items d-flex justify-content-around">
                            <div class="card-stats-item">
                                <div class="font-weight-bold"><?= rupiah($rekap['saldo_settlement']['saldo_masuk']) ?></div>
                                <div class="card-stats-item-label">Availabe</div>
                            </div>
                            <div class="card-stats-item">
                                <div class="font-weight-bold"><?= rupiah(($rekap['saldo_pending']['saldo_masuk'] + $rekap['saldo_withdraw_pending']['saldo_withdraw'])) ?></div>
                                <div class="card-stats-item-label">Pending</div>
                            </div>
                            <div class="card-stats-item">
                                <div class="font-weight-bold"><?= rupiah($rekap['saldo_withdraw']['saldo_withdraw']) ?></div>
                                <div class="card-stats-item-label">Withdrawal</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fa-solid fa-money-bill-transfer text-white"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total keuangan</h4>
                        </div>
                        <div class="card-body">
                            <?php
                            echo rupiah($rekap['saldo_settlement']['saldo_masuk'] + $rekap['saldo_pending']['saldo_masuk'] +  - $rekap['saldo_withdraw']['saldo_withdraw']);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12">
                <div class="card card-statistic-2">
                    <div class="card-stats">
                        <div class="card-stats-title">Riwayat Penghuni</div>
                        <div class="card-stats-items d-flex justify-content-center">
                            <div class="card-stats-item">
                                <span class="font-weight-bold"><?= $riwayat_penghuni ?></span>
                                <div class="card-stats-item-label">Penghuni</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fa-solid fa-users text-white"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Penghuni</h4>
                        </div>
                        <div class="card-body">
                            <?= $riwayat_penghuni ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Invoices</h4>
                        <div class="card-header-action">
                            <a href="<?= base_url('juragan/transaksi') ?>" class="btn btn-danger">View More <i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive table-invoice">
                            <table class="table table-striped">
                                <tr>
                                    <th>Invoice ID</th>
                                    <th>Penghuni</th>
                                    <th>Status</th>
                                    <th>Waktu transaksi</th>
                                    <th>Batas Pembayaran</th>
                                    <th>Action</th>
                                </tr>
                                <?php
                                $i = 1;
                                foreach ($transaksi as $transaksi) :
                                ?>
                                    <tr>
                                        <td><a href="<?= base_url('juragan/transaksi/detail/') . $transaksi['uid_transaksi'] ?>"><?= $transaksi['uid_transaksi'] ?></a></td>
                                        <td class="font-weight-600"><?= $transaksi['fnama'] . ' ' . $transaksi['lnama'] ?></td>
                                        <td>
                                            <div class="badge <?= ($transaksi['status_pembayaran'] === 'SETTLEMENT') ? 'badge-success' : 'badge-warning' ?>">
                                                <?= $transaksi['status_pembayaran'] ?>
                                            </div>
                                        </td>
                                        <td><?= $transaksi['waktu_transaksi'] ?></td>
                                        <td><?= $transaksi['tenggat_pembayaran'] ?></td>
                                        <td>
                                            <a href="<?= base_url('juragan/transaksi/detail/') . $transaksi['uid_transaksi'] ?>" class="btn btn-primary">Detail</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php $this->load->view('dist/_partials/footer') ?>