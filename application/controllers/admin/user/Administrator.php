<?php

class Administrator extends CI_Controller
{
    var $user_log, $uid_member, $data_sess;
    public function __construct()
    {
        parent::__construct();
        isLogin();
        $this->load->model('member_m', 'member');
        $this->load->model('kamar_m', 'kamar');
        $this->load->model('user_m', 'user');
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
            'title'             => 'Master data user administrator',
            'user'              => $this->user_log,
            'uid_user'          => $this->user_log['member_id'],
            'administrator'     => $this->member->getMember('admin', null)
        );
        $this->load->view('admin/user/administrator', $data);
    }

    // crud user administrator
    // validation
    function _validation($action)
    {
        $is_unique_email = '';
        $is_unique_username = '';
        $is_required_password = '';
        if ($action === "edit") {
            $user = $this->user->getUser($_POST['uid_user'], null);
            if ($_POST['email'] != $user['email']) {
                $is_unique_email = '|is_unique[user.email]';
            } else if ($_POST['email'] === '') {
                $is_unique_email = '';
            } else if ($_POST['username'] != $user['username']) {
                $is_unique_username = '|is_unique[user.username]';
            } else if ($_POST['username'] === '') {
                $is_unique_username = '';
            } else if ($_POST['password'] === '') {
                $is_required_password = '';
            }
        } else if ($action === "add") {
            $is_unique_email = '|is_unique[user.email]';
            $is_unique_username = '|is_unique[user.username]';
            $is_required_password = 'required';
        }

        $config = array(
            array(
                'field' => 'nama',
                'label' => 'Nama',
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

    function _data($action)
    {
        date_default_timezone_set('Asia/jakarta');
        if ($action === 'add') {
            $uid_user = uuid_check(uuid_generate(), 'user', 'uid_user');
            $date_created = date('Y-m-d H:i:s');
            $date_updated = date('Y-m-d H:i:s');
            $level = 'administrator';
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        } else if ($action === 'edit') {
            $uid_user = $_POST['uid_user'];
            $date_created = $_POST['date_created'];
            $date_updated = date('Y-m-d H:i:s');
            $level = 'administrator';
            $password = ($_POST['password'] === '') ? $_POST['passwordHidden'] : password_hash($_POST['password'], PASSWORD_DEFAULT);
        }
        $pathImage = 'assets/img/profile';
        $data = array(
            'uid_user'          => $uid_user,
            'email'             => $_POST['email'],
            'username'          => $_POST['username'],
            'password'          => $password,
            'nama'              => $_POST['nama'],
            'status'            => $_POST['status'],
            'level'             => $level,
            'image'             => uploadVerification('image', $_POST['imageHidden'], $_POST['username'], $pathImage, $action),
            'date_created'      => $date_created,
            'date_updated'      => $date_updated
        );
        return $data;
    }

    public function addAdministrator()
    {
        $this->form_validation->set_rules($this->_validation('add'));
        if ($this->form_validation->run() === FALSE) {
            $response = array(
                'error'     => array(
                    'invalid-email'    => form_error('email'),
                    'invalid-nama'     => form_error('nama'),
                    'invalid-password' => form_error('password'),
                    'invalid-username' => form_error('username'),
                ),
                'code'      => 500,
                'data'      => $this->_data('add')
            );
            echo json_encode($response);
        } else {
            $data = $this->_data('add');
            $eksekusi = $this->user->addUser($data);
            if ($eksekusi === TRUE) {
                $response = array(
                    'code'      => 200,
                    'status'    => 'success',
                    'message'   => 'Data administrator berhasil ditambah'
                );
                echo json_encode($response);
            } else {
                $response = array(
                    'code'      => 400,
                    'status'    => 'error',
                    'message'   => 'Data administrator gagal ditambah'
                );
                echo json_encode($response);
            }
        }
    }

    public function getAdministrator()
    {
        echo json_encode($this->user->getUser($_POST['uid_user'], null));
    }

    public function editAdministrator()
    {
        $this->form_validation->set_rules($this->_validation('edit'));
        if ($this->form_validation->run() === FALSE) {
            $response = array(
                'error'     => array(
                    'invalid-email'    => form_error('email'),
                    'invalid-nama'     => form_error('nama'),
                    'invalid-password' => form_error('password'),
                    'invalid-username' => form_error('username'),
                ),
                'code'      => 500
            );
            echo json_encode($response);
        } else {
            $data = $this->_data('edit');
            $eksekusi = $this->user->editUser($data, $data['uid_user']);
            if ($eksekusi === TRUE) {
                $response = array(
                    'code'      => 200,
                    'status'    => 'success',
                    'message'   => 'Data administrator berhasil diedit'
                );
                echo json_encode($response);
            } else {
                $response = array(
                    'code'      => 400,
                    'status'    => 'error',
                    'message'   => 'Data administrator gagal diedit'
                );
                echo json_encode($response);
            }
        }
    }

    public function deleteAdministrator()
    {
        $eksekusi = $this->user->deleteUser($_POST['uid_user']);
        if ($eksekusi === TRUE) {
            $response = array(
                'code'      => 200,
                'status'    => 'success',
                'message'   => 'Data administrator berhasil dihapus'
            );
            echo json_encode($response);
        } else {
            $response = array(
                'code'      => 400,
                'status'    => 'error',
                'message'   => 'Data administrator gagal dihapus'
            );
            echo json_encode($response);
        }
    }
}
