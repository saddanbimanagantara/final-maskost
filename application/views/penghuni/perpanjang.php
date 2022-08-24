<?php $this->load->view('dist/_partials/header'); ?>
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-Ejyk6W8iGNPzCd2V"></script>
<div class="main-content mt-4">
    <div class="card">
        <div class="card-header bg-primary text-center text-white">
            <h5 class="pt-2"><?= $title ?></h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="card">
                        <img class="card-img-top" src="<?= base_url('public/images/kamar/') . $kamar['gambar_satu'] ?>" alt="Card image cap">
                        <div class="card-body">
                            <p class="card-title text-center"><?= $kamar['nama'] ?></p>
                            <table class="table">
                                <tr>
                                    <td><small class="font-weight-bold">Harga</small></td>
                                    <td><small><?= rupiah($kamar['harga']); ?></small></td>
                                </tr>
                                <tr>
                                    <td><small class="font-weight-bold">Diskon</small></td>
                                    <td><small><?= $kamar['diskon'] ?>%</small></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-sm-12">
                    <form id="payment-form" method="post" action="<?= site_url() ?>snap/finish">
                        <p class="font-weight-bold">Identitas anda</p>
                        <div class="form-group">
                            <label for="fnama">Nama depan</label>
                            <input type="text" class="form-control" id="fnama" name="fnama" value="<?= $user['fnama'] ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label for="lnama">Nama belakang</label>
                            <input type="text" class="form-control" id="lnama" name="lnama" value="<?= $user['lnama'] ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label for="lnama">Alamat rumah</label>
                            <textarea type="text" class="form-control" id="alamat" name="alamat" disabled><?= $user['alamat'] ?></textarea>
                        </div>
                        <p class="font-weight-bold">Detail sewa saat ini</p>
                        <div class="form-group">
                            <label for="tanggal_masuk">Tanggal Masuk</label>
                            <input type="text" class="form-control" id="vtm" name="vtm" value="<?= $tx['tanggal_masuk'] ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_masuk">Tanggal Keluar</label>
                            <input type="text" class="form-control" id="vtk" name="vtk" value="<?= $tx['tanggal_keluar'] ?>" disabled>
                        </div>
                        <p class="font-weight-bold">Detail Perpanjang sewa</p>
                        <div class="form-group">
                            <label for="durasi">Durasi perpanjang</label>
                            <select name="durasi" id="durasi" class="form-control" onChange="check()">
                                <?php
                                $durasi = explode(',', $kamar['uid_durasi']);
                                $d = 0;
                                while ($d < count($durasi)) {
                                ?>
                                    <option value="<?= $durasi[$d] ?>"><?= $durasi[$d] ?> Bulan</option>
                                <?php
                                    $d++;
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="durasi">Total pembayaran</label>
                            <input type="text" class="form-control" id="jumlah_pembayaran" name="jumlah_pembayaran" onChange="check()">
                            <small>*Sudah termasuk perhitungan diskon + pajak</small>
                        </div>
                        <input type="hidden" name="jenis" id="jenis" value="perpanjang">
                        <input type="hidden" name="tanggal_masuk" id="tanggal_masuk" value="<?= $tx['tanggal_masuk'] ?>">
                        <input type="hidden" name="tanggal_keluar" id="tanggal_keluar" value="<?= $tx['tanggal_keluar'] ?>">
                        <input type="hidden" name="uid_member" id="uid_member" value="<?= $user['member_id'] ?>">
                        <input type="hidden" name="uid_kamar" id="uid_kamar" value="<?= $tx['uid_kamar'] ?>">
                        <input type="hidden" name="result_type" id="result-type" value="">
                        <input type="hidden" name="result_data" id="result-data" value="">
                        <input type="hidden" name="token" id="token" value="">
                        <button class="btn btn-primary" id="pay-button">Bayar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('dist/_partials/footer'); ?>
<script>
    $('document').ready(function() {
        check();
    })

    $('#pay-button').click(function(event) {
        event.preventDefault();
        $(this).attr("disabled", "disabled");

        $.ajax({
            url: '<?= site_url() ?>snap/token',
            type: 'POST',
            data: {
                jumlah_pembayaran: $('#jumlah_pembayaran').val(),
                uid_durasi: $('#durasi').val(),
                tanggal_masuk: $('#tanggal_masuk').val(),
                tanggal_keluar: $('#tanggal_keluar').val(),
                jenis: 'perpanjang',
                uid_member: '<?= $user['member_id'] ?>',
                uid_kamar: '<?= $kamar['uid_kamar'] ?>',
                nama_kost: '<?= $kamar['nama'] ?>',
                fnama: '<?= $user['fnama'] ?>',
                lnama: '<?= $user['lnama'] ?>',
                email: '<?= $user['email'] ?>',
                alamat: $('#alamat').val()
            },
            cache: false,

            success: function(data) {
                //location = data;

                console.log('token = ' + data);
                var token = data;
                var resultType = document.getElementById('result-type');
                var resultData = document.getElementById('result-data');

                function changeResult(type, data) {
                    $("#result-type").val(type);
                    $("#result-data").val(JSON.stringify(data));
                    $("#token").val(token);
                    //resultType.innerHTML = type;
                    //resultData.innerHTML = JSON.stringify(data);
                }

                snap.pay(data, {

                    onSuccess: function(result) {
                        changeResult('success', result);
                        console.log(result.status_message);
                        console.log(result);
                        $("#token").val(data);
                        $("#payment-form").submit();
                    },
                    onPending: function(result) {
                        changeResult('pending', result);
                        console.log(result.status_message);
                        $("#token").val(data);
                        $("#payment-form").submit();
                    },
                    onError: function(result) {
                        $("#token").val(data);
                        changeResult('error', result);
                        console.log(result.status_message);
                        $("#payment-form").submit();
                    }
                });
            }
        });
    });

    function kalkulasi() {
        var durasi = document.getElementById('durasi').value;
        var harga = "<?= $kamar['harga'] ?>";
        var diskon = "<?= $kamar['harga'] * ($kamar['diskon'] / 100) ?>";
        var total = ("<?= $kamar['harga'] ?>" * durasi - diskon);
        document.getElementById('jumlah_pembayaran').value = "Rp " + rupiah(total);
    }

    function rupiah(nilai) {
        var reverse = nilai.toString().split('').reverse().join(''),
            ribuan = reverse.match(/\d{1,3}/g);
        ribuan = ribuan.join('.').split('').reverse().join('');
        return ribuan;
    }

    function check() {
        kalkulasi();
        var durasi = document.getElementById('durasi').value;
        var jumlah_pembayaran = document.getElementById('jumlah_pembayaran').value;
        if (durasi == 0) {
            tanggalMaksimal();
            swal("Maaf!", "Silahkan pilih durasi pengajuan kost!", "warning");
            $('#pay-button').attr('disabled', true);
        } else {
            tanggalMaksimal();
            $('#pay-button').removeAttr('disabled');
        }
    }

    function tanggalMaksimal() {
        var tanggal_masuk = document.getElementById('tanggal_masuk').value;
        var dateNow = Date.now();
        var tanggal_maksimal_booking = addDays(dateNow, 7);
        if (tanggal_masuk > tanggal_maksimal_booking) {
            swal("Maaf!", "Pemesanan kamar tidak boleh lebih dari 7 hari dari tanggal sekarang!", "warning");
            $('#pay-button').attr('disabled', true);
        } else {
            $('#pay-button').removeAttr('disabled');
        }
    }

    function addDays(date, days) {
        var result = new Date(date);
        result.setDate(result.getDate() + days);
        let month = (result.getMonth() + 1).toString();
        let day = result.getDate().toString();
        let year = result.getFullYear();
        if (month.length < 2) {
            month = '0' + month;
        }
        if (day.length < 2) {
            day = '0' + day;
        }
        return [year, month, day].join('-');
    }
</script>