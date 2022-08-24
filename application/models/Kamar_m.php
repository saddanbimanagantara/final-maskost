<?php

class Kamar_m extends CI_Model
{
    var $queryBintang = "sum(if(testimonial.bintang = 5,testimonial.bintang,NULL)) as limabintang,sum(if(testimonial.bintang = 4,testimonial.bintang,NULL)) as empatbintang, sum(if(testimonial.bintang = 3,testimonial.bintang,NULL)) as tigabintang, sum(if(testimonial.bintang = 2,testimonial.bintang,NULL)) as duabintang,sum(if(testimonial.bintang = 1,testimonial.bintang,NULL)) as satubintang";

    public function get($limit, $start, $kategori = null, $kota = null)
    {
        $this->db->select('kamar_kost.*, gambar_kamar.*, kategori_kamar.*, member.fnama as juragan, count(testimonial.uid_testimonial) as testicount, ' . $this->queryBintang . '', FALSE);
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
        $this->db->group_by('kamar_kost.uid_kamar');
        $this->db->order_by('update_post', 'DESC');
        $this->db->limit($limit, $start);
        return $this->db->get()->result_array();
    }

    // get Kamar For Sewa Form
    public function getFormKamar($uid_kamar)
    {
        $this->db->select('kamar_kost.uid_kamar, kamar_kost.nama, kamar_kost.harga, kamar_kost.diskon, kamar_kost.status, kamar_kost.uid_durasi , gambar_kamar.gambar_satu');
        $this->db->from('kamar_kost');
        $this->db->join('gambar_kamar', 'kamar_kost.uid_kamar=gambar_kamar.uid_kamar');
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
        $this->db->select('kamar_kost.*, gambar_kamar.*, kategori_kamar.*,member.fnama as juragan, count(testimonial.uid_testimonial) as testicount, ' . $this->queryBintang . '', FALSE);
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

    public function getFasilitas()
    {
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
        $this->db->select('testimonial.bintang, testimonial.pesan, testimonial.anonim_status, member.fnama, member.lnama, member.image as foto');
        $this->db->from('testimonial');
        $this->db->join('member', 'testimonial.uid_member=member.uid_member', 'right');
        $this->db->where('testimonial.uid_kamar', $uid_kamar);
        return $this->db->get()->result_array();
    }

    // section admin, juragan, penghuni kamar
    public function getKamar($uid_member = null)
    {
        $this->db->select('kamar_kost.*, gambar_kamar.*, kategori_kamar.*, member.fnama as juragan,member.image as fotojuragan, count(testimonial.uid_testimonial) as testicount, ' . $this->queryBintang . '', FALSE);
        $this->db->from('kamar_kost');
        $this->db->join('gambar_kamar', 'kamar_kost.uid_gambar=gambar_kamar.uid_gambar', 'left');
        $this->db->join('kategori_kamar', 'kamar_kost.uid_kategori=kategori_kamar.uid_kategori', 'left');
        $this->db->join('testimonial', 'kamar_kost.uid_kamar=testimonial.uid_kamar', 'left');
        $this->db->join('member', 'kamar_kost.uid_member=member.uid_member', 'left');
        $this->db->group_by('kamar_kost.uid_kamar');
        if ($uid_member) {
            $this->db->where('kamar_kost.uid_member', $uid_member);
        }
        return $this->db->get()->result_array();
    }

    public function getKamarDetail($uid_kamar)
    {
        $this->db->select('kamar_kost.*, kategori_kamar.*, member.fnama as juragan,member.image as fotojuragan, count(testimonial.uid_testimonial) as testicount, ' . $this->queryBintang . '', FALSE);
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

    public function count($status, $uid_member)
    {
        $this->db->from('kamar_kost');
        $this->db->where('uid_member', $uid_member);
        $this->db->where('status', $status);
        return $this->db->get()->num_rows();
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
            $this->db->set('status', 0);
            $this->db->update('kamar_kost');
            $this->db->where('uid_kamar', $uid_kamar);
        } else {
        }
    }
}
