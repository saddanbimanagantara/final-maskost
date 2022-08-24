<?php

class User_m extends CI_Model
{

    public function getUser($uid_user = null, $level = null)
    {
        if ($uid_user && $level) {
            return $this->db->get_where('user', array('uid_user' => $uid_user, 'level' => $level))->row_array();
        } else if ($uid_user) {
            return $this->db->get_where('user', array('uid_user' => $uid_user))->row_array();
        } else if ($level) {
            return $this->db->get_where('user', array('level' => $level))->result_array();
        } else {
            return $this->db->get('user')->result_array();
        }
    }

    public function get()
    {
        return $this->db->get('user')->result();
    }

    public function getRekening($uid_member)
    {
        return $this->db->get_where('rekening', array('uid_member' => $uid_member))->result_array();
    }

    public function addUser($data)
    {
        $this->db->insert('user', $data);
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function editUser($data, $uid_user)
    {
        $this->db->update('user', $data, array('uid_user' => $uid_user));
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function deleteUser($uid_user)
    {
        $this->db->delete('user', array('uid_user' => $uid_user));
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function getTestimonial($uid_member, $uid_kamar, $uid_transaksi = null)
    {
        if ($uid_transaksi) {
            $this->db->where('uid_transaksi', $uid_transaksi);
        }
        $this->db->where('uid_member', $uid_member);
        $this->db->where('uid_kamar', $uid_kamar);
        return $this->db->get('testimonial')->row_array();
    }
}
