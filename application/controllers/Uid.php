<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Uid extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('account_helper');
        $this->load->helper('kamar_helper');
    }
    public function index()
    {
        var_dump(uuid_generate());
    }

    // public function uid()
    // {
    //     $uid_generate = uuid_generate();
    //     if (uuid_check($uid_generate) >= 1) {
    //         return false;
    //     } else {
    //         echo $uid_generate;
    //     }
    // }

    public function password()
    {
        $password = "Saddan11!";
        echo password_hash($password, PASSWORD_DEFAULT);
    }

    public function uid_gambar()
    {
    }
}
