<?php

class Chat_m extends CI_Model
{
    // section test
    public function getChat($uid_penerima)
    {
        'max(uid_chat) as uid_chat, uid_pengirim, uid_penerima, SUBSTR(MAX(CONCAT(LPAD(uid_chat, 50), message)), 51) as message, max(time) as time';
        $this->db->select('chat.*,member.fnama, member.uid_member, member.lnama, member.otoritas, member.email, member.image, kamar_kost.nama');
        $this->db->from('chat');
        $this->db->join('member', 'member.uid_member=chat.uid_pengirim');
        $this->db->join('transaksi_detail', 'transaksi_detail.uid_member=chat.uid_pengirim', 'left');
        $this->db->join('kamar_kost', 'kamar_kost.uid_kamar=transaksi_detail.uid_kamar', 'left');
        if (isset($_POST['search'])) {
            $this->db->group_start();
            $this->db->where('member.fnama', $_POST['search'], 'both');
            $this->db->or_where('member.lnama', $_POST['search'], 'both');
            $this->db->group_end();
        } else if (isset($_POST['penghuni'])) {
            $this->db->group_start();
            $this->db->where('transaksi_detail.uid_member is NOT NULL', null, 'both');
            $this->db->group_end();
        }
        $this->db->where('uid_penerima', $uid_penerima);
        $this->db->or_where('uid_pengirim', $uid_penerima);
        $this->db->group_by('uid_pengirim');
        $this->db->order_by('time', 'DESC');
        return $this->db->get()->result_array();
    }

    // section juragan
    public function getPengirim($uid_member)
    {
        $this->db->from('chat');
        $this->db->where('uid_penerima', $uid_member);
        $this->db->or_where('uid_pengirim', $uid_member);
        $this->db->group_by('uid_pengirim');
        return $this->_getPengirimInfo($this->db->get()->result_array());
    }

    public function getPenghuni($uid_juragan)
    {
        $this->db->select('member.uid_member, member.fnama, member.lnama, member.image, member.otoritas, ,member.email');
        $this->db->from('transaksi_detail');
        $this->db->join('member', 'transaksi_detail.uid_member=member.uid_member');
        $this->db->join('kamar_kost', 'transaksi_detail.uid_kamar=kamar_kost.uid_kamar');
        $this->db->where('kamar_kost.uid_member', $uid_juragan);
        $this->db->where('transaksi_detail.status', 'huni');
        return $this->readyChat($this->db->get()->result_array(), $uid_juragan);
    }

    public function readyChat($chat, $uid_juragan)
    {
        $this->db->select('max(uid_chat) as uid_chat, uid_pengirim, uid_penerima, SUBSTR(MAX(CONCAT(LPAD(uid_chat, 50), message)), 51) as message, max(time) as time,member.uid_member, member.fnama, member.lnama, member.otoritas, member.email, member.image, kamar_kost.nama');
        $this->db->from('chat');
        $this->db->where('uid_penerima', $uid_juragan);
        $this->db->join('member', 'member.uid_member=chat.uid_pengirim');
        $this->db->join('transaksi_detail', 'transaksi_detail.uid_member=chat.uid_pengirim');
        $this->db->join('kamar_kost', 'kamar_kost.uid_kamar=transaksi_detail.uid_kamar');
        if (isset($_POST['search'])) {
            $this->db->group_start();
            $this->db->where('member.fnama', $_POST['search'], 'both');
            $this->db->or_where('member.lnama', $_POST['search'], 'both');
            $this->db->group_end();
        }
        $this->db->group_by('uid_pengirim');
        $this->db->order_by('time', 'DESC');
        return $this->db->get()->result_array();
    }

    private function _getPengirimInfo($chat)
    {
        $member = array();
        $this->db->select('uid_member, fnama,lnama, image, otoritas');
        $this->db->group_start();
        foreach ($chat as $chat) {
            $this->db->or_where('uid_member', $chat['uid_penerima']);
        }
        $this->db->group_end();
        return $this->db->get('member')->result_array();
    }

    public function getPenerima($uid_penerima)
    {
        $this->db->select('uid_member, fnama, lnama, image, otoritas, email');
        $this->db->where('uid_member', $uid_penerima);
        return $this->db->get('member')->row_array();
    }

    public function getChatMsg($uid_pengirim, $uid_penerima)
    {
        $this->db->from('chat');
        $this->db->where('uid_penerima', $uid_penerima);
        $this->db->or_where('uid_pengirim', $uid_penerima);
        return $this->db->get()->result_array();
    }

    public function insertChat($data)
    {
        return $this->db->insert('chat', $data);
    }

