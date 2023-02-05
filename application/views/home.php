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
                    <div class="btn kategori btn-sm btn-sm btn-primary"><?= $kamar['nama_kategori'] ?> </div>
                    <div class="des">
                        <h6 class="font-weight-bold"><?= $kamar['nama'] ?></h6>
                        <?php
                        $diskon = ($kamar['diskon'] / 100) * $kamar['harga'];
                        if ($diskon != 0) {
                            echo '<small class="font-weight-normal">' . $kamar['diskon'] . '% <del>' . rupiah($kamar['harga']) . '</del></small>';
                        }
                        ?>
                        <h4 class="font-weight-bold"><?= rupiah($kamar['harga'] - $diskon) ?></h4>
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