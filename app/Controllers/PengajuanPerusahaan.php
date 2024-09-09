<?php

namespace App\Controllers;

class PengajuanPerusahaan extends BaseController
{
    protected $base_model;
    protected $base_name;
    protected $upload_path;

    public function __construct()
    {
        $this->base_model   = model('Users');
        $this->base_name    = 'users';
        $this->upload_path  = 'assets/uploads/' . $this->base_name . '/';
    }

    /*--------------------------------------------------------------
    # Superadmin / Admin
    --------------------------------------------------------------*/
    public function getData()
    {
        $total_rows = $this->base_model->countAll();
        $limit = $this->request->getVar('length') ?? $total_rows;
        $offset = $this->request->getVar('start') ?? 0;

        $data = $this->base_model->whereIn('status_pengajuan_perusahaan', ['Menunggu Verifikasi', 'Ditolak'])
                ->orderBy('submission_at ASC')
                ->findAll($limit, $offset);

        $search = $this->request->getVar('search')['value'] ?? null;
        if ($search) {
            $data       = $this->base_model->whereIn('status_pengajuan_perusahaan', ['Menunggu Verifikasi', 'Ditolak'])
                            ->orderBy('submission_at ASC')
                            ->like('nama_perusahaan', $search)->findAll($limit, $offset);
            $total_rows = $this->base_model->whereIn('status_pengajuan_perusahaan', ['Menunggu Verifikasi', 'Ditolak'])
                            ->orderBy('submission_at ASC')
                            ->like('nama_perusahaan', $search)->countAllResults();
        }

        foreach ($data as $key => $v) {
            $data[$key]['no_urut'] = $offset + $key + 1;
            $data[$key]['id'] = encode($v['id']);
            $data[$key]['submission_at'] = date('d-m-Y H:i:s', strtotime($v['submission_at']));
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
        $view['content'] = view('pengajuan_perusahaan/main', $data);
        return view('dashboard/header', $view);
    }

    public function edit($id_encode = null)
    {
        $id = decode($id_encode);

        $data = [
            'data'        => $this->base_model->find($id),
            'upload_path' => $this->upload_path,
            'base_route'  => $this->base_route,
            'title'       => 'Pengajuan Perusahaan',
        ];
        
        $view['sidebar'] = view('dashboard/sidebar');
        $view['content'] = view('pengajuan_perusahaan/edit', $data);
        return view('dashboard/header', $view);
    }

    public function update($id_encode = null)
    {
        $id = decode($id_encode);
        $find_data = $this->base_model->find($id);

        $rules = [
            'status_pengajuan_perusahaan' => 'required',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput();
        } else {
            $status_pengajuan_perusahaan = $this->request->getVar('status_pengajuan_perusahaan', $this->filter);

            if ($status_pengajuan_perusahaan == 'Ditolak') {
                $dokumen_akta_perusahaan_filename = '';
                $dokumen_akta_perusahaan = $this->upload_path . 'dokumen_akta_perusahaan/' . $find_data['dokumen_akta_perusahaan'];
                if (is_file($dokumen_akta_perusahaan)) unlink($dokumen_akta_perusahaan);

            }
            
            $checked_at = null;
            if ($status_pengajuan_perusahaan == 'Aktif') {
                $dokumen_akta_perusahaan_filename = $find_data['dokumen_akta_perusahaan'];
                $checked_at = date('Y-m-d H:i:s');
            }

            $data = [
                'dokumen_akta_perusahaan'     => $dokumen_akta_perusahaan_filename,
                'status_pengajuan_perusahaan' => $status_pengajuan_perusahaan,
                'checked_at'                  => $checked_at,
            ];

            $this->base_model->update($id, $data);
            return redirect()->to($this->base_route)
            ->with('message',
            "<script>
                Swal.fire({
                icon: 'success',
                title: 'Status pengajuan $status_pengajuan_perusahaan',
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

        $dokumen_akta_perusahaan = $this->upload_path . 'dokumen_akta_perusahaan/' . $find_data['dokumen_akta_perusahaan'];
        if (is_file($dokumen_akta_perusahaan)) unlink($dokumen_akta_perusahaan);

        $data = [
            'no_akta_perusahaan'          => '',
            'dokumen_akta_perusahaan'     => '',
            'status_pengajuan_perusahaan' => 'Pending',
            'submission_at'  => null,
        ];

        $this->base_model->update($id, $data);
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

    public function getDataPerusahaanAktif()
    {
        $total_rows = $this->base_model->countAll();
        $limit = $this->request->getVar('length') ?? $total_rows;
        $offset = $this->request->getVar('start') ?? 0;

        $data = $this->base_model->where('status_pengajuan_perusahaan', 'Aktif')->findAll($limit, $offset);
        
        $search = $this->request->getVar('search')['value'] ?? null;
        if ($search) {
            $data       = $this->base_model->where('status_pengajuan_perusahaan', 'Aktif')->like('nama', $search)->findAll($limit, $offset);
            $total_rows = $this->base_model->where('status_pengajuan_perusahaan', 'Aktif')->like('nama', $search)->countAllResults();
        }

        foreach ($data as $key => $v) {
            $data[$key]['no_urut'] = $offset + $key + 1;
            $data[$key]['id'] = encode($v['id']);
            $data[$key]['checked_at'] = date('d-m-Y H:i:s', strtotime($v['checked_at']));
        }

        return $this->response->setJSON([
            'recordsTotal'    => $this->base_model->countAll(),
            'recordsFiltered' => $total_rows,
            'data'            => $data,
        ]);
    }

    public function perusahaanAktif()
    {
        $data = [
            'get_data'    => $this->base_route . '/get-data',
            'upload_path' => $this->upload_path,
            'base_route'  => $this->base_route,
            'title'       => 'Perusahaan',
        ];

        $view['sidebar'] = view('dashboard/sidebar');
        $view['content'] = view('pengajuan_perusahaan/perusahaan_aktif', $data);
        return view('dashboard/header', $view);
    }

    public function detailPerusahaanAktif($id_encode = null)
    {
        $id = decode($id_encode);

        $data = [
            'data'        => $this->base_model->find($id),
            'upload_path' => $this->upload_path,
            'base_route'  => $this->base_route,
            'title'       => 'Detail Perusahaan',
        ];
        
        $view['sidebar'] = view('dashboard/sidebar');
        $view['content'] = view('pengajuan_perusahaan/detail_perusahaan_aktif', $data);
        return view('dashboard/header', $view);
    }

    /*--------------------------------------------------------------
    # Perusahaan
    --------------------------------------------------------------*/
    public function kirimPengajuan()
    {
        $id = $this->user_session['id'];

        $data = [
            'data'        => $this->base_model->find($id),
            'upload_path' => $this->upload_path,
            'base_route'  => $this->base_route,
            'title'       => 'Pengajuan Perusahaan',
        ];
        
        $view['sidebar'] = view('dashboard/sidebar');
        $view['content'] = view('pengajuan_perusahaan/kirim_pengajuan', $data);
        return view('dashboard/header', $view);
    }

    public function prosesKirimPengajuan()
    {
        $id = $this->user_session['id'];
        $find_data = $this->base_model->find($id);

        $uploaded = '';
        if ($find_data['dokumen_akta_perusahaan'] == '') {
            $uploaded = 'uploaded[dokumen_akta_perusahaan]|';
        }

        $rules = [
            'nama'          => 'required',
            'jenis_kelamin' => 'required',
            'no_ponsel'     => 'required',
            'nama_perusahaan'         => "required|is_unique[$this->base_name.nama_perusahaan,id,$id]",
            'alamat_perusahaan'       => 'required',
            'no_telepon_perusahaan'   => "required|is_unique[$this->base_name.no_telepon_perusahaan,id,$id]",
            'email_perusahaan'        => "required|valid_email|is_unique[users.email_perusahaan,id,$id]",
            'no_akta_perusahaan'      => "required|is_unique[$this->base_name.no_akta_perusahaan,id,$id]",
            'dokumen_akta_perusahaan' => $uploaded . 'max_size[dokumen_akta_perusahaan,10240]|ext_in[dokumen_akta_perusahaan,pdf]|mime_in[dokumen_akta_perusahaan,application/pdf]',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput();
        } else {
            $dokumen_akta_perusahaan = $this->request->getFile('dokumen_akta_perusahaan');
            if ($dokumen_akta_perusahaan != '') {
                $file = $this->upload_path . $find_data['dokumen_akta_perusahaan'];
                if (is_file($file)) unlink($file);
                $dokumen_akta_perusahaan_name = $dokumen_akta_perusahaan->getRandomName();
                $dokumen_akta_perusahaan->move($this->upload_path . '/dokumen_akta_perusahaan', $dokumen_akta_perusahaan_name);
            } else {
                $dokumen_akta_perusahaan_name = $find_data['dokumen_akta_perusahaan'];
            }

            $data = [
                'nama'          => $this->request->getVar('nama', $this->filter),
                'jenis_kelamin' => $this->request->getVar('jenis_kelamin', $this->filter),
                'no_ponsel'     => $this->request->getVar('no_ponsel', $this->filter),
                'nama_perusahaan'       => $this->request->getVar('nama_perusahaan', $this->filter),
                'alamat_perusahaan'     => $this->request->getVar('alamat_perusahaan', $this->filter),
                'no_telepon_perusahaan' => $this->request->getVar('no_telepon_perusahaan', $this->filter),
                'email_perusahaan'      => $this->request->getVar('email_perusahaan', $this->filter),
                'no_akta_perusahaan'    => $this->request->getVar('no_akta_perusahaan', $this->filter),
                'dokumen_akta_perusahaan' => $dokumen_akta_perusahaan_name,
                'status_pengajuan_perusahaan'  => 'Menunggu Verifikasi',
                'submission_at'  => date('Y-m-d H:i:s'),
            ];

            $this->base_model->update($id, $data);
            return redirect()->to($this->base_route)
            ->with('message',
            "<script>
                Swal.fire({
                icon: 'success',
                title: 'Pengajuan telah dikirim',
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true,
                })
            </script>");
        }
    }
}
