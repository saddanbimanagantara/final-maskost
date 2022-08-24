<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title><?= $title; ?></title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/modules/fontawesome/css/all.min.css">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/modules/bootstrap-social/bootstrap-social.css">

  <!-- swall -->
  <script src="<?= base_url() ?>assets/modules/sweetalert/sweetalert.min.js"></script>

  <!-- Template CSS -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/css/style.css">
</head>

<body>
  <div id="app">
    <?php $this->load->view('dist/_partials/notif.php'); ?>
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
              <img src="<?php echo base_url(); ?>public/assets/logo.png" width="200" alt="logo" class="shadow-light">
            </div>

            <div class="card card-primary">
              <div class="card-header">
                <h4>Login</h4>
              </div>

              <div class="card-body">
                <form method="POST" action="<?= base_url('auth/loginjuragan') ?>" class="needs-validation" novalidate="">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email" tabindex="1" required autofocus>
                    <div class="invalid-feedback">
                      Email harus diisi atau email tidak valid!
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="d-block">
                      <label for="password" class="control-label">Password</label>
                      <div class="float-right">
                        <a href="<?php echo base_url(); ?>dist/auth_forgot_password" class="text-small">
                          Forgot Password?
                        </a>
                      </div>
                    </div>
                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                    <?= form_error('password') ?>
                    <div class="invalid-feedback">
                      Password harus diisi!
                    </div>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Login
                    </button>
                  </div>
                </form>
              </div>
            </div>
            <div class="mt-5 text-muted text-center">
              Belum punya akun? <a href="<?php echo base_url(); ?>auth/singup">Daftar</a>
            </div>
            <div class="simple-footer">
              Copyright &copy; maskost 2022
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</body>
<!-- General JS Scripts -->
<script src="<?= base_url(); ?>assets/modules/jquery.min.js"></script>
<script src="<?= base_url(); ?>assets/modules/popper.js"></script>
<script src="<?= base_url(); ?>assets/modules/tooltip.js"></script>
<script src="<?= base_url(); ?>assets/modules/bootstrap/js/bootstrap.min.js"></script>
<script src="<?= base_url(); ?>assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
<script src="<?= base_url(); ?>assets/modules/moment.min.js"></script>
<script src="<?= base_url(); ?>assets/js/stisla.js"></script>

<!-- JS Libraies -->

<!-- Page Specific JS File -->

<!-- Template JS File -->
<script src="<?= base_url(); ?>assets/js/scripts.js"></script>
<script src="<?= base_url(); ?>assets/js/custom.js"></script>
</body>

</html>