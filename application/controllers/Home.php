<?php

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('kamar_m', 'kamar');
        get_instance()->load->helper('kamar_helper', 'changer_helper');
    }

    public function index()
    {
        $data['title'] = "Market Kost";
        $data['kamar'] = $this->kamar->getFetured();
        $this->load->view('_templatepublic/header', $data);
        $this->load->view('home', $data);
        $this->load->view('_templatepublic/footer', $data);
    }

    public function kamarby($kategori)
    {
    }
}
