<?php

class Durasi extends CI_Controller
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
            'title'     => 'Master data durasi kamar',
            'user'      => $this->user_log,
            'durasi'    => $this->durasi->getDurasi()
        );
        $this->load->view('admin/kamar/durasi', $data);
    }

    function getDurasi()
    {
        echo json_encode($this->durasi->getDurasi($_POST['uid_durasi']));
    }

    function addDurasi()
    {
        $data = array(
            'uid_durasi'     => '',
            'durasi'              => $_POST['durasi'],
            'nama'              => $_POST['nama']
        );
        $eksekusi = $this->durasi->addDurasi($data);
        if ($eksekusi === TRUE) {
            $response = array(
                'code'      => 200,
                'status'    => 'success',
                'message'   => 'Data master durasi berhasil ditambah!'
            );
            $this->session->set_flashdata('response', $response);
            redirect(base_url('admin/kamar/durasi'));
        } else {
            $response = array(
                'code'      => 400,
                'status'    => 'error',
                'message'   => 'Data master fasilitas gagal ditambah!'
            );
            $this->session->set_flashdata('response', $response);
            redirect(base_url('admin/kamar/durasi'));
        }
    }

    function editDurasi()
    {
        $data = array(
            'uid_durasi'     => $_POST['uid_durasi'],
            'durasi'              => $_POST['durasi'],
            'nama'              => $_POST['nama']
        );
        $eksekusi = $this->durasi->editDurasi($data, $_POST['uid_durasi']);
        if ($eksekusi === TRUE) {
            $response = array(
                'code'      => 200,
                'status'    => 'success',
                'message'   => 'Data master durasi berhasil diupdate!'
            );
            $this->session->set_flashdata('response', $response);
            redirect(base_url('admin/kamar/durasi'));
        } else {
            $response = array(
                'code'      => 400,
                'status'    => 'error',
                'message'   => 'Data master durasi gagal diupdate!'
            );
            $this->session->set_flashdata('response', $response);
            redirect(base_url('admin/kamar/durasi'));
        }
    }

    function deleteDurasi()
    {
        $eksekusi = $this->durasi->deleteDurasi($_POST['uid_durasi']);
        if ($eksekusi === TRUE) {
            $response = array(
                'code'      => 200,
                'status'    => 'success',
                'message'   => 'Data master durasi berhasil dihapus!'
            );
            echo json_encode($response);
        } else {
            $response = array(
                'code'      => 400,
                'status'    => 'error',
                'message'   => 'Data master durasi gagal dihapus!'
            );
            echo json_encode($response);
        }
    }
}
