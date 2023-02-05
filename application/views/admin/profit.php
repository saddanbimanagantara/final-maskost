<?php $this->load->view('dist/_partials/header') ?>
<div class="main-content">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="card card-primary opacity-75">
                <div class="card-header">
                    <h5>Total profit</h5>
                </div>
                <div class="card-body">
                    <h5><?= rupiah($totalprofit['jumlah_profit']) ?></h5>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="card card-success opacity-75">
                <div class="card-header">
                    <h5>Settingan profit</h5>
                </div>
                <div class="card-body">
                    <h5><?= rupiah($profit_set['gross_amount']) ?></h5>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4>Profit Website</h4>
            <button class="btn btn-sm btn-primary setprofit" id="setprofit" data-toggle="modal" data-target="#setprofitmodal">set profit</button>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Profit</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($profit as $profit) :
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= rupiah($profit['jumlah_profit']) ?></td>
                            <td><?= $profit['date_updated'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- modal set profit -->
<div class="modal fade" id="setprofitmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Set profit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/profit/setProfit') ?>" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="profit">Nominal profit</label>
                        <input type="number" name="nominal" id="nominal" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $this->load->view('dist/_partials/footer') ?>
<script>
    <?php if (isset($_SESSION['response']) && $_SESSION['response'] !== '') : ?>
        swal({
            title: "<?php echo $_SESSION['response']['status']; ?>",
            text: "<?php echo $_SESSION['response']['message']; ?>",
            icon: "<?php echo $_SESSION['response']['status']; ?>"
        });
    <?php endif; ?>
    $(document).ready(function() {
        $('.table').DataTable();
    })
</script>