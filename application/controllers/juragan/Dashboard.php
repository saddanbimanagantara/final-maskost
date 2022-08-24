<?php

class Dashboard extends CI_Controller
{
    var $uid_member;
    var $data_sess;
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

        $kamar = kamarCheck();
        if (!$kamar) {
            redirect('juragan/kamar/add');
        }
    }

    public function index()
    {
        $rekap = array(
            'saldo_settlement'        => $this->keuangan->getRekap($this->uid_member, "SETTLEMENT", "saldo_masuk"),
            'saldo_pending'           => $this->keuangan->getRekap($this->uid_member, "PENDING", "saldo_masuk"),
            'saldo_withdraw'          => $this->keuangan->getRekap($this->uid_member, "SETTLEMENT", "saldo_withdraw"),
            'saldo_withdraw_pending'  => $this->keuangan->getRekap($this->uid_member, "PENDING", "saldo_withdraw")
        );
        $data = array(
            'title'             => 'Dashboard juragan',
            'user'              => $this->member->getMember('juragan', $this->uid_member),
            'jumlahAvailable'   => $this->kamar->count("1", $this->uid_member),
            'jumlahSold'        => $this->kamar->count("0", $this->uid_member),
            'jumlah_kamar'      => $this->kamar->jumlahKamar($this->uid_member),
            'riwayat_penghuni'  => $this->transaksi->CountPenghuni($this->uid_member),
            'transaksi'         => $this->transaksi->getTransaksi(null, $this->uid_member),
            'rekap'             => $rekap
        );
        $this->load->view('juragan/index', $data);
    }

    public function kamar()
    {
    }
}
