<?php

class Kamar extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        isLogin();
        $this->load->model('kamar_m', 'kamar');
        $this->load->model('fasilitas_kamar_m', 'fasilitas');
        $this->load->model('kategori_kamar_m', 'kategori');
        $this->load->model('durasi_kamar_m', 'durasi');
        $this->load->model('member_m', 'member');
        $this->load->model('transaksi_m', 'transaksi');
        $this->load->library('wilayah');
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

        $kamar = kamarCheck();
    }

    public function index()
    {
        $data = array(
            'title'     => 'Data kamar',
            'user'      => $this->member->getMember('juragan', $this->uid_member),
            'kamar'     => $this->kamar->getKamar($this->uid_member)
        );
        $this->load->view('juragan/kamar/index', $data);
    }

    function _data($action)
    {
        date_default_timezone_set('Asia/jakarta');

        // validation data by action
        if ($action === 'add') {
            $uid_kamar = uuid_check(uuid_generate(), 'kamar_kost', 'uid_kamar');
            $uid_gambar = generateUidGambar();
            $maps = $this->secure->encrypt_url($this->input->post('maps'));
        } else if ($action === 'update') {
            $uid_kamar = $this->input->post('uid_kamar');
            $uid_member = $this->input->post('uid_member');
            $uid_gambar = $this->input->post('uid_gambar');
            $maps = ($this->input->post('maps') != '') ? $this->secure->encrypt_url($this->input->post('maps')) : $this->input->post('hidden_maps');
        }

        $path = 'public/images/kamar/';
        $fasilitas = implode(',', $this->input->post('f_umum')) . ',' . implode(',', $this->input->post('f_kamar')) . ',' . implode(',', $this->input->post('f_kamar_mandi')) . ',' . implode(',', $this->input->post('f_parkiran'));
        $data = array(
            'kamar'         => array(
                'nama'          => $this->input->post('nama'),
                'jumlah_kamar'  => $this->input->post('jumlah_kamar'),
                'tipe'          => $this->input->post('tipe'),
                'harga'         => $this->input->post('harga'),
                'diskon'        => $this->input->post('diskon'),
                'uid_kamar'     => $uid_kamar,
                'uid_gambar'    => $uid_gambar,
                'uid_member'    => $this->uid_member,
                'uid_fasilitas' => rtrim($fasilitas, ','),
                'uid_durasi'    => implode(',', $this->input->post('durasi')),
                'uid_kategori'  => $this->input->post('kategori'),
                'luas_kamar'    => $this->input->post('luaskamar'),
                'status'        => $this->input->post('status'),
                'deskripsi'     => $this->input->post('deskripsi'),
                'alamat'        => $this->input->post('alamat'),
                'provinsi'      => $this->input->post('provinsi'),
                'kota'          => $this->input->post('kota'),
                'maps'          => ($this->input->post('maps') === '') ? $this->input->post('hidden_maps') : $maps,
                'url_title'          => url_title($this->input->post('nama') . ' ' . $this->input->post('provinsi') . ' ' . $this->input->post('kota') . ' murah tipe ' . $this->input->post('tipe') . ' u' . rand(1, 1000), 'dash', true),
                'date_post'     => ($this->input->post('date_post') === null) ? date('Y-m-d H:i:s') : $this->input->post('date_post'),
                'update_post'   => date('Y-m-d H:i:s')
            ),
            'gambar'       => array(
                'uid_gambar'    => $uid_gambar,
                'uid_kamar'     => $uid_kamar,
                'gambar_satu'   => $this->data_gambar('gambar_satu', 'gambar_satu_hidden'),
                'gambar_dua'    => $this->data_gambar('gambar_dua', 'gambar_dua_hidden'),
                'gambar_tiga'   => $this->data_gambar('gambar_tiga', 'gambar_tiga_hidden'),
                'gambar_empat'  => $this->data_gambar('gambar_empat', 'gambar_empat_hidden'),
                'gambar_lima'   => $this->data_gambar('gambar_lima', 'gambar_lima_hidden')
            ),
            'uid'       => array(
                'uid_kamar'     => $uid_kamar,
                'uid_gambar'    => $uid_gambar
            )
        );
        return $data;
    }

    public function add()
    {
        $data = array(
            'title'     => 'Tambah kamar kost',
            'f_umum' => $this->kamar->getFasilitas('umum'),
            'f_kamar' => $this->kamar->getFasilitas('kamar'),
            'f_kamar_mandi' => $this->kamar->getFasilitas('kamar mandi'),
            'f_parkiran' => $this->kamar->getFasilitas('PARKIRAN'),
            'durasi'    => $this->kamar->getDurasi(),
            'kategori'  => $this->kamar->getKategori(),
            'juragan'   => $this->kamar->getJuragan(),
            'user'      => $this->member->getMember('juragan', $this->uid_member)
        );
        $this->load->view('juragan/kamar/tambah', $data);
    }

    public function sendValidasiKamar()
    {
        $token  = '5484559434:AAFxveLoGNyw_Wx_Qs9HyowDOusQnIqKET0';
        $link   = 'https://api.telegram.org:443/bot' . $token . '';
        $update = file_get_contents($link . '/getUpdates');
        $response = json_decode($update, TRUE);
        $chat_id = $response['result'][0]['message']['chat']['id'];
        $message = 'Hello There [data](www.localhost/sk-kost/admin/kamar/master/validasi/)';
        $parameters = [
            'chat_id' => $chat_id,
            'text'  => $message,
            'parse_mode' => 'markdown'
        ];
        $url = $link . '/sendMessage?' . http_build_query($parameters);
        file_get_contents($url);
    }

    public function save()
    {
        $data = $this->_data('add');
        // eksekusi
        $eksekusi = array(
            'kamar'     => $this->kamar->addKamar($data['kamar']),
            'gambar'    => $this->kamar->addGambar($data['gambar'])
        );
        $url = base_url('admin/kamar/master/validasi/') . $eksekusi['kamar']['slug'];
        // send response
        if ($eksekusi['kamar'] === TRUE && $eksekusi['gambar'] === TRUE) {
            $response = array(
                'code'      => 200,
                'status'    => 'success',
                'message'   => 'Data kamar dan gambar berhasil ditambah!'
            );
            $this->sendValidasiKamar($url);
            $this->session->set_flashdata('response', $response);
            redirect(base_url('juragan/kamar/detail/') . $data['uid']['uid_kamar']);
        } else if ($eksekusi['kamar'] === TRUE && $eksekusi['gambar'] === FALSE) {
            $response = array(
                'code'      => 200,
                'status'    => 'success',
                'message'   => 'Data kamar dan gambar berhasil ditambah!'
            );
            $this->sendValidasiKamar($url);
            $this->session->set_flashdata('response', $response);
            redirect(base_url('juragan/kamar/detail/') . $data['uid']['uid_kamar']);
        } else {
            $response = array(
                'code'    => 400,
                'status'    => 'error',
                'message'   => 'Update kamar dan gambar ditambah!'
            );
            $this->session->set_flashdata('response', $response);
            redirect(base_url('juragan/kamar/'));
        }
    }

    public function detail($uid_kamar)
    {
        $kamar = $this->kamar->getKamarDetail($uid_kamar);
        $durasi = $this->kamar->getDurasi();
        $kategori = $this->kamar->getKategori();
        $gambar = $this->kamar->getGambar($uid_kamar);
        $transaksi = $this->kamar->transaksiKamar($uid_kamar);
        $data = array(
            'title'     => $kamar[0]['nama'],
            'user'      => $this->member->getMember('juragan', $this->uid_member),
            'kamar'     => $kamar,
            'f_umum' => $this->kamar->getFasilitas('umum'),
            'f_kamar' => $this->kamar->getFasilitas('kamar'),
            'f_kamar_mandi' => $this->kamar->getFasilitas('kamar mandi'),
            'f_parkiran' => $this->kamar->getFasilitas('PARKIRAN'),
            'durasi'    => $durasi,
            'kategori'  => $kategori,
            'gambar'    => $gambar,
            'transaksi' => $transaksi
        );
        $this->load->view('juragan/kamar/detail', $data);
    }

    public function update()
    {
        $data = $this->_data('update');
        $eksekusi = array(
            'kamar'     => $this->kamar->updateKamar($data['kamar'], $data['uid']['uid_kamar']),
            'gambar'    => $this->kamar->updateGambarKamar($data['gambar'], $data['uid']['uid_gambar'])
        );


        // send response
        if ($eksekusi['kamar'] === TRUE && $eksekusi['gambar'] === TRUE) {
            $response = array(
                'code'      => 200,
                'status'    => 'success',
                'message'   => 'Data kamar dan gambar berhasil diupdate!'
            );
            $this->session->set_flashdata('response', $response);
            echo json_encode($response);
            // redirect(base_url('juragan/kamar/detail/') . $data['uid']['uid_kamar']);
        } else if ($eksekusi['kamar'] === TRUE && $eksekusi['gambar'] === FALSE) {
            $response = array(
                'code'      => 200,
                'status'    => 'success',
                'message'   => 'Data kamar dan gambar berhasil diupdate!'
            );
            $this->session->set_flashdata('response', $response);
            echo json_encode($response);
            // redirect(base_url('juragan/kamar/detail/') . $data['uid']['uid_kamar']);
        } else {
            $response = array(
                'code'    => 400,
                'status'    => 'error',
                'message'   => 'Update kamar dan gambar gagal!'
            );
            $this->session->set_flashdata('response', $response);
            // $this->session->set_flashdata('response', $response);
            echo json_encode($response);
            // redirect(base_url('juragan/kamar/detail/') . $data['uid']['uid_kamar']);
        }
    }

    public function delete()
    {
        $uid_kamar = $_POST['uid_kamar'];
        $uid_gambar = $_POST['uid_gambar'];
        $this->db->where('uid_kamar', $uid_kamar);
        $this->db->where('status', 'huni');
        $this->db->or_where('status', 'booking');
        $this->db->from('transaksi_detail');
        $checkTX = $this->db->get();
        if ($checkTX->num_rows() >= 1) {
            $response = array(
                'code'      => 203,
                'status'    => 'error',
                'message'   => 'Hapus kamar tidak berhasil, karena kamar berpenghuni/sedang booking!'
            );
            echo json_encode($response);
        } else {
            $eksekusi = $this->kamar->deleteKamar($uid_kamar, $uid_gambar);
            if ($eksekusi === TRUE) {
                $response = array(
                    'code'      => 200,
                    'status'    => 'success',
                    'message'   => 'Hapus kamar berhasil!'
                );
                echo json_encode($response);
            } else {
                $response = array(
                    'code'      => 400,
                    'status'    => 'error',
                    'message'   => 'Hapus kamar gagal!'
                );
                echo json_encode($response);
            }
        }
    }

    function data_gambar($name, $namehidden)
    {
        return ($_FILES[$name]['error'] === 4) ? $this->input->post($namehidden) : $this->upload_gambar($name, generateRandomString(10));
    }

    function upload_gambar($variable, $filename)
    {
        $config['upload_path'] = FCPATH . 'public/images/kamar/';
        $config['file_name'] = $filename . pathinfo($_FILES[$variable]["name"], PATHINFO_EXTENSION);
        $config['allowed_types'] = 'jpg|png|jpeg';
        $this->upload->initialize($config);
        if (!$this->upload->do_upload($variable)) {
            $error = array('error' => $this->upload->display_errors());
            echo json_encode($error);
        } else {
            $data = array('upload_data' => $this->upload->data());
            return $data['upload_data']['file_name'];
        }
    }

    function do_delete($name)
    {
        $path_to_file = './public/images/kamar/' . $name;
        if (unlink($path_to_file)) {
            return true;
        } else {
            return false;
        }
    }
}
