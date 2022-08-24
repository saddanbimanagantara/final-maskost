<div class="container mt-5">
    <div class="card text-center mx-auto" style="max-width: 20rem;">
        <div class="card-header">
            <?= $title ?>
        </div>
        <div class="card-body">
            <h5 class="card-title p-2"><?php echo ($status == 200) ? '<i class="fa-solid fa-thumbs-up" style="color:blue; font-size:60px;"></i>' : '<i class="fa-solid fa-spinner"  style="color:orange; font-size:60px;"></i>' ?></h5>
            <small class="card-text"><?= $status_message ?></small>
            <a href="<?= base_url('penghuni/pembayaran') ?>" class="btn btn-primary mt-3">Cek Pembayaran</a>
        </div>
    </div>
</div>