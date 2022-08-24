<?php $this->load->view('dist/_partials/header'); ?>
<div class="main-content">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Master data user administrator</h4>
                </div>
                <div class="card-body">
                    <div class="add d-flex justify-content-end mb-2">
                        <button class="btn btn-icon btn-primary" id="btn-tambah" data-toggle="modal" data-target="#bank"><span>Tambah rekening</span></i></a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped" id="data-bank">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Atas Nama</th>
                                    <th>Bank</th>
                                    <th>Nomor rekening</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <?php
                            $i = 1;
                            foreach ($bank as $bank) :
                            ?>
                                <tr>
                                    <td class="align-middle"><?= $i++ ?></td>
                                    <td class="align-middle"><?= $bank['atas_nama'] ?></td>
                                    <td class="align-middle"><?= $bank['nama_bank'] ?></td>
                                    <td class="align-middle"><?= $bank['nomor_rekening'] ?></td>
                                    <td class="align-middle text-center">
                                        <button class="btn btn-icon btn-info mb-1 edit" id="edit" data-uid_rekening="<?= $bank['uid_rekening'] ?>"><i class="far fa-edit"></i></button>
                                        <button class="btn btn-icon btn-danger mb-1" onclick="hapus(this)" uid_rekening="<?= $bank['uid_rekening'] ?>"><i class="fas fa-times"></i></button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="bank">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Rekening</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="form-bank" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="atas_nama">Atas Nama</label>
                        <input type="hidden" name="uid_member" value="<?= $user['member_id'] ?>">
                        <input type="text" class="form-control" name="atas_nama" id="atas_nama">
                    </div>
                    <div class="form-group">
                        <label for="nama_bank">NAMA BANK</label>
                        <select name="nama_bank" id="nama_bank" class="form-control">
                            <option value="BCA">BCA</option>
                            <option value="BRI">BRI</option>
                            <option value="BNI">BNI</option>
                            <option value="MANDIRI">MANDIRI</option>
                            <option value="MANDIRI_SYARIAH">MANDIRI SYARIAH</option>
                            <option value="CIMB_NIAGA">CIMB NIAGA</option>
                            <option value="BTPN">BTPN</option>
                            <option value="HSBC">HSBC</option>
                            <option value="CITIBANK">CITIBANK</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nomor_rekening">Nomor rekening</label><br>
                        <input type="text" name="nomor_rekening" id="nomor_rekening" class="form-control">
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="bankedit">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Rekening</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="form-bankedit" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="atas_namaedit">Atas Nama</label>
                        <input type="hidden" name="uid_member" value="<?= $user['member_id'] ?>">
                        <input type="hidden" name="uid_rekeningedit" id="uid_rekeningedit">
                        <input type="text" class="form-control" name="atas_namaedit" id="atas_namaedit">
                    </div>
                    <div class="form-group">
                        <label for="nama_bankedit">NAMA BANK</label>
                        <select name="nama_bankedit" id="nama_bankedit" class="form-control">
                            <option value="BCA">BCA</option>
                            <option value="BRI">BRI</option>
                            <option value="BNI">BNI</option>
                            <option value="MANDIRI">MANDIRI</option>
                            <option value="MANDIRI_SYARIAH">MANDIRI SYARIAH</option>
                            <option value="CIMB_NIAGA">CIMB NIAGA</option>
                            <option value="BTPN">BTPN</option>
                            <option value="HSBC">HSBC</option>
                            <option value="CITIBANK">CITIBANK</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nomor_rekeningedit">Nomor rekening</label><br>
                        <input type="text" name="nomor_rekeningedit" id="nomor_rekeningedit" class="form-control">
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $this->load->view('dist/_partials/footer'); ?>
<script>
    $('document').ready(function() {
        var table = $('#data-bank').DataTable();
        // insert bank
        var form = $('#form-bank');
        form.submit(function(ev) {
            ev.preventDefault();
            $.ajax({
                'type': form.attr('method'),
                'url': '<?= base_url('juragan/keuangan/tambahBank') ?>',
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
        // edit bank
        $('.edit').on("click", function() {
            var uid_rekening = $(this).attr('data-uid_rekening');
            $('#bankedit').modal('show');
            $.ajax({
                url: "<?= base_url('juragan/keuangan/getBank/') ?>" + uid_rekening,
                type: "GET",
                success: function(response) {
                    rekening = JSON.parse(response);
                    $('#uid_rekeningedit').val(rekening.uid_rekening);
                    $('#atas_namaedit').val(rekening.atas_nama);
                    $('#nama_bankedit').val(rekening.nama_bank);
                    $('#nomor_rekeningedit').val(rekening.nomor_rekening);
                }
            })
        })
        var form = $('#form-bankedit');
        form.submit(function(ev) {
            ev.preventDefault();
            $.ajax({
                'type': form.attr('method'),
                'url': '<?= base_url('juragan/keuangan/editBank') ?>',
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
    })
</script>