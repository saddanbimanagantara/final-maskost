<div class="container mt-5">
    <div class="card text-center mx-auto" style="max-width: 20rem;">
        <div class="card-header">
            <?= $title ?>
        </div>
        <div class="card-body">

            <?php
            if ($status == 200) {
                echo '<h5 class="card-title p-2"><i class="fa-solid fa-thumbs-up" style="color:blue; font-size:60px;"></i></h5>';
                echo '<small class="card-text">Pembayaran berhasil silahkan cek di dashboard pembayaran dibawah</small>';
            } else {
                echo '<h5 class="card-title p-2"><i class="fa-solid fa-spinner"  style="color:orange; font-size:60px;"></i></h5>';
                echo '<small class="card-text">Pembayaran belum dibayar silahkan cek di dashboard pembayaran dibawah</small>';
            }
            ?>
            <br>
            <a href="<?= base_url('penghuni/pembayaran') ?>" class="btn btn-primary mt-3">Cek Pembayaran</a>
        </div>
    </div>
</div>