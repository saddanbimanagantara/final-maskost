<!-- market kost section -->

<section class="kost-product section-p1">
    <div class="d-flex justify-content-center mt-3 mb-3">
        <button type="button" class="btn btn-md btn-primary btn-cari d-flex justify-content-end" data-toggle="modal" data-target="#cari-kost">Cari</button>
    </div>
    <h4>Semua kamar kost</h4>
    <div class="pro-container">
        <?php
        foreach ($kamar as $kamar) : ?>
            <div class="pro" kost-id="<?= $kamar['uid_kamar'] ?>">
                <img src="<?= base_url('public/images/kamar/') . $kamar['gambar_satu'] ?>">
                <div class="des">
                    <div class="kategori"><?= $kamar['nama_kategori'] ?></div>
                    <h5 class="title"><?= $kamar['nama'] ?></h5>
                    <?php
                    $totalbintang = $kamar['limabintang'] + $kamar['empatbintang'] + $kamar['tigabintang'] + $kamar['duabintang'] + $kamar['satubintang'];
                    $rate =  ratingcount($totalbintang, $kamar['testicount']);
                    ?>
                    <?php
                    $fasilitas = explode(',', $kamar['uid_fasilitas']);
                    $f = 0;
                    while ($f < count($fasilitas)) {
                        $string = '';
                        foreach ($fasilitaskamar as $fk) {
                            if ($fasilitas[$f] === $fk['uid_fasilitas']) {
                                $string .=  $fk['nama'] . ',';
                            }
                        }
                        // limit deskripsi fasilitas
                        $string = strip_tags($string);
                        if (strlen($string) > 16) {

                            $stringCut = substr($string, 0, 16);
                            $endPoint = strrpos($stringCut, ' ');
                            $string = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                            $string .= '...';
                        }
                        echo '<small>' . $string . '</small>';
                        $f++;
                    }
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
                    <h5 class="price"><?= rupiah($kamar['harga']) ?></h5>
                    <div class="owner"><i class="fa-solid fa-image-portrait text-warning"></i><em><small> <?= $kamar['juragan'] ?></small></em></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<!-- section pagination -->
<section class="pagination d-flex justify-content-center">
    <nav aria-label="Page navigation example">
        <?php echo $this->pagination->create_links(); ?>
    </nav>
</section>

<script>
    $(document).ready(() => {
        $('.pro').click(function() {
            var uid_kamar = $(this).attr('kost-id');
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
        })
    })
</script>