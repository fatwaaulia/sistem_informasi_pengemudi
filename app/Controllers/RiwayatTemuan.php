<?php

namespace App\Controllers;

class RiwayatTemuan extends BaseController
{
    protected $base_model;
    protected $base_name;
    protected $upload_path;

    public function __construct()
    {
        $this->base_model   = model('RiwayatTemuan');
        $this->base_name    = 'temuan';
        $this->upload_path  = 'assets/uploads/' . $this->base_name . '/';
    }

    /*--------------------------------------------------------------
    # Cari Temuan
    --------------------------------------------------------------*/
    public function cariTemuan()
    {
        $data = [
            'get_data'    => $this->base_route . '/get-data',
            'upload_path' => $this->upload_path,
            'base_route'  => $this->base_route,
            'title'       => 'Cari Temuan',
        ];

        $view['sidebar'] = view('dashboard/sidebar');
        $view['content'] = view($this->base_name . '/cari_temuan', $data);
        return view('dashboard/header', $view);
    }

    public function prosesCariTemuan()
    {
        $rules = [
            'nik' => "required|numeric",
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput();
        } else {
            $data = [
                'nik'     => $this->request->getVar('nik', $this->filter),
                'nama'    => $this->request->getVar('nama', $this->filter),
                'rincian' => $this->request->getVar('rincian', $this->filter),
                'tanggal' => $this->request->getVar('tanggal', $this->filter),
                'bukti'   => $bukti_name,
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
}
