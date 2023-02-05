<?php

class Profit extends CI_Controller
{
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
            'title' => 'Profit Website',
            'user'  => $this->user_log,
            'profit'    => $this->db->get('profit')->result_array(),
            'totalprofit' => $this->db->select_sum('jumlah_profit')->from('profit')->get()->row_array(),
            'profit_set' => $this->db->get_where('profit_set', array('set_profit_id', 1))->row_array()
        );
        $this->load->view('admin/profit', $data);
    }

    public function setProfit()
    {
        $nominal = $this->input->post('nominal');
        $this->db->where('set_profit_id', 1);
        $this->db->set('gross_amount', $nominal);
        $this->db->update('profit_set');
        $response = array(
            'code'      => 200,
            'status'    => 'success',
            'message'   => 'Berhasil setting profit website!'
        );
        $this->session->set_flashdata('response', $response);
        redirect(base_url('admin/profit'));
    }
}
