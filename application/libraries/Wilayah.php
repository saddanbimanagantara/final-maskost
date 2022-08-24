<?php
if (!defined("BASEPATH")) exit("No direct script access allowed");
class Wilayah
{
    public function provinsi()
    {
        $file_path = base_url('assets/wilayah/provinces.json');
        $json = file_get_contents($file_path);
        return json_decode($json);
    }

    function kabupaten($id = NULL)
    {
        $file_path = base_url('assets/wilayah/regencies/') . $id . '.json';
        $json = file_get_contents($file_path);
        return json_decode($json);
    }
}
