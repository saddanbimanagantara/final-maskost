<?php $this->load->view('dist/_partials/header') ?>
<div class="main-content">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Master data transaksi</h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="data-transaksi">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>ID Transaksi</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Jenis</th>
                                <th>Waktu</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($transaksi as $transaksi) :
                            ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><a href="<?= base_url('admin/transaksi/data/detail/') . $transaksi['uid_transaksi'] ?>"><?= $transaksi['uid_transaksi'] ?></a></td>
                                    <td><?= $transaksi['jumlah_pembayaran'] ?></td>
                                    <td>
                                        <span class="btn btn-sm <?= ($transaksi['status_pembayaran'] === 'SETTLEMENT') ? 'btn-outline-success' : 'btn-outline-warning' ?>">
                                            <?= $transaksi['status_pembayaran'] ?>
                                        </span>
                                    </td>
                                    <td><?= $transaksi['jenis_pembayaran'] ?></td>
                                    <td><?= $transaksi['waktu_transaksi'] ?></td>
                                    <td class="aling-center text-center">
                                        <button class="btn btn-icon btn-info mb-1" onclick="detail(this)" uid_transaksi="<?= $transaksi['uid_transaksi'] ?>"><i class="fa-solid fa-circle-info"></i></button>
                                        <button class="btn btn-icon btn-danger mb-1" onclick="hapus(this)" uid_transaksi="<?= $transaksi['uid_transaksi'] ?>"><i class="fas fa-times"></i></button>
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
<?php $this->load->view('dist/_partials/footer') ?>
<script>
    $(document).ready(function() {
        $('#data-transaksi').DataTable({
            responsive: true,
            autoWidth: false
        })
    })
</script>