<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class EnsurePerusahaan implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (session()->isLogin !== true) return redirect()->to(base_url('login'));
        
        $user_session = model('Users')->where('id', session()->get('id_user'))->first();
        if (!$user_session) return redirect()->to(base_url('login'));
        
        if ($user_session['id_role'] != 3) {
            $user_role = strtolower(model('Role')->where('id', $user_session['id_role'])->first()['nama']);
            return redirect()->to(base_url($user_role) . '/dashboard')
            ->with('message',
            "<script>
                Swal.fire({
                icon: 'error',
                title: 'Anda tidak memiliki akses!',
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true,
                })
            </script>");
        }

        $user_session = model('Users')->where('id', session()->get('id_user'))->first();
        if ($user_session['status_pengajuan_perusahaan'] != 'Aktif') {
            $url_kirim_pengajuan = [
                base_url('perusahaan/pengajuan-perusahaan'),
                base_url('perusahaan/pengajuan-perusahaan/update'),
            ];
            if (! in_array(current_url(), $url_kirim_pengajuan)) {
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
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
