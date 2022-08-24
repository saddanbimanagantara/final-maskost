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
      <li class="menu <?php echo $this->uri->segment(2) == 'dashboard' || $this->uri->segment(2) == 'dashboard' || $this->uri->segment(2) == 'dashboard' ? 'active' : ''; ?>"><a href="<?= base_url('penghuni/dashboard') ?>" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a></li>
      <li class="menu <?php echo $this->uri->segment(2) == 'pembayaran' || $this->uri->segment(2) == 'pembayaran' || $this->uri->segment(2) == 'pembayaran' ? 'active' : ''; ?>"><a href="<?= base_url('penghuni/pembayaran') ?>" class="nav-link"><i class="fa-solid fa-money-bills"></i><span>Pembayaran</span></a></li>
      <li class="menu-header">Layanan</li>
      <li class="dropdown <?= $this->uri->segment(2) == 'chat' ? 'active' : ''; ?>">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fa-solid fa-comment-dots"></i> <span>Chat</span></a>
        <ul class="dropdown-menu">
          <li class="<?php echo $this->uri->segment(3) == 'penghuni' ? 'active' : ''; ?>">
            <a href="<?= base_url('penghuni/chat/area') ?>" class="nav-link"><i class="fa-solid fa-building-user"></i> <span>Juragan</span></a>
          </li>
        </ul>
      </li>
      <li class="menu <?php echo $this->uri->segment(2) == 'testimonial' || $this->uri->segment(2) == 'testimonial' || $this->uri->segment(2) == 'testimonial' ? 'active' : ''; ?>"><a href="<?= base_url('penghuni/testimonial') ?>" class="nav-link"><i class="fa-solid fa-money-bills"></i><span>Testimonial</span></a></li>
      <li class="menu-header">Informasi</li>
      <li class="dropdown <?= $this->uri->segment(1) == 'profile' ? 'active' : ''; ?>">
        <a href="#" class="nav-link has-dropdown"><i class="far fa-user"></i> <span>Profil</span></a>
        <ul class="dropdown-menu">
          <li class="<?php echo $this->uri->segment(1) == 'profile' ? 'active' : ''; ?>"><a href="<?php echo base_url(); ?>profile" class="nav-link">Profil</a></li>
          <li class="<?php echo $this->uri->segment(2) == 'gantipassword' ? 'active' : ''; ?>"><a href="<?php echo base_url(); ?>profile/gantipassword" class="nav-link">Ganti Password</a></li>
        </ul>
      </li>
      <li class="<?php echo $this->uri->segment(3) == 'maskost' ? 'active' : ''; ?>">
        <a href="https://t.me/Bnagantarasys" class="nav-link"><i class="fa-brands fa-telegram"></i> <span>Hubungi Mas Kost</span></a>
      </li>
    </ul>
  </aside>
</div>