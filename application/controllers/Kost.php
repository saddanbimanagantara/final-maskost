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
                'otoritas'      => $this->user_log['otoritas'],
                'jenis_kelamin' => $this->user_log['jenis_kelamin']
            );
        }

        get_instance()->load->helper('kamar_helper', 'changer_helper');
    }

    public function list()
    {
        $this->load->view('_templatepublic/header');
        $this->load->view('kost');
        $this->load->view('_templatepublic/footer');
    }

    public function jsonKamar($rowno = 0)
    {

        $this->load->library('pagination');
        $jumlah_data = $this->kamar->jumlah_data();
        $config['base_url'] = base_url() . 'kost/list';
        $config['total_rows'] = $jumlah_data;
        $config['per_page'] = 8;
        // Row position
        if ($rowno != 0) {
            $rowno = ($rowno - 1) * $config['per_page'];
        }
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
        // filtering
        $postkey = array_keys(@$_POST);
        $data_fasilitas = $this->kamar->getFasilitas();
        $data_durasi = $this->kamar->getDurasi();
        $data_kategori = $this->kamar->getKategori();
        $filter_fasilitas = array();
        $filter_durasi = array();
        $filter_kategori = array();
        foreach ($postkey as $key => $value) {
            $uid_fasilitas = str_replace('uid_fasilitas', '', @$postkey[$key]);
            $uid_durasi = str_replace('uid_durasi', '', @$postkey[$key]);
            $uid_kategori = str_replace('uid_kategori', '', @$postkey[$key]);
            foreach ($data_fasilitas as $fasilitas) {
                $row = array();
                if ($uid_fasilitas == $fasilitas['uid_fasilitas'])
                    $row[] = $fasilitas['uid_fasilitas'];
                $filter_fasilitas[] = $row;
            }
            foreach ($data_durasi as $durasi) {
                $row = array();
                if ($uid_durasi == $durasi['uid_durasi'])
                    $row[] = $durasi['uid_durasi'];
                $filter_durasi[] = $row;
            }
            foreach ($data_kategori as $kategori) {
                $row = array();
                if ($uid_kategori == $kategori['uid_kategori'])
                    $row[] = $kategori['uid_kategori'];
                $filter_kategori[] = $row;
            }
        }
        $filter = array(
            'fasilitas' => array_filter($filter_fasilitas),
            'durasi'    => array_filter($filter_durasi),
            'kategori'  => array_filter($filter_kategori)
        );
        // data send
        $data['pagination'] = $this->pagination->create_links();
        $data['kamar'] = $this->kamar->get($config['per_page'], $from, $filter);
        $data['fasilitaskamar'] = $this->kamar->getFasilitas();
        $data['filter'] = $filter;
        $data['row'] = $rowno;

        echo json_encode($data);
    }

    public function test()
    {
        $this->db->select('kamar_kost.uid_kamar, (SELECT COUNT(transaksi.uid_transaksi) FROM transaksi JOIN transaksi_detail ON transaksi.uid_transaksi=transaksi_detail.uid_transaksi WHERE transaksi.jenis="baru" AND transaksi_detail.status="huni" AND transaksi_detail.uid_kamar=kamar_kost.uid_kamar) as jumlah', FALSE);
        $this->db->from('kamar_kost');
        $data = $this->db->get()->result_array();
        echo json_encode($data);
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
        $data['fasilitaskamar'] = $this->kamar->getFasilitas(null, null);
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
        $data['f_umum'] = $this->kamar->getFasilitas('umum');
        $data['f_kamar'] = $this->kamar->getFasilitas('kamar');
        $data['f_kamar_mandi'] = $this->kamar->getFasilitas('kamar mandi');
        $data['f_parkiran'] = $this->kamar->getFasilitas('parkiran');
        $data['review'] = $this->kamar->getReview($uid_kamar['uid_kamar']);
        $data['member'] = $this->user_log;
        if ($this->session->has_userdata('member')) {
            $data['tx'] = $this->transaksi->getStatus($data['kamar']['uid_kamar']);
        }

        $this->load->view('_templatepublic/header');
        $this->load->view('detail', $data);
        $this->load->view('_templatepublic/footer');
    }


    public function juragan($username)
    {
        $juragan = $this->member->getinfo($username);
        $data = array(
            'title'    => 'Daftar kamar',
            'juragan'   => $juragan,
            'username'  => $username
        );
        $this->load->view('_templatepublic/header');
        $this->load->view('juragan', $data);
        $this->load->view('_templatepublic/footer');
    }
}
