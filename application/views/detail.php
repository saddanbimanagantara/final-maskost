<script src="<?php echo base_url(); ?>assets/modules/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/modules/sweetalert/sweetalert.min.js"></script>
<section class="prodetails section-p1 mt-4">
    <div class="row">
        <div class="col-sm-12 col-md-8">
            <img src="<?= base_url('public/images/kamar/') . $kamar['gambar_satu'] ?>" class="mainImage" id="mainImage">
            <div class="small-img-group">
                <?php
                $gambar = array('gambar_satu', 'gambar_dua', 'gambar_tiga', 'gambar_empat', 'gambar_lima');
                $i = 0;
                while ($i < 5) {
                    if ($kamar[$gambar[$i]] != NULL) {

                ?>
                        <div class="small-img-col">
                            <img src="<?= base_url('public/images/kamar/') . $kamar[$gambar[$i]] ?>" class="small-img">
                        </div>
                <?php
                    }
                    $i++;
                }
                ?>
            </div>
        </div>

        <div class="col-sm-12 col-md-4 pro-detail" id="pro-detail">
            <h6>Home > Kost > Kamar > <?= $kamar['provinsi'] . " > " . $kamar['kota'] . " > " . $kamar['nama'] ?></h6>
            <button class="btn btn-sm kategori text-white mt-2 mb-2">Kost <?= $kamar['nama_kategori'] ?></button>
            <span class="location"><i class="fa-solid fa-location-dot"></i> <?= $kamar['kota'] ?></span>
            <h6>Pemilik : <?= $kamar['juragan'] ?></h6>
            <h3><?= $kamar['nama'] ?></h3>
            <h4><?= rupiah($kamar['harga']) ?>/ Bulan</h4>
            <div class="form-sewa" id="form-sewa">
                <form action="<?= base_url('sewa') ?>" method="POST">
                    <div class="ajukan-sewa">
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="text" name="uid_kamar" id="uid_kamar" value="<?= $kamar['uid_kamar'] ?>" hidden>
                                <label for="mulai">Mulai ngekost</label>
                                <input type="date" name="tanggal_masuk" id="tanggal_masuk" onchange="tanggalMaksimal()" class="form-control">
                            </div>
                            <div class="col-sm-6">
                                <label for="mulai">Durasi ngekost</label>
                                <select name="durasi" id="durasi" class="form-control" onChange="kalkulasi()">
                                    <option value="0" selected>Pilih durasi</option>
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
                        </div>
                        <div class="input-group mt-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Total pembayaran</span>
                            </div>
                            <input type="text" class="form-control" placeholder="total harga" aria-label="Username" aria-describedby="basic-addon1" id="totalharga" name="totalharga">
                        </div>
                        <div class="sewa-button" id="sewa-button">
                            <?php echo ($this->session->has_userdata('member')) ? '<button class="btn btn-success btn-md btn-sewa mt-3" id="btn-sewa">Ajukan Sewa</button>' : '<a href="' . base_url('auth/login') . '" class="badge badge-primary text-decoration-none mt-2">Silahkan login terlebih dahulu</a>'; ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
    if ($this->session->has_userdata('member')) {
        if ($tx['status'] === "huni") {
    ?>
            <script>
                swal("Maaf!", "Maksimal 1 orang Menyewa 1 Kamar Kost!", "warning");
                const sewaButton = document.getElementById('sewa-button');
                sewaButton.remove();
            </script>
    <?php
        }
    }

    ?>
    <div class="prodescription">
        <div class="discription-text">
            <h5>Deskripsi:</h5>
            <p><?= $kamar['deskripsi'] ?></p>
        </div>
        <div class="description-facility">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <h5>Fasilitas:</h5>
                    <?php
                    $fasilitas = explode(',', $kamar['uid_fasilitas']);
                    $f = 0;
                    while ($f < count($fasilitas)) {
                        $string = '';
                        foreach ($fasilitaskamar as $fk) {
                            if ($fasilitas[$f] === $fk['uid_fasilitas']) {
                                echo "<div class='facility'><div class='icon'><i class='" . $fk['icon'] . " fa-xl'></i></div><div class='icon-name'>: " . $fk['nama'] . "</div></div>";
                            }
                        }
                        $f++;
                    }
                    ?>
                </div>
                <div class="col-md-6 col-sm-12">
                    <h5>Luas kamar:</h5>
                    <p><?= $kamar['luas_kamar'] ?> m</p>
                </div>
            </div>
        </div>
        <div class="description-address row">
            <div class="address col-md-6 col-sm-12">
                <h5>Alamat:</h5>
                <p><?= $kamar['alamat'] ?></p>
                <h6>Maps</h6>
                <!-- <?= $kamar['maps'] ?> -->
            </div>
            <div class="testimonial-maps col-md-6 col-sm-12">
                <h5>Testimonial:</h5>
                <?php
                foreach ($review as $re) {
                    if ($re['anonim_status'] == 1) {
                ?>
                        <div class="box-testimonial">
                            <div class="profil-penghuni">
                                <img src="<?= base_url('assets/img/profile/penghuni/') . $re['foto'] ?>" class="testi-foto-penghuni">
                                <div class="bintang-testimonial">
                                    <span> <?= $re['fnama'] ?> <?= $re['lnama'] ?></span>
                                    <div class="start">
                                        <?php
                                        $b = 0;
                                        while ($b < $re['bintang']) {
                                            echo '<i class="fas fa-star text-warning"></i>';
                                            $b++;
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="pesan-testimonial">
                                <p><?= $re['pesan'] ?>!</p>

                            </div>
                        </div>
                    <?php
                    } else {
                    ?>
                        <div class="box-testimonial">
                            <div class="profil-penghuni">
                                <img src="<?= base_url('public/images/penghuni/') . $re['foto'] ?>" class="testi-foto-penghuni">
                                <div class="bintang-testimonial">
                                    <span> Anonim</span>
                                    <div class="start">
                                        <?php
                                        $b = 0;
                                        while ($b < $re['bintang']) {
                                            echo '<i class="fas fa-star text-warning"></i>';
                                            $b++;
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="pesan-testimonial">
                                <p><?= $re['pesan'] ?>!</p>

                            </div>
                        </div>
                <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
    </div>
</section>

<script>
    var mainImage = document.getElementById('mainImage');
    var smallImage = document.getElementsByClassName('small-img');

    smallImage[0].onclick = function() {
        mainImage.src = smallImage[0].src;
    }
    smallImage[1].onclick = function() {
        mainImage.src = smallImage[1].src;
    }
    smallImage[2].onclick = function() {
        mainImage.src = smallImage[2].src;
    }
    smallImage[3].onclick = function() {
        mainImage.src = smallImage[3].src;
    }
    smallImage[4].onclick = function() {
        mainImage.src = smallImage[4].src;
    }
    smallImage[5].onclick = function() {
        mainImage.src = smallImage[5].src;
    }

    function kalkulasi() {
        var durasi = document.getElementById('durasi');
        var durasiopsi = durasi.options[durasi.selectedIndex];
        var harga = "<?= $kamar['harga'] ?>";
        const total = ("<?= $kamar['harga'] ?>" * durasiopsi.value);
        document.getElementById('totalharga').value = "Rp " + rupiah(total);
    }

    function rupiah(nilai) {
        var reverse = nilai.toString().split('').reverse().join(''),
            ribuan = reverse.match(/\d{1,3}/g);
        ribuan = ribuan.join('.').split('').reverse().join('');
        return ribuan;
    }

    function tanggalMaksimal() {
        var tanggal_masuk = document.getElementById('tanggal_masuk').value;
        var dateNow = Date.now();
        var tanggal_maksimal_booking = addDays(dateNow, 7);
        if (tanggal_masuk > tanggal_maksimal_booking) {
            swal("Maaf!", "Pemesanan kamar tidak boleh lebih dari 7 hari dari tanggal sekarang!", "warning");
            $('#btn-sewa').attr('disabled', true);
        } else {
            $('#btn-sewa').removeAttr('disabled');
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