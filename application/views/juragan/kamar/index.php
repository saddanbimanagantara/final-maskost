<?php $this->load->view('dist/_partials/header') ?>

<div class="main-content">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Data kamar</h4>
                </div>
                <div class="add d-flex justify-content-end mr-4 mt-2">
                    <a href="<?= base_url('juragan/kamar/add') ?>" class="btn btn-icon btn-primary"><span>Tambah kamar</span> <i class="fa-solid fa-square-plus"></i></a>
                </div>
                <div class="card-body">
                    <table class="table table-stripped" id="data-kamar">
                        <thead>
                            <th class="text-center">#</th>
                            <th>Nama kamar</th>
                            <th>Status</th>
                            <th>Gambar kamar</th>
                            <th>Jumlah kamar</th>
                            <th>Kamar Disewa</th>
                            <th>Harga</th>
                            <th>Diskon</th>
                            <th>Aksi</th>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($kamar as $kamar) :
                            ?>
                                <tr>
                                    <td class="align-middle"><?= $i++ ?></td>
                                    <td class="align-middle"><?= $kamar['nama'] ?></td>
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
                                        <img src="<?= base_url('public/images/kamar/') . $kamar['gambar_satu'] ?>" style="width: 100px;" class="rounded">
                                    </td>
                                    <td class="align-middle">
                                        <?= $kamar['jumlah_kamar'] ?> Kamar
                                    </td>
                                    <td class="align-middle">
                                        <?= $kamar['terjual'] ?> Kamar
                                    </td>
                                    <td class="align-middle">
                                        <?php
                                        $diskon = ($kamar['diskon'] / 100) * $kamar['harga'];
                                        echo rupiah($kamar['harga'] - $diskon);
                                        ?>
                                        <br>
                                        <small>diskon <?= $kamar['diskon'] ?>%</small>
                                    </td>
                                    <td class="align-middle"><?= $kamar['diskon'] ?>%</td>
                                    <td class="align-middle">
                                        <a href="<?= base_url('juragan/kamar/detail/') . $kamar['uid_kamar'] ?>" class="btn btn-icon btn-info"><i class="fa-solid fa-circle-info"></i></a>
                                        <button class="btn btn-icon btn-danger" onclick="hapus(this)" uid_kamar="<?= $kamar['uid_kamar'] ?>" uid_gambar="<?= $kamar['uid_gambar'] ?>"><i class="fas fa-times"></i></button>
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

<?php $this->load->view('dist/_partials/footer') ?>
<script>
    $(document).ready(function() {
        $('#data-kamar').DataTable({
            responsive: true,
            autoWidth: false
        });
    })

    function hapus(data) {
        console.log(data);
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
                        url: '<?= base_url('juragan/kamar/delete') ?>',
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
                                }).then(() => {
                                    location.reload()
                                });
                            } else {
                                swal(response['message'], {
                                    icon: response['status'],
                                }).then(() => {
                                    location.reload()
                                });
                            }
                        }
                    })
                } else {
                    swal("Data tidak jadi dihapus!");
                }
            });

    }
</script>