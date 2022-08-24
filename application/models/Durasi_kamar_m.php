<?php

class Durasi_kamar_m extends CI_Model
{
    function getDurasi($uid_durasi = null)
    {
        if ($uid_durasi) {
            return $this->db->get_where('durasi_kamar', array('uid_durasi' => $uid_durasi))->row_array();
        } else {
            return $this->db->get('durasi_kamar')->result_array();
        }
    }

    function addDurasi($data)
    {
        $this->db->insert('durasi_kamar', $data);
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    function editDurasi($data, $uid_durasi)
    {
        $this->db->update('durasi_kamar', $data, array('uid_durasi' => $uid_durasi));
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    function deleteDurasi($uid_durasi)
    {
        $this->db->delete('durasi_kamar', array('uid_durasi' => $uid_durasi));
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }
}
