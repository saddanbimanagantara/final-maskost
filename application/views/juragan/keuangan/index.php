<?php $this->load->view('dist/_partials/header'); ?>

<div class="main-content">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Rekap Keuangan</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <div class="pricing">
                                <div class="pricing-title bg-success text-white">
                                    Saldo Masuk
                                </div>
                                <div class="pricing-padding">
                                    <div class="pricing-price">
                                        <h5><?= rupiah($rekap['saldo_masuk_settlement']['saldo_masuk']) ?></h5>
                                    </div>
                                    <span>Pending <?= rupiah($rekap['saldo_masuk_pending']['saldo_masuk']) ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="pricing">
                                <div class="pricing-title bg-primary text-white">
                                    Saldo DiTarik
                                </div>
                                <div class="pricing-padding">
                                    <div class="pricing-price">
                                        <h5><?= rupiah($rekap['saldo_withdraw_settlement']['saldo_withdraw']) ?></h5>
                                    </div>
                                    <span>Pending <?= rupiah($rekap['saldo_withdraw_pending']['saldo_withdraw']) ?> </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="pricing">
                                <div class="pricing-title bg-danger text-white">
                                    Sisa Saldo
                                </div>
                                <div class="pricing-padding">
                                    <div class="pricing-price">
                                        <h5><?= rupiah($rekap['saldo_masuk_settlement']['saldo_masuk'] - $rekap['saldo_withdraw_settlement']['saldo_withdraw']) ?></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm 12">
            <div class="card">
                <div class="card-header">
                    <h4>Chart Keuangan</h4>
                    <form action="<?= base_url('juragan/keuangan/index') ?>" method="post" id="filter">
                        <select name="tahun" id="tahun" class="form-control tahun">
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
                </div>
                <div class="card-body">
                    <canvas id="chartKeuangan"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4>Aktivitas Keuangan</h4>
                    <button class="btn btn-sm btn-primary" id="btn-pengeluaran" data-toggle="modal" data-target="#pengeluaran">Tarik Uang</button>
                </div>
                <div class="card-body">
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
                    <table class="table table-striped" id="aktivitas-keuangan">
                        <thead>
                            <th class="text-center">#</th>
                            <th>Tanggal Aktivitas</th>
                            <th>Nominal</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($aktivitas as $aktivitas) :
                            ?>
                                <tr>
                                    <td class="align-middle"><?= $i++ ?></td>
                                    <td class="align-middle"><?= $aktivitas['date_updated'] ?></td>
                                    <?php
                                    if ($aktivitas['saldo_masuk']) {
                                    ?>
                                        <td class="align-middle"><?= rupiah($aktivitas['saldo_masuk']) ?></td>
                                        <td class="align-middle"><button class="btn btn-outline-success">Saldo Masuk</button></td>
                                    <?php
                                    } else if ($aktivitas['saldo_withdraw']) {
                                    ?>
                                        <td class="align-middle"><?= rupiah($aktivitas['saldo_withdraw']) ?></td>
                                        <td class="align-middle"> <button class="btn btn-outline-primary">Saldo Withdraw</button></td>
                                    <?php
                                    }
                                    ?>
                                    <td class="align-middle">
                                        <?php
                                        if ($aktivitas['status'] === 'SETTLEMENT') {
                                            echo '<span class="badge badge-success">APPROVE</span>';
                                        } else if ($aktivitas['status'] === 'PENDING') {
                                            echo '<span class="badge badge-warning">PROCESSING</span>';
                                        } else if ($aktivitas['status'] === 'CANCEL') {
                                            echo '<span class="badge badge-danger">BATAL</span>';
                                        }
                                        ?>
                                    </td>
                                    <?php
                                    if ($aktivitas['saldo_masuk']) {
                                    ?>
                                        <td class="align-middle">
                                            <a href="<?= base_url('juragan/keuangan/detail/') . $aktivitas['uid_keuangan'] ?>" class="btn btn-icon btn-info"><i class="fa-solid fa-circle-info"></i> Detail</a>
                                        </td>
                                    <?php
                                    } else if ($aktivitas['saldo_withdraw'] && $aktivitas['status'] === "SETTLEMENT") {
                                    ?>
                                        <td class="align-middle">
                                            <a href="<?= base_url('juragan/keuangan/detail/') . $aktivitas['uid_keuangan'] ?>" class="btn btn-icon btn-info"><i class="fa-solid fa-circle-info"></i> Detail</a>
                                        </td>
                                    <?php
                                    } else if ($aktivitas['saldo_withdraw'] && $aktivitas['status'] === "PENDING") {
                                    ?>
                                        <td class="align-middle">
                                            <button class="btn btn-icon btn-danger batal" id="batal" uid_keuangan="<?= $aktivitas['uid_keuangan'] ?>"><i class="fas fa-times"></i> Batal</button>
                                            <a href="<?= base_url('juragan/keuangan/detail/') . $aktivitas['uid_keuangan'] ?>" class="btn btn-icon btn-info"><i class="fa-solid fa-circle-info"></i> Detail</a>
                                        </td>
                                    <?php
                                    } else {
                                    ?>
                                        <td class="align-middle">
                                            <a href="<?= base_url('juragan/keuangan/detail/') . $aktivitas['uid_keuangan'] ?>" class="btn btn-icon btn-info"><i class="fa-solid fa-circle-info"></i> Detail</a>
                                        </td>
                                    <?php
                                    }
                                    ?>

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
<!-- modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="pengeluaran">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tarik Uang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="form-pengeluaran" method="POST">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="nominal">Nominal</label>
                        <input type="text" class="form-control" name="nominal" id="nonimal" class="nominal">
                        <small>Maksimal penarikan :
                            <?= rupiah(
                                $rekap['saldo_masuk_settlement']['saldo_masuk'] - ($rekap['saldo_withdraw_settlement']['saldo_withdraw'] + $rekap['saldo_withdraw_pending']['saldo_withdraw'])
                            )
                            ?>
                        </small>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <input type="text" class="form-control" name="deskripsi" id="deskripsi">
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Pilih Metode Penarikan (Bank)</label><br>
                        <select name="nomor_rekening" id="nomor_rekening" class="form-control">
                            <?php
                            foreach ($rekening as $rekening) :
                            ?>
                                <option value="<?= $rekening['nomor_rekening'] ?>"><?= $rekening['nama_bank'] . " - " . $rekening['atas_nama'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span>Tambah metode penarikan: <a href="<?= base_url('juragan/keuangan/akunbank') ?>">"disini"</a></span>
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

<?php $this->load->view('dist/_partials/footer'); ?>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.1/css/buttons.dataTables.min.css">
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.flash.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script script src="<?php echo base_url(); ?>assets/modules/bootstrap-daterangepicker/daterangepicker.js"></script>
<script>
    // filter date 
    var start_date;
    var end_date;
    var DateFilterFunction = (function(oSettings, aData, iDataIndex) {
        var dateStart = start_date;
        var dateEnd = end_date;
        var createdAt = aData[1] || 1
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
            start_date = '';
            end_date = '';
            $.fn.dataTable.ext.search.splice($.fn.dataTable.ext.search.indexOf(DateFilterFunction, 1));
            table.draw();
        });

        $('.btn-reset').click(function() {
            $(this).val('');
            start_date = '';
            end_date = '';
            $.fn.dataTable.ext.search.splice($.fn.dataTable.ext.search.indexOf(DateFilterFunction, 1));
            table.draw();
        })
        var table = $('#aktivitas-keuangan').DataTable({
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
                        var min = (start_date == undefined) ? "" : start_date;
                        var max = (end_date === undefined) ? "" : end_date;
                        return `Aktivitas keuangan ${min} - ${max}`;
                    }
                },
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: 'th:not(:last-child)'
                    },
                    title: "aktivitas blabla",
                    messageTop: function(xlsx) {
                        var min = (start_date == undefined) ? "" : start_date;
                        var max = (end_date == undefined) ? "" : end_date;
                        return `Aktivitas keuangan ${min} - ${max}`;
                    }
                }
            ]
        });

        <?php if (isset($_SESSION['response']) && $_SESSION['response'] !== '') : ?>
            swal({
                title: "<?php echo $_SESSION['response']['status']; ?>",
                text: "<?php echo $_SESSION['response']['message']; ?>",
                icon: "<?php echo $_SESSION['response']['status']; ?>"
            });
        <?php endif; ?>

        var form = $('#form-pengeluaran');
        form.submit(function(ev) {
            ev.preventDefault();
            var nominal = $('#nonimal').val();
            if (nominal > <?= $rekap['saldo_masuk_settlement']['saldo_masuk'] - ($rekap['saldo_withdraw_settlement']['saldo_withdraw'] + $rekap['saldo_withdraw_pending']['saldo_withdraw']) ?>) {
                swal({
                    title: "Nominal melebihi batas!",
                    text: "Nominal yang anda masukan melebihi batas penarikan",
                    icon: 'error'
                })
            } else {

                $.ajax({
                    'type': form.attr('method'),
                    'url': '<?= base_url('juragan/keuangan/penarikan') ?>',
                    'data': form.serialize(),
                    'dataType': 'JSON',
                    beforeSend: function() {
                        var loader = "<?= base_url('public/assets/loader.svg') ?>";
                        swal({
                            title: 'Loading...',
                            html: `<img src="${loader}">.`,
                            showCancelButton: false,
                            showConfirmButton: false
                        })
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
            }
        })
        $('.batal').click(function() {
            uid_keuangan = $(this).attr('uid_keuangan');
            $.ajax({
                url: "<?= base_url('juragan/keuangan/batalWD/') ?>" + uid_keuangan,
                type: "PUT",
                dataType: 'JSON',
                success: function(data) {
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
    })

    $('.tahun').change(function() {
        const form = document.getElementById('filter');
        form.submit();
    })

    var ctx = document.getElementById("chartKeuangan").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "Oktober", "November", "Desember"],
            datasets: [{
                    label: 'Uang Masuk',
                    data: [
                        <?= $keuangan['januari']['saldo_masuk'] ?>,
                        <?= $keuangan['februari']['saldo_masuk'] ?>,
                        <?= $keuangan['maret']['saldo_masuk'] ?>,
                        <?= $keuangan['april']['saldo_masuk'] ?>,
                        <?= $keuangan['mei']['saldo_masuk'] ?>,
                        <?= $keuangan['juni']['saldo_masuk'] ?>,
                        <?= $keuangan['juli']['saldo_masuk'] ?>,
                        <?= $keuangan['agustus']['saldo_masuk'] ?>,
                        <?= $keuangan['september']['saldo_masuk'] ?>,
                        <?= $keuangan['oktober']['saldo_masuk'] ?>,
                        <?= $keuangan['november']['saldo_masuk'] ?>,
                        <?= $keuangan['desember']['saldo_masuk'] ?>
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
                    label: 'Uang Ditarik',
                    data: [
                        <?= $keuangan['januari']['saldo_withdraw'] ?>,
                        <?= $keuangan['februari']['saldo_withdraw'] ?>,
                        <?= $keuangan['maret']['saldo_withdraw'] ?>,
                        <?= $keuangan['april']['saldo_withdraw'] ?>,
                        <?= $keuangan['mei']['saldo_withdraw'] ?>,
                        <?= $keuangan['juni']['saldo_withdraw'] ?>,
                        <?= $keuangan['juli']['saldo_withdraw'] ?>,
                        <?= $keuangan['agustus']['saldo_withdraw'] ?>,
                        <?= $keuangan['september']['saldo_withdraw'] ?>,
                        <?= $keuangan['oktober']['saldo_withdraw'] ?>,
                        <?= $keuangan['november']['saldo_withdraw'] ?>,
                        <?= $keuangan['desember']['saldo_withdraw'] ?>
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

    function formatRupiah(angka) {
        var number_string = angka.toString(),
            sisa = number_string.length % 3,
            rupiah = number_string.substr(0, sisa),
            ribuan = number_string.substr(sisa).match(/\d{3}/g);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        return rupiah;
    }

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