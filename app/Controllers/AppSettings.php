<?php

namespace App\Controllers;

class AppSettings extends BaseController
{
    protected $base_model;
    protected $base_name;
    protected $upload_path;

    public function __construct()
    {
        $this->base_model   = model('AppSettings');
        $this->base_name    = 'app_settings';
        $this->upload_path  = 'assets/uploads/' . $this->base_name . '/';
    }

    public function index()
    {
        $data = [
            'base_route'  => $this->base_route,
            'title'       => ucwords(str_replace('_', ' ', $this->base_name)),
        ];

        $view['sidebar'] = view('dashboard/sidebar');
        $view['content'] = view($this->base_name . '/main', $data);
        return view('dashboard/header', $view);
    }

    public function menu()
    {
        $menu = $this->request->getVar('v', $this->filter);
        if ($menu == 'maintenance') {
            $view['base_route'] = $this->base_route;
            $response['view_menu'] = view($this->base_name . '/maintenance', $view);
        } else {
            $view = [
                'data'        => $this->base_model->find(1),
                'upload_path' => $this->upload_path,
                'base_route'  => $this->base_route,
            ];
            $response['view_menu'] = view($this->base_name . '/edit', $view);
        }

        return $this->response->setJSON($response);
    }

    public function update($id_encode = null)
    {
        $id = decode($id_encode);
        $find_data = $this->base_model->find($id);

        $rules = [
            'nama_aplikasi'   => 'required',
            'nama_perusahaan' => 'required',
            'deskripsi'       => 'required',
            'no_hp'           => 'required',
            'logo'            => 'max_size[logo,1024]|ext_in[logo,png,jpg,jpeg]',
            'favicon'         => 'max_size[favicon,1024]|ext_in[favicon,png,jpg,jpeg]',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput();
        } else {
            $logo = $this->request->getFile('logo');
            if ($logo != '') {
                $file = $this->upload_path . $find_data['logo'];
                if (is_file($file)) unlink($file);
                $logo_name = 'logo.' . $logo->guessExtension();
                $this->image->withFile($logo)->save($this->upload_path . $logo_name, 60);
            } else {
                $logo_name = $find_data['logo'];
            }

            $favicon = $this->request->getFile('favicon');
            if ($favicon != '') {
                $file = $this->upload_path . $find_data['favicon'];
                if (is_file($file)) unlink($file);
                $favicon_name = 'favicon.' . $favicon->guessExtension();
                $this->image->withFile($favicon)->save($this->upload_path . $favicon_name, 60);
            } else {
                $favicon_name = $find_data['favicon'];
            }

            $data = [
                'nama_aplikasi'     => $this->request->getVar('nama_aplikasi', $this->filter),
                'nama_perusahaan'   => $this->request->getVar('nama_perusahaan', $this->filter),
                'no_hp'             => $this->request->getVar('no_hp', $this->filter),
                'deskripsi'         => $this->request->getVar('deskripsi', $this->filter),
                'logo'              => $logo_name,
                'favicon'           => $favicon_name,
                'alamat'            => $this->request->getVar('alamat', $this->filter),
                'maps'              => $this->request->getVar('maps', $this->filter),
            ];

            $this->base_model->update($id, $data);
            return redirect()->to($this->base_route . '?menu=edit')
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

    public function emailLayout()
    {
        $data = [
            'for_name'      => 'Hamba Allah',
            'message'       => 'Ada pesan nih, baca ya: <br>' .
                                'Dan Dia telah memberikan kepadamu segala apa yang kamu mohonkan kepada-Nya. Dan jika kamu menghitung nikmat Allah, niscaya kamu tidak akan mampu menghitungnya. Sungguh, manusia itu sangat zalim dan sangat mengingkari (nikmat Allah). (QS. Ibrahim : 34)',
            'button_link'   => base_url(),
            'button_name'   =>  'Tombol',
        ];

        return view('app_settings/email', $data);
    }
    
    public function sendEmail()
    {
        $email  = $this->request->getVar('email', $this->filter);
        $pin    = $this->request->getVar('pin', $this->filter);

        if ($pin != '1234') {
            return redirect()->to($this->base_route . '?menu=maintenance')
            ->with('message',
            "<script>
                Swal.fire({
                icon: 'error',
                title: 'Gagal validasi!',
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true,
                })
            </script>");
        }

        $toEmail = $email;
        $subject = 'Maintenance Email SLIP Indonesia';
        $message_field = [
            'for_name'      => 'Kamu siapa?',
            'message'       => 'Kirim email berfungsi dengan baik, jangan lupa senyum dulu yaa:)',
            'button_name'   => 'Tombol',
            'button_link'   => base_url(),
        ];
        $message = view('app_settings/email', $message_field);

        $email = service('email');
        $email->setFrom($email->fromEmail, $email->fromName);
        $email->setTo($toEmail);
        $email->setSubject($subject);
        $email->setMessage($message);

        if ($email->send()) {
            return redirect()->to($this->base_route . '?menu=maintenance')
            ->with('message',
            "<script>
                Swal.fire({
                icon: 'info',
                title: 'Permintaan telah dikirim. Silakan periksa email Anda!',
                })
            </script>");
        } else {
            // $email_error = $email->printDebugger(['headers']);
            // print_r($email_error);
            // die;
            return redirect()->to($this->base_route . '?menu=maintenance')
            ->with('message',
            "<script>
                Swal.fire({
                icon: 'error',
                title: 'Permintaan gagal diproses',
                })
            </script>");
        }
    }
}
