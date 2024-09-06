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

    public function berita()
    {
        $model_berita = model('Berita');
        $limit        = 10; // jumlah data per page
        $search       = $this->request->getVar('search', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ($search) {
            $total_rows = $model_berita->like('judul', $search)->countAllResults();
            $page_now   = $this->request->getVar('page') ?? 1;
            $offset     = ($page_now) ? (($page_now - 1) * $limit) : 0;
            $berita     = $model_berita->like('judul', $search)->findAll($limit, $offset);
        } else {
            $total_rows = $model_berita->countAll();
            $page_now   = $this->request->getVar('page') ?? 1;
            $offset     = ($page_now) ? (($page_now - 1) * $limit) : 0;
            $berita     = $model_berita->findAll($limit, $offset);
        }

        $data = [
            'berita'        => $berita,
            'total_pages'   => ceil($total_rows / $limit),
            'page_now'      => $page_now,
            'search'        => $search,
            'berita_rekomendasi' => $model_berita->orderBy('created_at', 'RANDOM')->findAll(4),
            'title' => 'Berita',
        ];
        
        $view['navbar'] = view('landingpage/navbar');
        $view['content'] = view('landingpage/berita', $data);
        $view['footer'] = view('landingpage/footer');
        return view('landingpage/header', $view);
    }

    public function artikel($slug)
    {
        $model_berita = model('Berita');
        $berita = $model_berita->where('slug', $slug)->first();

        $data = [
            'berita' => $berita,
            'berita_rekomendasi' => $model_berita->orderBy('created_at', 'RANDOM')->findAll(4),
            'title' => $berita['judul'],
        ];

        $model_berita->update($berita['id'], ['viewed' => (int)$berita['viewed'] + 1]);

        $view['navbar'] = view('landingpage/navbar');
        $view['content'] = view('landingpage/artikel', $data);
        $view['footer'] = view('landingpage/footer');
        return view('landingpage/header', $view);
    }
}
