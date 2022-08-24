<?php

class Transaksi_m extends CI_Model
{
    public function getTransaksi($uid_transaksi = null, $uid_member = null)
    {
        if ($uid_transaksi) {
            $this->db->order_by('transaksi.waktu_transaksi', 'DESC');
            return $this->db->get_where('transaksi', array('uid_transaksi', $uid_transaksi))->row_array();
        } else if ($uid_member) {
            $this->db->select('transaksi.*, transaksi_detail.*, member.fnama, member.lnama');
            $this->db->from('transaksi');
            $this->db->join('transaksi_detail', 'transaksi_detail.uid_transaksi=transaksi.uid_transaksi');
            $this->db->join('member', 'transaksi_detail.uid_member=member.uid_member');
            $this->db->join('kamar_kost', 'kamar_kost.uid_kamar=transaksi_detail.uid_kamar');
            $this->db->where('kamar_kost.uid_member', $uid_member);
            $this->db->order_by('transaksi.waktu_transaksi', 'DESC');
            return $this->db->get()->result_array();
        } else {
            $this->db->order_by('transaksi.waktu_transaksi', 'DESC');
            return $this->db->get('transaksi')->result_array();
        }
    }

    public function getDetailTransaksi($uid_transaksi)
    {
        $this->db->select('transaksi.*, transaksi_detail.*, member.*, kamar_kost.nama as nama_kamar, kamar_kost.deskripsi, kamar_kost.harga, kamar_kost.diskon, gambar_kamar.*, kategori_kamar.*, durasi_kamar.durasi as durasingekost');
        $this->db->from('transaksi');
        $this->db->join('transaksi_detail', 'transaksi.uid_transaksi=transaksi_detail.uid_transaksi');
        $this->db->join('member', 'transaksi_detail.uid_member=member.uid_member');
        $this->db->join('kamar_kost', 'transaksi_detail.uid_kamar=kamar_kost.uid_kamar');
        $this->db->join('gambar_kamar', 'gambar_kamar.uid_gambar=kamar_kost.uid_gambar');
        $this->db->join('kategori_kamar', 'kategori_kamar.uid_kategori=kamar_kost.uid_kategori');
        $this->db->join('durasi_kamar', 'transaksi_detail.uid_durasi=durasi_kamar.uid_durasi');
        return $this->db->get()->row_array();
    }

