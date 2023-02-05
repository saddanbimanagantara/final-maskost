<?php $this->load->view('dist/_partials/header') ?>
<div class="main-content">
    <div class="nav-top d-flex justify-content-between">
        <a href="<?= base_url('juragan/transaksi/') ?>" class="btn btn-sm btn-outline-info mb-3"><i class="fa-solid fa-circle-left"></i> Kembali ke data transaksi</a>
        <button class="btn btn-sm btn-danger cetak mb-3">Cetak</button>
    </div>
    <div class="invoice">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Informasi Transaksi</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 col-sm-12">
                                <h6>Id Transaksi</h6>
                                <p><?= $transaksi['uid_transaksi'] ?></p>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <h6>Jumlah</h6>
                                <p><?= rupiah($transaksi['jumlah_pembayaran']) ?></->
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <h6>Jenis Pembayaran</h6>
                                <p><?= $transaksi['jenis_pembayaran'] ?></p>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <h6>Status transaksi</h6>
                                <?= ($transaksi['status_pembayaran'] === 'SETTLEMENT') ? '<button class="btn btn-sm btn-outline-success">' . $transaksi['status_pembayaran'] . '</button>' : '<button class="btn btn-sm btn-outline-warning">' . $transaksi['status_pembayaran'] . '</button>' ?>
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
                        <h4>Detail transaksi</h4>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td class="font-weight-bold">ID Transaksi</td>
                                    <td><?= $transaksi['uid_transaksi'] ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Jenis Pembayaran</td>
                                    <td><?= $transaksi['jenis_pembayaran'] ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Status Pembayaran</td>
                                    <td><?= $transaksi['status_pembayaran'] ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Jumlah Pembayaran</td>
                                    <td><?= rupiah($transaksi['jumlah_pembayaran']) ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Id Pembayaran</td>
                                    <td><?= $transaksi['id_pembayaran'] ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Waktu Transaksi</td>
                                    <td><?= $transaksi['waktu_transaksi'] ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Data Penghuni</h4>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <div class="tbody">
                                <tr>
                                    <td class="font-weight-bold">Nama</td>
                                    <td><?= $transaksi['fnama'] . ' ' . $transaksi['lnama'] ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Telepon</td>
                                    <td><?= $transaksi['no_hp'] ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Email</td>
                                    <td><?= $transaksi['email'] ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Jenis Kelamin</td>
                                    <td><?= $transaksi['jenis_kelamin'] ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Alamat</td>
                                    <td><?= $transaksi['alamat'] ?></td>
                                </tr>
                            </div>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Data kamar</h4>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td class="font-weight-bold">Nama</td>
                                    <td>
                                        <p><?= $transaksi['nama_kamar'] ?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Gambar</td>
                                    <td>
                                        <img src="<?= base_url('public/images/kamar/') . $transaksi['gambar_satu'] ?>" class="img-thumbnail rounded" width="150">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Durasi ngekost</td>
                                    <td>
                                        <p><?= $transaksi['durasingekost'] ?> Bulan</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Harga</td>
                                    <td>
                                        <p><?= rupiah($transaksi['harga']) ?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Total pembayaran</td>
                                    <td>
                                        <p><?= rupiah(($transaksi['harga'] * $transaksi['durasingekost'])) ?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Tanggal masuk</td>
                                    <td>
                                        <p><?= $transaksi['tanggal_masuk'] ?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Tanggal keluar</td>
                                    <td>
                                        <p><?= $transaksi['tanggal_keluar'] ?></p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="float-right">
                            <a class="btn btn-sm btn-info" href="<?= base_url('juragan/kamar/detail/') . $transaksi['uid_kamar'] ?>">Detail Kamar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('dist/_partials/footer') ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>

<script>
    $(document).ready(function() {
        const doc = new jsPDF();
        var cetakarea = {
            '.invoice': function(element, renderer) {
                return true;
            }
        }
        $('.cetak').click(function() {
            var HTML_Width = $(".invoice").width();
            var HTML_Height = $(".invoice").height();
            var top_left_margin = 0;
            var PDF_Width = HTML_Width;
            var PDF_Height = (PDF_Width + top_left_margin);
            var canvas_image_width = HTML_Width;
            var canvas_image_height = HTML_Height;

            var totalPDFPages = Math.ceil(HTML_Height / PDF_Height) - 1;

            html2canvas($(".invoice")[0]).then(function(canvas) {
                var imgData = canvas.toDataURL("image/jpeg", 1.0);
                var pdf = new jsPDF('l', 'pt', [PDF_Width, PDF_Height]);
                pdf.addImage(imgData, 'JPG', top_left_margin, top_left_margin, canvas_image_width, canvas_image_height);
                for (var i = 1; i <= totalPDFPages; i++) {
                    pdf.addPage(PDF_Width, PDF_Height);
                    pdf.addImage(imgData, 'JPG', top_left_margin, -(PDF_Height * i) + (top_left_margin * 4), canvas_image_width, canvas_image_height);
                }
                pdf.save("Your_PDF_Name.pdf");
                $(".html-content").hide();
            });

        });
    });
</script>