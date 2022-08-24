<?php

class Keuangan extends CI_Controller
{
    var $uid_member;
    var $user_log;
    public function __construct()
    {
        parent::__construct();
        isLogin();
        $this->load->model('user_m', 'user');
        $this->load->model('member_m', 'member');
        $this->load->model('kamar_m', 'kamar');
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

        $kamar = kamarCheck();
        if (!$kamar) {
            redirect('juragan/kamar/add');
        }
    }

    public function index()
    {
        $rekap = array(
            'saldo_masuk_settlement'    => $this->keuangan->getRekap($this->uid_member, 'SETTLEMENT', "saldo_masuk"),
            'saldo_masuk_pending'       => $this->keuangan->getRekap($this->uid_member, 'PENDING', "saldo_masuk"),
            'saldo_withdraw_settlement' => $this->keuangan->getRekap($this->uid_member, 'SETTLEMENT', "saldo_withdraw"),
            'saldo_withdraw_pending'    => $this->keuangan->getRekap($this->uid_member, 'PENDING', "saldo_withdraw")
        );
        $data = array(
            'title'             => 'Keuangan',
            'user'              => $this->user_log,
            'keuangan'          => $this->keuangan->getChart($this->uid_member),
            'transaksi'         => $this->transaksi->getTransaksiByJuragan($this->uid_member),
            'aktivitas'         => $this->keuangan->getKeuanganByJuragan($this->uid_member),
            'rekap'             => $rekap
        );
        $this->load->view('juragan/keuangan/index', $data);
    }

    public function aktivitas()
    {
        $data = array(
            'title'             => 'Aktivitas Keuangan',
            'user'              => $this->user_log,
            'aktivitas'         => $this->keuangan->getKeuanganByJuragan($this->uid_member),
            'rekening'              => $this->user->getRekening($this->uid_member)
        );
        $this->load->view('juragan/keuangan/aktivitas', $data);
    }

    public function detail($uid_keuangan)
    {
        $data = array(
            'title'     => 'Detail Aktivitas Keuangan',
            'user'      => $this->user_log,
            'data'      => $this->keuangan->getDetail($uid_keuangan)
        );
        $this->load->view('juragan/keuangan/detail', $data);
    }

    public function penarikan()
    {
        date_default_timezone_set('Asia/jakarta');
        $data = array(
            'uid_member'        => $this->uid_member,
            'saldo_withdraw'      => $this->input->post('nominal'),
            'deskripsi'         => $this->input->post('deskripsi'),
            'status'            => 'PENDING',
            'nomor_rekening'    => $this->input->post('nomor_rekening'),
            'date_updated'      => date('Y-m-d H:i:s')
        );

        $jumlah_saldo = $this->keuangan->getRekap($this->uid_member, "SETTLEMENT", "saldo_masuk");
        if ($this->input->post('nominal') > $jumlah_saldo['saldo_masuk']) {
            $response = array(
                'code'      => 400,
                'status'    => 'error',
                'message'   => 'Nominal yang anda tarik melebih saldo anda yang tersedia!'
            );
            echo json_encode($response);
        } else {
            $eksekusi = $this->keuangan->insert($data);
            if ($eksekusi === TRUE) {
                $message = '<p>Ada penarikan dari:</p>
                            <p>user : ' . $this->user_log['fnama'] . ' ' . $this->user_log['lnama'] . '</p>
                            <p>nominal : ' . rupiah($this->input->post('nominal')) . '</p>
                            <p>nomor rekening : ' . $this->input->post('nomor_rekening') . '</p>';
                _notif($message, "maskostci@gmail.com", "Ada penarikan saldo dari user " . $this->user_log['fnama'] . $this->user_log['lnama']);
                $response = array(
                    'code'      => 200,
                    'status'    => 'success',
                    'message'   => 'Penarikan berhasil, Akan segera diproses!'
                );
                echo json_encode($response);
            } else {
                $response = array(
                    'code'      => 400,
                    'status'    => 'error',
                    'message'   => 'Penarikan gagal diproses!'
                );
                echo json_encode($response);
            }
        }
    }

    public function batalWD($uid_keuangan)
    {
        $check = $this->keuangan->getStatus($uid_keuangan);
        if ($check['status'] === "PENDING") {
            $this->db->set('status', 'CANCEL');
            $this->db->where('uid_keuangan', $uid_keuangan);
            $this->db->update('keuangan');
            $eksekusi = ($this->db->affected_rows() >= 1) ? TRUE : FALSE;
            if ($eksekusi === TRUE) {
                $response = array(
                    'code'      => 200,
                    'status'    => 'success',
                    'message'   => 'Penarikan berhasil dibatalkan!'
                );
                echo json_encode($response);
            } else {
                $response = array(
                    'code'      => 400,
                    'status'    => 'error',
                    'message'   => 'Penarikan gagal dibatalkan!'
                );
                echo json_encode($response);
            }
        } else {
            $response = array(
                'code'      => 400,
                'status'    => 'error',
                'message'   => 'Pembatalan penarikan gagal, karena sudah diproses!'
            );
            echo json_encode($response);
        }
    }

