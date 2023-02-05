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
                        <td class="align-center">Nama kamar</td>
                        <td class="align-center">Penghuni</td>
                        <td class="align-center">Status</td>
                        <td class="align-center">Tgl keluar</td>
                        <td class="align-center">Perpanjang</td>
                        <td class="align-center">Data pembayaran</td>
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
                                <td><?= $transaksi['nama'] ?></td>
                                <td><?= $transaksi['fnama'] . ' ' . $transaksi['lnama'] ?></td>
                                <td>
                                    <?= ($transaksi['status'] === 'huni') ? '<button class="btn btn-sm btn-outline-success">' . $transaksi['status'] . '</button>' : '<button class="btn btn-sm btn-outline-warning">' . $transaksi['status'] . '</button>' ?>
                                </td>
                                <td>
                                    <?php
                                    $perpanjang = $this->transaksi->getTransaksi($user['uid_member'], null, $transaksi['uid_transaksi']);
                                    if ($perpanjang[0]['tanggal_keluar']) {
                                        $dateNow = date('Y-m-d');
                                        $dateNow = strtotime($dateNow);
                                        $dateKeluar = strtotime($perpanjang[0]['tanggal_keluar']);
                                        if ($dateKeluar > $dateNow) {
                                            echo $perpanjang[0]['tanggal_keluar'];
                                        } else {
                                            echo '<span class="text-danger">Sewa habis</span><br>';
                                            if ($transaksi['status'] == 'huni') {
                                                echo '<button class="btn btn-sm btn-info" data-uid_transaksi="' . $transaksi['uid_transaksi'] . '" onclick="status(this)">ubah status</button>';
                                            }
                                        }
                                    } else {
                                        $dateNow = date('Y-m-d');
                                        $dateNow = strtotime($dateNow);
                                        $dateKeluar = strtotime($transaksi['tanggal_keluar']);
                                        if ($dateKeluar > $dateNow) {
                                            echo $transaksi['tanggal_keluar'];
                                        } else {
                                            echo '<span class="text-danger">Sewa habis</span><br>';
                                            if ($transaksi['status'] == 'huni') {
                                                echo '<button class="btn btn-sm btn-info" data-uid_transaksi="' . $transaksi['uid_transaksi'] . '" onclick="status(this)">ubah status</button>';
                                            }
                                        }
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $perpanjang =  $this->transaksi->countTransaksiPerpanjang($transaksi['uid_transaksi']);
                                    if ($perpanjang > 0) {
                                        if ($transaksi['status'] == 'selesai') {
                                            echo 'ada perpanjang, sudah selesai';
                                        } else {
                                            echo 'ada perpanjang,';
                                        }
                                    } else {
                                        if ($transaksi['status'] == 'selesai') {
                                            echo 'tidak ada perpanjang, sudah selesai';
                                        } else {
                                            echo 'belum ada perpanjang';
                                        }
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo ' <a href="' . base_url('juragan/transaksi/pembayaran/') . $transaksi['uid_transaksi'] . '" class="btn btn-sm btn-primary">cek data</a>';
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

<?php $this->load->view('dist/_partials/footer'); ?>

<script>
    $(document).ready(function() {
        $('#data-transaksi').DataTable({
            responsive: true,
            autoWidth: false
        })
    })

    function status(data) {
        var uid_transaksi = $(data).data('uid_transaksi');
        $.ajax({
            url: '<?= base_url('juragan/transaksi/update_status/') ?>' + uid_transaksi,
            type: 'POST',
            dataType: 'JSON',
            success: function(data) {
                swal({
                    icon: 'success',
                    text: 'Kamar berhasil diperbaharui'
                }).then(() => {
                    location.reload();
                })
            }
        })
    }

    function detail(data) {
        window.location.href = "<?= base_url('juragan/transaksi/detail/') . $transaksi['uid_transaksi'] ?>";
    }
</script>