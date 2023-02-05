<?php

use FFI\ParserException;

class Dashboard extends CI_Controller
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
        // available, withdraw, profit, total
        // member juragan, penghuni
        $data = array(
            'title'     => "SK KOST",
            'user'      => $this->user_log,
            'kamar'     => array(
                'available' => $this->kamar->hitungKamar("0"),
                'sold'      => $this->kamar->hitungKamar("1"),
            ),
            'member'    => array(
                'juragan'   => $this->member->hitungMember('juragan'),
                'penghuni'  => $this->member->hitungMember('penghuni')
            ),
            'saldo'     => array(
                'available' => $this->keuangan->getSaldo("SETTLEMENT", "masuk"),
                'withdraw'  => $this->keuangan->getSaldo("SETTLEMENT", "keluar"),
                'profit'    => $this->keuangan->getProfit()
            ),
            'transaksi'        => $this->transaksi->getTransaksiAll()
        );
        $this->load->view('admin/index', $data);
    }

    public function second()
    {
        $data = array(
            'title' => "SK KOST"
        );
        $this->load->view('dist\modules-datatables.php', $data);
    }
}
