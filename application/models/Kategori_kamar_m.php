<?php

class Kategori_kamar_m extends CI_Model
{
    function getKategori($uid_kategori = null)
    {
        if ($uid_kategori) {
            return $this->db->get_where('kategori_kamar', array('uid_kategori' => $uid_kategori))->row_array();
        } else {
            return $this->db->get('kategori_kamar')->result_array();
        }
    }

    function editKategori($data, $uid_kategori)
    {
        $this->db->update('kategori_kamar', $data, array('uid_kategori' => $uid_kategori));
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    function addKategori($data)
    {
        $this->db->insert('kategori_kamar', $data);
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    function deleteKategori($uid_kategori)
    {
        $this->db->delete('kategori_kamar', array('uid_kategori' => $uid_kategori));
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }
}
