<?php

class Dashboard extends CI_Controller
{
    var $member_id;
    var $user_log;
    var $data_sess;
    public function __construct()
    {
        parent::__construct();
        isLogin();
        $this->load->model('member_m', 'member');
        $this->load->model('transaksi_m', 'transaksi');
        $this->data_sess = $this->session->userdata('member');
        $this->member_id = $this->data_sess['uid_member'];
        $this->user_log = $this->member->getMember('penghuni', $this->member_id);
        $this->user_log = array(
            'member_id'     => $this->member_id,
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
        $transaksi = $this->transaksi->gtdPenghuni($this->member_id);
        if ($transaksi) {
            $data = array(
                'title'     => 'Dashboard penghuni',
                'user'      => $this->user_log,
                'data'      => array(
                    'transaksi' => $transaksi,
                    'kamar'     => $this->transaksi->gtdkamar($transaksi['uid_kamar'])
                )
            );
        } else {
            $data = array(
                'title'     => 'Dashboard penghuni',
                'user'      => $this->user_log,
                'data'      => NULL
            );
        }
        $this->load->view('penghuni/index', $data);
    }
}
