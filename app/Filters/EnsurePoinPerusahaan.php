<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class EnsurePoinPerusahaan implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $user_session = model('Users')->where('id', session()->get('id_user'))->first();

        if ($user_session['poin']  <= 0) {
            return redirect()->to(base_url('perusahaan/berlangganan'))
            ->with('message',
            "<script>
                Swal.fire({
                icon: 'error',
                title: 'Anda tidak memiliki poin. Silakan berlangganan.',
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
