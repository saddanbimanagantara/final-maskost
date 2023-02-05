<?php

class Kamar_m extends CI_Model
{
    var $queryBintang = "sum(if(testimonial.bintang = 5,testimonial.bintang,NULL)) as limabintang,sum(if(testimonial.bintang = 4,testimonial.bintang,NULL)) as empatbintang, sum(if(testimonial.bintang = 3,testimonial.bintang,NULL)) as tigabintang, sum(if(testimonial.bintang = 2,testimonial.bintang,NULL)) as duabintang,sum(if(testimonial.bintang = 1,testimonial.bintang,NULL)) as satubintang";

    public function get($limit, $start, $filter)
    {
        $this->db->select('kamar_kost.*, gambar_kamar.*,(SELECT COUNT(transaksi.uid_transaksi) FROM transaksi JOIN transaksi_detail ON transaksi.uid_transaksi=transaksi_detail.uid_transaksi WHERE transaksi.jenis="baru" AND transaksi_detail.status="huni" AND transaksi_detail.uid_kamar=kamar_kost.uid_kamar) as terjual,  member.fnama as juragan, member.no_hp as telepon, member.username, count(testimonial.uid_testimonial) as testicount, kategori_kamar.nama_kategori, kategori_kamar.uid_kategori,' . $this->queryBintang . '', FALSE);
        // section filter
        if (@$_POST) {
            $this->db->where('harga>', $this->input->post('price-from'));
            $this->db->where('harga<', $this->input->post('price-to'));
            if (@$this->input->post('kota')) {
                $this->db->where('kamar_kost.kota', $this->input->post('kota'));
            } else if (@$this->input->post('tipe')) {
                $this->db->where('kamar_kost.tipe', $this->input->post('tipe'));
            } else if (@$this->input->post('kategori_kamar')) {
                $this->db->where('kamar_kost.uid_kategori', $this->input->post('kategori_kamar'));
            }
        }

        if (@$filter['fasilitas']) {
            $i = 0;
            foreach ($filter['fasilitas'] as $index => $value) {
                $this->db->like('kamar_kost.uid_fasilitas', $value[0]);
            }
        } else if (@$filter['durasi']) {
            $i = 0;
            foreach ($filter['durasi'] as $index => $value) {
                $this->db->like('kamar_kost.uid_durasi', $value[0]);
            }
        }
        if (@$this->input->post('username')) {
            $this->db->where('member.username', $this->input->post('username'));
        }
        $this->db->where('kamar_kost.status', 'approve');
        $this->db->from('kamar_kost');
        $this->db->join('gambar_kamar', 'kamar_kost.uid_gambar=gambar_kamar.uid_gambar', 'left');
        $this->db->join('testimonial', 'kamar_kost.uid_kamar=testimonial.uid_kamar', 'left');
        $this->db->join('kategori_kamar', 'kamar_kost.uid_kategori=kategori_kamar.uid_kategori', 'left');
        $this->db->join('member', 'kamar_kost.uid_member=member.uid_member', 'left');
        $this->db->group_by('kamar_kost.uid_kamar');
        $this->db->order_by('update_post', 'DESC');
        $this->db->limit($limit, $start);
        return $this->db->get()->result_array();
    }

    private function getKamarFasilitas()
    {
        return $this->db->get('fasilitas_kamar')->result_array();
    }

    // get Kamar For Sewa Form
    public function getFormKamar($uid_kamar)
    {
        $this->db->select('kamar_kost.uid_kamar, kamar_kost.nama, kamar_kost.harga, kamar_kost.diskon, kamar_kost.status, kamar_kost.uid_durasi , gambar_kamar.gambar_satu, kategori_kamar.nama_kategori');
        $this->db->from('kamar_kost');
        $this->db->join('gambar_kamar', 'kamar_kost.uid_kamar=gambar_kamar.uid_kamar');
        $this->db->join('kategori_kamar', 'kamar_kost.uid_kategori=kategori_kamar.uid_kategori');
        $this->db->where('kamar_kost.uid_kamar', $uid_kamar);
        return $this->db->get()->row_array();
    }

