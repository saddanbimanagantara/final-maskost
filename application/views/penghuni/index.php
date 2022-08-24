<?php $this->load->view('dist/_partials/header'); ?>

<div class="main-content">
    <div class="card">
        <div class="card-header">
            <h4>Selamat datang&#128513;, <?= $user['fnama'] . ' ' . $user['lnama'] ?></h4>
        </div>
        <?php
        if ($data === NULL) {
            echo '<div class="d-flex justify-content-center m-3">
            <a href="' . base_url('kost') . '" class="btn btn-sm btn-primary">Sewa Kamar Disini</a>
            </div>';
        } else {
            $tgl1 = strtotime($data['transaksi']['tanggal_masuk']);
            $tgl2 = strtotime($data['transaksi']['tanggal_keluar']);
            $sisa = $tgl2 - $tgl1;
            $sisahari = $sisa / 60 / 60 / 24;
            $tgl = date('Y-m-d');
            if ($sisahari == 0) {
        ?>
                <script src="http://localhost/sk-kost/assets/modules/sweetalert/sweetalert.min.js"></script>
                <script>
                    swal({
                        icon: "error",
                        text: "Masa kost anda sudah habis, silahkan sewa kamar baru!"
                    });
                </script>
                <div class="d-flex justify-content-center m-3">
                    <a href="' . base_url('kost') . '" class="btn btn-sm btn-primary">Sewa Kamar Baru</a>
                </div>
            <?php
                die;
            } else if ($sisahari < 7) {
            ?>
                <script src="http://localhost/sk-kost/assets/modules/sweetalert/sweetalert.min.js"></script>
                <script>
                    swal({
                        icon: "warning",
                        text: "Sudah memasuki masa pembayaran perpanjang, silahkan perpanjang!"
                    });
                </script>
            <?php
            }
            ?>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-header bg-primary">
                                <h6 class="text-white">Pembayaran</h6>
                            </div>
                            <div class="card-body">
                                <table>
                                    <tr>
                                        <td>Total pembayaran</td>
                                        <td class="pl-5 font-weight-bold">
                                            <?php
                                            $this->db->select('sum(jumlah_pembayaran) as jumlah');
                                            $this->db->from('transaksi');
                                            $this->db->join('transaksi_detail', 'transaksi_detail.uid_transaksi=transaksi.uid_transaksi');
                                            $this->db->where('transaksi_detail.uid_member', $user['member_id']);
                                            $this->db->where('transaksi_detail.status', 'huni');
                                            $total = $this->db->get()->row_array();
                                            echo rupiah($total['jumlah']);
                                            ?>
                                        </td>
                                    </tr>
                                </table>
                                <a href="<?= base_url('penghuni/pembayaran/') ?>" class="float-right">Riwayat pembayaran</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h6 class="text-white">Masa ngekost</h6>
                            </div>
                            <div class="card-body">
                                <table>
                                    <tr>

                                        <td>Sisa</td>
                                        <td class="pl-5 font-weight-bold">
                                            <?php
                                            $tgl = date('Y-m-d');
                                            if ($data['transaksi']['tanggal_keluar'] < $tgl) {
                                                echo "<span class='text-danger'>masa kost sudah habis</span>";
                                            } else {
                                                $tgl1 = strtotime($data['transaksi']['tanggal_masuk']);
                                                $tgl2 = strtotime($data['transaksi']['tanggal_keluar']);
                                                $sisa = $tgl2 - $tgl1;
                                                $sisahari = $sisa / 60 / 60 / 24;
                                                echo $sisahari;
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal selesai</td>
                                        <td class="pl-5 font-weight-bold"><?= $data['transaksi']['tanggal_keluar'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal masuk</td>
                                        <td class="pl-5 font-weight-bold"><?= $data['transaksi']['tanggal_masuk'] ?></td>
                                    </tr>
                                </table>
                                <a href="<?= base_url('penghuni/pembayaran/perpanjang') ?>" class="float-right">Perpanjang</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="card">
                            <div class="card-header bg-success">
                                <h6 class="text-white">Informasi kamar dihuni</h6>
                            </div>
                            <div class="card-body">
                                <div class="font-weight-bold" style="width: 100%; text-align:center;">
                                    <?= $data['kamar']['nama'] ?>
                                    <br>
                                    <img src="<?= base_url('public/images/kamar/') . $data['kamar']['gambar_satu'] ?>" style="width: 30%;"></img>
                                </div>
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>Harga</td>
                                            <td><?= rupiah($data['kamar']['harga']) ?></td>
                                        </tr>
                                        <tr>
                                            <td>Status pembayaran</td>
                                            <td>
                                                <?= $data['transaksi']['status_pembayaran'] ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="float-right">
                                    <a href="<?= base_url('penghuni/chat/area') ?>" class="btn btn-success bg-opacity-75">Komplain</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</div>

<?php $this->load->view('dist/_partials/footer'); ?>