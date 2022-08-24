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
      <li class="menu <?php echo $this->uri->segment(2) == 'dashboard' || $this->uri->segment(2) == 'dashboard' || $this->uri->segment(2) == 'dashboard' ? 'active' : ''; ?>"><a href="<?= base_url('admin/dashboard') ?>" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a></li>
      <li class="menu-header">Master</li>
      <li class="dropdown <?php echo $this->uri->segment(2) == 'member' || $this->uri->segment(2) == 'kamar' || $this->uri->segment(3) == 'available' || $this->uri->segment(3) == 'sold' || $this->uri->segment(3) == 'pendingpayment' ? 'active' : ''; ?>">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-bed"></i> <span>Kamar</span></a>
        <ul class="dropdown-menu">
          <li class="<?php echo $this->uri->segment(3) == 'master' ? 'active' : ''; ?>"><a class="nav-link" href="<?php echo base_url(); ?>admin/kamar/master">Kamar</a></li>
          <li class="<?php echo $this->uri->segment(3) == 'kategori' ? 'active' : ''; ?>"><a class="nav-link" href="<?php echo base_url(); ?>admin/kamar/kategori">Kategori kamar</a></li>
          <li class="<?php echo $this->uri->segment(3) == 'fasilitas' ? 'active' : ''; ?>"><a class="nav-link" href="<?php echo base_url(); ?>admin/kamar/fasilitas">Fasilitas kamar</a></li>
          <li class="<?php echo $this->uri->segment(3) == 'durasi' ? 'active' : ''; ?>"><a class="nav-link" href="<?php echo base_url(); ?>admin/kamar/durasi">Durasi kamar</a></li>
        </ul>
      </li>
      <li class="dropdown <?php echo $this->uri->segment(2) == 'user' || $this->uri->segment(2) == 'member' || $this->uri->segment(2) == 'member' ? 'active' : ''; ?>">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-users"></i> <span>Member</span></a>
        <ul class="dropdown-menu">
          <li class="<?php echo $this->uri->segment(3) == 'administrator' ? 'active' : ''; ?>"><a class="nav-link" href="<?php echo base_url(); ?>admin/user/administrator">Administrator</a></li>
          <li class="<?php echo $this->uri->segment(5) == 'juragan' ? 'active' : ''; ?>"><a class="nav-link" href="<?php echo base_url(); ?>admin/user/member/master/juragan">Juragan</a></li>
          <li class="<?php echo $this->uri->segment(5) == 'penghuni' ? 'active' : ''; ?>"><a class="nav-link" href="<?php echo base_url(); ?>admin/user/member/master/penghuni">Penghuni</a></li>
        </ul>
      </li>
      <li class="dropdown <?php echo $this->uri->segment(2) == 'transaksi' ? 'active' : ''; ?>">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fa-solid fa-money-bill-transfer"></i> <span>Transaksi</span></a>
        <ul class="dropdown-menu">
          <li class="<?php echo $this->uri->segment(3) == 'data' ? 'active' : ''; ?>"><a class="nav-link" href="<?php echo base_url('admin/transaksi/data'); ?>">Transaksi Invoice</a></li>
          <li class="<?php echo $this->uri->segment(3) == 'withdraw_req' ? 'active' : ''; ?>"><a class="nav-link" href="<?php echo base_url(); ?>admin/transaksi/withdraw_req">Withdrawal request</a></li>
        </ul>
      </li>
      <li class="menu-header">Layanan</li>
      <li class="<?php echo $this->uri->segment(2) == 'chat' || $this->uri->segment(2) == 'chat' || $this->uri->segment(2) == 'chat' ? 'active' : ''; ?>">
        <a href="<?= base_url('admin/chat') ?>" class="nav-link"><i class="fa-solid fa-comment-dots"></i> <span>Layanan chat</span></a>
      </li>
      <li class="menu-header">Pages</li>
      <li class="dropdown <?= $this->uri->segment(1) == 'profile' ? 'active' : ''; ?>">
        <a href="#" class="nav-link has-dropdown"><i class="far fa-user"></i> <span>Profil</span></a>
        <ul class="dropdown-menu">
          <li class="<?php echo $this->uri->segment(1) == 'profile' ? 'active' : ''; ?>"><a href="<?php echo base_url(); ?>profile" class="nav-link">Profil</a></li>
          <li class="<?php echo $this->uri->segment(2) == 'gantipassword' ? 'active' : ''; ?>"><a href="<?php echo base_url(); ?>profile/gantipassword" class="nav-link">Ganti Password</a></li>
        </ul>
      </li>
  </aside>
</div>