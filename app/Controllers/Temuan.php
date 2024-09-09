<?php

namespace App\Controllers;

class Temuan extends BaseController
{
    protected $base_model;
    protected $base_name;
    protected $upload_path;

    public function __construct()
    {
        $this->base_model   = model('Temuan');
        $this->base_name    = 'temuan';
        $this->upload_path  = 'assets/uploads/' . $this->base_name . '/';
    }

    /*--------------------------------------------------------------
    # Lapor Temuan
    --------------------------------------------------------------*/
    public function getData()
    {
        $total_rows = $this->base_model->countAll();
        $limit = $this->request->getVar('length') ?? $total_rows;
        $offset = $this->request->getVar('start') ?? 0;

        $user_session = model('Users')->where('id', session()->get('id_user'))->first();
        $data = $this->base_model->where('id_pelapor', $user_session['id'])->findAll($limit, $offset);
        
        $search = $this->request->getVar('search')['value'] ?? null;
        if ($search) {
            $data       = $this->base_model->like('nama', $search)->findAll($limit, $offset);
            $total_rows = $this->base_model->like('nama', $search)->countAllResults();
        }

        foreach ($data as $key => $v) {
            $data[$key]['no_urut'] = $offset + $key + 1;
            $data[$key]['id'] = encode($v['id']);
            $data[$key]['bukti'] = $v['bukti'] ? base_url($this->upload_path) . $v['bukti'] : base_url('assets/uploads/default.png');
            $data[$key]['tanggal'] = date('d-m-Y', strtotime($v['tanggal']));
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
            'title'       => 'Lapor Temuan',
        ];

        $view['sidebar'] = view('dashboard/sidebar');
        $view['content'] = view($this->base_name . '/main', $data);
        return view('dashboard/header', $view);
    }

    public function new()
    {
        $data = [
            'base_route' => $this->base_route,
            'title'      => 'Add Lapor Temuan',
        ];

        $view['sidebar'] = view('dashboard/sidebar');
        $view['content'] = view($this->base_name . '/new', $data);
        return view('dashboard/header', $view);
    }

    public function create()
    {
        $rules = [
            'nik'     => "required|numeric",
            'nama'    => 'required',
            'rincian' => 'required',
            'tanggal' => 'required',
            'bukti'   => 'max_size[bukti,1024]|ext_in[bukti,png,jpg,jpeg]|mime_in[bukti,image/png,image/jpg,image/jpeg]|is_image[bukti]',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput();
        } else {
            $bukti = $this->request->getFile('bukti');
            if ($bukti != '') {
                $bukti_name = $bukti->getRandomName();
                $this->image->withFile($bukti)->save($this->upload_path . $bukti_name, 60);
            } else {
                $bukti_name = '';
            }

            $data = [
                'id_pelapor' => $this->user_session['id'],
                'nik'        => $this->request->getVar('nik', $this->filter),
                'nama'       => $this->request->getVar('nama', $this->filter),
                'rincian'    => $this->request->getVar('rincian', $this->filter),
                'tanggal'    => $this->request->getVar('tanggal', $this->filter),
                'bukti'      => $bukti_name,
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
            'title'       => 'Edit Lapor Temuan',
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
            'nik'     => "required|numeric",
            'nama'    => 'required',
            'rincian' => 'required',
            'tanggal' => 'required',
            'bukti'   => 'max_size[bukti,1024]|ext_in[bukti,png,jpg,jpeg]|mime_in[bukti,image/png,image/jpg,image/jpeg]|is_image[bukti]',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput();
        } else {
            $bukti = $this->request->getFile('bukti');
            if ($bukti != '') {
                $file = $this->upload_path . $find_data['bukti'];
                if (is_file($file)) unlink($file);
                $bukti_name = $bukti->getRandomName();
                $this->image->withFile($bukti)->save($this->upload_path . $bukti_name, 60);
            } else {
                $bukti_name = $find_data['bukti'];
            }

            $data = [
                'nik'     => $this->request->getVar('nik', $this->filter),
                'nama'    => $this->request->getVar('nama', $this->filter),
                'rincian' => $this->request->getVar('rincian', $this->filter),
                'tanggal' => $this->request->getVar('tanggal', $this->filter),
                'bukti'   => $bukti_name,
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

        $bukti = $this->upload_path . $find_data['bukti'];
        if (is_file($bukti)) unlink($bukti);

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

    /*--------------------------------------------------------------
    # Cari Temuan
    --------------------------------------------------------------*/
    public function cariTemuan()
    {
        $nik = $this->request->getVar('nik', FILTER_SANITIZE_NUMBER_INT);
        $cek_temuan = $this->base_model->where('nik', $nik)->findAll();

        if ($nik) {
            if ($cek_temuan) {
                $get_data = [
                    'id_temuan'  => json_encode(array_column($cek_temuan, 'id'), true),
                    'id_pelapor' => json_encode(array_column($cek_temuan, 'id_pelapor'), true),
                    'nama'       => json_encode(array_column($cek_temuan, 'nama'), true),
                    'rincian'    => json_encode(array_column($cek_temuan, 'rincian'), true),
                    'tanggal'    => json_encode(array_column($cek_temuan, 'tanggal'), true),
                    'bukti'      => json_encode(array_column($cek_temuan, 'bukti'), true),
                ];
            }
            $get_data['nik'] = $nik;
            $get_data['id_peminta'] = $this->user_session['id'];

            model('RiwayatPencarian')->insert($get_data);

            $user_session = model('Users')->where('id', session()->get('id_user'))->first();
            $data = [
                'poin' => $user_session['poin'] - 1, 
            ];
            model('Users')->update($user_session['id'], $data);
        }

        $data = [
            'get_data'    => $this->base_route . '/get-data',
            'upload_path' => $this->upload_path,
            'base_route'  => $this->base_route,
            'title'       => 'Cari Temuan',
            'nik'         => $nik,
            'status'      => $cek_temuan ? 'NIK ditemukan' : 'NIK tidak ditemukan',
            'data'        => $this->base_model->where('nik', $nik)->findAll(),
        ];

        $view['sidebar'] = view('dashboard/sidebar');
        $view['content'] = view($this->base_name . '/cari_temuan', $data);
        return view('dashboard/header', $view);
    }
}
