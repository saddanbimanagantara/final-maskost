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
                    <form action="<?= base_url('juragan/keuangan/buku') ?>" method="post" id="filter">
                        <select name="tahun" id="tahun" class="form-control tahun" style="width: 25%;">
                            <option value="<?= $filter ?>" selected><?= ($filter == "") ? "pilih tahun" : $filter ?></option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                            <option value="2025">2024</option>
                            <option value="2026">2023</option>
                            <option value="2027">2027</option>
                        </select>
                    </form>
                    <canvas id="chart" class="chart"></canvas>
                    <hr>
                    <h6>Data Buku</h6>
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="form-group" style="width: 25%;">
                            <label>Filter Tanggal:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="far fa-calendar-alt"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control float-right" id="filterdate" name="filterdate" width="400px">
                            </div>
                            <button class="btn btn-sm btn-danger mt-2 btn-reset" id="btn-reset-filter"><i class="fas fa-filter text-light mr-1"></i><span>reset filter</span></button>
                        </div>
                        <div class="actionSelect form-group">
                            <select class="form-control" id="exportLink">
                                <option>Export Data</option>
                                <option id="excel">Export as XLS</option>
                                <option id="pdf">Export as PDF</option>
                            </select>
                        </div>
                    </div>
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
                                        <button class="btn btn-sm btn-info btn-edit" id="btn-edit" data-uid="<?= $buku['uid_buku_keuangan'] ?>"><i class="fa-solid fa-pen-to-square" data-toggle="modal" data-target="#edit"></i></button>
                                        <button class="btn btn-sm btn-danger btn-hapus" data-uid="<?= $buku['uid_buku_keuangan'] ?>"><i class="fa-solid fa-trash-can"></i></button>
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
                        <input type="text" class="form-control" name="nominal" id="nonimal" required>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Keterangan</label>
                        <select class="form-control" name="keterangan" id="keterangan" required>
                            <option value="in">Masuk</option>
                            <option value="in">Keluar</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <input type="text" class="form-control" name="deskripsi" id="deskripsi" required>
                    </div>
                    <div class="form-group">
                        <label for="date">Tanggal</label>
                        <input type="datetime-local" name="date" id="date" class="form-control" required>
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
            <form action="#" id="form-edit" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nominal">Nominal</label>
                        <input type="text" name="uidEdit" id="uidEdit" hidden>
                        <input type="text" name="uid_memberEdit" id="uid_memberEdit" hidden>
                        <input type="text" class="form-control" name="nominalEdit" id="nominalEdit" required>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Keterangan</label>
                        <select class="form-control" name="keteranganEdit" id="keteranganEdit" required>
                            <option value="in">Masuk</option>
                            <option value="out">Keluar</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <input type="text" class="form-control" name="deskripsiEdit" id="deskripsiEdit" required>
                    </div>
                    <div class="form-group">
                        <label for="date">Tanggal</label>
                        <input type="datetime-local" name="dateEdit" id="dateEdit" class="form-control" step="any" required>
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

