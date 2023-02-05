<?php

class Page extends CI_Controller
{
    public function about()
    {
        $data = array(
            'title'     => "About Us"
        );
        $this->load->view('_templatepublic/header', $data);
        $this->load->view('pages/about', $data);
        $this->load->view('_templatepublic/footer', $data);
    }

    public function contact()
    {
        $data = array(
            'title' => 'Contact Us'
        );
        $this->load->view('_templatepublic/header', $data);
        $this->load->view('dist/utilities-contact', $data);
        $this->load->view('_templatepublic/footer', $data);
    }

    public function tutorialMaps()
    {
        $data = array('title' => 'Tutorial Memasukan Email');
        $this->load->view('_templatepublic/header', $data);
        $this->load->view('dist/maps', $data);
        $this->load->view('_templatepublic/footer', $data);
    }

    public function contactProccess()
    {
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $message = $this->input->post('message');
        $send = $this->_contactSend($message, $email, "Pesan dari" . $name);
        if ($send === TRUE) {
            $this->session->set_flashdata('notifikasi', 'sendContact_berhasil');
            $this->contact();
        } else {
            $this->session->set_flashdata('notifikasi', 'sendContact_gagal');
            $this->contact();
        }
    }

    private function _contactSend($pesan, $email, $subject)
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
        $this->email->from($email, 'Mas Kost');
        $this->email->to("maskostci@gmail.com");
        $this->email->subject($subject);
        $this->email->message($pesan);
        if ($this->email->send()) {
            return true;
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }

    public function error()
    {
        $data['title'] = '404 Not Found';
        $this->load->view('dist/errors-404', $data);
    }
}
