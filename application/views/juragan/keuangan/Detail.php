<?php $this->load->view('dist/_partials/header'); ?>

<div class="main-content">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex align-content-center">
                    <div>
                        <a href="<?= base_url('juragan/keuangan/aktivitas') ?>" class="mr-4"><i class="fa-solid fa-circle-left fa-xl"></i></a>
                    </div>
                    <h4>Detail Keuangan</h4>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <td class="font-weight-bold">Keterangan</td>
                            <td>
                                <?= ($data['saldo_masuk'] != null || $data['saldo_masuk'] != 0) ? '<button type="button" class="btn btn-sm btn-success btn-icon icon-left"><i class="fa-solid fa-circle-arrow-down"></i> Saldo Masuk</button>' : '<button type="button" class="btn btn-sm btn-primary btn-icon icon-left"><i class="fa-solid fa-circle-arrow-up"></i> Saldo Keluar</button>'; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Nominal</td>
                            <?php
                            if ($data['saldo_masuk']) {
                            ?>
                                <td class="font-weight-bold"><?= rupiah($data['saldo_masuk']) ?></td>
                            <?php
                            } else if ($data['saldo_withdraw']) {
                            ?>
                                <td class="font-weight-bold"><?= rupiah($data['saldo_withdraw']) ?></td>
                            <?php
                            }
                            ?>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Status</td>
                            <td>
                                <?php
                                if ($data['status'] === 'SETTLEMENT') {
                                    echo '<span class="badge badge-success">SETTLEMENT</span>';
                                } else if ($data['status'] === 'PENDING') {
                                    echo '<span class="badge badge-warning">PROCESSING</span>';
                                } else if ($data['status'] === 'CANCEL') {
                                    echo '<span class="badge badge-danger">BATAL</span>';
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Rekening</td>
                            <td><?= ($data['nomor_rekening']) ? $data['nomor_rekening'] : '-' ?></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Tanggal</td>
                            <td><?= $data['date_updated'] ?></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Deskripsi</td>
                            <td><?= $data['deskripsi'] ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('dist/_partials/footer'); ?>