<?php $this->load->view('dist/_partials/header') ?>
<div class="main-content">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Master data user administrator</h4>
                </div>
                <div class="card-body">
                    <div class="add d-flex justify-content-end mb-2">
                        <button class="btn btn-icon btn-primary" id="btn-tambah"><span>Tambah administrator</span></i></a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped" id="data-administrator">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Profile</th>
                                    <th>Email</th>
                                    <th>Username</th>
                                    <th>Nama</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <?php
                            $i = 1;
                            foreach ($administrator as $administrator) :
                            ?>
                                <tr>
                                    <td class="align-middle"><?= $i++ ?></td>
                                    <td class="align-middle">
                                        <figure class="avatar avatar-lg">
                                            <img src="<?= base_url('assets/img/profile/') . $administrator['image'] ?>">
                                        </figure>
                                    </td>
                                    <td class="align-middle"><?= $administrator['email'] ?></td>
                                    <td class="align-middle"><?= $administrator['username'] ?></td>
                                    <td class="align-middle"><?= $administrator['nama'] ?></td>
                                    <td class="align-middle"><?= $administrator['status'] ?></td>
                                    <td class="align-middle text-center">
                                        <button class="btn btn-icon btn-info mb-1" onclick="edit(this)" uid_user="<?= $administrator['uid_user'] ?>"><i class="far fa-edit"></i></button>
                                        <button class="btn btn-icon btn-danger mb-1" onclick="hapus(this)" uid_user="<?= $administrator['uid_user'] ?>"><i class="fas fa-times"></i></button>
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
            <form action="" method="post" id="form-data" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row d-flex align-items-end mb-1">
                        <div class="col-lg-8 col-sm-8 col-md-8">
                            <div class="form-gruop">
                                <label for="gambar">Profile image</label>
                                <input type="file" class="form-control" name="image" id="image">
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-4 col-md-4">
                            <figure class="avatar avatar-lg">
                                <input type="text" name="imageHidden" id="imageHidden" hidden>
                                <img id="imageAvatar">
                            </figure>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama">
                        <div class="invalid-feedback" id="invalid-nama">
                            Oh tidak! Nama wajib diisi.
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Email">Email</label>
                        <input type="text" class="form-control" id="uid_user" name="uid_user" hidden>
                        <input type="text" class="form-control" id="date_created" name="date_created" hidden>
                        <input type="email" class="form-control" id="email" name="email">
                        <div class="invalid-feedback" id="invalid-email">
                            Oh tidak! Email wajib diisi.
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Username">Username</label>
                        <input type="text" class="form-control" id="username" name="username">
                        <div class="invalid-feedback" id="invalid-username">
                            Oh tidak! username wajib diisi.
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="text" class="form-control" id="passwordHidden" name="passwordHidden" hidden>
                        <input type="password" class="form-control" id="password" name="password">
                        <div class="invalid-feedback" id="invalid-password">
                            Oh tidak! password wajib diisi.
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="icon_kategori">status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="aktif">Aktif</option>
                            <option value="tidak">Tidak aktif</option>
                        </select>
                        <div class="invalid-feedback">
                            Oh tidak! Status wajib dipilih.
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
        $('#data-administrator').DataTable();
        // send data
        $('#form-data').on('submit', function(e) {
            e.preventDefault();
            var url = $('#form-data').attr('action');
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'JSON',
                processData: false,
                contentType: false,
                cache: false,
                async: false,
                data: new FormData(this),
                success: function(response) {
                    console.log(response);
                    if (response['code'] === 500) {
                        const error = Object.entries(response['error']);
                        error.forEach(function(value, index) {
                            if (value[1] != 0) {
                                $('#' + value[0]).addClass('d-block');
                                $('#' + value[0]).html(value[1]);
                            } else {
                                $('#' + value[0]).removeClass('d-block');
                            }
                        });
                    } else {
                        swal({
                            title: response['status'],
                            text: response['message'],
                            icon: response['status']
                        }).then(function() {
                            window.location.reload();
                        });
                    }
                }
            })
        })


        $('#btn-tambah').on('click', function() {
            $('.modal-title').html('Tambah administrator');
            $('#form-data').attr('action', '<?= base_url('admin/user/administrator/addAdministrator') ?>');
            $('#imageAvatar').attr('src', '<?= base_url('assets/img/profile/default.jpg') ?>');
            showmodal();
        })

        // reset modal
        resetmodal();
        // upload and edit gambar
        gambar();
    })

    function edit(data) {
        var uid_user = $(data).attr('uid_user');
        $('.modal-title').html('Edit administrator');
        $('#form-data').attr('action', '<?= base_url('admin/user/administrator/editAdministrator') ?>');
        showmodal();
        $.ajax({
            url: '<?= base_url('admin/user/administrator/getAdministrator') ?>',
            type: 'POST',
            data: {
                uid_user: uid_user
            },
            dataType: 'JSON',
            success: function(response) {
                console.log(response);
                $('#uid_user').val(response.uid_user);
                $('#email').val(response.email);
                $('#username').val(response.username);
                $('#passwordHidden').val(response.password);
                $('#nama').val(response.nama);
                $('#imageAvatar').attr('src', '<?= base_url('assets/img/profile/') ?>' + response.image);
                $('#imageHidden').val(response.image);
                $('#date_created').val(response.date_created);
                $('#status').val(response.status);
            }
        })
    }

    function hapus(data) {
        var uid_user = $(data).attr('uid_user');
        $.ajax({
            url: '<?= base_url('admin/user/administrator/deleteAdministrator') ?>',
            type: 'POST',
            dataType: 'JSON',
            data: {
                uid_user: uid_user
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
            $('.invalid-feedback').removeClass('d-block');

        })
    }

    function showmodal() {
        $('#modal').modal({
            show: true
        });
    }

    function gambar() {
        image = document.getElementById('image');
        imageAvatar = document.getElementById('imageAvatar');
        image.onchange = evt => {
            const [file] = image.files;
            if (file) {
                imageAvatar.src = URL.createObjectURL(file);
            }
        }
    }
</script>