<?php

namespace App\Controllers;

class Berlangganan extends BaseController
{
    protected $base_model;
    protected $base_name;
    protected $upload_path;

    public function __construct()
    {
        $this->base_model   = model('PaketLangganan');
        $this->base_name    = 'berlangganan';
        $this->upload_path  = 'assets/uploads/' . $this->base_name . '/';
    }

    public function getData()
    {
        $total_rows = $this->base_model->countAll();
        $limit = $this->request->getVar('length') ?? $total_rows;
        $offset = $this->request->getVar('start') ?? 0;

        $data = $this->base_model->findAll($limit, $offset);
        
        $search = $this->request->getVar('search')['value'] ?? null;
        if ($search) {
            $data       = $this->base_model->like('nama', $search)->findAll($limit, $offset);
            $total_rows = $this->base_model->like('nama', $search)->countAllResults();
        }

        foreach ($data as $key => $v) {
            $data[$key]['no_urut'] = $offset + $key + 1;
            $data[$key]['id'] = encode($v['id']);
            $data[$key]['harga_normal'] = number_format($v['harga_normal'], 0, ',', '.');
            $data[$key]['harga_promo'] = number_format($v['harga_promo'], 0, ',', '.');
        }

        return $this->response->setJSON([
            'recordsTotal'    => $this->base_model->countAll(),
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
            'title'       => ucwords(str_replace('_', ' ', $this->base_name)),
            'paket_langganan' => $data = $this->base_model->findAll(),
        ];

        $view['sidebar'] = view('dashboard/sidebar');
        $view['content'] = view($this->base_name . '/main', $data);
        return view('dashboard/header', $view);
    }

    public function new()
    {
        $data = [
            'base_route' => $this->base_route,
            'title'      => 'Add ' . ucwords(str_replace('_', ' ', $this->base_name)),
        ];

        $view['sidebar'] = view('dashboard/sidebar');
        $view['content'] = view($this->base_name . '/new', $data);
        return view('dashboard/header', $view);
    }

    public function create()
    {
        $rules = [
            'nama_paket'    => "required|is_unique[$this->base_name.nama_paket]",
            'harga_normal'  => 'required',
            'harga_promo'   => 'required',
            'poin'          => 'required',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput();
        } else {
            $data = [
                'nama_paket'    => $this->request->getVar('nama_paket', $this->filter),
                'harga_normal'  => $this->request->getVar('harga_normal', $this->filter),
                'harga_promo'   => $this->request->getVar('harga_promo', $this->filter),
                'label'         => $this->request->getVar('label', $this->filter),
                'deskripsi'     => $this->request->getVar('deskripsi', $this->filter),
                'poin'          => $this->request->getVar('poin', $this->filter),
            ];

            $this->base_model->insert($data);
            return redirect()->to($this->base_route)
            ->with('message',
            "<script>
                Swal.fire({
                icon: 'success',
                title: 'Data berhasil ditambahkan',
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true,
                })
            </script>");
        }
    }
}