    public function akunBank()
    {
        $data = array(
            'title'     => "Akun Bank Anda",
            'user'      => $this->user_log,
            'bank'      => $this->user->getRekening($this->uid_member)
        );
        $this->load->view('juragan/keuangan/bankakun', $data);
    }

    public function tambahBank()
    {
        $data = array(
            'uid_rekening'      => '',
            'uid_member'        => $this->input->post('uid_member'),
            'atas_nama'         => $this->input->post('atas_nama'),
            'nama_bank'         => $this->input->post('nama_bank'),
            'nomor_rekening'    => $this->input->post('nomor_rekening'),
        );
        $this->db->insert('rekening', $data);
        $response = ($this->db->affected_rows() >= 1) ? TRUE : FALSE;
        if ($response === TRUE) {
            $response = array(
                'code'      => 200,
                'status'    => 'success',
                'message'   => 'Data bank berhasil ditambahkan!'
            );
            echo json_encode($response);
        } else {
            $response = array(
                'code'      => 400,
                'status'    => 'error',
                'message'   => 'Data bank gagal ditambahkan!'
            );
            echo json_encode($response);
        }
    }
    public function editBank()
    {
        $data = array(
            'uid_member'        => $this->input->post('uid_member'),
            'atas_nama'         => $this->input->post('atas_namaedit'),
            'nama_bank'         => $this->input->post('nama_bankedit'),
            'nomor_rekening'    => $this->input->post('nomor_rekeningedit'),
        );
        $this->db->where('uid_rekening', $this->input->post('uid_rekeningedit'));
        $this->db->update('rekening', $data);
        $response = ($this->db->affected_rows() >= 1) ? TRUE : FALSE;
        if ($response === TRUE) {
            $response = array(
                'code'      => 200,
                'status'    => 'success',
                'message'   => 'Data bank berhasil ditambahkan!'
            );
            echo json_encode($response);
        } else {
            $response = array(
                'code'      => 400,
                'status'    => 'error',
                'message'   => 'Data bank gagal ditambahkan!'
            );
            echo json_encode($response);
        }
    }

    public function getBank($id)
    {
        $uid_rekening = $id;
        $this->db->from('rekening');
        if ($uid_rekening) {
            $this->db->where('uid_rekening', $uid_rekening);
            $data = $this->db->get()->row_array();
        } else {
            $this->db->where('uid_member', $this->user_log);
            $data = $this->db->get()->result_array();
        }
        echo json_encode($data);
    }

    public function getBuku()
    {
        $uid_buku_keuangan = $this->input->post('uid_buku_keuangan');
        $response = $this->keuangan->getBukuKeuangan($this->uid_member, $uid_buku_keuangan);
        echo json_encode($response);
    }

    public function buku()
    {
        $data = array(
            'title'         => 'Buku Keuangan',
            'user'          => $this->user_log,
            'uid_member'    => $this->uid_member,
            'rekap'         => array(
                'withdraw'      => $this->keuangan->getBukuKeuanganWithdraw($this->uid_member),
                'masuk'         => $this->keuangan->getBukuKeuanganOffline($this->uid_member, 'in'),
                'keluar'        => $this->keuangan->getBukuKeuanganOffline($this->uid_member, 'out'),
            ),
            'buku'          => $this->keuangan->getBukuKeuangan($this->uid_member, null)
        );
        $this->load->view('juragan/keuangan/buku', $data);
    }

    public function bukuTambah()
    {
        $data = array(
            'uid_buku_keuangan' => '',
            'uid_member'        => $this->uid_member,
            'nominal'           => $this->input->post('nominal'),
            'keterangan'         => $this->input->post('keterangan'),
            'deskripsi'         => $this->input->post('deskripsi'),
            'date'              => ($this->input->post('date') === '') ? date('Y-m-d H:i:s') : $this->input->post('date')
        );

        $eksekusi = $this->keuangan->bukuTambah($data);
        if ($eksekusi === TRUE) {
            $response = array(
                'code'      => 200,
                'status'    => 'success',
                'message'   => 'Data berhasil ditambah!'
            );
            echo json_encode($response);
        } else {
            $response = array(
                'code'      => 400,
                'status'    => 'error',
                'message'   => 'Data berhasil ditambah!'
            );
            echo json_encode($response);
        }
    }
}
