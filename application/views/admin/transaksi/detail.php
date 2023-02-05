<?php $this->load->view('dist/_partials/header') ?>
<div class="main-content">
    <div class="nav-top d-flex justify-content-between">
        <a href="<?= base_url('admin/transaksi/data') ?>" class="btn btn-sm btn-outline-info mb-3"><i class="fa-solid fa-circle-left"></i> Kembali ke data transaksi</a>
        <button class="btn btn-sm btn-danger cetak mb-3">Cetak</button>
    </div>
    <div class="invoice">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Informasi transaksi</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col col-md-3 col-sm-6">
                                <h6>ID Transaksi</h6>
                                <p><?= $detail['uid_transaksi'] ?></p>
                            </div>
                            <div class="col col-md-3 col-sm-6">
                                <h6>Jumlah</h6>
                                <p><?= rupiah($detail['jumlah_pembayaran']) ?></p>
                            </div>
                            <div class="col col-md-3 col-sm-6">
                                <h6>Jenis</h6>
                                <p><?= $detail['jenis_pembayaran'] ?></p>
                            </div>
                            <div class="col col-md-3 col-sm-6">
                                <h6>Status Transaksi</h6>
                                <button type="button" class="btn btn-sm <?= ($detail['status_pembayaran'] === 'SETTLEMENT') ? 'btn-success' : 'btn-warning' ?> btn-icon icon-left">
                                    <i class="fa-solid fa-money-bill-wave"></i> <?= $detail['status_pembayaran'] ?>
                                </button>
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
                            <tr>
                                <td class="font-weight-bold">Id transaksi</td>
                                <td><?= $detail['uid_transaksi'] ?></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Jenis pembayaran</td>
                                <td><?= $detail['jenis_pembayaran'] ?></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Jumlah pembayaran</td>
                                <td><?= rupiah($detail['jumlah_pembayaran']) ?></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Id pembayaran</td>
                                <td><?= $detail['id_pembayaran'] ?></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Waktu pembayaran</td>
                                <td><?= $detail['waktu_transaksi'] ?></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Status</td>
                                <td><?= $detail['status_pembayaran'] ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Detail penghuni</h4>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <td class="font-weight-bold">Nama</td>
                                <td><?= $detail['fnama'] . ' ' . $detail['lnama'] ?></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Telepon</td>
                                <td><?= $detail['no_hp'] ?></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Email</td>
                                <td><?= $detail['email'] ?></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Jenis kelamin</td>
                                <td><?= $detail['jenis_kelamin'] ?></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Alamat</td>
                                <td><?= $detail['alamat'] ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="card author-box">
                    <div class="card-header">
                        <h4>Transaksi kamar</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2 col-sm-12">
                                <img alt="image" src="<?= base_url('public/images/kamar/') . $detail['gambar_satu'] ?>" class="img-fluid">
                            </div>
                            <div class="col-md-8 col-sm-12">
                                <div class="author-box-name">
                                    <h6><?= $detail['nama_kamar'] ?></h6>
                                </div>
                                <table class="table table-bordered table-md">
                                    <tr>
                                        <td class="font-weight-bold">Durasi ngekost</td>
                                        <td><?= $detail['durasingekost'] ?> Bulan</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Tipe kamar</td>
                                        <td><?= $detail['nama_kategori'] ?></td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Harga</td>
                                        <td><?= rupiah(($detail['harga'] * $detail['durasingekost'])) ?></td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Diskon</td>
                                        <td><?= $detail['diskon'] ?> %</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="w-100 d-sm-none"></div>
                        <div class="float-right mt-sm-0 mt-3">
                            <a href="<?= base_url('admin/kamar/master/detail/') . $detail['uid_kamar'] ?>" class="btn">Detail kamar<i class="fas fa-chevron-right"></i></a>
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
            var top_left_margin = 15;
            var PDF_Width = HTML_Width + (top_left_margin * 2);
            var PDF_Height = (PDF_Width * 1.5) + (top_left_margin * 2);
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