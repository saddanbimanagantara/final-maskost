<?php

class Testimonial extends CI_Controller
{
    var $member_id;
    var $user_log;
    var $data_sess;
    public function __construct()
    {
        parent::__construct();
        isLogin();
        $this->load->model('member_m', 'member');
        $this->load->model('user_m', 'user');
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
        $data = array(
            'title'         => "Testimonial",
            'user'          => $this->user_log,
            'transaksi'     => $transaksi,
            'testimonial'   => $this->user->getTestimonial($this->user_log['member_id'], $transaksi['uid_kamar'])
        );
        $this->load->view('penghuni/testimonial', $data);
    }

    public function insert()
    {
        $check = $this->user->getTestimonial($this->user_log['member_id'], $this->input->post('uid_kamar'), $this->input->post('uid_transaksi'));
        if ($check != null) {
            $data = array(
                'uid_transaksi'     => $this->input->post('uid_transaksi'),
                'uid_kamar'         => $this->input->post('uid_kamar'),
                'uid_member'        => $this->input->post('uid_member'),
                'anonim_status'     => $this->input->post('anonim_status'),
                'bintang'           => $this->input->post('bintang'),
                'pesan'             => $this->input->post('pesan')
            );
            $this->db->where('uid_transaksi', $check['uid_transaksi']);
            $this->db->update('testimonial', $data);
            redirect('penghuni/testimonial');
        } else {
            $data = array(
                'uid_testimonial'   => '',
                'uid_transaksi'     => $this->input->post('uid_transaksi'),
                'uid_kamar'         => $this->input->post('uid_kamar'),
                'uid_member'        => $this->input->post('uid_member'),
                'anonim_status'     => $this->input->post('anonim_status'),
                'bintang'           => $this->input->post('bintang'),
                'pesan'             => $this->input->post('pesan')
            );
            $this->db->insert('testimonial', $data);
            redirect('penghuni/testimonial');
        }
    }
}
