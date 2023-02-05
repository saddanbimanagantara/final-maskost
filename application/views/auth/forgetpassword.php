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
                            <a href="<?= base_url() ?>"><img src="<?php echo base_url(); ?>public/assets/logo.png" width="200" alt="logo" class="shadow-light"></a>
                        </div>

                        <div class="card card-primary">
                            <div class="card-header">
                                <h4>Lupa password</h4>
                            </div>

                            <div class="card-body">
                                <form method="POST" action="<?= base_url('auth/forgetpassword'); ?>">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input id="email" type="email" class="form-control" name="email" tabindex="1" value="<?= set_value('email') ?>" autofocus>
                                        <span class="text-danger">
                                            <?= form_error('email') ?>
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                            Kirim
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="mt-5 text-muted text-center">
                            Ingat password? <a href="<?php echo base_url(); ?>auth/login">Login</a>
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

<script src="<?= base_url(); ?>assets/js/scripts.js"></script>
<script src="<?= base_url(); ?>assets/js/custom.js"></script>
</body>

</html>