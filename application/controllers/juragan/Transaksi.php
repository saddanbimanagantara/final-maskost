<?php

class Transaksi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        isLogin();
        $this->load->model('kamar_m', 'kamar');
        $this->load->model('transaksi_m', 'transaksi');
        $this->load->model('member_m', 'member');
        $this->load->model('durasi_kamar_m', 'durasi');
        $this->load->model('fasilitas_kamar_m', 'fasilitas');
        $this->load->model('kategori_kamar_m', 'kategori');
        $this->load->helper('account_helper', 'kamar_helper', 'transaksi_helper');
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
        $data = array(
            'title'     => 'Data transaksi kamar',
            'user'      => $this->member->getMember('juragan', $this->uid_member),
            'transaksi' => $this->transaksi->getTransaksi($this->uid_member, 'baru', null)
        );
        $this->load->view('juragan/transaksi/index', $data);
    }

    public function pembayaran($uid_transaksi)
    {
        $data = array(
            'title'     => 'Data pembayaran dan Perpanjangan',
            'user'      => $this->user_log,
            'transaksi' => $this->transaksi->getTransaksi($this->uid_member, null, $uid_transaksi),
        );
        $this->load->view('juragan/transaksi/pembayaran', $data);
    }

    public function update_status($uid_transaksi)
    {
        $this->transaksi->updatetransaksi($uid_transaksi);
        echo json_encode(true);
    }

    public function dataperpanjang($uid_transaksi)
    {
        $data = array(
            'title'                 => 'Data transaksi perpanjang - ' . $uid_transaksi,
            'user'                  => $this->user_log,
            'transaksi_perpanjang'  => $this->transaksi->getDataTransaksiPerpanjang($uid_transaksi)
        );
        echo json_encode($data['transaksi_perpanjang']);
    }

    public function detail($uid_transaksi)
    {
        $data = array(
            'title'     => 'Detail ' . $uid_transaksi,
            'user'      => $this->member->getMember('juragan', $this->uid_member),
            'transaksi' => $this->transaksi->getDetailTransaksi($uid_transaksi)
        );
        $this->load->view('juragan/transaksi/detail', $data);
    }
}
