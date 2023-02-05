<?php $this->load->view('dist/_partials/header') ?>
<div class="main-content">
    <div class="card">
        <div class="card-header">
            <?= $title ?>
        </div>
        <div class="card-body">
            <table class="table" id="tb-pembayaran">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Transaksi</th>
                        <th>Jumlah</th>
                        <th>Jenis</th>
                        <th>Status</th>
                        <th>Tanggal masuk</th>
                        <th>Tanggal keluar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($transaksi as $transaksi) {
                    ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><a href="<?= base_url('juragan/transaksi/detail/') . $transaksi['uid_transaksi'] ?>"><?= $transaksi['uid_transaksi'] ?></a></td>
                            <td><?= rupiah($transaksi['jumlah_pembayaran']) ?></td>
                            <td><?= $transaksi['jenis'] ?></td>
                            <td>
                                <?php
                                if ($transaksi['status_code'] == 200) {
                                    echo "<span class='text-success font-weight-bold'>APPROVE</span>";
                                } else if ($transaksi['status_code'] == 201) {
                                    echo "<span class='text-warning font-weight-bold'>PENDING</span>";
                                } else {
                                    echo "<span class='text-danger font-weight-bold'>CANCEL</span>";
                                }
                                ?>
                            </td>
                            <td><?= $transaksi['tanggal_masuk'] ?></td>
                            <td><?= $transaksi['tanggal_keluar'] ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<?php $this->load->view('dist/_partials/footer') ?>
<script>
    $(document).ready(function() {
        $('#tb-pembayaran').DataTable();
    })
</script>