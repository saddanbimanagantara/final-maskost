<?php

function ratingcount($bintang, $user)
{
    if ($user == 0) {
        $rate = 0;
        return $rate;
    }
    $rate = (int)($bintang / $user);
    return $rate;
}

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function generateUidGambar()
{
    $ci = get_instance();
    $uid_gambar = generateRandomString();
    $ci->db->get_where('gambar_kamar', array('uid_gambar' => $uid_gambar));
    if ($ci->db->affected_rows() >= 1) {
        return false;
    }
    return $uid_gambar;
}

function uploadVerificationKamar($name, $nameHidden, $filename, $path)
{
    $ci = &get_instance();
    return ($_FILES[$name]['error'] === 4) ? $nameHidden : uploadImageProfileKamar($name, $nameHidden, $filename, $path);
}

function uploadImageProfileKamar($name, $nameHidden, $filename, $path)
{
    $ci = get_instance();
    $ci->load->library('upload');
    $config['upload_path'] = FCPATH . $path;
    $config['file_name'] = $filename;
    $config['allowed_types'] = 'jpg|png';
    $ci->upload->initialize($config);
    if (!$ci->upload->do_upload($name)) {
        $error = array('error' => $ci->upload->display_errors());
        echo json_encode($error);
    } else {
        $data = array('upload_data' => $ci->upload->data());
        $filapath = $path . $nameHidden;
        deleteImageProfileKamar($filapath);
        return $data['upload_data']['file_name'];
    }
}

function deleteImageProfileKamar($filename)
{
    unlink($filename);
}
