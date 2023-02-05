<?php

class Transaksi_m extends CI_Model
{
    // public function getTransaksi($uid_transaksi = null, $uid_member = null)
    // {
    //     if ($uid_transaksi) {
    //         $this->db->order_by('transaksi.waktu_transaksi', 'DESC');
    //         return $this->db->get_where('transaksi', array('uid_transaksi', $uid_transaksi))->row_array();
    //     } else if ($uid_member) {
    //         $this->db->select('transaksi.*, transaksi_detail.*, member.fnama, member.lnama, kamar_kost.nama, count(transaksi_perpanjang.uid_perpanjang) as data_perpanjang, max(transaksi_perpanjang_detail.tanggal_keluar) as tanggal_keluar_perpanjang');
    //         $this->db->from('transaksi');
    //         $this->db->join('transaksi_detail', 'transaksi_detail.uid_transaksi=transaksi.uid_transaksi');
    //         $this->db->join('transaksi_perpanjang', 'transaksi_perpanjang.uid_transaksi=transaksi.uid_transaksi', 'left');
    //         $this->db->join('transaksi_perpanjang_detail', 'transaksi_perpanjang.uid_perpanjang=transaksi_perpanjang_detail.uid_perpanjang', 'left');
    //         $this->db->join('member', 'transaksi_detail.uid_member=member.uid_member');
    //         $this->db->join('kamar_kost', 'kamar_kost.uid_kamar=transaksi_detail.uid_kamar');
    //         $this->db->where('kamar_kost.uid_member', $uid_member);
    //         $this->db->order_by('transaksi.waktu_transaksi', 'DESC');
    //         return $this->db->get()->result_array();
    //     } else {
    //         $this->db->select('transaksi.*, transaksi_detail.*, member.fnama, member.lnama, kamar_kost.nama');
    //         $this->db->from('transaksi');
    //         $this->db->join('transaksi_detail', 'transaksi.uid_transaksi=transaksi_detail.uid_transaksi');
    //         $this->db->join('member', 'transaksi_detail.uid_member=member.uid_member');
    //         $this->db->join('kamar_kost', 'kamar_kost.uid_kamar=transaksi_detail.uid_kamar');
    //         $this->db->order_by('transaksi.waktu_transaksi', 'DESC');
    //         return $this->db->get()->result_array();
    //     }
    // }

    public function getDataTransaksiPerpanjang($uid_transaksi)
    {
        $this->db->select('transaksi_perpanjang.uid_transaksi, transaksi_perpanjang.uid_perpanjang, transaksi_perpanjang.snapToken, transaksi_perpanjang.waktu_transaksi, transaksi_perpanjang.status_code, transaksi_perpanjang_detail.tanggal_masuk, transaksi_perpanjang_detail.tanggal_keluar, transaksi_perpanjang.jumlah_pembayaran');
        $this->db->from('transaksi_perpanjang');
        $this->db->join('transaksi_perpanjang_detail', 'transaksi_perpanjang.uid_perpanjang=transaksi_perpanjang_detail.uid_perpanjang');
        $this->db->where('transaksi_perpanjang.uid_transaksi', $uid_transaksi);
        return $this->db->get()->result_array();
    }

