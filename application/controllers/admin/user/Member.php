<?php

class Member extends CI_Controller
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

    public function master()
    {
        $otoritas = $this->uri->segment(5);
        $data = array(
            'title'     => 'Master data member ' . $otoritas,
            'user'      => $this->user_log,
            'otoritas'  => $otoritas,
            'member'    => $this->member->getMember($otoritas, null)
        );
        $this->load->view('admin/user/member', $data);
    }

    function _data($action)
    {
        date_default_timezone_set('Asia/jakarta');
        if ($action === 'add') {
            $uid_member = uuid_check(uuid_generate(), 'member', 'uid_member');
            $date_created = date('Y-m-d H:i:s');
            $date_updated = date('Y-m-d H:i:s');
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $saldo = 0;
            $saldo_released = 0;
        } else if ($action === 'edit') {
            $uid_member = $_POST['uid_member'];
            $date_created = $_POST['date_created'];
            $date_updated = date('Y-m-d H:i:s');
            $password = ($_POST['password'] === '') ? $_POST['passwordHidden'] : password_hash($_POST['password'], PASSWORD_DEFAULT);
            $saldo = $_POST['saldo'];
            $saldo_released = $_POST['saldo_released'];
        }

        $pathImage = 'assets/img/profile/juragan/';
        $data = array(
            'uid_member'        => $uid_member,
            'email'             => $_POST['email'],
            'username'          => $_POST['username'],
            'password'          => $password,
            'fnama'             => $_POST['fnama'],
            'lnama'             => $_POST['lnama'],
            'alamat'            => $_POST['alamat'],
            'jenis_kelamin'     => $_POST['jenis_kelamin'],
            'no_hp'             => $_POST['no_hp'],
            'image'             => uploadVerification('image', $_POST['imageHidden'], $_POST['username'], $pathImage),
            'status'            => $_POST['status'],
            'otoritas'          => $this->params,
            'saldo'             => $saldo,
            'saldo_released'    => $saldo_released,
            'date_created'      => $date_created,
            'date_updated'      => $date_updated
        );
        return $data;
    }

    // validation
    function _validation($action, $otoritas)
    {
        $is_unique_email = '';
        $is_unique_username = '';
        $is_required_password = '';
        if ($action === "edit") {
            $member = $this->member->getMember($otoritas, $_POST['uid_member']);
            if ($_POST['email'] != $member['email']) {
                $is_unique_email = '|is_unique[member.email]';
            } else if ($_POST['email'] === '') {
                $is_unique_email = '';
            } else if ($_POST['username'] != $member['username']) {
                $is_unique_username = '|is_unique[member.username]';
            } else if ($_POST['username'] === '') {
                $is_unique_username = '';
            } else if ($_POST['password'] === '') {
                $is_required_password = '';
            }
        } else if ($action === "add") {
            $is_unique_email = '|is_unique[member.email]';
            $is_unique_username = '|is_unique[member.username]';
            $is_required_password = 'required';
        }

        $config = array(
            array(
                'field' => 'fnama',
                'label' => 'Nama depan',
                'rules' => 'required',
                'errors'   => array(
                    'required'      => 'Oh tidak! %s wajib diisi.'
                )
            ),
            array(
                'field' => 'lnama',
                'label' => 'Nama akhir',
                'rules' => 'required',
                'errors'   => array(
                    'required'      => 'Oh tidak! %s wajib diisi.'
                )
            ),
            array(
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'required' . $is_unique_email,
                'errors'   => array(
                    'required'      => 'Oh tidak! %s wajib diisi.',
                    'is_unique'     => 'Email sudah terpakai!'
                )
            ),
            array(
                'field' => 'username',
                'label' => 'Username',
                'rules' => 'required' . $is_unique_username,
                'errors'   => array(
                    'required'      => 'Oh tidak! %s wajib diisi.',
                    'is_unique'     => 'Username sudah terpakai!'
                )
            ),
            array(
                'field' => 'password',
                'label' => 'Password',
                'rules' => $is_required_password,
                'errors'   => array(
                    'required'      => 'Oh tidak! %s wajib diisi.'
                )
            )
        );
        return $config;
    }
    // crud data member
    public function getMember($otoritas)
    {
        $data = $this->member->getMember($otoritas, $_POST['uid_member']);
        echo json_encode($data);
    }

    public function add($otoritas)
    {
        $action = $_POST['action'];
        $this->form_validation->set_rules($this->_validation($action, $otoritas));
        if ($this->form_validation->run() === FALSE) {
            $response = array(
                'error'     => array(
                    'invalid-email'    => form_error('email'),
                    'invalid-fnama'     => form_error('fnama'),
                    'invalid-lnama'     => form_error('lnama'),
                    'invalid-password' => form_error('password'),
                    'invalid-username' => form_error('username'),
                ),
                'code'      => 500,
            );
            echo json_encode($response);
        } else {
            $data = $this->_data($action);
            $eksekusi = $this->member->addMember($data);
            if ($eksekusi === TRUE) {
                $response = array(
                    'code'      => 200,
                    'status'    => 'success',
                    'message'   => 'Data member juragan berhasil ditambah'
                );
                echo json_encode($response);
            } else {
                $response = array(
                    'code'      => 400,
                    'status'    => 'error',
                    'message'   => 'Data member juragan gagal ditambah'
                );
                echo json_encode($response);
            }
        }
    }

    public function edit($otoritas)
    {
        $action = $_POST['action'];
        $this->form_validation->set_rules($this->_validation($action, $otoritas));
        if ($this->form_validation->run() === FALSE) {
            $response = array(
                'error'     => array(
                    'invalid-email'    => form_error('email'),
                    'invalid-fnama'     => form_error('fnama'),
                    'invalid-lnama'     => form_error('lnama'),
                    'invalid-password' => form_error('password'),
                    'invalid-username' => form_error('username'),
                ),
                'code'      => 500,
                'data'      => $this->_data($action)
            );
            echo json_encode($response);
        } else {
            $data = $this->_data($action);
            $eksekusi = $this->member->editMember($data, $data['uid_member']);
            if ($eksekusi === TRUE) {
                $response = array(
                    'code'      => 200,
                    'status'    => 'success',
                    'message'   => 'Data member juragan berhasil diedit',
                    'data'      => $this->_data($action)
                );
                echo json_encode($response);
            } else {
                $response = array(
                    'code'      => 400,
                    'status'    => 'error',
                    'message'   => 'Data member juragan gagal diedit'
                );
                echo json_encode($response);
            }
        }
    }

    public function delete()
    {
        $uid_member = $_POST['uid_member'];
        $eksekusi = $this->member->deleteMember($uid_member);
        if ($eksekusi === TRUE) {
            $response = array(
                'code'      => 200,
                'status'    => 'success',
                'message'   => 'Data member juragan berhasil dihapus'
            );
            echo json_encode($response);
        } else {
            $response = array(
                'code'      => 400,
                'status'    => 'error',
                'message'   => 'Data member juragan gagal dihapus'
            );
            echo json_encode($response);
        }
    }
}
