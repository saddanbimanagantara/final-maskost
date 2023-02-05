<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<body>
  <div id="app">
    <?php if ($this->uri->segment(2) === 'error') {
    } else { ?>
      <div class="main-wrapper main-wrapper-1">
        <nav class="navbar navbar-expand-lg main-navbar d-flex justify-content-between bg-primary">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
          </ul>
          <ul class="navbar-nav navbar-right">
            <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <?php
                $imgurl = base_url() . 'assets/img/profile/' . ($user['otoritas']) . '/' . $user['image'];
                ?>
                <figure class="avatar mr-2 avatar-sm">
                  <img src="<?= $imgurl ?>" alt="...">
                </figure>
                <div class="d-sm-none d-lg-inline-block">Hi, <?= $user['fnama'] . ' ' . $user['lnama'] ?></div>
              </a>
              <div class="dropdown-menu dropdown-menu-right">
                <a href="<?php echo base_url(); ?>profile" class="dropdown-item has-icon">
                  <i class="far fa-user"></i> Profile
                </a>
                <a href="<?= base_url('auth/logout') ?>" class="dropdown-item has-icon text-danger">
                  <i class="fas fa-sign-out-alt"></i> Logout
                </a>
              </div>
            </li>
          </ul>
        </nav>
      <?php } ?>