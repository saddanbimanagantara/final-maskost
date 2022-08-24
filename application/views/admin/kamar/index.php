<?php $this->load->view('dist/_partials/header') ?>

<div class="main-content">
    <section class="master-kamar">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Data kamar</h4>
                    </div>
                    <div class="add d-flex justify-content-end mr-4 mt-2">
                        <a href="<?= base_url('admin/kamar/master/add') ?>" class="btn btn-icon btn-primary"><span>Tambah kamar</span> <i class="fa-solid fa-square-plus"></i></a>
                    </div>
                    <div class="card-body">
                        <div>
                            <table class="table table-striped" id="data-kamar">
                                <thead>
                                    <tr>
                                        <th>
                                            #
                                        </th>
                                        <th>Nama kamar</th>
                                        <th>Status</th>
                                        <th>Gambar kamar</th>
                                        <th>Juragan</th>
                                        <th>Harga</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($kamar as $kamar) :
                                    ?>
                                        <tr>
                                            <td>
                                                <?= $i++ ?>
                                            </td>
                                            <td><?= $kamar['nama'] ?></td>
                                            <td>
                                                <?php
                                                if ($kamar['status'] == 0) {
                                                    echo '<span class="badge badge-success">Available</span>';
                                                } else if ($kamar['status'] == 1) {
                                                    echo '<span class="badge badge-danger">Sold</span>';
                                                } else if ($kamar['status'] == 3) {
                                                    echo '<span class="badge badge-warning">Pending payment</span>';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <img src="<?= base_url('public/images/kamar/') . $kamar['gambar_satu'] ?>" style="width: 100px;" class="rounded">
                                            </td>
                                            <td>
                                                <img alt="image" src="<?= base_url('assets/img/profile/juragan/') . $kamar['fotojuragan'] ?>" class="rounded-circle" width="35" data-toggle="tooltip" title="<?= $kamar['juragan'] ?>"> <span><?= $kamar['juragan'] ?></span>
                                            </td>
                                            <td>
                                                <div class="kamar-harga"><?= rupiah($kamar['harga']) ?></div>
                                            </td>

                                            <td>
                                                <a href="<?= base_url('admin/kamar/master/detail/') . $kamar['uid_kamar'] ?>" type="button" class="btn btn-icon btn-info"><i class="fas fa-info-circle"></i>
                                                </a>
                                                <button type="button" class="btn btn-icon btn-danger" id="hapus" onClick="hapus(this)" uid_kamar="<?= $kamar['uid_kamar'] ?>" uid_gambar="<?= $kamar['uid_gambar'] ?>">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php $this->load->view('dist/_partials/footer') ?>
<script>
    var table;
    $(document).ready(function() {
        table = $('#data-kamar').DataTable({
            responsive: true,
            autoWidth: false,
            columnDefs: [{
                targets: 0,
                width: "1%"
            }, {
                targets: 1,
                width: "23%"
            }, {
                targets: 2,
                width: "10%"
            }, {
                targets: 3,
                width: "13%"
            }, {
                targets: 4,
                width: "23%"
            }, {
                targets: 5,
                width: "15%"
            }, {
                targets: 6,
                width: "15%"
            }]
        });
    })

    function hapus(data) {
        var uid_kamar = $(data).attr('uid_kamar');
        var uid_gambar = $(data).attr('uid_gambar');
        console.log(uid_gambar + 'soku' + uid_kamar);
        swal({
                title: "Apakah anda yakin?",
                text: "ketika anda hapus, maka data tidak bisa dikembalikan!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: '<?= base_url('admin/kamar/master/delete') ?>',
                        type: 'POST',
                        dataType: 'JSON',
                        data: {
                            uid_kamar: uid_kamar,
                            uid_gambar: uid_gambar
                        },
                        success: function(response) {
                            console.log(response)
                            if (response['code'] === 200) {
                                swal(response['message'], {
                                    icon: response['status'],
                                });
                                location.reload()
                            } else {
                                swal(response['message'], {
                                    icon: response['status'],
                                });
                                location.reload()
                            }
                        }
                    })
                } else {
                    swal("Data tidak jadi dihapus!");
                }
            });

    }
</script>