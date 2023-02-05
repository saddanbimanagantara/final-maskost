    <!-- hero section -->
    <section class="hero-kost">
        <div class="hero-slogan">
            <h4>Binggung cari hunian sementara?</h4>
            <h1>MasKost Solusinya</h1>
            <h6>MasKost menyediakan layanan dengan aman, lengkap dan terpercaya</h6>
            <a type="button" href="<?= base_url('kost') ?>" class="btn btn-primary text-white">cari</a>
        </div>
    </section>

    <!-- fetured section -->
    <section class="fetured">
        <div class="fe-box">
            <img src="<?= base_url("public/assets/fetured/fe-1.svg") ?>" alt="pembayaran instant">
            <h6>Pembayaran Instan</h6>
        </div>
        <div class="fe-box">
            <img src="<?= base_url("public/assets/fetured/fe-2.svg") ?>" alt="Keamanan Terjamin">
            <h6>Keamanan Terjamin</h6>
        </div>
        <div class="fe-box">
            <img src="<?= base_url("public/assets/fetured/fe-3.svg") ?>" alt="Fitur Chat">
            <h6>Fitur Chat</h6>
        </div>
        <div class="fe-box">
            <img src="<?= base_url("public/assets/fetured/fe-4.svg") ?>" alt="Banyak Diskon">
            <h6>Banyak Diskon</h6>
        </div>
    </section>

    <!-- market kost section -->
    <section class="kost-product section-p1">
        <h2>Fetured Kost</h2>
        <p>Kost terbaru dengan berbagai fasilitas menarik dengan harga terjangkau</p>
        <div class="pro-container">
            <?php
            foreach ($kamar as $kamar) : ?>
                <div class="pro" kost-id="<?= $kamar['uid_kamar'] ?>" onclick="detail(this)">
                    <img src="<?= base_url('public/images/kamar/') . $kamar['gambar_satu'] ?>">
                    <div class="des">
                        <div class="btn btn-sm btn-outline-secondary mt-1 font-weight-bold"><?= $kamar['nama_kategori'] ?> </div>
                        <h6 class="mt-1 mb-1 font-weight-bold"><?= $kamar['nama'] ?></h6>
                        <small class="font-weight-bold"><?= $kamar['kota'] ?></small>
                        <?php
                        $totalbintang = $kamar['limabintang'] + $kamar['empatbintang'] + $kamar['tigabintang'] + $kamar['duabintang'] + $kamar['satubintang'];
                        $rate =  ratingcount($totalbintang, $kamar['testicount']);
                        echo $kamar['testicount'];
                        ?>
                        <?php
                        $fasilitas = explode(',', $kamar['uid_fasilitas']);
                        $f = 0;
                        $string = '';
                        while ($f < count($fasilitas)) {
                            foreach ($fasilitaskamar as $fk) {
                                if ($fasilitas[$f] === $fk['uid_fasilitas']) {
                                    $string .=  $fk['nama'] . '<span data-v-fdf112ec="" class="rc-facilities_divider">·</span>';
                                }
                            }
                            $f++;
                        }
                        // limit deskripsi fasilitas
                        $string = strip_tags($string);
                        if (strlen($string) > 80) {
                            $stringCut = substr($string, 0, 80);
                            $endPoint = strrpos($stringCut, ' ');
                            $string = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                            $string .= '...';
                        }

                        echo '<small>' . $string . '</small>';
                        ?>
                        <div class="star">
                            <?php
                            // show review bintang
                            $i = 0;
                            while ($i < $rate) {
                                echo '<i class="fas fa-star"></i>';
                                $i++;
                            }
                            echo "<small> (" . $kamar['testicount'] . " total reviews) </small>";
                            ?>
                        </div>
                        <?php
                        $diskon = ($kamar['diskon'] / 100) * $kamar['harga'];
                        if ($diskon != 0) {
                            echo '<small class="font-weight-normal">' . $kamar['diskon'] . '% <del>' . rupiah($kamar['harga']) . '</del></small>';
                        }
                        ?>
                        <br>

                        <h4 class="font-weight-bold mt-1"><?= rupiah($kamar['harga'] - $diskon) ?></h4>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    <script>
        function detail(data) {
            var uid_kamar = $(data).attr('kost-id');
            $.ajax({
                'url': '<?= base_url('kost/getKamar/') ?>',
                'type': 'POST',
                'dataType': 'JSON',
                'data': {
                    uid_kamar: uid_kamar
                },
                'success': function(data) {
                    window.location = "<?= base_url('kost/kamar/') ?>" + data.kamar['url_title'];
                }
            })
        }
    </script>