<?php $this->load->view('dist/_partials/header') ?>
<div class="main-content">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Master data user member <?= $otoritas ?></h4>
                </div>
                <div class="card-body">
                    <div class="add d-flex justify-content-end mb-2">
                        <button class="btn btn-icon btn-primary" id="btn-tambah"><span>Tambah <?= $otoritas ?></span></i></a>
                    </div>
                    <div class="">
                        <table class="table table-striped table-bordered nowrap" style="width:100%" id="data-member">
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
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($member as $member) :
                                ?>
                                    <tr>
                                        <td class="align-middle"><?= $i++ ?></td>
                                        <td class="align-middle">
                                            <figure class="avatar avatar-lg">
                                                <?php
                                                $imgsrc = '';
                                                ($otoritas === "admin") ? $imgsrc = base_url('assets/img/profile/admin/') . $member['image'] : $imgsrc = base_url('assets/img/profile/') . $otoritas . '/' . $member['image']
                                                ?>
                                                <img src="<?= $imgsrc ?>">
                                            </figure>
                                        </td>
                                        <td class="align-middle"><?= $member['email'] ?></td>
                                        <td class="align-middle"><?= $member['username'] ?></td>
                                        <td class="align-middle"><?= $member['fnama'] . ' ' . $member['lnama'] ?></td>
                                        <td class="align-middle">
                                            <?php
                                            echo ($member['status'] === "aktif") ? '<span class="badge badge-primary">Aktif</span>' : '<span class="badge badge-warning">Tidak aktif</span>';
                                            ?>
                                        </td>
                                        <td class="align-middle text-center">
                                            <button class="btn btn-icon btn-info mb-1" onclick="edit(this)" uid_member="<?= $member['uid_member'] ?>"><i class="far fa-edit"></i></button>
                                            <button class="btn btn-icon btn-danger mb-1" onclick="hapus(this)" uid_member="<?= $member['uid_member'] ?>"><i class="fas fa-times"></i></button>
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
</div>
<!-- modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Juragan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post" id="form-data" enctype="multipart/form-data" class="needs-validation">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Profile image</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text" style="border: none;">
                                    <figure class="avatar avatar-md">
                                        <input type="text" name="imageHidden" id="imageHidden" hidden>
                                        <img id="imageAvatar">
                                    </figure>
                                </div>
                            </div>
                            <input type="file" class="form-control image" name="image" id="image">
                            <div class="invalid-feedback" id="invalid-image">
                                Oh tidak! Nama wajib diisi.
                            </div>
                        </div>
                    </div>
                    <div class="hidden-section">
                        <input type="text" class="form-control" id="action" name="action" hidden>
                        <input type="text" class="form-control" id="uid_member" name="uid_member" hidden>
                        <input type="text" class="form-control" id="date_created" name="date_created" hidden>
                        <input type="text" class="form-control" id="passwordHidden" name="passwordHidden" hidden>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm 12">
                            <div class="form-group">
                                <label for="Nama">Nama depan</label>
                                <input type="text" class="form-control" id="fnama" name="fnama">
                                <div class="invalid-feedback" id="invalid-fnama">
                                    Oh tidak! Nama wajib diisi.
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm 12">
                            <div class="form-group">
                                <label for="Nama">Nama akhir</label>
                                <input type="text" class="form-control" id="lnama" name="lnama">
                                <div class="invalid-feedback" id="invalid-lnama">
                                    Oh tidak! Nama wajib diisi.
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm 12"></div>
                        <div class="col-lg-6 col-md-6 col-sm 12"></div>
                    </div>
                    <div class="form-group">
                        <label for="Email">Email</label>
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
                        <input type="password" class="form-control" id="password" name="password">
                        <div class="invalid-feedback" id="invalid-password">
                            Oh tidak! password wajib diisi.
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea name="alamat" id="alamat" class="form-control" rows="5"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm 12">
                            <div class="form-group">
                                <label for="jenis_kelamin">Jenis kelamin</label>
                                <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm 12">
                            <div class="form-group">
                                <label for="no_hp">No ponsel</label>
                                <input type="text" name="no_hp" id="no_hp" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm 12">
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
                        <div class="col-lg-6 col-md-6 col-sm 12">
                            <div class="form-group">
                                <label for="otoritas">Otoritas</label>
                                <input type="text" class="form-control" id="otoritas" name="otoritas" disabled>
                            </div>
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
        var table = $('#data-member').DataTable({
            responsive: true,
            autoWidth: false,
            columnDefs: [{
                responsivePriority: 2,
                targets: 4
            }, {
                responsivePriority: 2,
                targets: -1
            }]
        })
        new $.fn.dataTable.FixedHeader(table);
        // send data
        $('#form-data').on('submit', function(e) {
            e.preventDefault();
            var url = $('#form-data').attr('action');
            const datas = new FormData(this);
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
            $('.modal-title').html('Tambah member');
            $('#form-data').attr('action', '<?= base_url('admin/user/member/add/') . $otoritas ?>');
            $('#imageAvatar').attr('src', '<?= base_url('assets/img/profile/default.jpg') ?>');
            $('#action').val('add');
            $('#otoritas').val('<?= $otoritas ?>');
            showmodal();
        })


        // reset modal
        resetmodal();
        // upload and edit gambar
        gambar();
    })

    function edit(data) {
        var uid_member = $(data).attr('uid_member');
        $('.modal-title').html('Edit member');
        $('#form-data').attr('action', '<?= base_url('admin/user/member/edit/') . $otoritas ?>');
        $('#action').val('edit');
        $('#otoritas').val('<?= $otoritas ?>');
        $('#saldo').attr('disabled', false);
        $('#saldo_released').attr('disabled', false);
        showmodal();
        $.ajax({
            url: '<?= base_url('admin/user/member/getmember/') . $otoritas  ?>',
            type: 'POST',
            data: {
                uid_member: uid_member
            },
            dataType: 'JSON',
            success: function(response) {
                console.log(response);
                $('#uid_member').val(response.uid_member);
                $('#email').val(response.email);
                $('#username').val(response.username);
                $('#passwordHidden').val(response.password);
                $('#fnama').val(response.fnama);
                $('#lnama').val(response.lnama);
                $('#otoritas').val(response.otoritas);
                $('#alamat').val(response.alamat);
                $('#jenis_kelamin').val(response.jenis_kelamin);
                $('#no_hp').val(response.no_hp);
                $('#status').val(response.status);
                <?php
                $imgsrc = '';
                ($otoritas === "admin") ? $imgsrc = base_url('assets/img/profile/admin/') : $imgsrc = base_url('assets/img/profile/') . $otoritas . '/';
                ?>
                $('#imageAvatar').attr('src', '<?= $imgsrc ?>' + response.image);
                $('#imageHidden').val(response.image);
                $('#date_created').val(response.date_created);
            }
        })
    }

    function hapus(data) {
        var uid_member = $(data).attr('uid_member');
        $.ajax({
            url: '<?= base_url('admin/user/member/delete/') . $otoritas ?>',
            type: 'POST',
            dataType: 'JSON',
            data: {
                uid_member: uid_member
            },
            success: function(response) {
                if (response['code'] === 200) {
                    swal(`${response['message']}`, {
                        icon: `${response['status']}`,
                    }).then(function() {
                        window.location.reload();
                    });
                } else {
                    swal(`${response['message']}`, {
                        icon: `${response['status']}`,
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