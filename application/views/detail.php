<script src="<?php echo base_url(); ?>assets/modules/jquery.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<section class="prodetails section-p1 mt-4">
    <div class="row">
        <div class="col-sm-12 col-md-8">
            <img src="<?= base_url('public/images/kamar/') . $kamar['gambar_satu'] ?>" class="mainImage" id="mainImage">
            <div class="small-img-group" id="small-img-group">
                <div class="small-img-group small-img-col" id="small-img-col">
                    <?php
                    $gambar = array('gambar_satu', 'gambar_dua', 'gambar_tiga', 'gambar_empat', 'gambar_lima');
                    $i = 0;
                    while ($i < 5) {
                        if ($kamar[$gambar[$i]] != NULL) {

                    ?>
                            <img src="<?= base_url('public/images/kamar/') . $kamar[$gambar[$i]] ?>" class="small-img mr-1">
                    <?php
                        }
                        $i++;
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-4 pro-detail" id="pro-detail">
            <h6>Home > Kost > Kamar > <?= $kamar['provinsi'] . " > " . $kamar['kota'] . " > " . $kamar['nama'] ?></h6>
            <button class="btn btn-sm kategori text-white mt-2 mb-2">Kost <?= $kamar['nama_kategori'] ?></button>
            <span class="location"><i class="fa-solid fa-location-dot"></i> <?= $kamar['kota'] ?></span>
            <br>
            <?php
            $terjual = $this->kamar->getKamarTerjual($kamar['uid_kamar'], null);
            $sisaKamar = $kamar['jumlah_kamar'] - $terjual;
            ?>
            <small>Sisa kamar: <?= $sisaKamar ?></small><br>
            <h4><?= $kamar['nama'] ?></h4>
            <a class="btn btn-sm btn-success" href="<?= base_url('kost/juragan/') . $kamar['username'] ?>">Juragan <?= $kamar['juragan'] ?></a>
            <a href="https://api.whatsapp.com/send?phone='.<?= $kamar['telepon'] ?>.'&text=hallo" class="btn btn-sm btn-primary mb-2 mt-2">Hubungi juragan</a><br>
            <?php
            $diskon = ($kamar['diskon'] / 100) * $kamar['harga'];
            if ($diskon != 0) {
                echo '<small class="font-weight-normal">' . $kamar['diskon'] . '% <del>' . rupiah($kamar['harga']) . '</del></small>';
            }
            ?>
            <br>

            <h4 class="font-weight-bold mt-1"><?= rupiah($kamar['harga'] - $diskon) ?>/Bulan</h4>
            <div class="form-sewa" id="form-sewa">
                <?php
                $sess = $this->session->userdata('member');
                if ($sess != null and $sess['otoritas'] === 'penghuni') { ?>
                    <form id="sewa-form" action="<?= base_url('sewa') ?>" method="POST">
                        <div class="ajukan-sewa">
                            <div class="row">
                                <div class="col-sm-6">
                                    <input type="text" name="uid_kamar" id="uid_kamar" value="<?= $kamar['uid_kamar'] ?>" hidden>
                                    <label for="mulai">Mulai ngekost</label>
                                    <input type="date" name="tanggal_masuk" id="tanggal_masuk" onchange="tanggalMaksimal()" class="form-control" required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="mulai">Durasi ngekost</label>
                                    <select name="durasi" id="durasi" class="form-control" onChange="kalkulasi()" required>
                                        <option value="">Pilih durasi</option>
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
                                <input type="text" class="form-control" placeholder="total harga" aria-label="Username" aria-describedby="basic-addon1" id="totalharga" name="totalharga" disabled>
                            </div>
                            <div class="sewa-button" id="sewa-button">
                                <?php echo ($this->session->has_userdata('member')) ? '<button class="btn btn-success btn-md btn-sewa mt-3" id="btn-sewa">Ajukan Sewa</button>' : '<a href="' . base_url('auth/login') . '" class="badge badge-primary text-decoration-none mt-2">Silahkan login terlebih dahulu</a>'; ?>
                            </div>
                        </div>
                    </form>
                <?php } ?>
                <p class="font-weight-bold mt-1">Aturan</p>
                <li><?= ($kamar['tipe'] == 'A') ? 'Tipe A Maks. 1 orang/ kamar' : 'Tipe A Maks. 2 orang/ kamar' ?></li>
                <li>Kategori <?= $kamar['nama_kategori'] ?>,
                    hanya dapat disewa oleh penghuni <?= $kamar['nama_kategori'] ?></li>
            </div>
        </div>
    </div>
    <?php
    if ($this->session->has_userdata('member')) {
        if (isset($tx['status'])) {
            if ($tx['status'] == 'huni') {
                if ($tx['uid_member'] != $member['member_id']) {
                    if ($sisaKamar == 0) {
    ?>
                        <script>
                            swal("Maaf!", "Maaf kamar sudah terjual habis!", "warning");
                            const sewaButton = document.getElementById('sewa-button');
                            sewaButton.remove();
                        </script>
                    <?php
                    }
                } else {
                    ?>
                    <script>
                        swal("Maaf!", "Maksimal 1 orang Menyewa 1 Kamar Kost!", "warning");
                        const sewaButton = document.getElementById('sewa-button');
                        sewaButton.remove();
                    </script>
    <?php
                }
            }
        }
    }

    ?>
    <div class="prodescription">
        <div class="description-facility">
            <div class="row">
                <div class="col-md-6 col-sm-12 mb-1">
                    <h6>Fasilitas Kamar:</h6>
                    <?php
                    $fasilitas = explode(',', $kamar['uid_fasilitas']);
                    $f = 0;
                    while ($f < count($fasilitas)) {
                        $string = '';
                        foreach ($f_kamar as $fk) {
                            if ($fasilitas[$f] === $fk['uid_fasilitas']) {
                                echo "<small class='facility'><div class='icon'><i class='" . $fk['icon'] . " fa-xl'></i></div><div class='icon-name'>: " . $fk['nama'] . "</div></small>";
                            }
                        }
                        $f++;
                    }
                    ?>
                </div>
                <div class="col-md-6 col-sm-12 mb-1">
                    <h6>Fasilitas umum:</h6>
                    <?php
                    $fasilitas = explode(',', $kamar['uid_fasilitas']);
                    $f = 0;
                    while ($f < count($fasilitas)) {
                        $string = '';
                        foreach ($f_umum as $fk) {
                            if ($fasilitas[$f] === $fk['uid_fasilitas']) {
                                echo "<small class='facility'><div class='icon'><i class='" . $fk['icon'] . " fa-xl'></i></div><div class='icon-name'>: " . $fk['nama'] . "</div></small>";
                            }
                        }
                        $f++;
                    }
                    ?>
                </div>

                <div class="col-md-6 col-sm-12 mb-1">
                    <h6>Fasilitas kamar mandi:</h6>
                    <?php
                    $fasilitas = explode(',', $kamar['uid_fasilitas']);
                    $f = 0;
                    while ($f < count($fasilitas)) {
                        $string = '';
                        foreach ($f_kamar_mandi as $fk) {
                            if ($fasilitas[$f] === $fk['uid_fasilitas']) {
                                echo "<small class='facility'><div class='icon'><i class='" . $fk['icon'] . " fa-xl'></i></div><div class='icon-name'>: " . $fk['nama'] . "</div></small>";
                            }
                        }
                        $f++;
                    }
                    ?>
                </div>
                <div class="col-md-6 col-sm-12 mb-1">
                    <h6>Fasilitas parkir:</h6>
                    <?php
                    $fasilitas = explode(',', $kamar['uid_fasilitas']);
                    $f = 0;
                    while ($f < count($fasilitas)) {
                        $string = '';
                        foreach ($f_parkiran as $fk) {
                            if ($fasilitas[$f] === $fk['uid_fasilitas']) {
                                echo "<small class='facility'><div class='icon'><i class='" . $fk['icon'] . " fa-xl'></i></div><div class='icon-name'>: " . $fk['nama'] . "</div></small>";
                            }
                        }
                        $f++;
                    }
                    ?>
                </div>
                <div class="col-md-6 col-sm-12 mb-1">
                    <h6>Luas kamar:</h6>
                    <small><?= $kamar['luas_kamar'] ?> m</small>
                </div>
            </div>
        </div>
        <div class="discription-text">
            <h6>Deskripsi:</h6>
            <p><?= $kamar['deskripsi'] ?></p>
        </div>

        <div class="description-address row">
            <div class="address col-md-6 col-sm-12">
                <h6>Alamat:</h6>
                <p><?= $kamar['alamat'] ?></p>
                <h6>Maps</h6>
                <?= $this->secure->decrypt_url($kamar['maps']) ?>
            </div>
            <div class="testimonial-maps col-md-6 col-sm-12">
                <h6>Testimonial:</h6>
                <?php
                if ($review)
                    foreach ($review as $re) {
                        if ($re['anonim_status'] == 1) {
                ?>
                        <div class="box-testimonial">
                            <div class="profil-penghuni">
                                <img src="<?= base_url('assets/img/profile/penghuni/') . $re['image'] ?>" class="testi-foto-penghuni">
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
                                <img src="<?= base_url('assets/img/profile/penghuni/') . $re['image'] ?>" class="testi-foto-penghuni">
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
</section>

<script>
    $(document).ready(function() {
        $('#sewa-form').submit(function(e) {
            e.preventDefault();
            var jenis_kelamin = '<?php if ($member) {
                                        switch ($member['jenis_kelamin']) {
                                            case 'L':
                                                $jk = 'Laki';
                                                break;
                                            case 'P':
                                                $jk = 'Perempuan';
                                                break;
                                            case '':
                                                $jk = '';
                                                break;
                                        }
                                        echo $jk;
                                    } ?>';
            if (jenis_kelamin == '') {
                swal({
                    title: 'Lengkapi profile anda',
                    text: 'Profile anda belum lengkap!',
                    icon: 'warning'
                })
            } else if ('<?= $kamar['nama_kategori'] ?>' != 'perempuan' || '<?= $kamar['nama_kategori'] ?>' != 'laki') {
                swal({
                    title: 'Anda yakin?',
                    text: 'Apakah anda sudah yakin mau menyewa kamar ini?',
                    icon: "warning",
                    buttons: {
                        cancel: true,
                        cancel: 'Tidak',
                        confirm: "Ya, Saya Yakin"
                    },
                }).then(function(isOk) {
                    if (isOk) {
                        var tanggal_masuk = $('#tanggal_masuk').val()
                        var durasi = $('#durasi').val()
                        var uid_kamar = $('#uid_kamar').val();
                        var url = `sewa?kamar=${uid_kamar}&tanggal_masuk=${tanggal_masuk}&durasi=${durasi}`;
                        window.location.href = "<?= base_url() ?>" + url
                    }
                })
            } else if (jenis_kelamin != '<?= $kamar['nama_kategori'] ?>') {
                swal({
                    title: 'Kamar kost kategori ' + '<?= $kamar['nama_kategori'] ?>',
                    text: 'Jenis kelamin anda tidak sesuai dengan kategori kamar, silahkan cari kamar lain!',
                    icon: 'warning'
                })
                $('.btn-sewa').prop('disabled', 'disabled');
            } else {
                swal({
                    title: 'Anda yakin?',
                    text: 'Apakah anda sudah yakin mau menyewa kamar ini?',
                    icon: "warning",
                    buttons: {
                        cancel: true,
                        cancel: 'Tidak',
                        confirm: "Ya, Saya Yakin"
                    },
                }).then(function(isOk) {
                    if (isOk) {
                        var tanggal_masuk = $('#tanggal_masuk').val()
                        var durasi = $('#durasi').val()
                        var uid_kamar = $('#uid_kamar').val();
                        var url = `sewa?kamar=${uid_kamar}&tanggal_masuk=${tanggal_masuk}&durasi=${durasi}`;
                        window.location.href = "<?= base_url() ?>" + url
                    }
                })
            }

        })
    });
    var mainImage = document.getElementById('mainImage');
    var smallImage = document.getElementsByClassName('small-img');
    var listImage = document.getElementById('small-img-col');
    listImage.addEventListener('click', function(e) {
        mainImage.src = e.target.currentSrc
    })


    function kalkulasi() {
        var diskon = "<?= $diskon ?>";
        var durasi = document.getElementById('durasi');
        var durasiopsi = durasi.options[durasi.selectedIndex];
        var harga = "<?= $kamar['harga'] ?>";
        const total = ("<?= $kamar['harga'] ?>" * durasiopsi.value) - (diskon * durasiopsi.value);
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