    public function getFetured()
    {
        $this->db->select('kamar_kost.*, gambar_kamar.*, kategori_kamar.*, count(testimonial.uid_testimonial) as testicount, ' . $this->queryBintang . '', FALSE);
        $this->db->from('kamar_kost');
        $this->db->join('gambar_kamar', 'kamar_kost.uid_gambar=gambar_kamar.uid_gambar', 'left');
        $this->db->join('kategori_kamar', 'kamar_kost.uid_kategori=kategori_kamar.uid_kategori', 'left');
        $this->db->join('testimonial', 'kamar_kost.uid_kamar=testimonial.uid_kamar', 'left');
        $this->db->group_by('kamar_kost.uid_kamar');
        $this->db->order_by('kamar_kost.date_post', 'desc');
        $this->db->limit('4');
        return $this->db->get()->result_array();
    }

    public function getUidKamar($uid_kamar)
    {
        $this->db->select('kamar_kost.*, gambar_kamar.*, kategori_kamar.*, count(testimonial.uid_testimonial) as testicount, ' . $this->queryBintang . '', FALSE);
        $this->db->from('kamar_kost');
        $this->db->join('gambar_kamar', 'kamar_kost.uid_gambar=gambar_kamar.uid_gambar', 'left');
        $this->db->join('kategori_kamar', 'kamar_kost.uid_kategori=kategori_kamar.uid_kategori', 'left');
        $this->db->join('testimonial', 'kamar_kost.uid_kamar=testimonial.uid_kamar', 'left');
        $this->db->where('kamar_kost.uid_kamar', $uid_kamar);
        return $this->db->get()->row_array();
    }

    public function getDetail($url_title)
    {
        $this->db->select('kamar_kost.*, gambar_kamar.*, kategori_kamar.*,member.username, member.fnama as juragan, member.no_hp as telepon, count(testimonial.uid_testimonial) as testicount, ' . $this->queryBintang . '', FALSE);
        $this->db->from('kamar_kost');
        $this->db->join('gambar_kamar', 'kamar_kost.uid_gambar=gambar_kamar.uid_gambar', 'left');
        $this->db->join('kategori_kamar', 'kamar_kost.uid_kategori=kategori_kamar.uid_kategori', 'left');
        $this->db->join('testimonial', 'kamar_kost.uid_kamar=testimonial.uid_kamar', 'left');
        $this->db->join('member', 'kamar_kost.uid_member=member.uid_member', 'left');
        $this->db->where('kamar_kost.url_title', $url_title);
        return $this->db->get()->row_array();
    }

    public function jumlah_data($kategori = null, $kota = null)
    {
        $this->db->from('kamar_kost');
        $this->db->join('gambar_kamar', 'kamar_kost.uid_gambar=gambar_kamar.uid_gambar', 'left');
        $this->db->join('kategori_kamar', 'kamar_kost.uid_kategori=kategori_kamar.uid_kategori', 'left');
        $this->db->join('testimonial', 'kamar_kost.uid_kamar=testimonial.uid_kamar', 'left');
        $this->db->join('member', 'kamar_kost.uid_member=member.uid_member', 'left');
        if ($kategori && $kota) {
            ($kota == "nil") ? $kota = "" : $kota;
            ($kategori == "nil") ? $kategori = "" : $kategori;
            $this->db->like('kategori_kamar.nama_kategori', $kategori, 'both');
            $this->db->like('kamar_kost.kota', $kota, 'both');
        }
        return $this->db->get()->num_rows();
    }

    public function hitungKamar($status)
    {
        $this->db->from('kamar_kost');
        $this->db->where('status', $status);
        return $this->db->get()->num_rows();
    }

    public function getUidKamarCV($url_title)
    {
        return $this->db->select('uid_kamar')->where('url_title', $url_title)->from('kamar_kost')->limit(1)->get()->row_array();
    }

    public function getDurasi()
    {
        return $this->db->get('durasi_kamar')->result_array();
    }

