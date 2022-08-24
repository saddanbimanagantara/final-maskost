<?php

class Data extends CI_Controller
{
    var $user_log, $uid_member, $data_sess;
    public function __construct()
    {
        parent::__construct();
        isLogin();
        $this->load->model('member_m', 'member');
        $this->load->model('kamar_m', 'kamar');
        $this->load->model('durasi_kamar_m', 'durasi');
        $this->load->model('kategori_kamar_m', 'kategori');
        $this->load->model('fasilitas_kamar_m', 'fasilitas');
        $this->load->model('transaksi_m', 'transaksi');
        $this->load->model('keuangan_m', 'keuangan');
        $this->data_sess = $this->session->userdata('member');
        $this->uid_member = $this->data_sess['uid_member'];
        $this->user_log = $this->member->getMember($this->data_sess['otoritas'], $this->uid_member);
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
            'title'     => 'Master data transaksi',
            'user'      => $this->user_log,
            'transaksi' => $this->transaksi->getTransaksi()
        );
        $this->load->view('admin/transaksi/index', $data);
    }

    public function detail($uid_transaksi)
    {
        $detail = $this->transaksi->getDetailTransaksi($uid_transaksi);
        $data = array(
            'title'     => 'Data transaksi ' . $uid_transaksi,
            'user'      => $this->user_log,
            'detail'    => $detail
        );

        $this->load->view('admin/transaksi/detail', $data);
    }
}
