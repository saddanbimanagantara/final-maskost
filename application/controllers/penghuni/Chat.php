<?php

class Chat extends CI_Controller
{
    var $data_sess, $uid_member, $user_log, $kamarPenghuni;
    public function __construct()
    {
        parent::__construct();
        isLogin();
        $this->load->model('member_m', 'member');
        $this->load->model('chat_m', 'chat');
        $this->load->model('kamar_m', 'kamar');
        $this->data_sess = $this->session->userdata('member');
        $this->uid_member = $this->data_sess['uid_member'];
        $this->user_log = $this->member->getMember($this->data_sess['otoritas'], $this->uid_member);
        $this->kamarPenghuni = $this->member->getKamarMember($this->uid_member);
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
            'title'     => "Chat",
            'user'      => $this->user_log
        );
        $this->load->view('chat', $data);
    }

    public function test()
    {
        $data = $this->chat->getChat($this->user_log['member_id']);
        echo json_encode($data);
    }

    public function getPengirim()
    {
        $data = $this->chat->getChat($this->user_log['member_id']);
        $chat = "";
        foreach ($data as $data) {
            if ($data['uid_pengirim'] === $this->uid_member) {
            } else {
                $chatarea = base_url($this->user_log['otoritas'] . '/chat/area/' . $data['uid_member']);
                $image = base_url('assets/img/profile/') . $data['otoritas'] . '/' . $data['image'];
                if (isset($this->kamarPenghuni['nama'])) {
                    $nama_kamar = 'Juragan anda';
                } else if ($data['nama'] === null) {
                    $nama_kamar = 'Calon juragan';
                } else {
                    $nama_kamar = 'Penghuni ' . $data['nama'];
                }
                $chat .= '<li class="media mt-1" id="media" data-chatid="' . $chatarea . '">
                        <figure class="avatar mr-3 avatar-lg">
                            <img src="' . $image . '" alt="">
                        </figure>
                        <div class="media-body">
                            <div class="mt-0 mb-1 font-weight-bold">' . $data['fnama'] . ' ' . $data['lnama'] . ' - ' . $nama_kamar . '</div>
                            <div class="text-small font-600-bold"><i class="fa-solid fa-message"></i>
                                ' . $data['message'] . '
                            </div>
                            <div class="text-small font-600-bold"><i class="fa-solid fa-clock"></i>
                                ' . $data['time'] . '
                            </div>
                            <a href="' . $chatarea . '" class="btn btn-sm btn-primary">Kirim pesan</a>
                        </div>
                    </li>';
            }
        }
        echo $chat;
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
        $terkirim = $this->chat->insertChat($data);
        $pesan = $this->input->post('message');
        $email = $this->input->post('email');
        if ($terkirim === true) {
            _notif($pesan, $email, "Ada pesan baru - MasKost");
            echo json_encode("terkirim");
        } else {
            echo json_encode("tidak terkirim");
        }
    }

    public function getChat()
    {
        $chat = $this->chat->getChatMsg($this->user_log['member_id'], $this->user_log['member_id']);
        $penerima = $this->chat->getPenerima($this->uri->segment(4));
        $chatBox = "";
        foreach ($chat as $chat) {
            $position = ($chat['uid_penerima'] === $this->uid_member) ? "left" : "right";
            $image = ($chat['uid_penerima'] === $this->uid_member) ? base_url() . "assets/img/profile/" . $penerima['otoritas'] . "/" . $penerima['image'] : base_url() . "assets/img/profile/" . $this->user_log['otoritas'] . "/" . $this->user_log['image'];
            $chatBox .= '<div class="chat-item chat-' . $position . '">
                        <img src="' . $image . '">
                            <div class="chat-details">
                                <div class="chat-text">' . $chat['message'] . '</div>
                                <div class="chat-time">' . $chat['time'] . '</div>
                            </div>
                        </div>';
        }
        echo $chatBox;
    }

    public function getPenghuni()
    {
        $nama = $this->input->post('nama');
        $getPenghuni = $this->chat->getPenghuni($this->user_log['member_id'], $nama);
        echo json_encode($getPenghuni);
    }
}
