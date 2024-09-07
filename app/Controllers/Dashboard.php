<?php

namespace App\Controllers;

class Dashboard extends BaseController
{   
    public function dashboard()
    {
        $data['title'] = 'Dashboard';
        $user_session = model('Users')->where('id', session()->get('id_user'))->first();

        if ($user_session['id_role'] == 1) {
            $view['content'] = view('dashboard/superadmin', $data);
        } elseif ($user_session['id_role'] == 2) {
            $view['content'] = view('dashboard/admin', $data);
        } elseif ($user_session['id_role'] == 3) {
            $data_perusahaan = [
                $user_session['nama'],
                $user_session['jenis_kelamin'],
                $user_session['no_ponsel'],
                $user_session['nama_perusahaan'],
                $user_session['alamat_perusahaan'],
                $user_session['no_telepon_perusahaan'],
                $user_session['no_akta_perusahaan'],
                $user_session['dokumen_akta_perusahaan'],
            ];
            if (in_array('', $data_perusahaan)) {
                return redirect()->to(base_url('perusahaan/pengajuan-perusahaan'))
                ->with('message',
                "<script>
                    Swal.fire({
                    icon: 'warning',
                    title: 'Silakan melengkapi data perusahaan',
                    showConfirmButton: false,
                    timer: 2500,
                    timerProgressBar: true,
                    })
                </script>");
            }
            $view['content'] = view('dashboard/perusahaan', $data);
        }
        $view['sidebar'] = view('dashboard/sidebar', $data);
        return view('dashboard/header', $view);
    }
}
