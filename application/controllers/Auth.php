<?php

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('member_m', 'member');
        $this->load->helper('account_helper');
    }

    function _data($role)
    {
        date_default_timezone_set('Asia/jakarta');

        $pathImage = 'assets/img/profile/juragan/';
        $data = array(
            'uid_member'        => uuid_check(uuid_generate(), 'member', 'uid_member'),
            'email'             => $_POST['email'],
            'username'          => $_POST['username'],
            'password'          => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'fnama'             => $_POST['fnama'],
            'lnama'             => $_POST['lnama'],
            'alamat'            => $_POST['alamat'],
            'jenis_kelamin'     => $_POST['jenis_kelamin'],
            'no_hp'             => $_POST['no_hp'],
            'image'             => 'avatar-1.png',
            'status'            => 0,
            'otoritas'          => $role,
            'saldo'             => 0,
            'saldo_released'    => 0,
            'date_created'      => date('Y-m-d H:i:s'),
            'date_updated'      => date('Y-m-d H:i:s')
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
        } else if ($action === "singup") {
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
            ),
            array(
                'field' => 'password-confirm',
                'label' => 'password konfirmasi',
                'rules' => 'required|matches[password]',
                'errors' => array(
                    'required'      => 'Oh tidak! %s wajib diisi',
                    'matches'       => 'Oh tidak! %s tidak sama'
                )
            ),
            array(
                'field' => 'alamat',
                'label' => 'alamat',
                'rules' => 'required',
                'errors' => array(
                    'required'      => 'Oh tidak! %s wajib diisi'
                )
            ),
            array(
                'field' => 'no_hp',
                'label' => 'no hp',
                'rules' => 'required',
                'errors' => array(
                    'required'      => 'Oh tidak! %s wajib diisi'
                )
            )
        );
        return $config;
    }

    public function singup()
    {
        $data = array(
            'title'     => "Pendaftaran penghuni kost"
        );
        $action = "singup";
        $this->form_validation->set_rules($this->_validation($action, 'penghuni'));
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('auth/singup', $data);
        } else {
            $data = $this->_data('penghuni');

            // data token
            $token = bin2hex(random_bytes(32));
            $user_token = [
                'email'         => $data['email'],
                'token'         => $token,
                'date_created'  => time()
            ];

            // eksekusi data
            $eksekusi = $this->member->addMember($data);
            $this->db->insert('member_token', $user_token);
            if ($eksekusi === TRUE) {
                $title = array(
                    'title'     => 'Pendaftaran Juragan - Mas Kost'
                );
                $this->_sendEmail($user_token, 'verify');
                $this->session->set_flashdata('notifikasi', 'pendaftaran_berhasil');
                $this->load->view('auth/singup', $title);
            } else {
                $title = array(
                    'title'     => 'Pendaftaran Juragan - Mas Kost'
                );
                $this->session->set_flashdata('notifikasi', 'pendaftaran_gagal');
                $this->load->view('auth/singup', $title);
            }
        }
    }

    public function singupjuragan()
    {
        $data = array(
            'title'     => 'Pendaftaran Juragan - Mas Kost'
        );
        $action = "singup";
        $this->form_validation->set_rules($this->_validation($action, 'juragan'));
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('auth/singup-juragan', $data);
        } else {
            $data = $this->_data('juragan');
            // data token
            $token = bin2hex(random_bytes(32));
            $user_token = [
                'email'         => $data['email'],
                'token'         => $token,
                'date_created'  => time()
            ];

            // eksekusi data
            $eksekusi = $this->member->addMember($data);
            $this->db->insert('member_token', $user_token);
            if ($eksekusi === TRUE) {
                $title = array(
                    'title'     => 'Pendaftaran Juragan - Mas Kost'
                );
                $this->_sendEmail($user_token, 'verify');
                $this->session->set_flashdata('notifikasi', 'pendaftaran_berhasil');
                $this->load->view('auth/singup-juragan', $title);
            } else {
                $title = array(
                    'title'     => 'Pendaftaran Juragan - Mas Kost'
                );
                $this->session->set_flashdata('notifikasi', 'pendaftaran_gagal');
                $this->load->view('auth/singup-juragan', $title);
            }
        }
    }

    private function _sendEmail($token, $type)
    {
        $config = [
            'protocol'      => 'smtp',
            'smtp_host'     => 'ssl://smtp.googlemail.com',
            'smtp_user'     => 'maskostci@gmail.com',
            'smtp_pass'     => 'mwfzooxhupbrsjav',
            'smtp_port'     => 465,
            'mailtype'      => 'html',
            'charset'       => 'utf-8',
            'newline'       => "\r\n"
        ];

        $this->load->library('email', $config);
        $this->email->initialize($config);
        $this->email->from('maskostci@gmail.com', 'Mas Kost');
        $this->email->to($token['email']);
        $this->email->subject('Aktivisasi Akun MasKost');
        $this->email->message('Click link to verify your account : <a href="' . base_url() . 'auth/verify?email=' . $token['email'] . '&token=' . $token['token'] . '">Activate</a>');
        if ($this->email->send()) {
            return true;
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }

    public function verify()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $member = $this->db->get_where('member', array('email' => $email))->row_array();
        $user_token = $this->db->get_where('member_token', array('token' => $token))->row_array();
        if ($member) {
            if ($user_token) {
                // aktif member
                $this->db->set('status', 'aktif');
                $this->db->where('email', $email);
                $this->db->update('member');
                // delete token
                $this->db->delete('member_token', array('email' => $email));
                $this->session->set_flashdata('notifikasi', 'verifikasi_berhasil');
                $this->login();
            } else {
                $data = array(
                    'title'     => '403 - You do not have access this page',
                    'response'  => 'Your token invalid or already used'
                );
                $this->load->view('dist/errors-403', $data);
            }
        } else {
            $data = array(
                'title'     => '403 - You do not have access this page',
                'response'  => 'Your email invalid or not registed in this site'
            );
            $this->load->view('dist/errors-403', $data);
        }
    }

    private function _loginFormValidation()
    {
        $config = array(
            array(
                'field'     => 'email',
                'label'     => 'Email',
                'rules'     => 'required|valid_email|trim',
                'errors'    => array(
                    'required'      => 'Alamat %s harus diisi',
                    'valid_email'   => 'Alamat %s harus valid'
                )
            ),
            array(
                'field'     => 'password',
                'label'     => 'Password',
                'rules'     => 'required',
                'errors'    => array(
                    'required'      => '%s harus diisi'
                )
            )
        );
        return $config;
    }

    public function login()
    {
        if ($this->session->userdata('member')) {
            $member = $this->session->userdata('member');
            redirect(base_url($member['otoritas'] . '/dashboard'));
        }
        $data = array(
            'title'     => 'Login - Mas Kost'
        );
        $this->load->view('auth/auth-login.php', $data);
        $this->form_validation->set_rules($this->_loginFormValidation());
        if ($this->form_validation->run()) {
            // login verifikasi
            $login_data = $this->_loginverifikasi();
            if ($login_data['password'] === true) {
                // set session
                $data = array(
                    'member'        => array(
                        'uid_member'    => $login_data['member']['uid_member'],
                        'fnama'         => $login_data['member']['fnama'],
                        'lnama'         => $login_data['member']['lnama'],
                        'otoritas'      => $login_data['member']['otoritas']
                    ),
                    'login'         => true
                );
                if ($data['member']['otoritas'] === "juragan") {
                    $this->session->set_userdata($data);
                    $this->session->set_flashdata('notifikasi', 'Login_berhasil');
                    redirect(base_url('juragan/dashboard'));
                } else if ($data['member']['otoritas'] === "penghuni") {
                    $this->session->set_userdata($data);
                    $this->session->set_flashdata('notifikasi', 'Login_berhasil');
                    redirect(base_url('penghuni/dashboard'));
                } else if ($data['member']['otoritas'] === "admin") {
                    $this->session->set_userdata($data);
                    $this->session->set_flashdata('notifikasi', 'Login_berhasil');
                    redirect(base_url('admin/dashboard'));
                }
            } else {
                $this->session->set_flashdata('notifikasi', 'login_gagal');
                redirect(base_url('auth/login'));
            }
        }
    }

    private function _loginverifikasi()
    {
        $member = $this->db->get_where('member', array('email' => $this->input->post('email')))->row_array();

        if ($member) {
            // check password
            if (password_verify($this->input->post('password'), $member['password'])) {
                $data = array(
                    'member'    => $member,
                    'password'  => true
                );
                return $data;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url('auth/login'));
        $this->session->set_flashdata('notifikasi', 'logout_berhasil');
    }

    public function forgetpassword()
    {
        $this->form_validation->set_rules('email', 'Email', 'required', array('required' => '%s harus diisi!'));
        if (!$this->form_validation->run()) {
            $data['title']  = 'Lupa password - Mas Kost';
            $this->load->view('auth/forgetpassword', $data);
        } else {
            $email = $this->input->post('email');
            $token = bin2hex(random_bytes(36));
            $member_token = $this->db->insert('member_token', array('uid' => '', 'email' => $email, 'token' => $token, 'date_created' => time()));
            if ($member_token === TRUE) {
                $pesan = 'Silahkan klik link berikut untuk lupa password akun anda <a href="' . base_url('auth/forgetpasswordverif?token=') . $token . '">Lupa password</a>';
                $subject = 'Lupa password - Maskost';
                $sendemail = _notif($pesan, $email, $subject);
                if ($sendemail === TRUE) {
                    $data['title'] = "Lupa password - Mas Kost";
                    $this->session->set_flashdata('notifikasi', 'forgetpasswordsend_success');
                    $this->load->view('auth/forgetpassword', $data);
                } else {
                    $data['title'] = "Lupa password - Mas Kost";
                    $this->session->set_flashdata('notifikasi', 'forgetpasswordsend_error');
                    $this->load->view('auth/forgetpassword', $data);
                }
            }
        }
    }

    public function forgetpasswordverif()
    {
        $token = $_GET['token'];
        $this->form_validation->set_rules('email', 'Email', 'required', array('%s harus diisi!'));
        $this->form_validation->set_rules(
            'password',
            'Password',
            'required|min_length[8]',
            array(
                'required' => '%s harus diisi!',
                'min_length' => '%s minimal 8 karakter'
            )
        );
        $this->form_validation->set_rules(
            'passwordrepeat',
            'Password',
            'required|min_length[8]|matches[password]',
            array(
                'required' => '%s harus diisi!',
                'min_length' => '%s minimal 8 karakter!',
                'matches'   => '%s password tidak sama!'
            )
        );
        if (!$this->form_validation->run()) {
            $data['title']  = 'Lupa password verifikasi - Mas Kost';
            $this->load->view('auth/forgetpasswordverif', $data);
        } else {
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $passwordrepeat = $this->input->post('passwordrepeat');
            $validation_token = $this->db->get_where('member_token', array('email' => $email, 'token' => $token))->row_array();
            if ($validation_token != null) {
                $this->db->set('password', password_hash($password, PASSWORD_DEFAULT));
                $this->db->where('email', $email);
                $member_update = $this->db->update('member');
                if ($member_update === TRUE) {
                    $this->db->delete('member_token', array('token' => $token));
                    $this->session->set_flashdata('notifikasi', 'forgetpassword_success');
                    redirect(base_url('auth/login'));
                } else {
                    $this->session->set_flashdata('notifikasi', 'forgetpassword_error');
                    $data['title']  = 'Lupa password verifikasi - Mas Kost';
                    $this->load->view('auth/forgetpasswordverif', $data);
                }
            } else {
                $this->session->set_flashdata('notifikasi', 'token_or_email_invalid');
                $data['title']  = 'Lupa password verifikasi - Mas Kost';
                $this->load->view('auth/forgetpasswordverif', $data);
            }
        }
    }

    public function blocked()
    {
        $data = array(
            'title'     => '403 - You do not have access this page',
            'response'  => 'Your email invalid or not registed in this site'
        );
        $this->load->view('dist/errors-403', $data);
    }
}
