<?php $this->load->view('dist/_partials/header'); ?>

<div class="main-content">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Pembayaran <?= $this->uri->segment(4) ?></h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col col-md-3 col-sm-6">
                            <h6>ID Transaksi</h6>
                            <p><?= $transaksi['uid_transaksi'] ?></p>
                        </div>
                        <div class="col col-md-3 col-sm-6">
                            <h6>Jumlah</h6>
                            <p><?= rupiah($transaksi['jumlah_pembayaran']) ?></p>
                        </div>
                        <div class="col col-md-3 col-sm-6">
                            <h6>Jenis</h6>
                            <p><?= str_replace('_', ' ', strtoupper($transaksi['jenis_pembayaran']));  ?></p>
                        </div>
                        <div class="col col-md-3 col-sm-6">
                            <h6>Status Transaksi</h6>
                            <button type="button" class="btn btn-sm <?= ($transaksi['status_code'] = 200) ? 'btn-success' : 'btn-warning' ?> btn-icon icon-left">
                                <i class="fa-solid fa-money-bill-wave"></i> <?= $transaksi['status_pembayaran'] ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Detail pembayaran</h4>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <td class="font-weight-bold">Id transaksi</td>
                            <td><?= $transaksi['uid_transaksi'] ?></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Jenis pembayaran</td>
                            <td><?= str_replace('_', ' ', strtoupper($transaksi['jenis_pembayaran'])); ?></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Jumlah pembayaran</td>
                            <td><?= rupiah($transaksi['jumlah_pembayaran']) ?></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Id pembayaran</td>
                            <td><?= words_to_stars($transaksi['id_pembayaran']); ?></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Waktu pembayaran</td>
                            <td><?= $transaksi['waktu_transaksi'] ?></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Status</td>
                            <td><?= ($transaksi['status_code'] == 200) ? "<span class='text-success font-weight-bold'>SETTLEMENT</span>" : "<span class='text-warning font-weight-bold'>PENDING</span>" ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Detail Transaksi</h4>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <td class="font-weight-bold">Kamar</td>
                            <td><?= $transaksi['nama_kamar'] ?></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Durasi ngekost</td>
                            <td><?= $transaksi['uid_durasi'] ?> Bulan</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Sisa hari ngekost</td>
                            <td>
                                <?php
                                $tgl = date('Y-m-d');
                                if ($transaksi['tanggal_keluar'] < $tgl) {
                                    echo "<span class='text-danger'>masa kost sudah habis</span>";
                                } else {
                                    $tgl1 = strtotime($transaksi['tanggal_masuk']);
                                    $tgl2 = strtotime($transaksi['tanggal_keluar']);
                                    $sisa = $tgl2 - $tgl1;
                                    $sisahari = $sisa / 60 / 60 / 24;
                                    echo $sisahari;
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Mulai ngekost</td>
                            <td><?= $transaksi['tanggal_masuk'] ?></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Selesai ngekost</td>
                            <td><?= $transaksi['tanggal_keluar']; ?></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Perpanjang</td>
                            <td><a href="##" class="btn btn-sm btn-primary">Ya, perpanjang</a></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('dist/_partials/footer'); ?>