<?php

class Landing extends CI_Controller
{

    public function index()
    {
        $data = array(
            'title'     => "Landing Page Juragan Kost - Promosikan Kost Anda Melalui Mas Kost"
        );
        $this->load->view('_templatepublic/header', $data);
        $this->load->view('landingpage', $data);
        $this->load->view('_templatepublic/footer', $data);
    }
}
