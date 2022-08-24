<?php

class Sewa extends CI_Controller
{
    var $datasess;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('member_m', 'member');
        $this->load->model('kamar_m', 'kamar');
        $this->datasess = $_SESSION['member'];
    }

    public function index()
    {
        $uid_kamar = $this->input->post('uid_kamar');
        $data = array(
            'title'     => "Form Pengajuan Sewa",
            'member'    => $this->member->getMember($this->datasess['otoritas'], $this->datasess['uid_member']),
            'kamar'     => $this->kamar->getFormKamar($uid_kamar),
            'sewa'      => array(
                'uid_kamar'             => $uid_kamar,
                'tanggal_masuk'         => $this->input->post('tanggal_masuk'),
                'durasi'                => $this->input->post('durasi')
            )
        );
        $this->load->view('_templatepublic/header', $data);
        $this->load->view('sewa', $data);
        $this->load->view('_templatepublic/footer', $data);
    }
}
