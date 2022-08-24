<?php

class Kategori extends CI_Controller
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

    // master data kategori kamar
    function getKategori()
    {
        $uid_kategori = $_POST['uid_kategori'];
        echo json_encode($this->kategori->getKategori($uid_kategori));
    }
    function index()
    {
        $data = array(
            'title'     => 'Master data kategori',
            'kategori'  => $this->kategori->getKategori(),
            'user'      => $this->user_log,
        );
        $this->load->view('admin/kamar/kategori', $data);
    }
    function editKategori()
    {
        $data = array(
            'uid_kategori'      => $_POST['uid_kategori'],
            'nama_kategori'     => $_POST['nama_kategori'],
            'icon_kategori'     => $_POST['icon_kategori']
        );
        $eksekusi = $this->kategori->editKategori($data, $_POST['uid_kategori']);
        if ($eksekusi === TRUE) {
            $response = array(
                'code'      => 200,
                'status'    => 'success',
                'message'   => 'Data kategori berhasil diedit'
            );
            $this->session->set_flashdata('response', $response);
            redirect(base_url('admin/kamar/kategori/'));
        } else {
            $response = array(
                'code'      => 400,
                'status'    => 'error',
                'message'   => 'Data kategori gagal diedit'
            );
            $this->session->set_flashdata('response', $response);
            redirect(base_url('admin/kamar/kategori/'));
        }
    }

    function addKategori()
    {
        $data = array(
            'uid_kategori'      => '',
            'nama_kategori'     => $_POST['nama_kategori'],
            'icon_kategori'     => $_POST['icon_kategori']
        );
        $eksekusi = $this->kategori->addKategori($data);
        if ($eksekusi === TRUE) {
            $response = array(
                'code'      => 200,
                'status'    => 'success',
                'message'   => 'Data kategori berhasil ditambah'
            );
            $this->session->set_flashdata('response', $response);
            redirect(base_url('admin/kamar/kategori/'));
        } else {
            $response = array(
                'code'      => 400,
                'status'    => 'error',
                'message'   => 'Data kategori gagal ditambah'
            );
            $this->session->set_flashdata('response', $response);
            redirect(base_url('admin/kamar/kategori/'));
        }
    }

    function deleteKategori()
    {
        $eksekusi = $this->kategori->deleteKategori($_POST['uid_kategori']);
        if ($eksekusi === TRUE) {
            $response = array(
                'code'      => 200,
                'status'    => 'success',
                'message'   => 'Data kategori berhasil dihapus'
            );
            echo json_encode($response);
        } else {
            $response = array(
                'code'      => 400,
                'status'    => 'error',
                'message'   => 'Data kategori gagal dihapus'
            );
            echo json_encode($response);
        }
    }
}
