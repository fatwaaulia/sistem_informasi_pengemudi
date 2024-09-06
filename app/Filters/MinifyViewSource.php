<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class MinifyViewSource implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        //
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        $responseBody = $response->getBody();
        $compressedBody = preg_replace('/(?<!http:|https:)\/\/.*$/m', '', $responseBody);
        $compressedBody = preg_replace('/\s+/', ' ', $compressedBody);
        $response->setBody($compressedBody);
    }
}

