<?php $this->load->view('dist/_partials/header'); ?>
<div class="main-content">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Master data kategori kamar</h4>
                </div>
                <div class="card-body">
                    <div class="add d-flex justify-content-end mb-2">
                        <button class="btn btn-icon btn-primary" id="btn-tambah"><span>Tambah kategori</span></i></a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped" id="data-kategori">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Nama kategori</th>
                                    <th>Icon kategori</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <?php
                            $i = 1;
                            foreach ($kategori as $kategori) :
                            ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= $kategori['nama_kategori'] ?></td>
                                    <td><?= $kategori['icon_kategori'] ?></td>
                                    <td class="text-center">
                                        <button class="btn btn-icon btn-info mb-1" onclick="edit(this)" uid_kategori="<?= $kategori['uid_kategori'] ?>"><i class="far fa-edit"></i></button>
                                        <button class="btn btn-icon btn-danger mb-1" onclick="hapus(this)" uid_kategori="<?= $kategori['uid_kategori'] ?>"><i class="fas fa-times"></i></button>
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
                        <label for="nama_kategori">Nama kategori</label>
                        <input type="text" class="form-control" id="uid_kategori" name="uid_kategori" hidden>
                        <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" required="">
                        <div class="invalid-feedback">
                            Oh tidak! Nama kategori wajib diisi.
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="icon_kategori">Icon kategori</label>
                        <input type="text" class="form-control" id="icon_kategori" name="icon_kategori" required="">
                        <div class="invalid-feedback">
                            Oh tidak! Icon kategori wajib diisi.
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
<?php $this->load->view('dist/_partials/footer'); ?>
<script>
    $(document).ready(function() {
        <?php if (isset($_SESSION['response']) && $_SESSION['response'] !== '') : ?>
            swal({
                title: "<?php echo $_SESSION['response']['status']; ?>",
                text: "<?php echo $_SESSION['response']['message']; ?>",
                icon: "<?php echo $_SESSION['response']['status']; ?>"
            });
        <?php endif; ?>
        $('#data-kategori').DataTable();
        $('#btn-tambah').on('click', function() {
            $('.modal-title').html('Tambah kategori');
            $('#form-data').attr('action', '<?= base_url('admin/kamar/kategori/addKategori') ?>');
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
        var uid_kategori = $(data).attr('uid_kategori');
        $('.modal-title').html('Edit kategori');
        $('#form-data').attr('action', '<?= base_url('admin/kamar/kategori/editKategori') ?>');
        showmodal();
        $.ajax({
            url: '<?= base_url('admin/kamar/kategori/getKategori/') ?>',
            type: 'POST',
            data: {
                uid_kategori: uid_kategori
            },
            dataType: 'JSON',
            success: function(response) {
                $('#uid_kategori').val(response.uid_kategori);
                $('#nama_kategori').val(response.nama_kategori);
                $('#icon_kategori').val(response.icon_kategori);
            }
        })
    }

    function hapus(data) {
        var uid_kategori = $(data).attr('uid_kategori');
        $.ajax({
            url: '<?= base_url('admin/kamar/kategori/deleteKategori') ?>',
            type: 'POST',
            dataType: 'JSON',
            data: {
                uid_kategori: uid_kategori
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