    public function getDetailTransaksi($uid_transaksi)
    {
        $this->db->select('transaksi.*, transaksi_detail.*, member.*, kamar_kost.nama as nama_kamar, kamar_kost.deskripsi, kamar_kost.harga, kamar_kost.diskon, gambar_kamar.*, kategori_kamar.*, durasi_kamar.uid_durasi as durasingekost');
        $this->db->from('transaksi');
        $this->db->join('transaksi_detail', 'transaksi.uid_transaksi=transaksi_detail.uid_transaksi');
        $this->db->join('member', 'transaksi_detail.uid_member=member.uid_member');
        $this->db->join('kamar_kost', 'transaksi_detail.uid_kamar=kamar_kost.uid_kamar');
        $this->db->join('gambar_kamar', 'gambar_kamar.uid_gambar=kamar_kost.uid_gambar');
        $this->db->join('kategori_kamar', 'kategori_kamar.uid_kategori=kamar_kost.uid_kategori');
        $this->db->join('durasi_kamar', 'transaksi_detail.uid_durasi=durasi_kamar.uid_durasi');
        $this->db->where('transaksi.uid_transaksi', $uid_transaksi);
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
    public function get_transaksi($uid_member)
    {
        $this->db->select('transaksi.uid_transaksi, transaksi.status_code, transaksi_detail.tanggal_masuk, transaksi_detail.tanggal_keluar,kamar_kost.nama, count(transaksi_perpanjang.uid_perpanjang) as data_perpanjang, max(transaksi_perpanjang_detail.tanggal_keluar) as tanggal_keluar_perpanjang, transaksi_perpanjang.status_code as status_code_perpanjang');
        $this->db->from('transaksi');
        $this->db->join('transaksi_detail', 'transaksi_detail.uid_transaksi=transaksi.uid_transaksi');
        $this->db->join('transaksi_perpanjang', 'transaksi_perpanjang.uid_transaksi=transaksi.uid_transaksi', 'left');
        $this->db->join('transaksi_perpanjang_detail', 'transaksi_perpanjang.uid_perpanjang=transaksi_perpanjang_detail.uid_perpanjang', 'left');
        $this->db->join('kamar_kost', 'kamar_kost.uid_kamar=transaksi_detail.uid_kamar');
        $this->db->where('transaksi_detail.uid_member', $uid_member);
        $this->db->order_by('transaksi.waktu_transaksi', 'DESC');
        return $this->db->get()->result_array();
    }

    public function getPenguniTransaksi($uid_member)
    {
        $this->db->select('transaksi.uid_transaksi, transaksi.jumlah_pembayaran, transaksi.waktu_transaksi, transaksi.tenggat_pembayaran, transaksi.status_code, transaksi.snapToken');
        $this->db->where('transaksi_detail.uid_member', $uid_member);
        $this->db->from('transaksi');
        $this->db->join('transaksi_detail', 'transaksi.uid_transaksi=transaksi_detail.uid_transaksi');
        $this->db->order_by('transaksi.waktu_transaksi', 'DESC');
        return $this->db->get()->result_array();
    }

    public function gtTransaksi($uid_member)
    {
        $this->db->select('transaksi.*, kamar_kost.nama, sum(transaksi_perpanjang.jumlah_pembayaran) as total');
        $this->db->from('transaksi');
        $this->db->join('transaksi_detail', 'transaksi.uid_transaksi=transaksi_detail.uid_transaksi');
        $this->db->join('kamar_kost', 'kamar_kost.uid_kamar=transaksi_detail.uid_kamar');
        $this->db->join('transaksi_perpanjang', 'transaksi_perpanjang.uid_transaksi=transaksi.uid_transaksi', 'left');
        $this->db->join('transaksi_perpanjang_detail', 'transaksi_perpanjang.uid_perpanjang=transaksi_perpanjang_detail.uid_perpanjang', 'left');
        $this->db->where('transaksi_detail.uid_member', $uid_member);
        $this->db->order_by('transaksi.waktu_transaksi', 'DESC');
        return $this->db->get()->result_array();
    }

    public function gtdPenghuni($uid_member)
    {
        date_default_timezone_set('Asia/jakarta');
        $this->db->select('kamar_kost.uid_kamar, kamar_kost.nama, transaksi.uid_transaksi, transaksi_detail.uid_member, testimonial.uid_testimonial, testimonial.anonim_status, testimonial.pesan, testimonial.bintang');
        $this->db->from('transaksi');
        $this->db->join('transaksi_detail', 'transaksi_detail.uid_transaksi=transaksi.uid_transaksi');
        $this->db->join('kamar_kost', 'transaksi_detail.uid_kamar=kamar_kost.uid_kamar');
        $this->db->join('testimonial', 'transaksi.uid_transaksi=testimonial.uid_transaksi', 'left');
        $this->db->where('transaksi_detail.uid_member', $uid_member);
        $this->db->order_by('transaksi.waktu_transaksi', 'DESC');
        return $this->db->get()->result_array();
    }

    public function gtdKamar($uid_kamar, $uid_transaksi)
    {
        $this->db->select('*');
        $this->db->from('kamar_kost');
        $this->db->join('gambar_kamar', 'gambar_kamar.uid_gambar=kamar_kost.uid_gambar');
        $this->db->join('transaksi_detail', 'transaksi_detail.uid_kamar=kamar_kost.uid_kamar');
        $this->db->where('kamar_kost.uid_kamar', $uid_kamar);
        $this->db->where('transaksi_detail.uid_transaksi', $uid_transaksi);
        $this->db->where('transaksi_detail.status', 'huni');
        return $this->db->get()->row_array();
    }

    public function updateTransaksiPembayaran($data, $uid_transaksi)
    {
        $this->db->set('status_pembayaran', $data['status_pembayaran']);
        $this->db->set('waktu_transaksi', $data['waktu_transaksi']);
        $this->db->set('status_code', $data['status_code']);
        $this->db->where('uid_transaksi', $uid_transaksi);
        $this->db->update('transaksi');
    }

    public function updateTransaksiNotif($data, $uid_transaksi)
    {
        $this->db->set('status_pembayaran', $data['status_pembayaran']);
        $this->db->set('bayar_transaksi', $data['bayar_transaksi']);
        $this->db->set('status_code', $data['status_code']);
        $this->db->where('uid_transaksi', $uid_transaksi);
        return $this->db->update('transaksi');
    }

    public function updateTransaksiDetail($data, $uid_transaksi)
    {
        $this->db->set('status', $data['status']);
        $this->db->where('uid_transaksi', $uid_transaksi);
        return $this->db->update('transaksi_detail');
    }

    public function getTransaksiPerpanjang($uid_member)
    {
        // $this->db->select('max(transaksi.uid_transaksi) as uid_transaksi, max(transaksi_detail.tanggal_masuk) as tanggal_masuk, max(transaksi_detail.tanggal_keluar) as tanggal_keluar, transaksi_detail.uid_kamar, max(transaksi.status_pembayaran) as status_pembayaran');
        $this->db->select('transaksi.uid_transaksi, transaksi.uid_perpanjang, transaksi_detail.tanggal_masuk, transaksi_detail.tanggal_keluar, transaksi_detail.uid_kamar, transaksi.status_pembayaran');
        $this->db->from('transaksi');
        $this->db->join('transaksi_detail', 'transaksi.uid_transaksi=transaksi_detail.uid_transaksi');
        $this->db->where('transaksi_detail.uid_member', $uid_member);
        $this->db->where('transaksi_detail.status', 'huni');
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

    public function getStatus($uid_kamar)
    {
        $this->db->from('transaksi');
        $this->db->join('transaksi_detail', 'transaksi_detail.uid_transaksi=transaksi.uid_transaksi');
        $this->db->where('transaksi_detail.uid_kamar', $uid_kamar);
        $this->db->order_by('transaksi.waktu_transaksi', 'DESC');
        return $this->db->get()->row_array();
    }
    // revisi
    public function getTransaksi($uid_member = null, $jenis = null, $uid_transaksi = null)
    {
        if ($uid_member && $uid_transaksi) {
            $this->db->select('transaksi.uid_transaksi, transaksi.jumlah_pembayaran, transaksi.jenis, transaksi.status_code, transaksi_detail.tanggal_masuk, transaksi_detail.tanggal_keluar');
            $this->db->where('transaksi.uid_transaksi', $uid_transaksi);
            $this->db->or_where('transaksi.uid_perpanjang', $uid_transaksi);
        } else if ($uid_member && $jenis) {
            $this->db->select('transaksi.uid_transaksi,kamar_kost.nama, member.fnama, member.lnama, transaksi.status_pembayaran, transaksi.waktu_transaksi, transaksi.tenggat_pembayaran, transaksi_detail.tanggal_keluar, transaksi_detail.status,');
            $this->db->limit(10);
            $this->db->where('kamar_kost.uid_member', $uid_member);
            $this->db->where('transaksi.jenis', $jenis);
        } else if ($uid_transaksi) {
            $this->db->select('max(transaksi_detail.tanggal_keluar) as tanggal_keluar');
            $this->db->where('transaksi.uid_perpanjang', $uid_transaksi);
        } else if ($jenis) {
            $this->db->select('transaksi.uid_transaksi, transaksi_detail.tanggal_keluar, transaksi_detail.status, kamar_kost.nama, member.fnama, member.lnama');
        }
        $this->db->from('transaksi');
        $this->db->join('transaksi_detail', 'transaksi_detail.uid_transaksi=transaksi.uid_transaksi');
        $this->db->join('kamar_kost', 'kamar_kost.uid_kamar=transaksi_detail.uid_kamar');
        $this->db->join('member', 'member.uid_member=transaksi_detail.uid_member');
        $this->db->order_by('transaksi.waktu_transaksi', 'DESC');
        return $this->db->get()->result_array();
    }

    public function countTransaksiPerpanjang($uid_perpanjang)
    {
        $this->db->where('uid_perpanjang', $uid_perpanjang);
        $this->db->from('transaksi');
        return $this->db->count_all_results();
    }

    public function updateTransaksi($uid_transaksi)
    {
        $this->db->select('uid_transaksi');
        $this->db->where('uid_transaksi', $uid_transaksi);
        $this->db->or_where('uid_perpanjang', $uid_transaksi);
        $data = $this->db->get('transaksi')->result_array();
        foreach ($data as $data) {
            $this->db->set('status', 'selesai');
            $this->db->where('uid_transaksi', $data['uid_transaksi']);
            $this->db->update('transaksi_detail');
        }
        return true;
    }

    public function updateTransaksiV2($data, $uid_transaksi)
    {
        $this->db->set('status_pembayaran', $data['status_pembayaran']);
        $this->db->set('waktu_transaksi', $data['waktu_transaksi']);
        $this->db->set('status_code', $data['status_code']);
        $this->db->where('uid_transaksi', $uid_transaksi);
        $this->db->update('transaksi');
    }
}
