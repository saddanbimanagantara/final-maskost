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
                <div class="pro">
                    <img src="<?= base_url('public/images/kamar/') . $kamar['gambar_satu'] ?>" alt="">
                    <div class="des">
                        <span><?= $kamar['nama_kategori'] ?></span>
                        <h5 class="title"><?= $kamar['nama'] ?></h5>
                        <?php
                        $totalbintang = $kamar['limabintang'] + $kamar['empatbintang'] + $kamar['tigabintang'] + $kamar['duabintang'] + $kamar['satubintang'];
                        $rate =  ratingcount($totalbintang, $kamar['testicount']);
                        ?>
                        <div class="star">
                            <?php
                            $i = 0;
                            while ($i < $rate) {
                                echo '<i class="fas fa-star"></i>';
                                $i++;
                            }
                            echo "<small> (" . $kamar['testicount'] . ")</small>";
                            ?>
                        </div>
                        <h5 class="price"><?= rupiah($kamar['harga']) ?></h5>
                    </div>
                    <div class="d-flex align-items-end justify-content-center">
                        <a href="<?= base_url('kost/kamar/') . $kamar['url_title'] ?>" class="btn btn-sm btn-primary text-white m-1">Detail</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>