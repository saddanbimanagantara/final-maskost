<?php

function uuid_generate()
{
    return sprintf(
        '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff)
    );
}

function uuid_check($uuid, $table, $uid_name)
{
    $ci = get_instance();
    $checked = $ci->db->from($table)->where($uid_name, $uuid)->get();
    return ($checked->num_rows() > 0) ? 0 : $uuid;
}

function uploadVerification($name, $nameHidden, $filename, $path, $action)
{
    $ci = &get_instance();
    return ($_FILES[$name]['error'] === 4) ? $nameHidden : uploadImageProfile($name, $nameHidden, $filename, $path, $action);
}

function uploadImageProfile($name, $nameHidden, $filename, $path, $action)
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
        if ($action == 'add') {
        } else {
            deleteImageProfile($filapath);
        }
        return $data['upload_data']['file_name'];
    }
}

function deleteImageProfile($filename)
{
    unlink($filename);
}
