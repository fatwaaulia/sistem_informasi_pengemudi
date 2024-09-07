<?php

namespace App\Controllers;

class Users extends BaseController
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

    public function getData()
    {
        $total_rows = $this->base_model->countAll();
        $limit = $this->request->getVar('length') ?? $total_rows;
        $offset = $this->request->getVar('start') ?? 0;

        $data = $this->base_model->where('id_role !=', 3)->findAll($limit, $offset);

        $search = $this->request->getVar('search')['value'] ?? null;
        if ($search) {
            $data       = $this->base_model->where('id_role !=', 3)->like('nama', $search)->findAll($limit, $offset);
            $total_rows = $this->base_model->where('id_role !=', 3)->like('nama', $search)->countAllResults();
        }

        $role = model('Role')->select(['id', 'nama'])->findAll();
        $nama_role = array_column($role, 'nama', 'id');
        foreach ($data as $key => $v) {
            $data[$key]['no_urut'] = $offset + $key + 1;
            $data[$key]['id'] = encode($v['id']);
            $data[$key]['nama_role'] = $nama_role[$v['id_role']];
            $data[$key]['foto_profil'] = $v['foto_profil'] ? base_url($this->upload_path) . $v['foto_profil'] : base_url('assets/uploads/user-default.png');
            $data[$key]['no_ponsel'] = $v['no_ponsel'] ? '+62 ' . $v['no_ponsel'] : null;
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
        $search = '';
        $role = $this->request->getVar('role', $this->filter);
        if ($role) $search = '?role=' . $role;

        $data = [
            'get_data'    => $this->base_route . '/get-data' . $search,
            'upload_path' => $this->upload_path,
            'base_route'  => $this->base_route,
            'title'       => 'Pengguna',
        ];

        $view['content'] = view($this->base_name . '/main', $data);
        $view['sidebar'] = view('dashboard/sidebar', $data);
        return view('dashboard/header', $view);
    }

    public function new()
    {
        $data = [
            'base_route' => $this->base_route,
            'title'      => 'Add Pengguna',
        ];

        $view['sidebar'] = view('dashboard/sidebar');
        $view['content'] = view($this->base_name . '/new', $data);
        return view('dashboard/header', $view);
    }

    public function create()
    {
        $rules = [
            'id_role'       => 'required',
            'nama'          => 'required',
            'email'         => "required|valid_email|is_unique[$this->base_name.email]",
            'password'      => 'required|min_length[8]|matches[passconf]',
            'passconf'      => 'required|min_length[8]|matches[password]',
            'jenis_kelamin' => 'required',
            'foto_profil'   => 'max_size[foto_profil,1024]|ext_in[foto_profil,png,jpg,jpeg]|mime_in[foto_profil,image/png,image/jpg,image/jpeg]|is_image[foto_profil]',
            'no_ponsel'    => "permit_empty|numeric|min_length[10]|max_length[15]|is_unique[$this->base_name.no_ponsel]",
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput();
        }else {
            $foto_profil = $this->request->getFile('foto_profil');
            if ($foto_profil != '') {
                $foto_profil_name = $foto_profil->getRandomName();
                $this->image->withFile($foto_profil)->save($this->upload_path . $foto_profil_name, 60);
            } else {
                $foto_profil_name = '';
            }

            $password = $this->request->getVar('password');
            $data = [
                'id_role'       => $this->request->getVar('id_role', $this->filter),
                'nama'          => ucwords($this->request->getVar('nama', $this->filter)),
                'email'         => $this->request->getVar('email', FILTER_SANITIZE_EMAIL),
                'password'      => $this->base_model->password_hash($password),
                'jenis_kelamin' => $this->request->getVar('jenis_kelamin', $this->filter),
                'foto_profil'   => $foto_profil_name,
                'no_ponsel'         => $this->request->getVar('no_ponsel', $this->filter),
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
            'title'       => 'Edit Pengguna',
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
            'nama'          => 'required',
            'password'      => 'permit_empty|min_length[8]|matches[passconf]',
            'passconf'      => 'permit_empty|min_length[8]|matches[password]',
            'jenis_kelamin' => 'required',
            'foto_profil'   => 'max_size[foto_profil,1024]|ext_in[foto_profil,png,jpg,jpeg]|mime_in[foto_profil,image/png,image/jpg,image/jpeg]|is_image[foto_profil]',
            'email'         => "required|valid_email|is_unique[$this->base_name.email,id,$id]",
            'no_ponsel'     => "permit_empty|numeric|min_length[10]|max_length[15]|is_unique[$this->base_name.no_ponsel,id,$id]",
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        } else {
            $foto_profil = $this->request->getFile('foto_profil');
            if ($foto_profil != '') {
                $file = $this->upload_path . $find_data['foto_profil'];
                if (is_file($file)) unlink($file);
                $foto_profil_name = $foto_profil->getRandomName();
                $this->image->withFile($foto_profil)->save($this->upload_path . $foto_profil_name, 60);
            } else {
                $foto_profil_name = $find_data['foto_profil'];
            }

            $password = $this->request->getVar('password');
            $data = [
                'id_role'       => 2,
                'nama'          => ucwords($this->request->getVar('nama', $this->filter)),
                'email'         => $this->request->getVar('email', FILTER_SANITIZE_EMAIL),
                'password'      => $password != '' ? $this->base_model->password_hash($password) : $find_data['password'],
                'jenis_kelamin' => $this->request->getVar('jenis_kelamin', $this->filter),
                'foto_profil'   => $foto_profil_name,
                'no_ponsel'     => $this->request->getVar('no_ponsel', $this->filter),
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

        $foto_profil = $this->upload_path . $find_data['foto_profil'];
        if (is_file($foto_profil)) unlink($foto_profil);

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

    public function deleteImg($id_encode = null)
    {
        $id = decode($id_encode);
        $find_data = $this->base_model->find($id);

        if ($find_data['foto_profil'] != '') {
            $file = $this->upload_path . $find_data['foto_profil'];
            if (is_file($file)) unlink($file);
        }

        $this->base_model->update($id, ['foto_profil' => '']);
        return redirect()->to($this->base_route . '/edit/' . $id_encode)
        ->with('message',
        "<script>
            Swal.fire({
            icon: 'success',
            title: 'Foto profil dihapus',
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true,
            })
        </script>");
    }

    public function profile()
    {
        $id = $this->user_session['id'];

        $data = [
            'data'        => $this->base_model->find($id),
            'upload_path' => $this->upload_path,
            'base_route'  => $this->base_route,
            'title'       => 'Profil',
        ];
        
        $view['sidebar'] = view('dashboard/sidebar');
        $view['content'] = view($this->base_name . '/profile', $data);
        return view('dashboard/header', $view);
    }

    public function updateProfile()
    {
        $id = $this->user_session['id'];
        $find_data = $this->base_model->find($id);

        $rules = [
            'nama'          => 'required',
            'jenis_kelamin' => 'required',
            'foto_profil'   => 'max_size[foto_profil,1024]|ext_in[foto_profil,png,jpg,jpeg]|mime_in[foto_profil,image/png,image/jpg,image/jpeg]|is_image[foto_profil]',
            'email'         => "required|valid_email|is_unique[$this->base_name.email,id,$id]",
            'no_ponsel'     => "permit_empty|numeric|min_length[10]|max_length[15]|is_unique[$this->base_name.no_ponsel,id,$id]",
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        } else {
            $foto_profil = $this->request->getFile('foto_profil');
            if ($foto_profil != '') {
                $file = $this->upload_path . $find_data['foto_profil'];
                if (is_file($file)) unlink($file);
                $foto_profil_name = $foto_profil->getRandomName();
                $this->image->withFile($foto_profil)->save($this->upload_path . $foto_profil_name, 60);
            } else {
                $foto_profil_name = $find_data['foto_profil'];
            }

            $data = [
                'nama'          => ucwords($this->request->getVar('nama', $this->filter)),
                'jenis_kelamin' => $this->request->getVar('jenis_kelamin', $this->filter),
                'foto_profil'   => $foto_profil_name,
                'email'         => $this->request->getVar('email', FILTER_SANITIZE_EMAIL),
                'no_ponsel'     => $this->request->getVar('no_ponsel', $this->filter),
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

    public function updatePassword()
    {
        $id = $this->user_session['id'];
        $find_data = $this->base_model->find($id);

        $oldpass = trim($this->request->getVar('oldpass'));
        $password = trim($this->request->getVar('password'));
        $passconf = trim($this->request->getVar('passconf'));
        if (
            !empty($oldpass && $password && $passconf)
            && (strlen($password) >= 8)
            && (strlen($passconf) >= 8)
        ) {
            if (($find_data['password'] == $this->base_model->password_hash($oldpass)) && ($password == $passconf)) {
                $data = [
                    'password'  => $this->base_model->password_hash($password),
                ];
                $this->base_model->update($id, $data);
                session()->remove(['isLogin', 'user']);
                return redirect()->to(base_url('login'))
                ->with('message',
                "<script>
                    Swal.fire({
                    icon: 'success',
                    title: 'Password berhasil diubah. Silakan login kembali.',
                    showConfirmButton: false,
                    timer: 2500,
                    timerProgressBar: true,
                    })
                </script>");
            } else {
                return redirect()->to($this->base_route)
                ->with('message',
                "<script>
                    Swal.fire({
                    icon: 'error',
                    title: 'Password saat ini salah!',
                    showConfirmButton: false,
                    timer: 2500,
                    timerProgressBar: true,
                    })
                </script>");
            }
        } else {
            return redirect()->to($this->base_route)
            ->with('message',
            "<script>
                Swal.fire({
                icon: 'error',
                title: 'Password setidaknya harus berisi 8 karakter!',
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true,
                })
            </script>");
        }
    }

    public function deleteProfilePhoto()
    {
        $id = $this->user_session['id'];
        $find_data = $this->base_model->find($id);

        $foto_profil = $this->upload_path . $find_data['foto_profil'];
        if (is_file($foto_profil)) unlink($foto_profil);

        $this->base_model->update($id, ['foto_profil' => '']);
        return redirect()->to($this->base_route)
        ->with('message',
        "<script>
            Swal.fire({
            icon: 'success',
            title: 'Foto profil dihapus',
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true,
            })
        </script>");
    }
}
