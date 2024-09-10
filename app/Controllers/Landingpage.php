<?php

namespace App\Controllers;

class Landingpage extends BaseController
{
    public function beranda()
    {
        if (strpos($_SERVER['HTTP_HOST'], 'www.') === 0) {
            $url = 'http://' . substr($_SERVER['HTTP_HOST'], 4) . $_SERVER['REQUEST_URI'];
            header('Location: ' . $url);
            exit();
        }

        $app_settings = model('AppSettings')->find(1);
        $data['title'] = $app_settings['nama_aplikasi'];

        $view['navbar'] = view('landingpage/navbar');
        $view['content'] = view('landingpage/beranda');
        $view['footer'] = view('landingpage/footer');
        return view('landingpage/header', $view);
    }

    public function kebijakanPrivasi()
    {
        $data['title'] = 'Kebijakan Privasi';

        $view['navbar'] = view('landingpage/navbar');
        $view['content'] = view('landingpage/kebijakan_privasi');
        $view['footer'] = view('landingpage/footer');
        return view('landingpage/header', $view);
    }

    public function syaratKetentuan()
    {
        $data['title'] = 'Syarat dan Ketentuan';

        $view['navbar'] = view('landingpage/navbar');
        $view['content'] = view('landingpage/syarat_ketentuan');
        $view['footer'] = view('landingpage/footer');
        return view('landingpage/header', $view);
    }
}
