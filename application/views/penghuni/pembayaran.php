<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-Ejyk6W8iGNPzCd2V"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/modules/sweetalert/sweetalert.min.js"></script>
<?php $this->load->view('dist/_partials/header') ?>
<div class="main-content">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <?php
                if ($transaksi) {
                ?>
                    <div class="card-header">
                        <h6>Data pembayaran</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover table-responsive-lg">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Jumlah pembayaran</th>
                                    <th>Waktu transaksi</th>
                                    <th>Tenggat pembayaran</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($transaksi as $tx) :
                                ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= rupiah($tx['jumlah_pembayaran']); ?></td>
                                        <td><?= $tx['waktu_transaksi'] ?></td>
                                        <td><?= $tx['tenggat_pembayaran'] ?></td>
                                        <td><?= ($tx['status_code'] == 200) ? "<span class='text-success font-weight-bold'>SETTLEMENT</span>" : "<span class='text-warning font-weight-bold'>PENDING</span>" ?></td>
                                        <td>
                                            <?php
                                            if ($tx['status_code'] == 200) {
                                                echo '<a href="' . base_url('penghuni/pembayaran/detail/') . $tx['uid_transaksi'] . '" class="btn btn-sm btn-primary mr-2">Detail</a>';
                                                echo '<a href="#" class="btn btn-sm btn-danger disabled" >Batal</a></td>';
                                            } else {
                                                echo '<button class="btn btn-sm btn-primary mr-2" data-token="' . $tx['snapToken'] . '" data-tx="' . $tx['uid_transaksi'] . '" id="pay-button" >Bayar</button>';
                                                echo '<a href="#" class="btn btn-sm btn-danger">Batal</a></td>';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
            </div>
        <?php
                }
                echo '<div class="card-header"><h6>Belum ada data transaksi!</h6></div>';
        ?>
        </div>
    </div>
</div>
<script>
    var payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function() {
        var token = $('#pay-button').data('token');
        var uid_transaksi = $('#pay-button').data('tx');
        console.log(token);
        // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
        window.snap.pay(token, {
            onSuccess: function(result) {
                /* You may add your own implementation here */
                $.ajax({
                    url: "<?= base_url('snap/pembayaran') ?>",
                    type: "POST",
                    data: {
                        uid_transaksi: uid_transaksi,
                        params: 200
                    },
                    success: function(data) {
                        swal("Berhasil!", "Selamat pembayaran berhasil!", "success");
                        location.reload();
                    }
                })
            },
            onPending: function(result) {
                /* You may add your own implementation here */
                alert("wating your payment!");
                console.log(result);
            },
            onError: function(result) {
                /* You may add your own implementation here */
                alert("payment failed!");
                console.log(result);
            },
            onClose: function() {
                /* You may add your own implementation here */
                alert('you closed the popup without finishing the payment');
            }
        })
    });
</script>
<?php $this->load->view('dist/_partials/footer') ?>