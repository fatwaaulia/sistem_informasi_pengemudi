<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class EnsureIsLogin implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (session()->isLogin !== true) {
            return redirect()->to(base_url('login'))
            ->with('message',
            "<script>
                Swal.fire({
                icon: 'warning',
                title: 'Silakan login!',
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
