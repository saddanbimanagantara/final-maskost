<?php $this->load->view('dist/_partials/header') ?>
<div class="main-content">
    <?php $this->load->view('dist/_partials/notif') ?>
    <div class="card">
        <div class="card-header">
            <h5>Daftar Withdraw Juragan</h5>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="withdraw">
                <thead>
                    <th>#</th>
                    <th>Nama juragan</th>
                    <th>Jumlah</th>
                    <th>A.N Rekening</th>
                    <th>Bank</th>
                    <th>Nomor rekening</th>
                    <th>Tanggal request</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($withdraw as $withdraw) : ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= $withdraw['fnama'] . ' ' . $withdraw['lnama'] ?></td>
                            <td><?= rupiah($withdraw['saldo_withdraw']) ?></td>
                            <td><?= $withdraw['atas_nama'] ?></td>
                            <td><?= $withdraw['nama_bank'] ?></td>
                            <td><?= $withdraw['nomor_rekening'] ?></td>
                            <td><?= $withdraw['date_updated'] ?></td>
                            <?php
                            if ($withdraw['status'] === 'SETTLEMENT') {
                                echo '<td><span class="badge badge-success">APPROVE</span></td>';
                                echo '<td>
                                        <button class="proses btn btn-sm btn-success" id="proses" uid_keuangan="' . $withdraw['uid_keuangan'] . '">Detail</button>
                                    </td>';
                            } else if ($withdraw['status'] === 'PENDING') {
                                echo '<td><span class="badge badge-warning">PENDING</span></td>';
                                echo '<td>
                                        <button class="proses btn btn-sm btn-primary" id="proses" uid_keuangan="' . $withdraw['uid_keuangan'] . '">Proses Withdraw</button>
                                    </td>';
                            } else if ($withdraw['status'] === 'CANCEL') {
                                echo '<td><span class="badge badge-danger">CANCEL</span></td>';
                                echo '<td>
                                        <button class="proses btn btn-sm btn-danger" id="proses" uid_keuangan="' . $withdraw['uid_keuangan'] . '" disabled>Dibatalkan</button>
                                    </td>';
                            }
                            ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- modal -->
<div class="modal" tabindex="-1" id="proses-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex justify-content-between">
                    <h5 class="modal-title">Data Withdraw</h5>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/transaksi/withdraw_req/proses') ?>" method="POST">
                <div class="modal-body">
                    <table class="table" border="1">
                        <input type="text" id="uid_keuangan" name="uid_keuangan" hidden>
                        <tr>
                            <td>Nama juragan</td>
                            <td id="nama"></td>
                        </tr>
                        <tr>
                            <td>Jumlah</td>
                            <td id="jumlah"></td>
                        </tr>
                        <tr>
                            <td>A.N Rekening</td>
                            <td id="atas_nama"></td>
                        </tr>
                        <tr>
                            <td>Bank</td>
                            <td id="nama_bank"></td>
                        </tr>
                        <tr>
                            <td>Nomor rekening</td>
                            <td id="nomor_rekening"></td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td id="status"></td>
                        </tr>
                    </table>
                    <small>Silahkan klik "proses" jika sudah melakukan proses withdraw</small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $this->load->view('dist/_partials/footer') ?>
<script>
    $(document).ready(function() {
        $('#withdraw').DataTable();
        $('.proses').click(function() {
            uid_keuangan = $(this).attr('uid_keuangan');
            $('#proses-modal').modal('show');
            $.ajax({
                url: "<?= base_url('admin/transaksi/withdraw_req/getWithdraw/') ?>" + uid_keuangan,
                type: "GET",
                dataType: "JSON",
                success: function(response) {
                    $('#nama').html(response[0].fnama + ' ' + response[0].lnama);
                    $('#jumlah').html(formatRupiah(response[0].saldo_withdraw, 'Rp '));
                    $('#atas_nama').html(response[0].atas_nama);
                    $('#nama_bank').html(response[0].nama_bank);
                    $('#nomor_rekening').html(response[0].nomor_rekening);
                    $('#uid_keuangan').val(response[0].uid_keuangan);
                    $('#status').html(response[0].status);
                    if (response[0].status === "PENDING") {
                        var modalfooter = document.querySelector('.modal-footer');
                        var button = document.createElement('BUTTON');
                        button.setAttribute('id', 'btn-proses');
                        button.setAttribute('class', 'btn btn-primary btn-proses');
                        button.setAttribute('type', 'submit');
                        button.innerText = "Proses";
                        modalfooter.appendChild(button);
                    }
                }
            })
        })
    })

    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp ' + rupiah : '');
    }
</script>