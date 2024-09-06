<?php

namespace App\Controllers;

class FormInput extends BaseController
{
    protected $base_model;
    protected $base_name;
    protected $upload_path;

    public function __construct()
    {
        $this->base_model   = model('FormInput');
        $this->base_name    = 'form_input';
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
            $data[$key]['gambar'] = $v['gambar'] ? base_url($this->upload_path) . $v['gambar'] : base_url('assets/uploads/default.png');
            $data[$key]['harga'] = number_format($v['harga'], 0, ',', '.');
            $data[$key]['tanggal_kegiatan'] = dateFormatter($v['tanggal_kegiatan'], 'cccc, d MMMM yyyy');
            $data[$key]['created_at'] = date('d-m-Y H:i:s', strtotime($v['created_at']));
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
            'nama'              => "required|is_unique[$this->base_name.nama]",
            'harga'             => 'required',
            'deskripsi'         => 'required',
            'dokumen_pendukung' => 'max_size[dokumen_pendukung,2048]|ext_in[dokumen_pendukung,pdf]|mime_in[dokumen_pendukung,application/pdf]',
            'gambar'            => 'uploaded[gambar]|max_size[gambar,1024]|ext_in[gambar,png,jpg,jpeg]|mime_in[gambar,image/png,image/jpg,image/jpeg]|is_image[gambar]',
            'tanggal_kegiatan'  => 'required',
            'select_multiple'   => 'required',
            'checkbox'          => 'required',
            'radio'             => 'required',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput();
        } else {
            $dokumen_pendukung = $this->request->getFile('dokumen_pendukung');
            if ($dokumen_pendukung != '') {
                $dokumen_pendukung_name = $dokumen_pendukung->getRandomName();
                $dokumen_pendukung->move($this->upload_path, $dokumen_pendukung_name);
            } else {
                $dokumen_pendukung_name = '';
            }

            $gambar = $this->request->getFile('gambar');
            if ($gambar != '') {
                $gambar_name = $gambar->getRandomName();
                $this->image->withFile($gambar)->save($this->upload_path . $gambar_name, 60);
            } else {
                $gambar_name = '';
            }

            $nama = trim($this->request->getVar('nama', $this->filter));
            $data = [
                'nama'              => $nama,
                'slug'              => url_title($nama, '-', true),
                'harga'             => $this->request->getVar('harga', $this->filter),
                'deskripsi'         => $this->request->getVar('deskripsi', $this->filter),
                'dokumen_pendukung' => $dokumen_pendukung_name,
                'gambar'            => $gambar_name,
                'tanggal_kegiatan'  => $this->request->getVar('tanggal_kegiatan', $this->filter),
                'select_multiple'   => json_encode($this->request->getVar('select_multiple', $this->filter), true),
                'checkbox'          => json_encode($this->request->getVar('checkbox', $this->filter), true),
                'radio'             => $this->request->getVar('radio', $this->filter),
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

    public function edit($id_encode = null)
    {
        $id = decode($id_encode);

        $data = [
            'data'        => $this->base_model->find($id),
            'upload_path' => $this->upload_path,
            'base_route'  => $this->base_route,
            'title'       => 'Edit ' . ucwords(str_replace('_', ' ', $this->base_name)),
        ];
        
        $view['sidebar'] = view('dashboard/sidebar');
        $view['content'] = view($this->base_name . '/edit', $data);
        return view('dashboard/header', $view);
    }

    public function update($id_encode = null)
    {
        $id = decode($id_encode);
        $find_data = $this->base_model->find($id);

        $rules = [
            'nama'              => "required|is_unique[$this->base_name.nama,id,$id]",
            'harga'             => 'required',
            'deskripsi'         => 'required',
            'dokumen_pendukung' => 'max_size[dokumen_pendukung,2048]|ext_in[dokumen_pendukung,pdf]|mime_in[dokumen_pendukung,application/pdf]',
            'gambar'            => 'max_size[gambar,1024]|ext_in[gambar,png,jpg,jpeg]|mime_in[gambar,image/png,image/jpg,image/jpeg]|is_image[gambar]',
            'tanggal_kegiatan'  => 'required',
            'select_multiple'   => 'required',
            'checkbox'          => 'required',
            'radio'             => 'required',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput();
        } else {
            $dokumen_pendukung = $this->request->getFile('dokumen_pendukung');
            if ($dokumen_pendukung != '') {
                $file = $this->upload_path . $find_data['dokumen_pendukung'];
                if (is_file($file)) unlink($file);
                $dokumen_pendukung_name = $dokumen_pendukung->getRandomName();
                $dokumen_pendukung->move($this->upload_path, $dokumen_pendukung_name);
            } else {
                $dokumen_pendukung_name = $find_data['dokumen_pendukung'];
            }

            $gambar = $this->request->getFile('gambar');
            if ($gambar != '') {
                $file = $this->upload_path . $find_data['gambar'];
                if (is_file($file)) unlink($file);
                $gambar_name = $gambar->getRandomName();
                $this->image->withFile($gambar)->save($this->upload_path . $gambar_name, 60);
            } else {
                $gambar_name = $find_data['gambar'];
            }

            $nama = trim($this->request->getVar('nama', $this->filter));
            $data = [
                'nama'              => $nama,
                'slug'              => url_title($nama, '-', true),
                'harga'             => $this->request->getVar('harga', $this->filter),
                'deskripsi'         => $this->request->getVar('deskripsi', $this->filter),
                'dokumen_pendukung' => $dokumen_pendukung_name,
                'gambar'            => $gambar_name,
                'tanggal_kegiatan'  => $this->request->getVar('tanggal_kegiatan', $this->filter),
                'select_multiple'   => json_encode($this->request->getVar('select_multiple', $this->filter), true),
                'checkbox'          => json_encode($this->request->getVar('checkbox', $this->filter), true),
                'radio'             => $this->request->getVar('radio', $this->filter),
            ];

            $this->base_model->update($id, $data);
            return redirect()->to($this->base_route)
            ->with('message',
            "<script>
                Swal.fire({
                icon: 'success',
                title: 'Perubahan disimpan',
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true,
                })
            </script>");
        }
    }

    public function delete($id_encode = null)
    {
        $id = decode($id_encode);
        $find_data = $this->base_model->find($id);

        $dokumen_pendukung = $this->upload_path . $find_data['dokumen_pendukung'];
        if (is_file($dokumen_pendukung)) unlink($dokumen_pendukung);

        $gambar = $this->upload_path . $find_data['gambar'];
        if (is_file($gambar)) unlink($gambar);

        $this->base_model->delete($id);
        return redirect()->to($this->base_route)
        ->with('message',
        "<script>
            Swal.fire({
            icon: 'success',
            title: 'Data berhasil dihapus',
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true,
            })
        </script>");
    }
}
