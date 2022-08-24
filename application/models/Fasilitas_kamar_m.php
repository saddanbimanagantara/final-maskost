<?php

class Fasilitas_kamar_m extends CI_Model
{
    function getFasilitas($uid_fasilitas = null)
    {
        if ($uid_fasilitas) {
            return $this->db->get_where('fasilitas_kamar', array('uid_fasilitas' => $uid_fasilitas))->row_array();
        } else {
            return $this->db->get('fasilitas_kamar')->result_array();
        }
    }

    function addFasilitas($data)
    {
        $this->db->insert('fasilitas_kamar', $data);
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    function editFasilitas($data, $uid_fasilitas)
    {
        $this->db->update('fasilitas_kamar', $data, array('uid_fasilitas' => $uid_fasilitas));
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    function deleteFasilitas($uid_fasilitas)
    {
        $this->db->delete('fasilitas_kamar', array('uid_fasilitas' => $uid_fasilitas));
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }
}