    public function addTransaksi($data)
    {
        $this->db->insert('transaksi', $data);
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function CountPenghuni($uid_member)
    {
        $this->db->from('transaksi_detail');
        $this->db->join('kamar_kost', 'kamar_kost.uid_kamar=transaksi_detail.uid_kamar');
        $this->db->group_by('transaksi_detail.uid_member');
        $query = $this->db->where('kamar_kost.uid_member', $uid_member)->get();
        return $query->num_rows();
    }

    public function getTransaksiByJuragan($uid_member)
    {
        $this->db->select('transaksi.*, transaksi_detail.*, member.saldo, member.saldo_released');
        $this->db->from('transaksi');
        $this->db->join('transaksi_detail', 'transaksi_detail.uid_transaksi=transaksi.uid_transaksi');
        $this->db->join('kamar_kost', 'kamar_kost.uid_kamar=transaksi_detail.uid_kamar');
        $this->db->join('member', 'member.uid_member=kamar_kost.uid_member');
        $this->db->where('kamar_kost.uid_member', $uid_member);
        return $this->db->get()->result_array();
    }

    // section penghuni
    // singkatan gt (get transaksi)
    // singkatan gtd (get transaksi detail)
    public function gtTransaksi($uid_member)
    {
        $this->db->from('transaksi_detail');
        $this->db->join('transaksi', 'transaksi.uid_transaksi=transaksi_detail.uid_transaksi');
        $this->db->where('transaksi_detail.uid_member', $uid_member);
        return $this->db->get()->result_array();
    }

    public function gtdPenghuni($uid_member)
    {
        date_default_timezone_set('Asia/jakarta');
        // $this->db->where('tanggal_keluar<', date('Y-m-d'));
        $this->db->from('transaksi');
        $this->db->join('transaksi_detail', 'transaksi_detail.uid_transaksi=transaksi.uid_transaksi');
        $this->db->where('uid_member', $uid_member);
        $this->db->order_by('transaksi.waktu_transaksi', 'DESC');
        return $this->db->get()->row_array();
    }

    public function gtdKamar($uid_kamar)
    {
        $this->db->select('*');
        $this->db->from('kamar_kost');
        $this->db->join('gambar_kamar', 'gambar_kamar.uid_gambar=kamar_kost.uid_gambar');
        $this->db->where('kamar_kost.uid_kamar', $uid_kamar);
        return $this->db->get()->row_array();
    }

    public function updateTransaksi($data, $uid_transaksi)
    {
        $this->db->set('status_pembayaran', $data['status_pembayaran']);
        $this->db->set('waktu_transaksi', $data['waktu_transaksi']);
        $this->db->set('status_code', $data['status_code']);
        $this->db->where('uid_transaksi', $uid_transaksi);
        $this->db->update('transaksi');
    }

    public function updateTransaksiDetail($data, $uid_transaksi)
    {
        $this->db->set('status', $data['status']);
        $this->db->where('uid_transaksi', $uid_transaksi);
        $this->db->update('transaksi_detail');
    }

    public function getTransaksiPerpanjang($uid_member)
    {
        $this->db->from('transaksi_detail');
        $this->db->join('transaksi', 'transaksi.uid_transaksi=transaksi_detail.uid_transaksi');
        $this->db->where('transaksi_detail.uid_member', $uid_member);
        $this->db->order_by('transaksi.waktu_transaksi', 'DESC');
        return $this->db->get()->row_array();
    }

    // section admin 
    public function getTransaksiAll()
    {
        $this->db->select('transaksi.uid_transaksi, transaksi.jenis, transaksi.jumlah_pembayaran, transaksi.status_pembayaran, transaksi.waktu_transaksi, transaksi.tenggat_pembayaran, member.fnama, member.lnama');
        $this->db->from('transaksi');
        $this->db->join('transaksi_detail', 'transaksi_detail.uid_transaksi=transaksi.uid_transaksi');
        $this->db->join('member', 'transaksi_detail.uid_member=member.uid_member');
        $this->db->join('kamar_kost', 'kamar_kost.uid_kamar=transaksi_detail.uid_kamar');
        $this->db->order_by('transaksi.waktu_transaksi', 'DESC');
        return $this->db->get()->result_array();
    }

    public function withdraw($uid_keuangan = null)
    {
        $this->db->select('keuangan.uid_keuangan, keuangan.saldo_withdraw, keuangan.status, keuangan.date_updated, member.uid_member, member.fnama, member.lnama, member.email, rekening.nomor_rekening, rekening.atas_nama, rekening.nama_bank');
        $this->db->from('keuangan');
        $this->db->join('member', 'member.uid_member=keuangan.uid_member');
        $this->db->join('rekening', 'keuangan.nomor_rekening=rekening.nomor_rekening');
        $this->db->where('saldo_withdraw > ', '0');
        if ($uid_keuangan) {
            $this->db->where('uid_keuangan', $uid_keuangan);
        }
        $this->db->order_by('uid_keuangan', 'DESC');
        return $this->db->get()->result_array();
    }

    public function updateHabis($uid_kamar)
    {
        $this->db->set('status', "habis");
        $this->db->where('uid_kamar', $uid_kamar);
        $this->db->update('transaksi_detail');
    }

    public function getStatus($uid_member)
    {
        $this->db->from('transaksi');
        $this->db->join('transaksi_detail', 'transaksi_detail.uid_transaksi=transaksi.uid_transaksi');
        $this->db->where('transaksi_detail.uid_member', $uid_member);
        $this->db->order_by('transaksi.waktu_transaksi', 'DESC');
        return $this->db->get()->row_array();
    }
}
