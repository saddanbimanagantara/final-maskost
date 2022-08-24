<?php $this->load->view('dist/_partials/header'); ?>

<div class="main-content">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <h4 class="card-header">Data transaksi kamar</h4>
            </div>
            <div class="card-body">
                <table class="table table-stripped" id="data-transaksi">
                    <thead>
                        <td class="align-center">#</td>
                        <td class="align-center">ID Transaksi</td>
                        <td class="align-center">Jumlah</td>
                        <td class="align-center">Status</td>
                        <td class="align-center">Jenis</td>
                        <td class="align-center">Waktu</td>
                        <td class="align-center">Aksi</td>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($transaksi as $transaksi) :
                        ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td>
                                    <a href="<?= base_url('juragan/transaksi/detail/') . $transaksi['uid_transaksi'] ?>"><?= $transaksi['uid_transaksi'] ?></a>
                                <td><?= $transaksi['jumlah_pembayaran'] ?></td>
                                <td>
                                    <?= ($transaksi['status_pembayaran'] === 'SETTLEMENT') ? '<button class="btn btn-sm btn-outline-success">' . $transaksi['status_pembayaran'] . '</button>' : '<button class="btn btn-sm btn-outline-warning">' . $transaksi['status_pembayaran'] . '</button>' ?>
                                </td>
                                <td><?= $transaksi['jenis_pembayaran'] ?></td>
                                <td><?= $transaksi['waktu_transaksi'] ?></td>
                                <td>
                                    <button class="btn btn-icon btn-info mb-1" onclick="detail(this)" uid_transaksi="TX-G354177046-239"><i class="fa-solid fa-circle-info"></i></button>
                                    <button class="btn btn-icon btn-danger mb-1" onclick="detail(this)" uid_transaksi="TX-G354177046-239"><i class="fas fa-times"></i></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('dist/_partials/footer'); ?>

<script>
    $(document).ready(function() {
        $('#data-transaksi').DataTable({
            responsive: true,
            autoWidth: false
        })
    })

    function detail(data) {
        window.location.href = "<?= base_url('juragan/transaksi/detail/') . $transaksi['uid_transaksi'] ?>";
    }
</script>