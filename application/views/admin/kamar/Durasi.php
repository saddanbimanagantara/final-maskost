<?php $this->load->view('dist/_partials/header') ?>

<div class="main-content">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Master data durasi kamar</h4>
                </div>
                <div class="card-body">
                    <div class="add d-flex justify-content-end mb-2">
                        <button class="btn btn-icon btn-primary" id="btn-tambah"><span>Tambah durasi</span></i></a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped" id="data-durasi">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>durasi</th>
                                    <th>Nama durasi</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <?php
                            $i = 1;
                            foreach ($durasi as $durasi) :
                            ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= $durasi['durasi'] ?></td>
                                    <td><?= $durasi['nama'] ?></td>
                                    <td class="text-center">
                                        <button class="btn btn-icon btn-info mb-1" onclick="edit(this)" uid_durasi="<?= $durasi['uid_durasi'] ?>"><i class="far fa-edit"></i></button>
                                        <button class="btn btn-icon btn-danger mb-1" onclick="hapus(this)" uid_durasi="<?= $durasi['uid_durasi'] ?>"><i class="fas fa-times"></i></button>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit kategroi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post" id="form-data" class="needs-validation" novalidate="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama">Durasi</label>
                        <input type="text" class="form-control" id="uid_durasi" name="uid_durasi" hidden>
                        <input type="number" class="form-control" id="durasi" name="durasi" required="">
                        <div class="invalid-feedback">
                            Oh tidak! Durasi wajib diisi.
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama durasi</label>
                        <input type="text" class="form-control" id="nama" name="nama" required="">
                        <div class="invalid-feedback">
                            Oh tidak! Nama durasi wajib diisi.
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btn-simpan">Simpan perubahan</button>
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
        $('#data-durasi').DataTable();
        $('#btn-tambah').on('click', function() {
            $('.modal-title').html('Tambah durasi');
            $('#form-data').attr('action', '<?= base_url('admin/kamar/durasi/addDurasi') ?>');
            showmodal();
        })

        $(".needs-validation").submit(function() {
            var form = $(this);
            if (form[0].checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.addClass('was-validated');
        });

        // reset modal
        resetmodal();
    })

    function edit(data) {
        var uid_durasi = $(data).attr('uid_durasi');
        $('.modal-title').html('Edit durasi');
        $('#form-data').attr('action', '<?= base_url('admin/kamar/durasi/editDurasi') ?>');
        showmodal();
        $.ajax({
            url: '<?= base_url('admin/kamar/durasi/getDurasi/') ?>',
            type: 'POST',
            data: {
                uid_durasi: uid_durasi
            },
            dataType: 'JSON',
            success: function(response) {
                $('#uid_durasi').val(response.uid_durasi);
                $('#durasi').val(response.durasi);
                $('#nama').val(response.nama);
            }
        })
    }

    function hapus(data) {
        var uid_durasi = $(data).attr('uid_durasi');
        $.ajax({
            url: '<?= base_url('admin/kamar/durasi/deleteDurasi') ?>',
            type: 'POST',
            dataType: 'JSON',
            data: {
                uid_durasi: uid_durasi
            },
            success: function(response) {
                if (response['code'] === 200) {
                    swal(response['message'], {
                        icon: response['status'],
                    }).then(function() {
                        window.location.reload();
                    });
                } else {
                    swal(response['message'], {
                        icon: response['status'],
                    }).then(function() {
                        window.location.reload();
                    });
                }
            }
        })
    }

    function resetmodal() {
        $('#modal').on('hidden.bs.modal', function(e) {
            $(this)
                .find("input,textarea,select")
                .val('')
                .end()
                .find("input[type=checkbox], input[type=radio]")
                .prop("checked", "")
                .end();
        })
    }

    function showmodal() {
        $('#modal').modal({
            show: true
        });
    }
</script>