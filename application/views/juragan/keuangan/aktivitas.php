<?php $this->load->view('dist/_partials/header') ?>
<div class="main-content">

    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4>Aktivitas Keuangan</h4>
                    <button class="btn btn-sm btn-primary" id="btn-pengeluaran" data-toggle="modal" data-target="#pengeluaran">Tarik Uang</button>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="aktivitas-keuangan">
                        <thead>
                            <th class="text-center">#</th>
                            <th>Tanggal Aktivitas</th>
                            <th>Nominal</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($aktivitas as $aktivitas) :
                            ?>
                                <tr>
                                    <td class="align-middle"><?= $i++ ?></td>
                                    <td class="align-middle"><?= $aktivitas['date_updated'] ?></td>
                                    <?php
                                    if ($aktivitas['saldo_masuk']) {
                                    ?>
                                        <td class="align-middle"><?= rupiah($aktivitas['saldo_masuk']) ?></td>
                                        <td class="align-middle"><button class="btn btn-outline-success">Saldo Masuk</button></td>
                                    <?php
                                    } else if ($aktivitas['saldo_withdraw']) {
                                    ?>
                                        <td class="align-middle"><?= rupiah($aktivitas['saldo_withdraw']) ?></td>
                                        <td class="align-middle"> <button class="btn btn-outline-primary">Saldo Withdraw</button></td>
                                    <?php
                                    }
                                    ?>
                                    <td class="align-middle">
                                        <?php
                                        if ($aktivitas['status'] === 'SETTLEMENT') {
                                            echo '<span class="badge badge-success">SETTLEMENT</span>';
                                        } else if ($aktivitas['status'] === 'PENDING') {
                                            echo '<span class="badge badge-warning">PROCESSING</span>';
                                        } else if ($aktivitas['status'] === 'CANCEL') {
                                            echo '<span class="badge badge-danger">BATAL</span>';
                                        }
                                        ?>
                                    </td>
                                    <?php
                                    if ($aktivitas['saldo_masuk']) {
                                    ?>
                                        <td class="align-middle">
                                            <a href="<?= base_url('juragan/keuangan/detail/') . $aktivitas['uid_keuangan'] ?>" class="btn btn-icon btn-info"><i class="fa-solid fa-circle-info"></i> Detail</a>
                                        </td>
                                    <?php
                                    } else if ($aktivitas['saldo_withdraw'] && $aktivitas['status'] === "SETTLEMENT") {
                                    ?>
                                        <td class="align-middle">
                                            <a href="<?= base_url('juragan/keuangan/detail/') . $aktivitas['uid_keuangan'] ?>" class="btn btn-icon btn-info"><i class="fa-solid fa-circle-info"></i> Detail</a>
                                        </td>
                                    <?php
                                    } else if ($aktivitas['saldo_withdraw'] && $aktivitas['status'] === "PENDING") {
                                    ?>
                                        <td class="align-middle">
                                            <button class="btn btn-icon btn-danger batal" id="batal" uid_keuangan="<?= $aktivitas['uid_keuangan'] ?>"><i class="fas fa-times"></i> Batal</button>
                                            <a href="<?= base_url('juragan/keuangan/detail/') . $aktivitas['uid_keuangan'] ?>" class="btn btn-icon btn-info"><i class="fa-solid fa-circle-info"></i> Detail</a>
                                        </td>
                                    <?php
                                    } else {
                                    ?>
                                        <td class="align-middle">
                                            <a href="<?= base_url('juragan/keuangan/detail/') . $aktivitas['uid_keuangan'] ?>" class="btn btn-icon btn-info"><i class="fa-solid fa-circle-info"></i> Detail</a>
                                        </td>
                                    <?php
                                    }
                                    ?>

                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="pengeluaran">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tarik Uang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="form-pengeluaran" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nominal">Nominal</label>
                        <input type="text" class="form-control" name="nominal" id="nonimal">
                        <?php
                        $jumlah_saldo = $this->keuangan->getRekap($this->uid_member, "SETTLEMENT", "saldo_masuk");
                        ?>
                        <small>Maksimal penarikan : <?= rupiah($jumlah_saldo['saldo_masuk']) ?></small>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <input type="text" class="form-control" name="deskripsi" id="deskripsi">
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Pilih Metode Penarikan (Bank)</label><br>
                        <select name="nomor_rekening" id="nomor_rekening" class="form-control">
                            <?php
                            foreach ($rekening as $rekening) :
                            ?>
                                <option value="<?= $rekening['nomor_rekening'] ?>"><?= $rekening['nama_bank'] . " - " . $rekening['atas_nama'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span>Tambah metode penarikan: <a href="<?= base_url('juragan/keuangan/akunbank') ?>">"disini"</a></span>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->load->view('dist/_partials/footer') ?>
<script>
    $(document).ready(function() {
        <?php if (isset($_SESSION['response']) && $_SESSION['response'] !== '') : ?>
            swal({
                title: "<?php echo $_SESSION['response']['status']; ?>",
                text: "<?php echo $_SESSION['response']['message']; ?>",
                icon: "<?php echo $_SESSION['response']['status']; ?>"
            });
        <?php endif; ?>
        $('#aktivitas-keuangan').DataTable();
        var form = $('#form-pengeluaran');
        form.submit(function(ev) {
            console.log(form.serialize());
            ev.preventDefault();
            $.ajax({
                'type': form.attr('method'),
                'url': '<?= base_url('juragan/keuangan/penarikan') ?>',
                'data': form.serialize(),
                'dataType': 'JSON',
                'success': function(data) {
                    swal({
                        title: data.status,
                        text: data.message,
                        icon: data.status
                    }).then(function() {
                        location.reload();
                    });
                }
            })
        })
        $('.batal').click(function() {
            uid_keuangan = $(this).attr('uid_keuangan');
            $.ajax({
                url: "<?= base_url('juragan/keuangan/batalWD/') ?>" + uid_keuangan,
                type: "PUT",
                dataType: 'JSON',
                success: function(data) {
                    swal({
                        title: data.status,
                        text: data.message,
                        icon: data.status
                    }).then(function() {
                        location.reload();
                    });
                }
            })
        })
    })
</script>