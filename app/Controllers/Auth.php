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
            
            // jika user tidak ditemukan
            if (! $user) {
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

            // jika belum aktivasi akun
            if (! $user['activated_at']) {
                for (;;) {
                    $random_string = random_string('alnum', 32);
                    $cek_token = $this->base_model->where('token', $random_string)->countAllResults();
                    if ($cek_token == 0) {
                        $token = $random_string;
                        break;
                    }
                }
                $this->base_model->update($user['id'], ['token' => $token]);

                // kirim email
                $toEmail = $user['email'];
                $subject = 'Pendaftaran Akun SLIP Indonesia';
                $message_field = [
                    'for_name'      => $user['nama'],
                    'message'       => 'Terima kasih telah mendaftar di SLIP Indonesia! <br>
                                        <br>Langkah selanjutnya, silakan login ke sistem kami dan lengkapi data diri serta informasi perusahaan Anda untuk menikmati kemudahan dalam mengelola data pengemudi.
                                        <br><br>    
                                        Klik tombol di bawah ini untuk masuk:',
                    'button_name'   => 'Masuk Sekarang',
                    'button_link'   => base_url() . 'aktivasi-akun?token=' . $token,
                ];
                $message = view('auth/email', $message_field);

                $email = service('email');
                $email->setFrom($email->fromEmail, $email->fromName);
                $email->setTo($toEmail);
                $email->setSubject($subject);
                $email->setMessage($message);

                if ($email->send()) {
                    return redirect()->to(base_url() . 'login')
                    ->with('message',
                    "<script>
                        Swal.fire({
                        icon: 'info',
                        title: 'Silakan periksa email Anda!',
                        })
                    </script>");
                } else {
                    return redirect()->to(base_url() . 'login')
                    ->with('message',
                    "<script>
                        Swal.fire({
                        icon: 'error',
                        title: 'Permintaan gagal diproses. <a href=" . 'https://wa.me/6285526250131' . " target=" . '_blank' . ">Hubungi CS</a>',
                        })
                    </script>");
                }
            }

            // jika sudah aktivasi bisa login
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
            'no_ponsel' => 'required',
            'email'     => 'required|valid_email|is_unique[users.email]',
            'password'  => 'required|min_length[8]|matches[passconf]',
            'passconf'  => 'required|min_length[8]|matches[password]',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput();
        } else {
            for (;;) {
                $random_string = random_string('alnum', 32);
                $cek_token = $this->base_model->where('token', $random_string)->countAllResults();
                if ($cek_token == 0) {
                    $token = $random_string;
                    break;
                }
            }

            $nama = ucwords($this->request->getVar('nama', $this->filter));
            $email = $this->request->getVar('email', FILTER_SANITIZE_EMAIL);
            $password = $this->request->getVar('password');
            $data = [
                'status_pengajuan_perusahaan' => 'Pending',
                'id_role'         => 3,
                'nama_perusahaan' => ucwords($this->request->getVar('nama_perusahaan', $this->filter)),
                'nama'            => $nama,
                'no_ponsel'       => $this->request->getVar('no_ponsel', $this->filter),
                'email'           => $email,
                'password'        => $this->base_model->password_hash($password),
                'token'           => $token,
            ];

            $this->base_model->insert($data);

            // kirim email
            $toEmail = $email;
            $subject = 'Pendaftaran Akun SLIP Indonesia';
            $message_field = [
                'for_name'      => $nama,
                'message'       => 'Terima kasih telah mendaftar di SLIP Indonesia! <br>
                                    <br>Langkah selanjutnya, silakan login ke sistem kami dan lengkapi data diri serta informasi perusahaan Anda untuk menikmati kemudahan dalam mengelola data pengemudi.
                                    <br><br>    
                                    Klik tombol di bawah ini untuk masuk:',
                'button_name'   => 'Masuk Sekarang',
                'button_link'   => base_url() . 'aktivasi-akun?token=' . $token,
            ];
            $message = view('auth/email', $message_field);

            $email = service('email');
            $email->setFrom($email->fromEmail, $email->fromName);
            $email->setTo($toEmail);
            $email->setSubject($subject);
            $email->setMessage($message);

            if ($email->send()) {
                return redirect()->to(base_url() . 'register')
                ->with('message',
                "<script>
                    Swal.fire({
                    icon: 'info',
                    title: 'Silakan periksa email Anda!',
                    })
                </script>");
            } else {
                return redirect()->to(base_url() . 'register')
                ->with('message',
                "<script>
                    Swal.fire({
                    icon: 'error',
                    title: 'Permintaan gagal diproses. <a href=" . 'https://wa.me/6285526250131' . " target=" . '_blank' . ">Hubungi CS</a>',
                    })
                </script>");
            }
        }
    }

    public function aktivasiAkun()
    {
        // jika pada url tidak ada query token
        $token = $this->request->getVar('token');
        if (! $token) {
            return redirect()->to(base_url() . 'login')
            ->with('message',
            "<script>
                Swal.fire({
                icon: 'error',
                title: 'Token tidak ditemukan!',
                })
            </script>");
        }

        // jika pengguna tidak ditemukan
        $user = $this->base_model->where('token', $token)->first();
        if (! $user) {
            return redirect()->to(base_url() . 'login')
            ->with('message',
            "<script>
                Swal.fire({
                icon: 'error',
                title: 'Token tidak ditemukan!',
                })
            </script>");
        }

        // aktivasi akun
        $data = [
            'token' => '',
            'activated_at' => date('Y-m-d H:i:s'),
        ];
        $this->base_model->update($user['id'], $data);

        return redirect()->to(base_url() . 'login')
        ->with('message',
        "<script>
            Swal.fire({
            icon: 'success',
            title: 'Berhasil aktivasi akun. Silakan masuk!',
            })
        </script>");
    }
}
