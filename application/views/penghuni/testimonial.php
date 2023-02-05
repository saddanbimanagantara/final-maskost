<?php $this->load->view('dist/_partials/header') ?>
<div class="main-content">
    <div class="card">
        <div class="card-header">
            Testimonial
        </div>
        <?php
        if ($transaksi) {
        ?>
            <div class="card-body">
                <table class="table" id="tb-testimonial">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama kamar</th>
                            <th>Status testimonial</th>
                            <th>Kirim testimonial</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($transaksi as $transaksi) {
                        ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td><?= $transaksi['nama'] ?></td>
                                <td>
                                    <?php
                                    if ($transaksi['uid_testimonial'] == null) {
                                        echo 'belum kirim testimonial';
                                    } else {
                                        echo 'sudah kirim testimonial';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($transaksi['uid_testimonial'] == null) {
                                        echo '<button class="btn btn-sm btn-primary" data-uid_transaksi="' . $transaksi['uid_transaksi'] . '" data-uid_kamar="' . $transaksi['uid_kamar'] . '" onclick="kirim(this)">Kirim Testimonial</button>';
                                    } else {
                                        echo '<button class="btn btn-sm btn-Info" data-uid_testimonial="' . $transaksi['uid_testimonial'] . '" data-anonim_status="' . $transaksi['anonim_status'] . '" data-pesan="' . $transaksi['pesan'] . '" data-bintang="' . $transaksi['bintang'] . '" onclick="edit(this)">Edit Testimonial</button>';
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php
        } else {
            echo "sewa dulu dong!";
        }
        ?>
    </div>
    <div class="modal fade" id="kirim" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Kirim testimonial</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('penghuni/testimonial/kirimtesti/kirim') ?>" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="bintang">Anonim status</label>
                            <input type="text" name="uid_member" id="uid_member" hidden>
                            <input type="text" name="uid_kamar" id="uid_kamar" hidden>
                            <input type="text" name="uid_transaksi" id="uid_transaksi" hidden>
                            <select name="anonim_status" id="anonim_status" class="form-control">
                                <option value="1">Testimonial nama muncul</option>
                                <option value="0">Testimonial nama tidak muncul</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="bintang">Rating</label>
                            <select name="bintang" id="bintang" class="form-control">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="pesan">Pesan</label>
                            <textarea type="text" name="pesan" id="pesan" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit testimonial</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('penghuni/testimonial/kirimtesti/edit') ?>" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="bintang">Anonim status</label>
                            <input type="hidden" name="uid_testimonial" id="uid_testimonial">
                            <select name="anonim_status" id="anonim_statusedit" class="form-control">
                                <option value="1">Testimonial nama muncul</option>
                                <option value="0">Testimonial nama tidak muncul</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="bintang">Rating</label>
                            <select name="bintang" id="bintangedit" class="form-control">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="pesan">Pesan</label>
                            <textarea type="text" name="pesan" id="pesanedit" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<?php $this->load->view('dist/_partials/footer') ?>
<script>
    function kirim(kirim) {
        $('#kirim').modal('show');
        var uid_member = '<?= $user['member_id'] ?>';
        var uid_kamar = $(kirim).data('uid_kamar');
        var uid_transaksi = $(kirim).data('uid_transaksi');
        $('#uid_member').val(uid_member);
        $('#uid_kamar').val(uid_kamar);
        $('#uid_transaksi').val(uid_transaksi);
    }

    function edit(edit) {
        $('#edit').modal('show');
        var uid_testimonial = $(edit).data('uid_testimonial');
        var anonim_status = $(edit).data('anonim_status');
        var pesan = $(edit).data('pesan');
        var bintang = $(edit).data('bintang');
        $('#uid_testimonial').val(uid_testimonial);
        $('#pesanedit').val(pesan);
        $('#bintangedit').val(bintang);
        $('#anonim_statusedit').val(anonim_status);
    }
</script>