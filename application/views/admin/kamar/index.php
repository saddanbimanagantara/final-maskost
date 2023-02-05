<?php $this->load->view('dist/_partials/header') ?>

<div class="main-content">
    <section class="master-kamar">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Data kamar</h4>
                    </div>
                    <div class="card-body">
                        <div>
                            <table class="table table-striped" id="data-kamar">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Nama kamar</th>
                                        <th>Juragan</th>
                                        <th>Status</th>
                                        <th>Jumlah kamar</th>
                                        <th>Kamar Disewa</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($kamar as $kamar) :
                                    ?>
                                        <tr>
                                            <td class="align-middle"><?= $i++ ?></td>
                                            <td class="align-middle">
                                                <a href="<?= base_url('admin/kamar/master/detail/') . $kamar['uid_kamar'] ?>"><?= $kamar['nama'] ?></i>
                                                </a>

                                            </td>
                                            <td>
                                                <img alt="image" src="<?= base_url('assets/img/profile/juragan/') . $kamar['fotojuragan'] ?>" class="rounded-circle" width="35" data-toggle="tooltip" title="<?= $kamar['juragan'] ?>"> <span><?= $kamar['juragan'] ?></span>
                                            </td>
                                            <td class="align-middle">
                                                <?php
                                                if ($kamar['status'] == 'APPROVE') {
                                                    echo '<span class="badge badge-success">APPROVE</span>';
                                                } else if ($kamar['status'] == 'VALIDASI') {
                                                    echo '<span class="badge badge-warning">PROSES VALIDASI</span>';
                                                } else if ($kamar['status'] == 'DITOLAK') {
                                                    echo '<span class="badge badge-danger">DITOLAK</span>';
                                                }
                                                ?>
                                            </td>
                                            <td class="align-middle">
                                                <?= $kamar['jumlah_kamar'] ?> Kamar
                                            </td>
                                            <td class="align-middle">
                                                <?= $kamar['terjual'] ?> Kamar
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-icon btn-success" id="hapus" onClick="approve(this)" uid_kamar="<?= $kamar['uid_kamar'] ?>" uid_gambar="<?= $kamar['uid_gambar'] ?>">
                                                    <i class="fa-solid fa-thumbs-up"></i> Approve
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
        swal.fire({
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
                                swal.fire(response['message'], {
                                    icon: response['status'],
                                });
                                location.reload()
                            } else {
                                swal.fire(response['message'], {
                                    icon: response['status'],
                                });
                                location.reload()
                            }
                        }
                    })
                } else {
                    swal.fire("Data tidak jadi dihapus!");
                }
            });

    }
</script>