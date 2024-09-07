<?php

namespace App\Controllers;

class Auth extends BaseController
{
    protected $base_model;

    public function __construct()
    {
        $this->base_model   = model('Users');
    }

    public function login()
    {
        if (session()->isLogin) return redirect()->to(base_url($this->user_role) . '/dashboard');
        $data['title'] = 'Masuk';

        $view['content'] = view('auth/login', $data);
        return view('dashboard/header', $view);
    }

    public function loginProcess()
    {
        $rules = [
            'email'     => 'required|valid_email',
            'password'  => 'required',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        } else {
            $password = $this->request->getVar('password');
            $where = [
                'email'     => $this->request->getVar('email', FILTER_SANITIZE_EMAIL),
                'password'  => $this->base_model->password_hash($password),
            ];
            $user = $this->base_model->where($where)->first();
            $cek = $this->base_model->where($where)->countAllResults();
            if ($cek == 1) {
                $session = [
                    'isLogin'   => true,
                    'id_user'   => $user['id'],
                ];
                session()->set($session);
                $user_role = model('Role')->where('id', $user['id_role'])->first()['slug'];
                return redirect()->to(base_url($user_role) . '/dashboard');
            } else {
                return redirect()->to(base_url('login'))
                ->with('message',
                "<script>
                    Swal.fire({
                    icon: 'error',
                    title: 'Email atau password salah!',
                    showConfirmButton: false,
                    timer: 2500,
                    timerProgressBar: true,
                    })
                </script>");
            }
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }

    public function register()
    {
        if (session()->isLogin) return redirect()->to(base_url($this->user_role) . '/dashboard');
        $data['title'] = 'Pendaftaran Akun';

        $view['content'] = view('auth/register', $data);
        return view('dashboard/header', $view);
    }
    public function registerProcess()
    {   
        $rules = [
            'nama_perusahaan' => 'required|is_unique[users.nama_perusahaan]',
            'nama'      => 'required',
            'no_ponsel' => 'required|is_unique[users.no_ponsel]',
            'email'     => 'required|valid_email|is_unique[users.email]',
            'password'  => 'required|min_length[8]|matches[passconf]',
            'passconf'  => 'required|min_length[8]|matches[password]',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput();
        } else {
            $password = $this->request->getVar('password');
            $data = [
                'status_pengajuan_perusahaan' => 'Pending',
                'id_role'         => 3,
                'nama_perusahaan' => ucwords($this->request->getVar('nama_perusahaan', $this->filter)),
                'nama'            => ucwords($this->request->getVar('nama', $this->filter)),
                'no_ponsel'       => ucwords($this->request->getVar('no_ponsel', $this->filter)),
                'email'           => $this->request->getVar('email', FILTER_SANITIZE_EMAIL),
                'password'        => $this->base_model->password_hash($password),
            ];

            $this->base_model->insert($data);
            return redirect()->to(base_url('login'))
            ->with('message',
            "<script>
                Swal.fire({
                icon: 'success',
                title: 'Selamat akun Anda berhasil dibuat',
                })
            </script>");
        }
    }
}