<?php $this->load->view('dist/_partials/footer') ?>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.1/css/buttons.dataTables.min.css">
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.flash.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script script src="<?php echo base_url(); ?>assets/modules/bootstrap-daterangepicker/daterangepicker.js"></script>
<script>
    var start_date;
    var end_date;
    var DateFilterFunction = (function(oSettings, aData, iDataIndex) {
        var dateStart = start_date;
        var dateEnd = end_date;
        var createdAt = aData[4] || 4
        var createdAt = formatDate(createdAt)
        if (
            (dateStart === null && dateEnd === null) ||
            (dateStart === null && createdAt <= dateEnd) ||
            (dateStart <= createdAt && dateEnd === null) ||
            (dateStart <= createdAt && createdAt <= dateEnd)
        ) {
            return true
        }
        return false;
    });
    $(document).ready(function() {
        $('#filterdate').daterangepicker();
        $('#filterdate').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
            start_date = picker.startDate.format('YYYY-MM-DD');
            end_date = picker.endDate.format('YYYY-MM-DD');
            $.fn.dataTableExt.afnFiltering.push(DateFilterFunction);
            table.draw();
        });

        $('#filterdate').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            start_date = null;
            end_date = null;
            $.fn.dataTable.ext.search.splice($.fn.dataTable.ext.search.indexOf(DateFilterFunction, 1));
            table.draw();
        });

        $('.btn-reset').click(function() {
            $(this).val('');
            start_date = null;
            end_date = null;
            $.fn.dataTable.ext.search.splice($.fn.dataTable.ext.search.indexOf(DateFilterFunction, 1));
            table.draw();
        })

        var table = $('#buku-keuangan').DataTable({
            initComplete: function() {
                var $buttons = $('.dt-buttons').hide();
                $('#exportLink').on('change', function() {
                    var btnClass = $(this).find(":selected")[0].id ?
                        '.buttons-' + $(this).find(":selected")[0].id :
                        null;
                    if (btnClass) $buttons.find(btnClass).click();
                })
            },
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'excel',
                    exportOptions: {
                        columns: 'th:not(:last-child)'
                    },
                    messageTop: function(xlsx) {
                        var min = $('#min').val();
                        var max = $('#max').val();
                        return `Aktivitas keuangan ${min} - ${max}`;
                    }
                },
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: 'th:not(:last-child)'
                    },
                    messageTop: function(xlsx) {
                        var min = $('#min').val();
                        var max = $('#max').val();
                        return `Aktivitas keuangan ${min} - ${max}`;
                    }
                }
            ]
        });

        $('.tahun').change(function() {
            const form = document.getElementById('filter');
            form.submit();
        })

        $('.btn-edit').click(function() {
            $('#edit').modal('show');
            var uid = $(this).data('uid');
            console.log(uid);
            $.ajax({
                'url': '<?= base_url('juragan/keuangan/getBuku') ?>',
                'type': 'POST',
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
        $('.btn-hapus').click(function() {
            var uid = $(this).data('uid');
            $.ajax({
                'url': '<?= base_url('juragan/keuangan/bukuHapus') ?>',
                'type': 'POST',
                'dataType': 'JSON',
                'data': {
                    uid_buku_keuangan: uid
                },
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
        });

        var formTambah = $('#form-edit');
        formTambah.submit(function(env) {
            env.preventDefault();
            $.ajax({
                'type': formTambah.attr('method'),
                'url': '<?= base_url('juragan/keuangan/bukuEdit') ?>',
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

        var ctx = document.getElementById("chart").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "Oktober", "November", "Desember"],
                datasets: [{
                        label: 'Uang Masuk Rp',
                        data: [
                            <?= $chart['januari']['saldo_masuk'] ?>,
                            <?= $chart['februari']['saldo_masuk'] ?>,
                            <?= $chart['maret']['saldo_masuk'] ?>,
                            <?= $chart['april']['saldo_masuk'] ?>,
                            <?= $chart['mei']['saldo_masuk'] ?>,
                            <?= $chart['juni']['saldo_masuk'] ?>,
                            <?= $chart['juli']['saldo_masuk'] ?>,
                            <?= $chart['agustus']['saldo_masuk'] ?>
                            <?= $chart['september']['saldo_masuk'] ?>
                            <?= $chart['oktober']['saldo_masuk'] ?>
                            <?= $chart['november']['saldo_masuk'] ?>
                            <?= $chart['desember']['saldo_masuk'] ?>
                        ],
                        borderWidth: 2,
                        backgroundColor: 'rgba(99,237,112,.9)',
                        borderWidth: 0,
                        borderColor: 'transparent',
                        pointBorderWidth: 0,
                        pointRadius: 3.5,
                        pointBackgroundColor: 'transparent',
                        pointHoverBackgroundColor: 'rgba(99,237,112,.9)',
                    },
                    {
                        label: 'Uang Keluar Rp',
                        data: [
                            <?= $chart['januari']['saldo_withdraw'] ?>,
                            <?= $chart['februari']['saldo_withdraw'] ?>,
                            <?= $chart['maret']['saldo_withdraw'] ?>,
                            <?= $chart['april']['saldo_withdraw'] ?>,
                            <?= $chart['mei']['saldo_withdraw'] ?>,
                            <?= $chart['juni']['saldo_withdraw'] ?>,
                            <?= $chart['juli']['saldo_withdraw'] ?>,
                            <?= $chart['agustus']['saldo_withdraw'] ?>
                            <?= $chart['september']['saldo_withdraw'] ?>
                            <?= $chart['oktober']['saldo_withdraw'] ?>
                            <?= $chart['november']['saldo_withdraw'] ?>
                            <?= $chart['desember']['saldo_withdraw'] ?>
                        ],
                        borderWidth: 2,
                        backgroundColor: 'rgba(103,119,239,.9)',
                        borderWidth: 0,
                        borderColor: 'transparent',
                        pointBorderWidth: 0,
                        pointRadius: 3.5,
                        pointBackgroundColor: 'transparent',
                        pointHoverBackgroundColor: 'rgba(103,119,239,.9)',
                    }
                ]
            },
            options: {
                legend: {
                    display: true
                },
                scales: {
                    yAxes: [{
                        gridLines: {
                            // display: false,
                            drawBorder: false,
                            color: '#f2f2f2',
                        },
                        ticks: {
                            beginAtZero: true,
                        }
                    }],
                    xAxes: [{
                        ticks: {
                            display: true
                        },
                        gridLines: {
                            display: false
                        }
                    }]
                },
            }
        });
    })

    var formTambah = $('#form-tambah');
    formTambah.submit(function(env) {
        env.preventDefault();
        console.log(env)
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

    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2)
            month = '0' + month;
        if (day.length < 2)
            day = '0' + day;

        return [year, month, day].join('-');
    }
</script>