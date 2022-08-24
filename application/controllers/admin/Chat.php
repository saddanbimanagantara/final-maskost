<?php

class Chat extends CI_Controller
{
    var $data_sess, $uid_member, $user_log;
    public function __construct()
    {
        parent::__construct();
        isLogin();
        $this->load->model('member_m', 'member');
        $this->load->model('chat_m', 'chat');
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

    public function index($params)
    {
        $otoritas = $this->uri->segment(3);
        $chat = $this->chat->getChat(null, $$params);
        $data = array(
            'title'     => "Daftar Chat",
            'user'      => $this->user_log,
            'list_user' => $chat
        );
        echo json_encode($data);
        die;
        $this->load->view('chat', $data);
    }

    public function juragan()
    {
        $member = $this->chat->getMember('juragan');
        $chat = $this->chat->getChat("juragan", $member);
        $memberchat = $this->chat->getMemberChat($chat);
        $data = array(
            'title'     => "Daftar Chat",
            'user'      => $this->user_log,
            'list_user' => $memberchat
        );
        $this->load->view('chat', $data);
    }

    public function penghuni()
    {
        $member = $this->chat->getMember('penghuni');
        $chat = $this->chat->getChat("penghuni", $member);
        $memberchat = $this->chat->getMemberChat($chat);
        $data = array(
            'title'     => "Daftar Chat",
            'user'      => $this->user_log,
            'list_user' => $memberchat
        );
        $this->load->view('chat', $data);
    }

    public function area()
    {
        $uid_member_penghuni = $this->uri->segment(4);
        if ($uid_member_penghuni) {
            $penerima = $this->chat->getPenerima($uid_member_penghuni);
            $data = array(
                'title'         => "Chat dengan ",
                'user'          => $this->user_log,
                'penerima'      => $penerima
            );
            $this->load->view('chatarea', $data);
        } else {
            redirect('juragan/chat');
        }
    }

    public function kirimpesan()
    {
        $data = array(
            'uid_penerima'      => $this->input->post('uid_penerima'),
            'uid_pengirim'      => $this->input->post('uid_pengirim'),
            'message'           => $this->input->post('message')
        );
        $email = $this->input->post('email');
        $pesan = $this->input->post('message');
        $terkirim = $this->chat->insertChat($data);
        if ($terkirim === true) {
            _notif($pesan, $email, "Ada pesan baru - MasKost");
            echo json_encode("terkirim");
        } else {
            echo json_encode("tidak terkirim");
        }
    }
}
