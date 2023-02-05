<?php $this->load->view('dist/_partials/header') ?>
<div class="main-content">
    <section class="web-information">
        <div class="row">
            <?php
            foreach ($jumlahSold as $jumlahSold) {
                $terjual =  $this->kamar->getKamarTerjual($jumlahSold['uid_kamar'], null);
            }
            ?>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card card-statistic-2">
                    <div class="card-stats">
                        <div class="card-stats-title">Kamar</div>
                        <div class="card-stats-items d-flex justify-content-center">
                            <div class="card-stats-item">
                                <div class="card-stats-item-count"><?= $jumlahAvailable[0]['jumlah'] ?> </div>
                                <small>Kamar Kosong</small>
                                <!-- <div class="card-stats-item-label">Kamar Kosong</div> -->
                            </div>
                            <div class="card-stats-item">
                                <div class="card-stats-item-count"><?= $terjual ?> </div>
                                <small>Kamar Terjual</small>
                                <!-- <div class="card-stats-item-label">Kamar Terjual</div> -->
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
                        <div class="card-stats-title">
                            Saldo (Rp)
                            <button class="btn btn-sm btn-primary float-right" id="btn-pengeluaran" data-toggle="modal" data-target="#pengeluaran">Tarik Uang</button>
                        </div>
                        <div class="card-stats-items d-flex justify-content-around">
                            <div class="card-stats-item">
                                <div class="font-weight-bold"><?= rupiah($rekap['saldo_settlement']['saldo_masuk']) ?></div>
                                <div class="card-stats-item-label">Total</div>
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
                            <h4>Available</h4>
                        </div>
                        <div class="card-body">
                            <?php
                            echo rupiah($rekap['saldo_settlement']['saldo_masuk'] + $rekap['saldo_pending']['saldo_masuk'] +  -$rekap['saldo_withdraw']['saldo_withdraw']);
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

<!-- modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="pengeluaran">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tarik Uang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="form-pengeluaran" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nominal">Nominal</label>
                        <input type="text" class="form-control" name="nominal" id="nonimal" class="nominal">
                        <small>Maksimal penarikan :
                            <?= rupiah(
                                $saldoSaya['saldo_masuk_settlement']['saldo_masuk'] - ($saldoSaya['saldo_withdraw_settlement']['saldo_withdraw'] + $saldoSaya['saldo_withdraw_pending']['saldo_withdraw'])
                            )
                            ?>
                        </small>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <input type="text" class="form-control" name="deskripsi" id="deskripsi">
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Pilih Metode Penarikan (Bank)</label><br>
                        <select name="nomor_rekening" id="nomor_rekening" class="form-control">
                            <?php
                            foreach ($rekening as $rekening) :
                            ?>
                                <option value="<?= $rekening['nomor_rekening'] ?>"><?= $rekening['nama_bank'] . " - " . $rekening['atas_nama'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span>Tambah metode penarikan: <a href="<?= base_url('juragan/keuangan/akunbank') ?>">"disini"</a></span>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->load->view('dist/_partials/footer') ?>
<script>
    $(document).ready(function() {
        var form = $('#form-pengeluaran');
        form.submit(function(ev) {
            ev.preventDefault();
            var nominal = $('#nonimal').val();
            if (nominal > <?= $saldoSaya['saldo_masuk_settlement']['saldo_masuk'] - ($saldoSaya['saldo_withdraw_settlement']['saldo_withdraw'] + $saldoSaya['saldo_withdraw_pending']['saldo_withdraw']) ?>) {
                swal({
                    title: "Nominal melebihi batas!",
                    text: "Nominal yang anda masukan melebihi batas penarikan",
                    icon: 'error'
                })
            } else {

                $.ajax({
                    'type': form.attr('method'),
                    'url': '<?= base_url('juragan/keuangan/penarikan') ?>',
                    'data': form.serialize(),
                    'dataType': 'JSON',
                    beforeSend: function() {
                        var loader = "<?= base_url('public/assets/loader.svg') ?>";
                        swal({
                            title: 'Loading...',
                            html: `<img src="${loader}">.`,
                            showCancelButton: false,
                            showConfirmButton: false
                        })
                    },
                    'success': function(data) {
                        swal({
                            title: data.status,
                            text: data.message,
                            icon: data.status
                        }).then(function() {
                            location.reload();
                        });
                    }
                })
            }
        })
    })
</script>