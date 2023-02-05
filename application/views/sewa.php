<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-Ejyk6W8iGNPzCd2V"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<div class="container mt-4">
    <?php
    if ($this->session->flashdata('message')) {
    ?>
        <script src="http://localhost/sk-kost/assets/modules/sweetalert/sweetalert.min.js"></script>
        <script>
            swal({
                title: "<?= $this->session->flashdata('icon') ?>",
                text: "<?= $this->session->flashdata('message') ?>",
                icon: "<?= $this->session->flashdata('icon') ?>"
            })
        </script>
    <?php
    }
    ?>
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
                    <form id="payment-form" method="post">
                        <p class="font-weight-bold">Identitas anda</p>
                        <div class="form-group">
                            <label for="fnama">Nama depan</label>
                            <input type="text" class="form-control" id="fnama" name="fnama" value="<?= $member['fnama'] ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label for="lnama">Nama belakang</label>
                            <input type="text" class="form-control" id="lnama" name="lnama" value="<?= $member['lnama'] ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label for="lnama">Alamat rumah</label>
                            <textarea type="text" class="form-control" id="alamat" name="alamat" disabled><?= $member['alamat'] ?></textarea>
                        </div>
                        <p class="font-weight-bold">Detail pengajuan sewa</p>
                        <div class="form-group">
                            <label for="tanggal_masuk">Tanggal masuk</label>
                            <input type="date" class="form-control" id="tanggal_masuk" name="tanggal_masuk" onchange="check()" value="<?= $_GET['tanggal_masuk'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="durasi">Durasi</label>
                            <select name="durasi" id="durasi" class="form-control" onChange="check()">
                                <?php
                                $durasi = explode(',', $kamar['uid_durasi']);
                                $d = 0;
                                while ($d < count($durasi)) {
                                ?>
                                    <option value="<?= $durasi[$d] ?>" <?= ($_GET['durasi'] == $durasi[$d]) ? 'selected' : '' ?>><?= $durasi[$d] ?> Bulan</option>
                                <?php
                                    $d++;
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="durasi">Total pembayaran</label>
                            <input type="text" class="form-control" id="jumlah_pembayaran" name="jumlah_pembayaran" onChange="check()" disabled>
                            <small>*Sudah termasuk perhitungan diskon + pajak</small>
                        </div>
                        <input type="hidden" name="uid_member" id="uid_member" value="<?= $member['uid_member'] ?>">
                        <input type="hidden" name="uid_kamar" id="uid_kamar" value="<?= $kamar['uid_kamar'] ?>">
                        <input type="hidden" name="jenis" id="jenis" value="baru">
                        <input type="hidden" name="result_type" id="result-type" value="">
                        <input type="hidden" name="result_data" id="result-data" value="">
                        <input type="hidden" name="token" id="token" value="">
                        <button class="btn btn-primary float-right" id="pay-button">Bayar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('document').ready(function() {
        check();
    })

    $('#pay-button').click(function(event) {
        event.preventDefault();
        $(this).attr("disabled", "disabled");
        var jenis_kelamin = '<?= ($member['jenis_kelamin'] == 'L') ? 'Laki' : 'Perempuan' ?>';
        if (jenis_kelamin != '<?= $kamar['nama_kategori'] ?>') {
            swal({
                title: 'Kamar kost kategori ' + '<?= $kamar['nama_kategori'] ?>',
                text: 'Jenis kelamin anda tidak sesuai dengan kategori kamar, silahkan cari kamar lain!',
                icon: 'warning'
            })
            console.log('not sesuai');
        } else {
            swal({
                title: 'yakin?',
                text: 'Apakah anda sudah yakin mau menyewa kamar ini?',
                icon: "warning",
                buttons: {
                    cancel: true,
                    cancel: 'Tidak',
                    confirm: "Ya, Saya Yakin"
                },
                dangerMode: true,
            }).then(function(isOk) {
                if (isOk) {
                    $.ajax({
                        url: '<?= site_url() ?>snap/token',
                        type: 'POST',
                        data: {
                            jumlah_pembayaran: $('#jumlah_pembayaran').val(),
                            uid_durasi: $('#durasi').val(),
                            tanggal_masuk: $('#tanggal_masuk').val(),
                            tanggal_keluar: '',
                            jenis: "baru",
                            uid_member: '<?= $member['uid_member'] ?>',
                            uid_kamar: '<?= $kamar['uid_kamar'] ?>',
                            nama_kost: '<?= $kamar['nama'] ?>',
                            fnama: '<?= $member['fnama'] ?>',
                            lnama: '<?= $member['lnama'] ?>',
                            email: '<?= $member['email'] ?>',
                            alamat: $('#alamat').val(),
                            no_hp: '<?= $member['no_hp'] ?>'
                        },
                        cache: false,

                        success: function(data) {
                            //location = data;
                            var token = data;
                            var resultType = document.getElementById('result-type');
                            var resultData = document.getElementById('result-data');

                            function changeResult(type, data) {
                                $("#result-type").val(type);
                                $("#result-data").val(JSON.stringify(data));
                                $("#token").val(token);
                            }
                            snap.pay(data, {
                                onSuccess: function(result) {
                                    changeResult('success', result);
                                    $("#token").val(data);
                                    $.ajax({
                                        url: '<?= site_url() ?>snap/saveData',
                                        type: 'POST',
                                        dataType: 'JSON',
                                        data: {
                                            jumlah_pembayaran: $('#jumlah_pembayaran').val(),
                                            uid_durasi: $('#durasi').val(),
                                            tanggal_masuk: $('#tanggal_masuk').val(),
                                            tanggal_keluar: '',
                                            jenis: "baru",
                                            uid_member: '<?= $member['uid_member'] ?>',
                                            uid_kamar: '<?= $kamar['uid_kamar'] ?>',
                                            result_data: $('#result-data').val(),
                                            token: $('#token').val()
                                        },
                                        cache: false,
                                        success: function(data) {
                                            url = "<?= base_url() ?>" + 'snap/finish?order_id=' + data.order_id + '&status=' + data.status;
                                            window.location.href = url;
                                        }
                                    });
                                },
                                onPending: function(result) {
                                    changeResult('pending', result);
                                    $("#token").val(data);
                                    $.ajax({
                                        url: '<?= site_url() ?>snap/saveData',
                                        type: 'POST',
                                        dataType: 'JSON',
                                        data: {
                                            jumlah_pembayaran: $('#jumlah_pembayaran').val(),
                                            uid_durasi: $('#durasi').val(),
                                            tanggal_masuk: $('#tanggal_masuk').val(),
                                            tanggal_keluar: '',
                                            jenis: "baru",
                                            uid_member: '<?= $member['uid_member'] ?>',
                                            uid_kamar: '<?= $kamar['uid_kamar'] ?>',
                                            result_data: $('#result-data').val(),
                                            token: $('#token').val()
                                        },
                                        cache: false,
                                        success: function(data) {
                                            url = "<?= base_url() ?>" + 'snap/finish?order_id=' + data.order_id + '&status=' + data.status;
                                            window.location.href = url;
                                        }
                                    });
                                },
                                onError: function(result) {
                                    $("#token").val(data);
                                    changeResult('error', result);
                                    $.ajax({
                                        url: '<?= site_url() ?>snap/saveData',
                                        type: 'POST',
                                        dataType: 'JSON',
                                        data: {
                                            jumlah_pembayaran: $('#jumlah_pembayaran').val(),
                                            uid_durasi: $('#durasi').val(),
                                            tanggal_masuk: $('#tanggal_masuk').val(),
                                            tanggal_keluar: '',
                                            jenis: "baru",
                                            uid_member: '<?= $member['uid_member'] ?>',
                                            uid_kamar: '<?= $kamar['uid_kamar'] ?>',
                                            result_data: $('#result-data').val(),
                                            token: $('#token').val()
                                        },
                                        cache: false,
                                        success: function(data) {
                                            url = "<?= base_url() ?>" + 'snap/finish?order_id=' + data.order_id + '&status=' + data.status;
                                            window.location.href = url;
                                        }
                                    });
                                },
                                onClose: function(result) {
                                    location.reload();
                                }
                            });
                        }
                    });
                } else {
                    $(this).removeAttr('disabled');
                }
            })
        }

    });

    function kalkulasi() {
        var durasi = document.getElementById('durasi').value;
        var harga = "<?= $kamar['harga'] ?>";
        var diskon = "<?= $kamar['harga'] * ($kamar['diskon'] / 100) ?>";
        var total = ("<?= $kamar['harga'] ?>" * durasi - (diskon * durasi));
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
            $('#pay-button').prop('disabled', true);
            swal("Maaf!", "Silahkan pilih durasi pengajuan kost!", "warning");
        } else {
            $('#pay-button').removeAttr('disabled');
            tanggalMaksimal();
        }
    }

    function tanggalMaksimal() {
        var tanggal_masuk = document.getElementById('tanggal_masuk').value;
        var dateNow = Date.now();
        var tanggal_maksimal_booking = addDays(dateNow, 7);
        if (tanggal_masuk > tanggal_maksimal_booking) {
            swal("Maaf!", "Pemesanan kamar tidak boleh lebih dari 7 hari dari tanggal sekarang!", "warning");
            $('#pay-button').prop('disabled', true);
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