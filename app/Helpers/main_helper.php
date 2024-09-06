<?php

use CodeIgniter\I18n\Time;

function encode($id)
{
    $key = 'bismillah';
    $hash = substr(hash_hmac('sha256', $id, $key), 0, 5);
    $encode = str_replace('=', '', base64_encode($id . '|' . $hash));
    return $encode;
}

function decode($encode)
{
    $decode = base64_decode($encode);
    list($id) = explode('|', $decode);
    return $id;
}

function dateFormatter($tanggal, $format)
{   
    $date = Time::parse($tanggal, 'Asia/Jakarta', 'id_ID');
    return $date->toLocalizedString($format); // cccc, d MMMM yyyy
}

function cutString($validation_message) // hanya untuk filter pesan validasi
{
    $undersore_to_space = str_replace('_', ' ', $validation_message);
    return $undersore_to_space;
}