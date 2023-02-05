<?php

class keuangan_m extends CI_Model
{
    public function get($uid_member = null)
    {
        $this->db->select('*');
        if ($uid_member) {
            $this->db->where('uid_member', $uid_member);
        }
        return $this->db->get('keuangan')->row_array();
    }

    public function insert($data)
    {
        $this->db->insert('keuangan', $data);
        return ($this->db->affected_rows() >= 1) ? TRUE : FALSE;
    }

    public function getRekap($uid_member, $status, $params)
    {
        if ($params === "saldo_masuk") {
            $this->db->select('sum(saldo_masuk) as saldo_masuk');
        } else if ($params === "saldo_withdraw") {
            $this->db->select('sum(saldo_withdraw) as saldo_withdraw');
        }
        $this->db->from('keuangan');
        $this->db->where('uid_member', $uid_member);
        $this->db->where('status', $status);
        return $this->db->get()->row_array();
    }

    public function getChart($uid_member)
    {
        $data = array(
            'januari'   => $this->getSaldoByMonth(1, $uid_member),
            'februari'  => $this->getSaldoByMonth(2, $uid_member),
            'maret'     => $this->getSaldoByMonth(3, $uid_member),
            'april'     => $this->getSaldoByMonth(4, $uid_member),
            'mei'       => $this->getSaldoByMonth(5, $uid_member),
            'juni'      => $this->getSaldoByMonth(6, $uid_member),
            'juli'      => $this->getSaldoByMonth(7, $uid_member),
            'agustus'   => $this->getSaldoByMonth(8, $uid_member),
            'september' => $this->getSaldoByMonth(9, $uid_member),
            'oktober'   => $this->getSaldoByMonth(10, $uid_member),
            'november'  => $this->getSaldoByMonth(11, $uid_member),
            'desember'  => $this->getSaldoByMonth(12, $uid_member),
        );
        return $data;
    }

    public function getSaldoByMonth($month, $uid_member)
    {
        $tahun = ($this->input->post('tahun') != "") ? $this->input->post('tahun') : date('Y');
        $this->db->select_sum('saldo_masuk');
        $this->db->select_sum('saldo_withdraw');
        $this->db->from('keuangan');
        $this->db->where('MONTH(date_updated)', $month);
        $this->db->where('YEAR(date_updated)', $tahun);
        $this->db->where('uid_member', $uid_member);
        $this->db->where('status', 'SETTLEMENT');
        return $this->db->get()->row_array();
    }

    public function getDetail($uid_keuangan)
    {
        return $this->db->get_where('keuangan', array('uid_keuangan' => $uid_keuangan))->row_array();
    }

    public function getKeuanganByJuragan($uid_member)
    {
        $this->db->order_by('date_updated', 'DESC');
        return $this->db->get_where('keuangan', array('uid_member' => $uid_member))->result_array();
    }

    public function insertKeuangan($uid_member, $uid_transaksi, $saldo, $status, $keterangan, $deskripsi, $nomor_rekening)
    {
        date_default_timezone_set('Asia/jakarta');
        if ($keterangan === "SALDO_MASUK") {
            $data = array(
                'uid_keuangan'      => '',
                'uid_transaksi'     => $uid_transaksi,
                'uid_member'        => $uid_member,
                'saldo_masuk'       => $saldo,
                'saldo_withdraw'    => 0,
                'status'            => $status,
                'deskripsi'         => $deskripsi,
                'nomor_rekening'    => $nomor_rekening,
                'date_updated'      => date('Y-m-d H:i:s')
            );
        } else {
            $data = array(
                'uid_keuangan'      => '',
                'uid_transaksi'     => $uid_transaksi,
                'uid_member'        => $uid_member,
                'saldo_masuk'       => 0,
                'saldo_withdraw'    => $saldo,
                'status'            => $status,
                'deskripsi'         => "pembayaran kost",
                'nomor_rekening'    => "",
                'date_updated'      => date('Y-m-d H:i:s')
            );
        }
        $this->db->insert('keuangan', $data);
    }

    public function updatePembayaran($data, $uid_transaksi)
    {
        $this->db->set('status', $data['status']);
        $this->db->set('date_updated', $data['date_updated']);
        $this->db->where('uid_transaksi', $uid_transaksi);
        return $this->db->update('keuangan');
    }

    private function _getSaldoMember($uid_member)
    {
        return $this->db->get_where('member', array('uid_member' => $uid_member))->row_array();
    }

    public function updateSaldoMember($gross_amount, $uid_member, $jenis)
    {
        $member = $this->_getSaldoMember($uid_member);
        if ($jenis === "masuk") {
            $this->db->set('saldo', $member['saldo'] + $gross_amount);
        } else if ($jenis === "withdraw") {
            $this->db->set('saldo_released', $member['saldo_released'] + $gross_amount);
        }
        $this->db->where('uid_member', $uid_member);
        $this->db->update('member');
    }

