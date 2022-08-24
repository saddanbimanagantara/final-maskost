<?php $this->load->view('dist/_partials/header') ?>

<div class="main-content">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Master data fasilitas kamar</h4>
                </div>
                <div class="card-body">
                    <div class="add d-flex justify-content-end mb-2">
                        <button class="btn btn-icon btn-primary" id="btn-tambah"><span>Tambah fasilitas</span></i></a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped" id="data-fasilitas">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Nama fasilitas</th>
                                    <th>Icon fasilitas</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <?php
                            $i = 1;
                            foreach ($fasilitas as $fasilitas) :
                            ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= $fasilitas['nama'] ?></td>
                                    <td><?= $fasilitas['icon'] ?></td>
                                    <td class="text-center">
                                        <button class="btn btn-icon btn-info mb-1" onclick="edit(this)" uid_fasilitas="<?= $fasilitas['uid_fasilitas'] ?>"><i class="far fa-edit"></i></button>
                                        <button class="btn btn-icon btn-danger mb-1" onclick="hapus(this)" uid_fasilitas="<?= $fasilitas['uid_fasilitas'] ?>"><i class="fas fa-times"></i></button>
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
                        <label for="nama">Nama fasilitas</label>
                        <input type="text" class="form-control" id="uid_fasilitas" name="uid_fasilitas" hidden>
                        <input type="text" class="form-control" id="nama" name="nama" required="">
                        <div class="invalid-feedback">
                            Oh tidak! Nama fasilitas wajib diisi.
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="icon_fasilitas">Icon fasilitas</label>
                        <input type="text" class="form-control" id="icon" name="icon" required="">
                        <div class="invalid-feedback">
                            Oh tidak! Icon fasilitas wajib diisi.
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
        $('#data-fasilitas').DataTable();
        $('#btn-tambah').on('click', function() {
            $('.modal-title').html('Tambah fasilitas');
            $('#form-data').attr('action', '<?= base_url('admin/kamar/fasilitas/addFasilitas') ?>');
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
        var uid_fasilitas = $(data).attr('uid_fasilitas');
        $('.modal-title').html('Edit fasilitas');
        $('#form-data').attr('action', '<?= base_url('admin/kamar/fasilitas/editFasilitas') ?>');
        showmodal();
        $.ajax({
            url: '<?= base_url('admin/kamar/fasilitas/getFasilitas/') ?>',
            type: 'POST',
            data: {
                uid_fasilitas: uid_fasilitas
            },
            dataType: 'JSON',
            success: function(response) {
                $('#uid_fasilitas').val(response.uid_fasilitas);
                $('#nama').val(response.nama);
                $('#icon').val(response.icon);
            }
        })
    }

    function hapus(data) {
        var uid_fasilitas = $(data).attr('uid_fasilitas');
        $.ajax({
            url: '<?= base_url('admin/kamar/fasilitas/deleteFasilitas') ?>',
            type: 'POST',
            dataType: 'JSON',
            data: {
                uid_fasilitas: uid_fasilitas
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