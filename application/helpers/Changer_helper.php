<?php

function rupiah($angka)
{
    $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
    return $hasil_rupiah;
}
function words_to_stars($text)
{
    $replace = str_replace(substr($text, 20, 20), str_repeat('*', 12), $text);
    return $replace;
}
