<?php

class Kost extends CI_Controller
{
    var $data_sess, $uid_member, $user_log;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('kamar_m', 'kamar');
        $this->load->model('member_m', 'member');
        $this->load->model('transaksi_m', 'transaksi');
        isLogin();
        if ($this->session->has_userdata('member')) {
            $this->data_sess = $this->session->userdata('member');
            $this->uid_member = $this->data_sess['uid_member'];
            $this->user_log = $this->member->getMember($this->data_sess['otoritas'], $this->uid_member);
            $this->user_log = array(
                'member_id'     => $this->uid_member,
                'email'         => $this->user_log['email'],
                'fnama'         => $this->user_log['fnama'],
                'lnama'         => $this->user_log['lnama'],
                'image'         => $this->user_log['image'],
                'otoritas'      => $this->user_log['otoritas']
            );
        }

        get_instance()->load->helper('kamar_helper', 'changer_helper');
    }

    public function list()
    {
        $this->load->library('pagination');
        $jumlah_data = $this->kamar->jumlah_data();
        $config['base_url'] = base_url() . 'kost/list';
        $config['total_rows'] = $jumlah_data;
        $config['per_page'] = 4;
        // styling pagination
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = "<li class='page-link'>";
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active" style="text-decoration:none"><a href="#" class="page-link bg-primary text-white">';
        $config['cur_tag_close'] = '</a></li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['first_tag_open'] = "<li class='page-link'>";
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = "<li class='page-link'>";
        $config['last_tag_close'] = '</li>';
        $config['prev_link'] = '<i class="fa fa-long-arrow-left"></i>Sebelumnya';
        $config['prev_tag_open'] = "<li class='page-link'>";
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'selanjutnya <i class="fa fa-long-arrow-right"></i>';
        $config['next_tag_open'] = "<li class='page-link'>";
        $config['next_tag_close'] = '</li>';
        $from = $this->uri->segment(3);
        $this->pagination->initialize($config);
        $data['kamar'] = $this->kamar->get($config['per_page'], $from, null, null);
        $data['fasilitaskamar'] = $this->kamar->getFasilitas();
        $this->load->view('_templatepublic/header');
        $this->load->view('kost', $data);
        $this->load->view('_templatepublic/footer');
    }

    public function cari()
    {
        $kategori = $this->input->post('kategori');
        $kota = $this->input->post('kota');
        $this->load->library('pagination');
        $jumlah_data = $this->kamar->jumlah_data($kategori, $kota);
        $config['base_url'] = base_url() . 'kost/cari';
        $config['total_rows'] = $jumlah_data;
        $config['per_page'] = 4;
        // styling pagination
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = "<li class='page-link'>";
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active" style="text-decoration:none"><a href="#" class="page-link bg-primary text-white">';
        $config['cur_tag_close'] = '</a></li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['first_tag_open'] = "<li class='page-link'>";
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = "<li class='page-link'>";
        $config['last_tag_close'] = '</li>';
        $config['prev_link'] = '<i class="fa fa-long-arrow-left"></i>Sebelumnya';
        $config['prev_tag_open'] = "<li class='page-link'>";
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'selanjutnya <i class="fa fa-long-arrow-right"></i>';
        $config['next_tag_open'] = "<li class='page-link'>";
        $config['next_tag_close'] = '</li>';
        $from = $this->uri->segment(3);
        $this->pagination->initialize($config);
        $data['kamar'] = $this->kamar->get($config['per_page'], $from, $kategori, $kota);
        $data['fasilitaskamar'] = $this->kamar->getFasilitas();
        $this->load->view('_templatepublic/header');
        $this->load->view('kost', $data);
        $this->load->view('_templatepublic/footer');
    }



    public function getKamar()
    {
        $uid_kamar = $_POST['uid_kamar'];
        $data = array(
            'kamar'     =>  $this->kamar->getUidKamar($uid_kamar),
            'keterangan' => 'success'
        );
        echo json_encode($data);
    }

    public function getUidkamar($url_title)
    {
        return $this->kamar->getUidKamarCV($url_title);
    }

    public function kamar($url_title)
    {
        $uid_kamar = $this->getUidkamar($url_title);
        $data['kamar'] = $this->kamar->getDetail($url_title);
        $data['durasikamar'] = $this->kamar->getDurasi();
        $data['fasilitaskamar'] = $this->kamar->getFasilitas();
        $data['review'] = $this->kamar->getReview($uid_kamar['uid_kamar']);
        $data['member'] = $this->user_log;
        if ($this->session->has_userdata('member')) {
            $data['tx'] = $this->transaksi->getStatus($this->uid_member);
        }
        $this->load->view('_templatepublic/header');
        $this->load->view('detail', $data);
        $this->load->view('_templatepublic/footer');
    }
}
