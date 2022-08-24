<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title><?= $title ?></title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/modules/fontawesome/css/all.min.css">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/modules/jquery-selectric/selectric.css">

    <!-- Template CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/components.css">

    <!-- sweetalert -->
    <script src="<?= base_url() ?>assets/modules/sweetalert/sweetalert.min.js"></script>
    <!-- Start GA -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-94034622-3');
    </script>
    <style>
        .home-singup {
            background-image: url("../public/assets/heroes.png");
            height: 90vh;
            width: 100%;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: top -420px left 600px;
            padding: 0 80px;
        }
    </style>
    <!-- /END GA -->
</head>

<body class="home-singup">
    <?php $this->load->view('dist/_partials/notif.php'); ?>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
                        <div class="login-brand">
                            <img src="<?= base_url('public/assets/logo.png') ?>" alt="logo" width="150">
                        </div>

                        <div class="card card-primary opacity-50">
                            <div class="card-header ">
                                <h4><?= $title; ?></h4>
                            </div>
                            <div class="card-body">
                                <form method="POST">
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="fnama">Nama depan</label>
                                            <input id="fnama" type="text" class="form-control" name="fnama" value="<?= set_value('fnama'); ?>" autofocus>
                                            <small class="text-danger"><?= form_error('fnama') ?></small>
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="lnama">Nama Akhir</label>
                                            <input id="lnama" type="text" class="form-control" name="lnama" value="<?= set_value('lnama'); ?>">
                                            <small class="text-danger"><?= form_error('lnama') ?></small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="username">Username</label>
                                            <input type="text" class="form-control" name="username" id="username" value="<?= set_value('username'); ?>">
                                            <small class="text-danger"><?= form_error('username') ?></small>
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="email">Email</label>
                                            <input id="email" type="email" class="form-control" name="email" value="<?= set_value('email') ?>">
                                            <small class="text-danger"><?= form_error('email') ?></small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="password" class="d-block">Password</label>
                                            <input id="password" type="password" class="form-control pwstrength" data-indicator="pwindicator" name="password" value="<?= set_value('password') ?>">
                                            <small class="text-danger"><?= form_error('password') ?></small>
                                            <div id="pwindicator" class="pwindicator">
                                                <div class="bar"></div>
                                                <div class="label"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="password2" class="d-block">Ulangi password</label>
                                            <input id="password2" type="password" class="form-control" name="password-confirm" value="<?= set_value('password-confirm') ?>">
                                            <small class="text-danger">
                                                <?= form_error('password-confirm') ?>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label>Alamat</label>
                                            <input type="text" class="form-control" name="alamat" id="alamat" value="<?= set_value('alamat') ?>">
                                            <small class="text-danger"><?= form_error('alamat'); ?></small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label>Jenis kelamin</label>
                                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                                                <option value="L">Laki-Laki</option>
                                                <option value="P">Perempuan</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-6">
                                            <label>Nomor ponsel</label>
                                            <input type="text" class="form-control" name="no_hp" id="no_hp" value="<?= set_value('no_hp'); ?>">
                                            <small class="text-danger"><?= form_error('no_hp') ?></small>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="agree" class="custom-control-input" id="agree" required>
                                            <label class="custom-control-label" for="agree">I agree with the terms and conditions</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                                            Register
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="simple-footer">
                            Copyright &copy; MasKost 2022
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- General JS Scripts -->
    <script src="<?= base_url() ?>assets/modules/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/modules/popper.js"></script>
    <script src="<?= base_url() ?>assets/modules/tooltip.js"></script>
    <script src="<?= base_url() ?>assets/modules/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
    <script src="<?= base_url() ?>assets/modules/moment.min.js"></script>
    <script src="<?= base_url() ?>assets/js/stisla.js"></script>

    <!-- JS Libraies -->
    <script src="<?= base_url() ?>assets/modules/jquery-pwstrength/jquery.pwstrength.min.js"></script>
    <script src="<?= base_url() ?>assets/modules/jquery-selectric/jquery.selectric.min.js"></script>

    <!-- Page Specific JS File -->
    <script src="<?= base_url() ?>assets/js/page/auth-register.js"></script>

    <!-- Template JS File -->
    <script src="<?= base_url() ?>assets/js/scripts.js"></script>
    <script src="<?= base_url() ?>assets/js/custom.js"></script>
    <script>
        $(document).ready(function() {});
    </script>
</body>

</html>