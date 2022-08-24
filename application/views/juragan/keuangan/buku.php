<?php $this->load->view('dist/_partials/header') ?>

<div class="main-content">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4>Buku Keuangan</h4>
                    <button class="btn btn-sm btn-primary" id="btn-tambah" data-toggle="modal" data-target="#tambah">Tambah Aktivitas Keuangan</button>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 col-sm-12">
                            <div class="card bg-success">
                                <div class="card-header">
                                    <h5>Total Saldo</h5>
                                </div>
                                <div class="card-body">
                                    <p><?= rupiah(($rekap['withdraw']['saldo_withdraw'] + $rekap['masuk']['nominal'])) ?></p>
                                    <small>keterangan:</small><br>
                                    <small>Withdrawal + Pemasukan Lokal</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="card bg-primary">
                                <div class="card-header">
                                    <h5>Saldo Withdrawal</h5>
                                </div>
                                <div class="card-body">
                                    <p><?= rupiah($rekap['withdraw']['saldo_withdraw']) ?></p>
                                    <small>Keterangan:</small><br>
                                    <small>Saldo Withdrawal</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="card bg-info">
                                <div class="card-header">
                                    <h5>Pemasukan lokal</h5>
                                </div>
                                <div class="card-body">
                                    <p><?= rupiah($rekap['masuk']['nominal']) ?></p>
                                    <small>Keterangan:</small><br>
                                    <small>Pemasukan Lokal</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="card bg-danger">
                                <div class="card-header">
                                    <h5>Pengeluaran</h5>
                                </div>
                                <div class="card-body">
                                    <p><?= rupiah($rekap['keluar']['nominal']) ?></p>
                                    <small>Keterangan:</small><br>
                                    <small>Pengeluaran Lokal</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p>Buku keuangan ini berfungsi sebagai buku keuangan pemilik kost dalam mengelola keuangan yang sudah dicairkan dari website. Digunakan untuk pencatatan pengeluaran operasional atau teknikal perawatan kost masing masing.</p>
                    <span>contoh: pencatatan pembayaran wifi, listrik, sampah dll.</span>
                    <hr>
                    <h6>Data Buku</h6>
                    <table class="table table-striped" id="buku-keuangan">
                        <thead>
                            <th class="align-center">#</th>
                            <th>Nominal</th>
                            <th>Keterangan</th>
                            <th>Deskripsi</th>
                            <th>Tanggal</th>
                            <th class="text-center">Aksi</th>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($buku as $buku) :
                            ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= rupiah($buku['nominal']) ?></td>
                                    <td><?= ($buku['keterangan'] === 'in') ? '<button class="btn btn-sm btn-primary">Masuk</button>' : '<button class="btn btn-sm btn-danger">Keluar</button>'  ?></td>
                                    <td><?= $buku['deskripsi'] ?></td>
                                    <td><?= $buku['date'] ?></td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-info" id="btn-edit" data-uid="<?= $buku['uid_buku_keuangan'] ?>"><i class="fa-solid fa-pen-to-square" data-toggle="modal" data-target="#edit"></i></button>
                                        <button class="btn btn-sm btn-danger"><i class="fa-solid fa-trash-can"></i></button>
                                    </td>
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
<div class="modal fade" tabindex="-1" role="dialog" id="tambah">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Buku Keuangan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="form-tambah" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nominal">Nominal</label>
                        <input type="text" name="uid_member" id="uid_member" value="<?= $uid_member ?>" hidden>
                        <input type="text" class="form-control" name="nominal" id="nonimal">
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Keterangan</label>
                        <select class="form-control" name="keterangan" id="keterangan">
                            <option value="in">Masuk</option>
                            <option value="in">Keluar</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <input type="text" class="form-control" name="deskripsi" id="deskripsi">
                    </div>
                    <div class="form-group">
                        <label for="date">Tanggal</label>
                        <input type="datetime-local" name="date" id="date" class="form-control">
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
<!-- modal edit -->
<div class="modal fade" tabindex="-1" role="dialog" id="edit">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data Buku Keuangan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="form-editt" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nominal">Nominal</label>
                        <input type="text" name="uidEdit" id="uidEdit" hidden>
                        <input type="text" name="uid_memberEdit" id="uid_memberEdit" hidden>
                        <input type="text" class="form-control" name="nominalEdit" id="nominalEdit">
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Keterangan</label>
                        <select class="form-control" name="keterangan" id="keterangan">
                            <option value="in">Masuk</option>
                            <option value="in">Keluar</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <input type="text" class="form-control" name="deskripsiEdit" id="deskripsiEdit">
                    </div>
                    <div class="form-group">
                        <label for="date">Tanggal</label>
                        <input type="datetime-local" name="dateEdit" id="dateEdit" class="form-control">
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
        $('#buku-keuangan').DataTable();
        var formTambah = $('#form-tambah');
        formTambah.submit(function(env) {
            env.preventDefault();
            $.ajax({
                'type': formTambah.attr('method'),
                'url': '<?= base_url('juragan/keuangan/bukuTambah') ?>',
                'data': formTambah.serialize(),
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
        $('#btn-edit').click(function() {
            $('#edit').modal('show');
            var uid = $(this).data('uid');
            $.ajax({
                'url': '<?= base_url('juragan/keuangan/getBuku') ?>',
                'type': 'GET',
                'dataType': 'JSON',
                'data': {
                    uid_buku_keuangan: uid
                },
                'success': function(data) {
                    console.log(data);
                    $('#nominalEdit').val(data[0].nominal);
                    $('#keteranganEdit').val(data[0].keterangan);
                    $('#deskripsiEdit').val(data[0].deskripsi);
                    $('#dateEdit').val(data[0].date);
                    $('#uidEdit').val(data[0].uid_buku_keuangan);
                    $('#uid_memberEdit').val(data[0].uid_member);
                }
            })
        });
    })
</script>