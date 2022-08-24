<?php

class Fasilitas extends CI_Controller
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

    function index()
    {
        $data = array(
            'title'     => 'Master data fasilitas kamar',
            'fasilitas' => $this->fasilitas->getFasilitas(),
            'user'      => $this->user_log,
        );
        $this->load->view('admin/kamar/fasilitas', $data);
    }

    function getFasilitas()
    {
        echo json_encode($this->fasilitas->getFasilitas($_POST['uid_fasilitas']));
    }

    function addFasilitas()
    {
        $data = array(
            'uid_fasilitas'     => '',
            'nama'              => $_POST['nama'],
            'icon'              => $_POST['icon']
        );
        $eksekusi = $this->fasilitas->addFasilitas($data);
        if ($eksekusi === TRUE) {
            $response = array(
                'code'      => 200,
                'status'    => 'success',
                'message'   => 'Data master fasilitas berhasil ditambah!'
            );
            $this->session->set_flashdata('response', $response);
            redirect(base_url('admin/kamar/fasilitas'));
        } else {
            $response = array(
                'code'      => 400,
                'status'    => 'error',
                'message'   => 'Data master fasilitas gagal ditambah!'
            );
            $this->session->set_flashdata('response', $response);
            redirect(base_url('admin/kamar/fasilitas'));
        }
    }

    function editFasilitas()
    {
        $data = array(
            'uid_fasilitas'     => $_POST['uid_fasilitas'],
            'nama'              => $_POST['nama'],
            'icon'              => $_POST['icon']
        );
        $eksekusi = $this->fasilitas->editFasilitas($data, $_POST['uid_fasilitas']);
        if ($eksekusi === TRUE) {
            $response = array(
                'code'      => 200,
                'status'    => 'success',
                'message'   => 'Data master fasilitas berhasil diupdate!'
            );
            $this->session->set_flashdata('response', $response);
            redirect(base_url('admin/kamar/fasilitas'));
        } else {
            $response = array(
                'code'      => 400,
                'status'    => 'error',
                'message'   => 'Data master fasilitas gagal diupdate!'
            );
            $this->session->set_flashdata('response', $response);
            redirect(base_url('admin/kamar/fasilitas'));
        }
    }

    function deleteFasilitas()
    {
        $eksekusi = $this->fasilitas->deleteFasilitas($_POST['uid_fasilitas']);
        if ($eksekusi === TRUE) {
            $response = array(
                'code'      => 200,
                'status'    => 'success',
                'message'   => 'Data master fasilitas berhasil dihapus!'
            );
            echo json_encode($response);
        } else {
            $response = array(
                'code'      => 400,
                'status'    => 'error',
                'message'   => 'Data master fasilitas gagal dihapus!'
            );
            echo json_encode($response);
        }
    }
}
