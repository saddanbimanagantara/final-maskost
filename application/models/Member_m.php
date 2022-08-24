<?php

class Member_m extends CI_Model
{
    // crud juragan
    function getMember($params = null, $uid_member = null)
    {
        if ($uid_member && $params) {
            return $this->db->get_where('member', array('uid_member' => $uid_member, 'otoritas' => $params))->row_array();
        } else if ($params) {
            return $this->db->get_where('member', array('otoritas' => $params))->result_array();
        } else if ($uid_member) {
            return $this->db->get_where('member', array('uid_member' => $params))->result_array();
        } else {
            return $this->db->get('member')->result_array();
        }
    }

    function addMember($data)
    {
        $this->db->insert('member', $data);
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    function editMember($data, $uid_member)
    {
        $this->db->update('member', $data, array('uid_member' => $uid_member));
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    function deleteMember($uid_member)
    {
        $this->db->delete('member', array('uid_member' => $uid_member));
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    function getSaldo($uid_member)
    {
        $this->db->select_sum('jumlah_pembayaran');
        $this->db->from('transaksi');
        $this->db->join('transaksi_detail', 'transaksi_detail.uid_transaksi=transaksi.uid_transaksi');
        $this->db->join('kamar_kost
        ', 'transaksi_detail.uid_kamar=kamar_kost.uid_kamar');
        $this->db->where('kamar_kost.uid_member', $uid_member);
        return $this->db->get()->row_array();
    }

    public function hitungMember($otoritas)
    {
        $this->db->from('member');
        $this->db->where('otoritas', $otoritas);
        return $this->db->get()->num_rows();
    }

    public function getKamarMember($uid_member)
    {
        $this->db->select('transaksi_detail.uid_transaksi, kamar_kost.uid_kamar, kamar_kost.uid_member');
        $this->db->from('transaksi_detail');
        $this->db->join('kamar_kost', 'transaksi_detail.uid_kamar=kamar_kost.uid_kamar');
        $this->db->where('transaksi_detail.uid_member', $uid_member);
        return $this->db->get()->row_array();
    }
}