    // get data juragan
    public function getJuragan($uid_member)
    {
        $this->db->select('kamar_kost.uid_member');
        $this->db->from('transaksi_detail');
        $this->db->join('kamar_kost', 'transaksi_detail.uid_kamar=kamar_kost.uid_kamar');
        $this->db->where('transaksi_detail.uid_member', $uid_member);
        return $this->db->get()->row_array();
    }


    // public function getChat($otoritas_penerima, $member)
    // {
    //     $this->db->from('chat');
    //     $this->db->group_start();
    //     for ($i = 0; $i < count($member); $i++) {
    //         $this->db->or_where('uid_pengirim', $member[$i]['uid_member']);
    //     }
    //     $this->db->group_end();
    //     $this->db->group_by('uid_pengirim');
    //     $this->db->order_by('uid_chat', 'DESC');
    //     return $this->db->get()->result_array();
    // }

    // public function getMember($otoritas)
    // {
    //     $this->db->select('uid_member, fnama, lnama, image, otoritas');
    //     $this->db->from('member');
    //     $this->db->where('otoritas', $otoritas);
    //     return $this->db->get()->result_array();
    // }

    // public function getMemberChat($chat)
    // {
    //     $data = array();
    //     foreach ($chat as $chat) {
    //         $this->db->select('uid_member, fnama, lnama, image, otoritas');
    //         $this->db->where('uid_member', $chat['uid_pengirim']);
    //         $data[] = $this->db->get('member')->result_array();
    //     }
    //     return array_filter($data);
    // }
    // public function allChatAdmin($otoritas)
    // {
    //     $admin = $this->getMemberAdmin();
    //     $this->db->from('chat');
    //     foreach ($admin as $admin) {
    //         $this->db->where('uid_penerima', $admin['uid_member']);
    //     }
    //     $this->db->group_by('uid_pengirim');
    //     $this->db->order_by('time', 'DESC');
    //     $chat = $this->db->get()->result_array();
    //     $data = $this->getMember($chat);
    //     return $data;
    // }

    // public function getMemberAdmin()
    // {
    //     return $this->db->get_where('member', array('otoritas' => 'admin'))->result_array();
    // }

    // // public function getMember($chat)
    // // {
    // //     $data = array();
    // //     foreach ($chat as $chat) {
    // //         $this->db->select('uid_member, fnama, lnama, image, otoritas, email');
    // //         $this->db->from('member');
    // //         $this->db->where('uid_member', $chat['uid_pengirim']);
    // //         $data[] = $this->db->get()->result_array();
    // //     }
    // //     return array_reverse($data);
    // // }





    // public function getJuragan($uid_juragan)
    // {
    //     $this->db->select('member.uid_member, member.fnama, member.lnama, member.image, member.otoritas, member.email');
    //     $this->db->from('transaksi_detail');
    //     $this->db->join('kamar_kost', 'transaksi_detail.uid_kamar=kamar_kost.uid_kamar');
    //     $this->db->join('member', 'member.uid_member=kamar_kost.uid_member');
    //     $this->db->where('transaksi_detail.uid_member', $uid_juragan);
    //     return $this->db->get()->result_array();
    // }

    // public function getPenghuni($uid_member, $params = null)
    // {
    //     $this->db->select('transaksi_detail.uid_member');
    //     $this->db->from('transaksi_detail');
    //     $this->db->join('kamar_kost', 'transaksi_detail.uid_kamar=kamar_kost.uid_kamar');
    //     $this->db->join('member', 'member.uid_member=kamar_kost.uid_member');
    //     $this->db->where('member.uid_member', $uid_member);
    //     $penghuni = $this->db->get()->result_array();
    //     $data = $this->getPenghuniDetail($penghuni, $params);
    //     return $data;
    // }

    // public function getPenerima($uid_penerima)
    // {
    //     return $this->db->select('uid_member, fnama, lnama, image, otoritas, email')->from('member')->where('uid_member', $uid_penerima)->get()->row_array();
    // }

    // public function getPenghuniDetail($data, $params = null)
    // {
    //     $final = array();
    //     foreach ($data as $d) {
    //         $this->db->select('uid_member, fnama, lnama, image, otoritas, email');
    //         $this->db->where('uid_member', $d['uid_member']);
    //         if ($params) {
    //             $this->db->like('fnama', $params, 'both');
    //             $this->db->or_like('fnama', $params, 'both');
    //             $this->db->or_like('lnama', $params, 'both');
    //             $this->db->or_like('lnama', $params, 'both');
    //             $this->db->limit(1);
    //         }
    //         $this->db->where('otoritas', 'penghuni');
    //         $result = $this->db->get('member')->row_array();
    //         array_push($final, $result);
    //     }
    //     if ($params) {
    //         unset($final[1]);
    //         return $final;
    //     } else {
    //         return $final;
    //     }
    // }
}