    public function getFasilitas($params = null, $limit = null)
    {
        if ($params) {
            $this->db->where('tipe', $params);
        } else if ($limit) {
            $this->db->limit($limit);
        }
        return $this->db->get('fasilitas_kamar')->result_array();
    }

    public function getKategori($uid_kategori = null)
    {
        if ($uid_kategori === null) {
            return $this->db->get('kategori_kamar')->result_array();
        } else {
            return $this->db->get_where('kategori_kamar', array('uid_kategori' => $uid_kategori))->result_array();
        }
    }

    public function getGambar($uid_kamar)
    {
        return $this->db->get_where('gambar_kamar', array('uid_kamar' => $uid_kamar))->result_array();
    }

    public function getReview($uid_kamar)
    {
        $this->db->select('testimonial.bintang, testimonial.pesan, testimonial.anonim_status, member.fnama, member.lnama, member.image');
        $this->db->from('testimonial');
        $this->db->join('member', 'testimonial.uid_member=member.uid_member', 'right');
        $this->db->where('testimonial.uid_kamar', $uid_kamar);
        return $this->db->get()->result_array();
    }

    // section admin, juragan, penghuni kamar
    public function getKamar($uid_member = null, $status = null)
    {
        $this->db->select('kamar_kost.*, gambar_kamar.*, kategori_kamar.*, member.fnama as juragan,member.image as fotojuragan ,count(testimonial.uid_testimonial) as testicount, (SELECT COUNT(transaksi.uid_transaksi) FROM transaksi JOIN transaksi_detail ON transaksi.uid_transaksi=transaksi_detail.uid_transaksi WHERE transaksi.jenis="baru" AND transaksi_detail.status="huni" AND transaksi_detail.uid_kamar=kamar_kost.uid_kamar) as terjual,' . $this->queryBintang . '', FALSE);
        $this->db->from('kamar_kost');
        $this->db->join('gambar_kamar', 'kamar_kost.uid_gambar=gambar_kamar.uid_gambar', 'left');
        $this->db->join('kategori_kamar', 'kamar_kost.uid_kategori=kategori_kamar.uid_kategori', 'left');
        $this->db->join('testimonial', 'kamar_kost.uid_kamar=testimonial.uid_kamar', 'left');
        $this->db->join('member', 'kamar_kost.uid_member=member.uid_member', 'left');
        if ($status) {
            $this->db->where('kamar_kost.status', 'validasi');
        }
        $this->db->group_by('kamar_kost.uid_kamar');
        if ($uid_member) {
            $this->db->where('kamar_kost.uid_member', $uid_member);
        }
        $this->db->order_by('update_post', 'DESC');
        return $this->db->get()->result_array();
    }

    public function getKamarDetail($uid_kamar)
    {
        $this->db->select('kamar_kost.*, kategori_kamar.*, member.fnama as juragan,member.image as fotojuragan, member.email as member_email, count(testimonial.uid_testimonial) as testicount,(SELECT COUNT(transaksi.uid_transaksi) FROM transaksi JOIN transaksi_detail ON transaksi.uid_transaksi=transaksi_detail.uid_transaksi WHERE transaksi.jenis="baru" AND transaksi_detail.status="huni" AND transaksi_detail.uid_kamar=kamar_kost.uid_kamar) as terjual, ' . $this->queryBintang . '', FALSE);
        $this->db->from('kamar_kost');
        $this->db->join('kategori_kamar', 'kamar_kost.uid_kategori=kategori_kamar.uid_kategori', 'left');
        $this->db->join('testimonial', 'kamar_kost.uid_kamar=testimonial.uid_kamar', 'left');
        $this->db->join('member', 'kamar_kost.uid_member=member.uid_member', 'left');
        $this->db->where('kamar_kost.uid_kamar', $uid_kamar);
        return $this->db->get()->result_array();
    }

    public function getJuragan()
    {
        return $this->db->get('member')->result_array();
    }

    // crud kamar
    public function addKamar($data)
    {
        $this->db->insert('kamar_kost', $data);
        return ($this->db->affected_rows() === 1) ? TRUE : FALSE;
    }

