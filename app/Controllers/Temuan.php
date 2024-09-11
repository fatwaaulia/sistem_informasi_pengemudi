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
        $user_session = model('Users')->where('id', session()->get('id_user'))->first();

        if (in_array($user_session['id_role'], [1, 2])) {

            $total_rows = $this->base_model->countAllResults();
            $limit = $this->request->getVar('length') ?? $total_rows;
            $offset = $this->request->getVar('start') ?? 0;

            $data = $this->base_model->findAll($limit, $offset);

            $search = $this->request->getVar('search')['value'] ?? null;
            if ($search) {
                $data       = $this->base_model->like('nik', $search)->findAll($limit, $offset);
                $total_rows = $this->base_model->like('nik', $search)->countAllResults();
            }

        } else {

            $total_rows = $this->base_model->where('id_pelapor', $user_session['id'])->countAllResults();
            $limit = $this->request->getVar('length') ?? $total_rows;
            $offset = $this->request->getVar('start') ?? 0;

            $data = $this->base_model->where('id_pelapor', $user_session['id'])->findAll($limit, $offset);

            $search = $this->request->getVar('search')['value'] ?? null;
            if ($search) {
                $data       = $this->base_model->like('nik', $search)
                                ->where('id_pelapor', session()->get('id_user'))->findAll($limit, $offset);
                $total_rows = $this->base_model->like('nik', $search)
                                ->where('id_pelapor', session()->get('id_user'))->countAllResults();
            }
        }

        foreach ($data as $key => $v) {
            $data[$key]['no_urut'] = $offset + $key + 1;
            $data[$key]['id'] = encode($v['id']);
            $data[$key]['foto_temuan'] = $v['foto_temuan'] ? base_url($this->upload_path . 'foto_temuan/') . $v['foto_temuan'] : base_url('assets/uploads/default.png');
            $data[$key]['tanggal_kejadian'] = $v['tanggal_kejadian'] != '0000-00-00' ? date('d-m-Y', strtotime($v['tanggal_kejadian'])) : '';
            $data[$key]['created_at'] = date('d-m-Y H:i:s', strtotime($v['created_at']));
        }

        return $this->response->setJSON([
            'recordsTotal'    => in_array($user_session['id_role'], [1, 2]) 
                                    ? $this->base_model->countAllResults()
                                    : $this->base_model->where('id_pelapor', $user_session['id'])->countAllResults(),
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
            'nik'               => "required|numeric|min_length[16]|max_length[16]",
            'catatan_kejadian'  => "required",
            'foto_sopir'        => 'max_size[foto_sopir,10240]|ext_in[foto_sopir,png,jpg,jpeg]|mime_in[foto_sopir,image/png,image/jpg,image/jpeg]|is_image[foto_sopir]',
            'foto_ktp'          => 'max_size[foto_ktp,10240]|ext_in[foto_ktp,png,jpg,jpeg]|mime_in[foto_ktp,image/png,image/jpg,image/jpeg]|is_image[foto_ktp]',
            'foto_sim'          => 'max_size[foto_sim,10240]|ext_in[foto_sim,png,jpg,jpeg]|mime_in[foto_sim,image/png,image/jpg,image/jpeg]|is_image[foto_sim]',
            'foto_temuan'       => 'max_size[foto_temuan,10240]|ext_in[foto_temuan,png,jpg,jpeg]|mime_in[foto_temuan,image/png,image/jpg,image/jpeg]|is_image[foto_temuan]',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput();
        } else {
            $foto_sopir = $this->request->getFile('foto_sopir');
            if ($foto_sopir != '') {
                $foto_sopir_name = $foto_sopir->getRandomName();
                $this->image->withFile($foto_sopir)->save($this->upload_path . 'foto_sopir/' . $foto_sopir_name, 60);
            } else {
                $foto_sopir_name = '';
            }

            $foto_ktp = $this->request->getFile('foto_ktp');
            if ($foto_ktp != '') {
                $foto_ktp_name = $foto_ktp->getRandomName();
                $this->image->withFile($foto_ktp)->save($this->upload_path . 'foto_ktp/' . $foto_ktp_name, 60);
            } else {
                $foto_ktp_name = '';
            }

            $foto_sim = $this->request->getFile('foto_sim');
            if ($foto_sim != '') {
                $foto_sim_name = $foto_sim->getRandomName();
                $this->image->withFile($foto_sim)->save($this->upload_path . 'foto_sim/' . $foto_sim_name, 60);
            } else {
                $foto_sim_name = '';
            }

            $foto_temuan = $this->request->getFile('foto_temuan');
            if ($foto_temuan != '') {
                $foto_temuan_name = $foto_temuan->getRandomName();
                $this->image->withFile($foto_temuan)->save($this->upload_path . 'foto_temuan/' . $foto_temuan_name, 60);
            } else {
                $foto_temuan_name = '';
            }

            $data = [
                'id_pelapor'        => $this->user_session['id'],
                'nama_perusahaan'   => $this->user_session['nama_perusahaan'],
                'nik'               => $this->request->getVar('nik', $this->filter),
                'nama'              => $this->request->getVar('nama', $this->filter),
                'no_sim'            => $this->request->getVar('no_sim', $this->filter),
                'no_ponsel'         => $this->request->getVar('no_ponsel', $this->filter),
                'tanggal_lahir'     => $this->request->getVar('tanggal_lahir', $this->filter),
                'alamat'            => $this->request->getVar('alamat', $this->filter),
                'catatan_kejadian'  => $this->request->getVar('catatan_kejadian', $this->filter),
                'tanggal_kejadian'  => $this->request->getVar('tanggal_kejadian', $this->filter),
                'foto_sopir'        => $foto_sopir_name,
                'foto_ktp'          => $foto_ktp_name,
                'foto_sim'          => $foto_sim_name,
                'foto_temuan'       => $foto_temuan_name,
            ];

            $jumlah_temuan = $this->base_model->where('id_pelapor', $this->user_session['id'])->countAllResults();
            $total_temuan = $jumlah_temuan + 1;

            // cek telah membuat kelipatan 5 data temuan
            if ($total_temuan % 5 == 0) {

                $id_perusahaan = $this->user_session['id'];
                $user_session = model('Users')->where('id', session()->get('id_user'))->first();

                // cek kelipatan terakhir yaitu 5 apakah lebih dari date temuan pengguna
                // tujuan: jika pengguna add data temuan mencapai 5, kemudian mengakali dengan hapus data jadi 4 temuan kemudian add data lagi jadi 5, maka bonus tidak diberikan
                if (
                    $user_session['kelipatan_poin_bonus_terakhir'] == 0 OR
                    $total_temuan > $user_session['kelipatan_poin_bonus_terakhir']
                ) {
                    $data_bonus = [
                        'poin'          => $user_session['poin'] + 1,
                        'poin_bonus'    => $user_session['poin_bonus'] + 1,
                        'kelipatan_poin_bonus_terakhir' => $total_temuan,
                    ];
                    model('Users')->update($id_perusahaan, $data_bonus);
                }
            }

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
            'nik'               => "required|numeric|min_length[16]|max_length[16]",
            'catatan_kejadian'  => "required",
            'foto_sopir'        => 'max_size[foto_sopir,10240]|ext_in[foto_sopir,png,jpg,jpeg]|mime_in[foto_sopir,image/png,image/jpg,image/jpeg]|is_image[foto_sopir]',
            'foto_ktp'          => 'max_size[foto_ktp,10240]|ext_in[foto_ktp,png,jpg,jpeg]|mime_in[foto_ktp,image/png,image/jpg,image/jpeg]|is_image[foto_ktp]',
            'foto_sim'          => 'max_size[foto_sim,10240]|ext_in[foto_sim,png,jpg,jpeg]|mime_in[foto_sim,image/png,image/jpg,image/jpeg]|is_image[foto_sim]',
            'foto_temuan'       => 'max_size[foto_temuan,10240]|ext_in[foto_temuan,png,jpg,jpeg]|mime_in[foto_temuan,image/png,image/jpg,image/jpeg]|is_image[foto_temuan]',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput();
        } else {
            $foto_sopir = $this->request->getFile('foto_sopir');
            if ($foto_sopir != '') {
                $file = $this->upload_path . 'foto_sopir/' . $find_data['foto_sopir'];
                if (is_file($file)) unlink($file);
                $foto_sopir_name = $foto_sopir->getRandomName();
                $this->image->withFile($foto_sopir)->save($this->upload_path . 'foto_sopir/' . $foto_sopir_name, 60);
            } else {
                $foto_sopir_name = $find_data['foto_sopir'];
            }

            $foto_ktp = $this->request->getFile('foto_ktp');
            if ($foto_ktp != '') {
                $file = $this->upload_path . 'foto_ktp/' . $find_data['foto_ktp'];
                if (is_file($file)) unlink($file);
                $foto_ktp_name = $foto_ktp->getRandomName();
                $this->image->withFile($foto_ktp)->save($this->upload_path . 'foto_ktp/' . $foto_ktp_name, 60);
            } else {
                $foto_ktp_name = $find_data['foto_ktp'];
            }

            $foto_sim = $this->request->getFile('foto_sim');
            if ($foto_sim != '') {
                $file = $this->upload_path . 'foto_sim/' . $find_data['foto_sim'];
                if (is_file($file)) unlink($file);
                $foto_sim_name = $foto_sim->getRandomName();
                $this->image->withFile($foto_sim)->save($this->upload_path . 'foto_sim/' . $foto_sim_name, 60);
            } else {
                $foto_sim_name = $find_data['foto_sim'];
            }

            $foto_temuan = $this->request->getFile('foto_temuan');
            if ($foto_temuan != '') {
                $file = $this->upload_path . 'foto_temuan/' . $find_data['foto_temuan'];
                if (is_file($file)) unlink($file);
                $foto_temuan_name = $foto_temuan->getRandomName();
                $this->image->withFile($foto_temuan)->save($this->upload_path . 'foto_temuan/' . $foto_temuan_name, 60);
            } else {
                $foto_temuan_name = $find_data['foto_temuan'];
            }

            $data = [
                'nama_perusahaan'   => $this->user_session['nama_perusahaan'],
                'nik'               => $this->request->getVar('nik', $this->filter),
                'nama'              => $this->request->getVar('nama', $this->filter),
                'no_sim'            => $this->request->getVar('no_sim', $this->filter),
                'no_ponsel'         => $this->request->getVar('no_ponsel', $this->filter),
                'tanggal_lahir'     => $this->request->getVar('tanggal_lahir', $this->filter),
                'alamat'            => $this->request->getVar('alamat', $this->filter),
                'catatan_kejadian'  => $this->request->getVar('catatan_kejadian', $this->filter),
                'tanggal_kejadian'  => $this->request->getVar('tanggal_kejadian', $this->filter),
                'foto_sopir'        => $foto_sopir_name,
                'foto_ktp'          => $foto_ktp_name,
                'foto_sim'          => $foto_sim_name,
                'foto_temuan'       => $foto_temuan_name,
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

        $foto_sopir = $this->upload_path . 'foto_sopir/' . $find_data['foto_sopir'];
        if (is_file($foto_sopir)) unlink($foto_sopir);

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
        $no_sim = $this->request->getVar('no_sim', $this->filter);

        $cek_temuan = $this->base_model->where('nik', $nik)->findAll();
        $status = 'NIK atau SIM tidak ditemukan';
        $data_temuan = [];
        if ($nik AND !$no_sim) {
            $cek_temuan = $this->base_model->where('nik', $nik)->findAll();
            if ($cek_temuan) {
                $status = 'NIK ditemukan';
                $data_temuan = $cek_temuan;
            }
        } elseif (!$nik AND $no_sim) {
            $cek_temuan = $this->base_model->where('no_sim', $no_sim)->findAll();
            if ($cek_temuan) {
                $status = 'SIM ditemukan';
                $data_temuan = $cek_temuan;
            }
        } elseif ($nik AND $no_sim) {
            $cek_temuan = $this->base_model->where(['nik' => $nik, 'no_sim' => $no_sim])->findAll();
            if ($cek_temuan) {
                $status = 'NIK dan SIM ditemukan';
                $data_temuan = $cek_temuan;
            }
        }

        if ($data_temuan) {
            $get_data = [
                'id_temuan'  => json_encode(array_column($cek_temuan, 'id'), true),
                'id_pelapor' => json_encode(array_column($cek_temuan, 'id_pelapor'), true),
                'nama'       => json_encode(array_column($cek_temuan, 'nama'), true),
                'no_sim'        => json_encode(array_column($cek_temuan, 'no_sim'), true),
                'no_ponsel'     => json_encode(array_column($cek_temuan, 'no_ponsel'), true),
                'tanggal_lahir' => json_encode(array_column($cek_temuan, 'tanggal_lahir'), true),
                'alamat'        => json_encode(array_column($cek_temuan, 'alamat'), true),
                'catatan_kejadian'  => json_encode(array_column($cek_temuan, 'catatan_kejadian'), true),
                'tanggal_kejadian'  => json_encode(array_column($cek_temuan, 'tanggal_kejadian'), true),
                'foto_sopir'        => json_encode(array_column($cek_temuan, 'foto_sopir'), true),
                'foto_ktp'        => json_encode(array_column($cek_temuan, 'foto_ktp'), true),
                'foto_sim'        => json_encode(array_column($cek_temuan, 'foto_sim'), true),
                'foto_temuan'     => json_encode(array_column($cek_temuan, 'foto_temuan'), true),
            ];

            $get_data['nik'] = $nik;
            $get_data['id_peminta'] = $this->user_session['id'];
            $get_data['nama_perusahaan'] = $this->user_session['nama_perusahaan'];
            model('RiwayatPencarian')->insert($get_data);

            $user_session = model('Users')->where('id', session()->get('id_user'))->first();
            $data = [
                'poin'        => $user_session['poin'] - 1,
                'poin_keluar' => $user_session['poin_keluar'] + 1,
            ];
            model('Users')->update($user_session['id'], $data);
        }

        $data = [
            'get_data'    => $this->base_route . '/get-data',
            'upload_path' => $this->upload_path,
            'base_route'  => $this->base_route,
            'title'       => 'Cari Temuan',
            'nik'         => $nik,
            'no_sim'      => $no_sim,
            'status'      => $status,
            'data'        => $data_temuan,
        ];

        $view['sidebar'] = view('dashboard/sidebar');
        $view['content'] = view($this->base_name . '/cari_temuan', $data);
        return view('dashboard/header', $view);
    }

    public function unduhPdf()
    {
        $nik = $this->request->getVar('nik', FILTER_SANITIZE_NUMBER_INT);
        $no_sim = $this->request->getVar('no_sim', $this->filter);

        $data['temuan'] = [];
        if ($nik AND !$no_sim) {
            $cek_temuan = $this->base_model->where('nik', $nik)->findAll();
            if ($cek_temuan) $data['temuan'] = $cek_temuan;
        } elseif (!$nik AND $no_sim) {
            $cek_temuan = $this->base_model->where('no_sim', $no_sim)->findAll();
            if ($cek_temuan) $data['temuan'] = $cek_temuan;
        } elseif ($nik AND $no_sim) {
            $cek_temuan = $this->base_model->where(['nik' => $nik, 'no_sim' => $no_sim])->findAll();
            if ($cek_temuan) $data['temuan'] = $cek_temuan;
        }

        if (! $data['temuan']) {
            return redirect()->to($this->base_route)
            ->with('message',
            "<script>
                Swal.fire({
                icon: 'error',
                title: 'Data tidak temukan!',
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true,
                })
            </script>");
        }
        
        return view($this->base_name . '/unduh_pdf', $data);
    }
}
