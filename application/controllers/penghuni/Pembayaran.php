<?php
class Pembayaran extends CI_Controller
{
    var $uid_member;
    var $user_log;

    public function __construct()
    {
        parent::__construct();
        isLogin();
        $this->load->model('member_m', 'member');
        $this->load->model('transaksi_m', 'transaksi');
        $this->load->model('kamar_m', 'kamar');
        $this->data_sess = $this->session->userdata('member');
        $this->uid_member = $this->data_sess['uid_member'];
        $this->user_log = $this->member->getMember('penghuni', $this->uid_member);
        $this->user_log = array(
            'member_id'     => $this->uid_member,
            'fnama'         => $this->user_log['fnama'],
            'lnama'         => $this->user_log['lnama'],
            'alamat'        => $this->user_log['alamat'],
            'email'         => $this->user_log['email'],
            'otoritas'      => $this->user_log['otoritas'],
            'image'         => $this->user_log['image']
        );
    }

    public function index()
    {
        $data = array(
            'title'     => "Data pembayaran",
            'user'      => $this->user_log,
            'transaksi' => $this->transaksi->gtTransaksi($this->uid_member)
        );
        $this->load->view('penghuni/pembayaran', $data);
    }

    public function detail($uid_transaksi)
    {
        $data = array(
            'title'     => "Detail pembayaran",
            'user'      => $this->user_log,
            'transaksi' => $this->transaksi->getDetailTransaksi($uid_transaksi)
        );
        $this->load->view('penghuni/detail', $data);
    }

    public function perpanjang()
    {
        $tx = $this->transaksi->getTransaksiPerpanjang($this->uid_member);
        $data = array(
            'title'     => "Perpanjang Kost",
            'user'      => $this->user_log,
            'kamar'     => $this->kamar->getFormKamar($tx['uid_kamar']),
            'tx'        => $tx
        );
        $this->load->view('penghuni/perpanjang', $data);
    }
}