    public function addGambar($data)
    {
        $this->db->insert('gambar_kamar', $data);
        return ($this->db->affected_rows() === 1) ? TRUE : FALSE;
    }

    public function updateKamar($data, $uid_kamar)
    {
        $this->db->update('kamar_kost', $data, array('uid_kamar' => $uid_kamar));
        return ($this->db->affected_rows() === 1) ? TRUE : FALSE;
    }

    public function updateGambarKamar($data, $uid_gambar)
    {
        $this->db->update('gambar_kamar', $data, array('uid_gambar' => $uid_gambar));
        return ($this->db->affected_rows() === 1) ? TRUE : FALSE;
    }

    public function deleteKamar($uid_kamar, $uid_gambar)
    {
        $this->_deleteGambarKamar($uid_kamar, $uid_gambar);
        $this->db->delete('kamar_kost', array('uid_kamar' => $uid_kamar));
        return ($this->db->affected_rows() === 1) ? TRUE : FALSE;
    }

    function _deleteGambarKamar($uid_kamar, $uid_gambar)
    {
        $this->db->delete('gambar_kamar', array('uid_kamar' => $uid_kamar, 'uid_gambar' => $uid_gambar));
        return ($this->db->affected_rows() === 1) ? TRUE : FALSE;
    }

    public function count($uid_member)
    {
        $this->db->select('sum(jumlah_kamar) as jumlah');
        $this->db->from('kamar_kost');
        $this->db->where('uid_member', $uid_member);
        return $this->db->get()->result_array();
    }

    public function countTerjual($uid_member)
    {
        $this->db->select('uid_kamar');
        $this->db->where('uid_member', $uid_member);
        $kamar = $this->db->get('kamar_kost')->result_array();

        return $kamar;
    }

    public function jumlahKamar($uid_member)
    {
        $this->db->from('kamar_kost');
        $this->db->where('uid_member', $uid_member);
        return $this->db->get()->num_rows();
    }

    public function updateKamarBookingOrHuni($uid_kamar, $jenis)
    {
        if ($jenis == "baru") {
            $this->db->set('status', 1);
            $this->db->where('uid_kamar', $uid_kamar);
            $this->db->update('kamar_kost');
        }
    }

    // get transaksi kamar
    public function transaksiKamar($uid_kamar)
    {
        $this->db->select('transaksi_detail.tanggal_keluar, member.fnama, member.lnama');
        $this->db->join('member', 'transaksi_detail.uid_member=member.uid_member');
        $this->db->where('transaksi_detail.uid_kamar', $uid_kamar);
        $this->db->where('transaksi_detail.status', 'huni');
        $this->db->where('transaksi_detail.tanggal_keluar<=', date('yy-m-d'));
        $this->db->order_by('transaksi_detail.tanggal_keluar', 'DESC');
        $this->db->limit(1);
        return $this->db->get('transaksi_detail')->result_array();
    }

    public function updateKamarTransaksi($uid_kamar, $cek)
    {
        // update transaksi
        if ($cek == 0) {
            $this->db->set('status', 'HABIS');
            $this->db->where('uid_kamar', $uid_kamar);
            $this->db->update('transaksi_detail');
            return true;
        } else {
            return false;
        }
    }

    public function getFilter($params, $fasilitas = null)
    {
        if ($fasilitas) {
            $this->db->where('tipe', $fasilitas);
        }
        return $this->db->get($params)->result_array();
    }

    public function getKamarTerjual($uid_kamar, $uid_member)
    {
        $this->db->select('count(transaksi.uid_transaksi) as terjual');
        $this->db->from('transaksi');
        $this->db->join('transaksi_detail', 'transaksi.uid_transaksi=transaksi_detail.uid_transaksi');
        $this->db->where('transaksi_detail.status', 'huni');
        $this->db->where('transaksi.jenis', 'baru');
        $this->db->where('transaksi_detail.uid_kamar', $uid_kamar);
        $query = $this->db->count_all_results();
        return $query;
    }
}
