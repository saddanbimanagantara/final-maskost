<?php $this->load->view('dist/_partials/header') ?>
<div class="main-content">
    <div class="card">
        <div class="card-header">
            Testimonial
        </div>

        <div class="card-body">
            <form action="<?= base_url('penghuni/testimonial/insert') ?>" method="POST">
                <div class="form-group">
                    <label for="bintang">Anonim status</label>
                    <input type="hidden" name="uid_member" value="<?= $transaksi['uid_member'] ?>">
                    <input type="hidden" name="uid_kamar" value="<?= $transaksi['uid_kamar'] ?>">
                    <input type="hidden" name="uid_transaksi" value="<?= $transaksi['uid_transaksi'] ?>">
                    <select name="anonim_status" id="anonim_status" class="form-control">
                        <?= ($testimonial['anonim_status']) ? '<option value="' . $testimonial['anonim_status'] . '" selected>Testimonial nama muncul</option>' : '<option value="' . $testimonial['anonim_status'] . '" selected>Testimonial nama tidak muncul</option>' ?>
                        <option value="1">Testimonial nama muncul</option>
                        <option value="0">Testimonial nama tidak muncul</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="bintang">Rating</label>
                    <select name="bintang" id="bintang" class="form-control">
                        <?= ($testimonial['bintang']) ? '<option value="' . $testimonial['bintang'] . '" selected>' . $testimonial['bintang'] . '</option>' : "" ?>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="pesan">Pesan</label>
                    <textarea type="text" name="pesan" id="pesan" class="form-control"><?= ($testimonial['pesan']) ? $testimonial['pesan'] : "" ?></textarea>
                </div>
                <button type="submit" class="btn btn-md btn-primary float-right">Kirim</button>
            </form>
        </div>
    </div>
</div>
<?php $this->load->view('dist/_partials/footer') ?>