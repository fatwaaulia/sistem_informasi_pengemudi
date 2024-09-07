<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class EnsureAdmin implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (session()->isLogin !== true) return redirect()->to(base_url());
        
        $user_session = model('Users')->where('id', session()->get('id_user'))->first();
        if (!$user_session) return redirect()->to(base_url());
        
        if ($user_session['id_role'] != 2) {
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
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
