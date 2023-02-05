<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="<?php echo base_url(); ?>">Mas KOST</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="<?php echo base_url(); ?>">MK</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu <?php echo $this->uri->segment(2) == 'dashboard' || $this->uri->segment(2) == 'dashboard' || $this->uri->segment(2) == 'dashboard' ? 'active' : ''; ?>"><a href="<?= base_url('juragan/dashboard') ?>" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a></li>
            <li class="menu-header">Master</li>
            <li class="dropdown <?php echo $this->uri->segment(2) == 'member' || $this->uri->segment(2) == 'kamar' || $this->uri->segment(3) == 'available' || $this->uri->segment(3) == 'sold' || $this->uri->segment(3) == 'pendingpayment' ? 'active' : ''; ?>">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-bed"></i> <span>Kamar</span></a>
                <ul class="dropdown-menu">
                    <li class="<?php echo $this->uri->segment(2) == 'kamar' ? 'active' : ''; ?>"><a class="nav-link" href="<?php echo base_url(); ?>juragan/kamar">Kamar</a></li>
                </ul>
            </li>
            <li class="dropdown <?php echo $this->uri->segment(2) == 'transaksi' || $this->uri->segment(2) == 'transaksi' || $this->uri->segment(2) == 'transaksi' ? 'active' : ''; ?>">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fa-solid fa-receipt"></i><span>Transaksi</span></a>
                <ul class="dropdown-menu">
                    <li class="<?php echo $this->uri->segment(2) == 'transaksi' ? 'active' : ''; ?>"><a class="nav-link" href="<?php echo base_url('juragan/transaksi/'); ?>">Transaksi Kamar</a></li>
                </ul>
            </li>
            <li class="dropdown <?= $this->uri->segment(2) == 'keuangan' ? 'active' : ''; ?>">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fa-solid fa-money-bills"></i> <span>Keuangan</span></a>
                <ul class="dropdown-menu">
                    <li class="<?php echo $this->uri->segment(3) == 'index' ? 'active' : ''; ?>">
                        <a href="<?= base_url('juragan/keuangan/index') ?>" class="nav-link"><i class="fa-solid fa-chart-bar"></i> <span>Rekap</span></a>
                    </li>
                    <!-- <li class="<?php echo $this->uri->segment(3) == 'aktivitas' ? 'active' : ''; ?>">
                        <a href="<?= base_url('juragan/keuangan/aktivitas') ?>" class="nav-link"><i class="fa-solid fa-money-bill-transfer"></i> <span>Aktivitas</span></a>
                    </li> -->
                    <li class="<?php echo $this->uri->segment(3) == 'buku' ? 'active' : ''; ?>">
                        <a href="<?= base_url('juragan/keuangan/buku') ?>" class="nav-link"><i class="fa-solid fa-book"></i> <span>Buku Keuangan</span></a>
                    </li>
                    <li class="<?php echo $this->uri->segment(3) == 'akunbank' ? 'active' : ''; ?>">
                        <a href="<?= base_url('juragan/keuangan/akunbank') ?>" class="nav-link"><i class="fa-solid fa-building-columns"></i> <span>Akun Bank</span></a>
                    </li>
                </ul>
            </li>
            <!-- <li class="menu-header">Layanan</li>
            <li class="menu <?php echo $this->uri->segment(3) == 'penghuni' ? 'active' : ''; ?>"><a href="<?= base_url('juragan/chat') ?>" class="nav-link"><i class="fa-solid fa-comment-dots"></i><span>Chat</span></a></li> -->
            <li class="menu-header">Pages</li>
            <li class="dropdown <?= $this->uri->segment(1) == 'profile' ? 'active' : ''; ?>">
                <a href="#" class="nav-link has-dropdown"><i class="far fa-user"></i> <span>Profil</span></a>
                <ul class="dropdown-menu">
                    <li class="<?php echo $this->uri->segment(1) == 'profile' ? 'active' : ''; ?>"><a href="<?php echo base_url(); ?>profile" class="nav-link">Profil</a></li>
                    <li class="<?php echo $this->uri->segment(2) == 'gantipassword' ? 'active' : ''; ?>"><a href="<?php echo base_url(); ?>profile/gantipassword" class="nav-link">Ganti Password</a></li>
                </ul>
            </li>
            <li class="<?php echo $this->uri->segment(3) == 'admin' ? 'active' : ''; ?>">
                <a href="<?= base_url('juragan/chat/maskost') ?>" class="nav-link"><i class="fa-brands fa-telegram"></i> <span>Hubungi Mas Kost</span></a>
            </li>
    </aside>
</div>