<?php $this->load->view('dist/_partials/header') ?>
<div class="main-content">
  <section class="web-information">
    <div class="row">
      <div class="col-lg-3 col-md-3 col-sm-12">
        <div class="card card-statistic-2">
          <div class="card-stats">
            <div class="card-stats-title">Kamar</div>
            <div class="card-stats-items d-flex justify-content-center">
              <div class="card-stats-item">
                <div class="card-stats-item-count"><?= $kamar['available'] ?></div>
                <small>Kosong</small>
              </div>
              <div class="card-stats-item">
                <div class="card-stats-item-count"><?= $kamar['sold'] ?></div>
                <small>Huni</small>
              </div>
            </div>
          </div>
          <div class="card-icon shadow-primary bg-primary">
            <i class="fa-solid fa-bed text-white"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Total kamar</h4>
            </div>
            <div class="card-body">
              <?= $kamar['available'] + $kamar['sold'] ?>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-5 col-md-5 col-sm-12">
        <div class="card card-statistic-2">
          <div class="card-stats">
            <div class="card-stats-title">Saldo</div>
            <div class="card-stats-items d-flex justify-content-around">
              <div class="card-stats-item">
                <span class="font-weight-bold"><?= rupiah($saldo['available']['saldo_masuk']) ?></span>
                <br>
                <small>Availabe</small>
              </div>
              <div class="card-stats-item">
                <span class="font-weight-bold"><?= rupiah($saldo['withdraw']['saldo_withdraw']) ?></span>
                <br>
                <small>Withdrawal</small>
              </div>
              <div class="card-stats-item">
                <span class="font-weight-bold"><?= rupiah($saldo['profit']['jumlah_profit']) ?></span>
                <br>
                <small>Profit</small>
              </div>
            </div>
          </div>
          <div class="card-icon shadow-primary bg-primary">
            <i class="fa-solid fa-money-bill-transfer text-white"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Total keuangan</h4>
            </div>
            <div class="card-body">
              <?= rupiah($saldo['available']['saldo_masuk'] - ($saldo['withdraw']['saldo_withdraw']) + $saldo['profit']['jumlah_profit']) ?>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-12">
        <div class="card card-statistic-2">
          <div class="card-stats">
            <div class="card-stats-title">Member</div>
            <div class="card-stats-items d-flex justify-content-center">
              <div class="card-stats-item">
                <span class="font-weight-bold"><?= $member['juragan'] ?></span>
                <br>
                <small>Juragan</small>
              </div>
              <div class="card-stats-item">
                <span class="font-weight-bold"><?= $member['penghuni'] ?></span>
                <smal>Penghuni</smal>
              </div>
            </div>
          </div>
          <div class="card-icon shadow-primary bg-primary">
            <i class="fa-solid fa-users text-white"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Total member</h4>
            </div>
            <div class="card-body">
              <?= $member['juragan'] + $member['penghuni'] ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 col-lg-12 col-sm-12">
        <div class="card">
          <div class="card-header">
            <h4>Invoices</h4>
            <div class="card-header-action">
              <a href="<?= base_url('admin/transaksi/data/') ?>" class="btn btn-danger">View More <i class="fas fa-chevron-right"></i></a>
            </div>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive table-invoice">
              <table class="table table-striped">
                <tr>
                  <th>Invoice ID</th>
                  <th>Penghuni</th>
                  <th>Jenis</th>
                  <th>Status</th>
                  <th>Waktu transaksi</th>
                  <th>Tenggat transaksi</th>
                </tr>
                <?php
                $i = 1;
                foreach ($transaksi as $transaksi) :
                ?>
                  <tr>
                    <td><a href="<?= base_url('admin/transaksi/data/detail/') . $transaksi['uid_transaksi'] ?>"><?= $transaksi['uid_transaksi'] ?></a></td>
                    <td class="font-weight-600"><?= $transaksi['fnama'] . ' ' . $transaksi['lnama'] ?></td>
                    <td class="font-weight-600"><?= $transaksi['jenis'] ?></td>
                    <td>
                      <div class="badge <?= ($transaksi['status_pembayaran'] === 'SETTLEMENT') ? 'badge-success' : 'badge-warning' ?>">
                        <?= ($transaksi['status_pembayaran'] === 'SETTLEMENT') ? 'APPROVE' : 'PENDING' ?>
                      </div>
                    </td>
                    <td><?= $transaksi['waktu_transaksi'] ?></td>
                    <td><?= $transaksi['tenggat_pembayaran'] ?></td>
                  </tr>
                <?php endforeach; ?>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<?php $this->load->view('dist/_partials/footer') ?>