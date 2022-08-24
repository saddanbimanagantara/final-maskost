<?php

class Profile extends CI_Controller
{
    var $data_sess, $uid_member, $user_log;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('member_m', 'member');
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
        isLogin();
    }

    public function index()
    {
        $data = array(
            'title'         => "Profile",
            'user'          => $this->user_log,
            'member'        => $this->member->getMember($this->data_sess['otoritas'], $this->uid_member)
        );
        $this->load->view('profile', $data);
    }

    public function edit()
    {
        $data = array(
            'fnama'     => $this->input->post('fnama'),
            'lnama'     => $this->input->post('lnama'),
            'no_hp'     => $this->input->post('no_hp'),
            'alamat'    => $this->input->post('alamat')
        );
        date_default_timezone_set('Asia/jakarta');
        $this->db->set('date_updated', date('Y-m-d H:i:s'));
        $this->db->where('uid_member', $this->user_log['member_id']);
        $this->db->update('member', $data);
        if ($this->db->affected_rows() >= 1) {
            $this->session->set_flashdata('message', 'Berhasil update profil');
            $this->session->set_flashdata('icon', 'success');
            redirect('profile');
        } else {
            $this->session->set_flashdata('message', 'Gagal update profil');
            $this->session->set_flashdata('icon', 'error');
            redirect('profile');
        }
    }


    function do_upload()
    {
        date_default_timezone_set('Asia/jakarta');
        $config['upload_path'] = FCPATH . "assets/img/profile/" . $this->user_log['otoritas'] . '/';
        $config['allowed_types'] = 'jpg|png';
        $filename = $_FILES["imageUpload"]["name"];
        $file_ext = pathinfo($filename, PATHINFO_EXTENSION);
        $filename = $this->user_log['member_id'] . '.' . $file_ext;
        $config['file_name'] = $filename;
        $this->upload->initialize($config);
        $this->upload->overwrite = true;
        if ($this->upload->do_upload("imageUpload")) {
            $data = array('upload_data' => $this->upload->data());
            $image = $data['upload_data']['file_name'];
            $this->db->set('image', $filename);
            $this->db->set('date_updated', date('Y-m-d H:i:s'));
            $this->db->where('uid_member', $this->user_log['member_id']);
            $this->db->update('member');
            $response = array(
                'icon'      => "success",
                'message'   => "Berhasil update gambar"
            );
            echo json_encode($response);
        } else {
            $response = array(
                'icon'      => "error",
                'message'   => "Berhasil update gambar"
            );
            echo json_encode($response);
        }
    }

    // lupa password
    public function gantipassword()
    {
        $data = array(
            'title'         => "Ganti password",
            'user'          => $this->user_log
        );
        $this->form_validation->set_rules($this->_rules());
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('gantipassword', $data);
        } else {
            $check = $this->member->getMember($this->data_sess['otoritas'], $this->uid_member);
            if (password_verify($this->input->post('password'), $check['password'])) {
                $this->db->set('password', password_hash($this->input->post('password_baru'), PASSWORD_DEFAULT));
                $this->db->where('uid_member', $check['uid_member']);
                $this->db->update('member');
                if ($this->db->affected_rows() >= 1) {
                    $this->session->set_flashdata('notifikasi', 'ganti_berhasil');
                    $this->load->view('gantipassword', $data);
                } else {
                    $this->session->set_flashdata('notifikasi', 'ganti_gagal');
                    $this->load->view('gantipassword', $data);
                }
            } else {
                $this->session->set_flashdata('notifikasi', 'password_notmatches');
                $this->load->view('gantipassword', $data);
            }
        }
    }

    private function _rules()
    {
        $rules = array(
            array(
                'field'     => 'password_baru',
                'label'     => 'Password baru',
                'rules'     => 'trim|required|min_length[8]',
                'errors'    => array(
                    'required'      => "Password baru wajib diisi!",
                    'min_length'    => "Password harus minimal 8 karakter!"
                )
            ),
            array(
                'field'     => 'password',
                'label'     => 'Password',
                'rules'     => 'required',
                'errors'    => array(
                    'required'      => "Password wajib diisi!",
                )
            ),
            array(
                'field'     => 'password2',
                'label'     => 'Password konfirmasi',
                'rules'     => 'required|matches[password]',
                'errors'    => array(
                    'required'      => "Password wajib diisi!",
                    'matches'       => "Password tidak sama!"
                )
            )
        );
        return $rules;
    }
}
