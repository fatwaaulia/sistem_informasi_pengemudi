<?php

namespace App\Controllers;

class RiwayatPencarian extends BaseController
{
    protected $base_model;
    protected $base_name;
    protected $upload_path;

    public function __construct()
    {
        $this->base_model   = model('RiwayatPencarian');
        $this->base_name    = 'riwayat_pencarian';
        $this->upload_path  = 'assets/uploads/temuan/';
    }

    public function getData()
    {
        $user_session = model('Users')->where('id', session()->get('id_user'))->first();

        $total_rows = $this->base_model->where('id_peminta', $user_session['id'])->countAllResults();
        $limit = $this->request->getVar('length') ?? $total_rows;
        $offset = $this->request->getVar('start') ?? 0;

        $user_session = model('Users')->where('id', session()->get('id_user'))->first();
        $data = $this->base_model->where('id_peminta', $user_session['id'])->findAll($limit, $offset);
        
        $search = $this->request->getVar('search')['value'] ?? null;
        if ($search) {
            $data       = $this->base_model->like('nik', $search)
                            ->where('id_peminta', $user_session['id'])->findAll($limit, $offset);
            $total_rows = $this->base_model->like('nik', $search)
                            ->where('id_peminta', $user_session['id'])->countAllResults();
        }

        foreach ($data as $key => $v) {
            $data[$key]['no_urut'] = $offset + $key + 1;
            $data[$key]['id'] = encode($v['id']);
            $data[$key]['created_at'] = date('d-m-Y H:i:s', strtotime($v['created_at']));
        }

        return $this->response->setJSON([
            'recordsTotal'    => $this->base_model->where('id_peminta', $user_session['id'])->countAllResults(),
            'recordsFiltered' => $total_rows,
            'data'            => $data,
        ]);
    }

    public function index()
    {
        $data = [
            'get_data'    => $this->base_route . '/get-data',
            'upload_path' => $this->upload_path,
            'base_route'  => $this->base_route,
            'title'       => 'Riwayat Pencarian',
        ];

        $view['sidebar'] = view('dashboard/sidebar');
        $view['content'] = view($this->base_name . '/main', $data);
        return view('dashboard/header', $view);
    }
}
