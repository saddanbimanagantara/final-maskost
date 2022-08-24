<?php

class Api extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('wilayah');
    }

    public function index()
    {
        echo "hello";
    }

    public function provinsi()
    {
        $provinsi = $this->wilayah->provinsi();
        echo json_encode($provinsi);
    }

    public function kabupaten($id)
    {
        $kabupaten = $this->wilayah->kabupaten($id);
        echo json_encode($kabupaten);
    }
}