    public function profit($profit)
    {
        date_default_timezone_set('Asia/jakarta');
        $data = array(
            'uid_profit'    => '',
            'jumlah_profit' => $profit,
            'date_updated'  => date('Y-m-d H:i:s')
        );
        $this->db->insert('profit', $data);
    }

    // section admin get
    public function getSaldo($status, $jenis)
    {
        if ($jenis === "masuk") {
            $this->db->select_sum('saldo_masuk');
        } else {
            $this->db->select_sum('saldo_withdraw');
        }
        $this->db->where('status', $status);
        return $this->db->get('keuangan')->row_array();
    }

    public function getProfit()
    {
        $this->db->select_sum('jumlah_profit');
        return $this->db->get('profit')->row_array();
    }

    // section withdraw
    public function getStatus($uid_keuangan)
    {
        $this->db->where('uid_keuangan', $uid_keuangan);
        return $this->db->get('keuangan')->row_array();
    }
    public function getWithdraw()
    {
        $this->db->from('keuangan');
        $this->db->where('saldo_withdraw >', 0);
        return $this->db->get()->result_array();
    }

    // buku keuangan
    public function getChartBuku($uid_member)
    {
        $data = array(
            'januari'   => $this->getSaldoByMonthBuku(1, $uid_member),
            'februari'  => $this->getSaldoByMonthBuku(2, $uid_member),
            'maret'     => $this->getSaldoByMonthBuku(3, $uid_member),
            'april'     => $this->getSaldoByMonthBuku(4, $uid_member),
            'mei'       => $this->getSaldoByMonthBuku(5, $uid_member),
            'juni'      => $this->getSaldoByMonthBuku(6, $uid_member),
            'juli'      => $this->getSaldoByMonthBuku(7, $uid_member),
            'agustus'   => $this->getSaldoByMonthBuku(8, $uid_member),
            'september' => $this->getSaldoByMonthBuku(9, $uid_member),
            'oktober'   => $this->getSaldoByMonthBuku(10, $uid_member),
            'november'  => $this->getSaldoByMonthBuku(11, $uid_member),
            'desember'  => $this->getSaldoByMonthBuku(12, $uid_member),
        );
        return $data;
    }

    public function getSaldoByMonthBuku($month, $uid_member)
    {
        $tahun = ($this->input->post('tahun') != "") ? $this->input->post('tahun') : date('Y');
        $this->db->select('sum(CASE WHEN keterangan="in" THEN nominal ELSE 0 END) AS saldo_masuk, SUM(CASE WHEN keterangan="out" THEN nominal ELSE 0 END) AS saldo_withdraw');
        $this->db->from('buku_keuangan');
        $this->db->where('MONTH(date)', $month);
        $this->db->where('YEAR(date)', $tahun);
        $this->db->where('uid_member', $uid_member);
        return $this->db->get()->row_array();
    }

    public function getBukuKeuangan($uid_member, $uid_buku_keuangan)
    {
        $this->db->where('uid_member', $uid_member);
        $this->db->order_by('date', 'desc');
        if ($uid_buku_keuangan) {
            $this->db->where('uid_buku_keuangan', $uid_buku_keuangan);
            return $this->db->get('buku_keuangan')->result_array();
        } else {
            return $this->db->get('buku_keuangan')->result_array();
        }
    }

    public function getBukuKeuanganWithdraw($uid_member)
    {
        $this->db->select_sum('saldo_withdraw');
        $this->db->where('uid_member', $uid_member);
        $this->db->where('status', 'SETTLEMENT');
        return $this->db->get('keuangan')->row_array();
    }

    public function getBukuKeuanganOffline($uid_member, $keterangan)
    {
        $this->db->select_sum('nominal');
        $this->db->where('uid_member', $uid_member);
        $this->db->where('keterangan', $keterangan);
        return $this->db->get('buku_keuangan')->row_array();
    }

    public function bukuTambah($data)
    {
        $this->db->insert('buku_keuangan', $data);
        return ($this->db->affected_rows() >= 1) ? TRUE : FALSE;
    }

    public function bukuEdit($data, $uid_buku_keuangan)
    {
        $this->db->where('uid_buku_keuangan', $uid_buku_keuangan);
        $this->db->update('buku_keuangan', $data);
        return ($this->db->affected_rows() >= 1) ? TRUE : FALSE;
    }

    public function tambahBukuWD($nominal, $uid_member)
    {
        $data = array(
            'uid_buku_keuangan' => '',
            'uid_member'        => $uid_member,
            'nominal'           => $nominal,
            'keterangan'        => 'in',
            'deskripsi'         => 'Pembayaran withdraw',
            'date'              => date('Y-m-d H:i:s')
        );
        $this->db->insert('buku_keuangan', $data);
    }
}
