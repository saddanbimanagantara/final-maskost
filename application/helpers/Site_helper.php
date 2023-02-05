<?php
function isLogin()
{
    $ci = &get_instance();
    $login = $ci->session->userdata('login');
    $member = $ci->session->userdata('member');
    if ($login === TRUE) {
        $otoritas = $ci->uri->segment(1);
        if ($otoritas === $member['otoritas']) {
        } else if ($otoritas === "profile") {
        } else if ($ci->uri->segment(1) === "kost") {
        } else {
            redirect('auth/blocked');
        }
    } else if ($ci->uri->segment(1) === "kost") {
    } else {
        redirect('auth/login');
    }
}

function kamarCheck()
{
    $ci = &get_instance();
    $member = $ci->session->userdata('member');
    return $ci->db->get_where('kamar_kost', array('uid_member' => $member['uid_member']))->row_array();
}

function _notif($pesan, $email, $subject)
{
    $ci = &get_instance();
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

    $ci->load->library('email', $config);
    $ci->email->initialize($config);
    $ci->email->from('maskostci@gmail.com', 'Mas Kost');
    $ci->email->to($email);
    $ci->email->subject($subject);
    $ci->email->message($pesan);
    if ($ci->email->send()) {
        return true;
    } else {
        echo $ci->email->print_debugger();
        die;
    }
}
