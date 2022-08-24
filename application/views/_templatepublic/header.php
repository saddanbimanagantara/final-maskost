<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>E-Kost - MasKost</title>
    <!-- ajax -->
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"></script>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="<?= base_url('public/') ?>assets/favicon.ico" />
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css" integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA==" crossorigin="">
    <!-- Fontawesome -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/fontawesome-free-6.1.1-web/css/all.css">
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="<?= base_url('public/') ?>css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?= base_url('public/') ?>css/custom.css">
</head>

<body>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <!-- header section -->
    <section class="header-top d-flex justify-content-end">
        <a href="<?= base_url('juragan/landing') ?>"><i class="fa-solid fa-rectangle-ad"></i> Promosikan Kost Anda</a>
    </section>
    <section class="header">
        <div class="logo">
            <a href="<?= base_url() ?>" class="logo"><img src="<?= base_url('public/assets/logo.png') ?>" alt="logo"></a>
        </div>
        <ul class="navBar">
            <div class="close-mobile">
                <i class="fa-solid fa-rectangle-xmark"></i>
            </div>
            <li class="navMenu"><a href="<?= base_url() ?>" class="navLink">Home</a></li>
            <li class="navMenu"><a href="<?= base_url('kost/list') ?>" class="navLink">Sewa</a></li>
            <li class="navMenu"><a href="<?= base_url('page/about') ?>" class="navLink">About</a></li>
            <li class="navMenu"><a href="<?= base_url('page/contact') ?>" class="navLink">Contact</a></li>
            <?php
            if ($this->session->userdata('member')) {
                $member = $this->session->userdata('member');
            ?>

                <li class="navMenu"><a href="<?= base_url() . $member['otoritas'] . '/dashboard' ?>" class="btn btn-sm btn-primary text-white btn-direction">Dashboard</a></li>
                <li class="navMenu"><a href="<?= base_url('auth/logout') ?>" class="btn btn-sm btn-danger text-white btn-direction">Log Out</a></li>
            <?php
            } else {
            ?>
                <li class="navMenu"><a href="<?= base_url('auth/login') ?>" class="btn btn-sm btn-primary text-white btn-direction">Masuk</a></li>
                <li class="navMenu"><a href="<?= base_url('auth/singup'); ?>" class="btn btn-sm btn-danger text-white btn-direction">Daftar</a></li>
            <?php
            }
            ?>
        </ul>
        <div class="mobile">
            <i class="fa-solid fa-bars"></i>
        </div>
    </section>