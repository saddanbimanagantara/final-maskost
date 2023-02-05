<?php

class Withdraw_req extends CI_Controller
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
            'title'     => "Withdraw Request",
            'user'      => $this->user_log,
            'withdraw'  => $this->transaksi->withdraw()
        );
        $this->load->view('admin/transaksi/withdraw', $data);
    }

    public function proses()
    {
        date_default_timezone_set('Asia/jakarta');
        $uid_keuangan = $this->input->post('uid_keuangan');
        $juragan = $this->transaksi->withdraw($uid_keuangan);
        $this->db->set('status', 'SETTLEMENT');
        $this->db->set('date_proses', date('Y-m-d H:i:s'));
        $this->db->where('uid_keuangan', $uid_keuangan);
        $this->db->update('keuangan');
        $this->keuangan->tambahBukuWD($juragan[0]['saldo_withdraw'], $juragan[0]['uid_member']);
        if ($this->db->affected_rows() >= 1) {
            $message = 'Withdraw berhasil diproses sebesar ' . rupiah($juragan[0]['saldo_withdraw']) . '! <br> silakan cek rekening anda!';
            _notif($message, $juragan[0]['email'], 'Withdraw berhasil');
            $this->session->set_flashdata('notifikasi', 'proses_berhasil');
            redirect(base_url('admin/transaksi/withdraw_req/index'));
        } else {
            $this->session->set_flashdata('notifikasi', 'proses_gagal');
            redirect(base_url('admin/transaksi/withdraw_req/index'));
        }
    }

    public function getWithdraw($uid_keuangan)
    {
        $result = $this->transaksi->withdraw($uid_keuangan);
        echo json_encode($result);
    }
}
