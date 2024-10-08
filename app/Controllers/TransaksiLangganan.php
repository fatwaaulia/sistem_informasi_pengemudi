<?php

namespace App\Controllers;

class TransaksiLangganan extends BaseController
{
    protected $base_model;
    protected $base_name;
    protected $upload_path;

    public function __construct()
    {
        $this->base_model   = model('TransaksiLangganan');
        $this->base_name    = 'transaksi_langganan';
        $this->upload_path  = 'assets/uploads/' . $this->base_name . '/';
    }
    
    public function getData()
    {
        $user_session = model('Users')->where('id', session()->get('id_user'))->first();

        $total_rows = $this->base_model->where('id_perusahaan', $user_session['id'])->countAllResults();
        $limit = $this->request->getVar('length') ?? $total_rows;
        $offset = $this->request->getVar('start') ?? 0;

        $data = $this->base_model
                ->where('id_perusahaan', $user_session['id'])
                ->orderBy('id DESC')
                ->findAll($limit, $offset);
        
        $search = $this->request->getVar('search')['value'] ?? null;
        if ($search) {
            $data       = $this->base_model
                            ->where('id_perusahaan', $user_session['id'])
                            ->like('nama', $search)->orderBy('id DESC')
                            ->findAll($limit, $offset);
            $total_rows = $this->base_model
                            ->where('id_perusahaan', $user_session['id'])
                            ->like('nama', $search)->orderBy('id DESC')
                            ->countAllResults();
        }

        foreach ($data as $key => $v) {
            $data[$key]['no_urut'] = $offset + $key + 1;
            $data[$key]['id'] = encode($v['id']);
            $data[$key]['harga_promo'] = number_format($v['harga_promo'], 0, ',', '.');
            $data[$key]['created_at'] = date('d-m-Y H:i:s', strtotime($v['created_at']));
        }

        return $this->response->setJSON([
            'recordsTotal'    => $this->base_model->where('id_perusahaan', $user_session['id'])->countAllResults(),
            'recordsFiltered' => $total_rows,
            'data'            => $data,
        ]);
    }

    public function index()
    {
        $data = [
            'get_data'    => $this->base_route . '/get-data',
            'upload_path' => $this->upload_path,
            'base_route'  => $this->base_route,
            'title'       => 'Transaksi Langganan',
        ];

        $view['sidebar'] = view('dashboard/sidebar');
        $view['content'] = view($this->base_name . '/main', $data);
        return view('dashboard/header', $view);
    }

    public function create()
    {
        $id_perusahaan = $this->user_session['id'];
        $user_session = model('Users')->where('id', session()->get('id_user'))->first();

        $id_paket = $this->request->getVar('id_paket', $this->filter);
        $paket_langganan = model('PaketLangganan')->find($id_paket);

        for (;;) {
            $random_string = strtoupper(random_string('alnum', 6));
            $cek_kode = $this->base_model->getWhere(['kode' => $random_string])->getNumRows();
            if ($cek_kode == 0) {
                $kode = $random_string;
                break;
            }
        }

        // cek free trial apakah sudah pernah digunakan
        if ($paket_langganan['harga_promo'] == 0) {

            if ($user_session['bonus_free_trial_at'] != null) {
                # pernah pakai free trial
                return redirect()->to(base_url() . 'perusahaan/berlangganan')
                ->with('message',
                "<script>
                    Swal.fire({
                    icon: 'error',
                    title: 'Paket ini tidak dapat digunakan lagi!',
                    showConfirmButton: false,
                    timer: 2500,
                    timerProgressBar: true,
                    })
                </script>");
            } else {
                # jika free trial belum pernah digunakan
                $data = [
                    'id_perusahaan'  => $id_perusahaan,
                    'id_paket'       => $id_paket,
                    'nama_paket'     => $paket_langganan['nama_paket'],
                    'harga_normal'   => $paket_langganan['harga_normal'],
                    'harga_promo'    => $paket_langganan['harga_promo'],
                    'label'          => $paket_langganan['label'],
                    'deskripsi'      => $paket_langganan['deskripsi'],
                    'poin'           => $paket_langganan['poin'],
                    'status_pencairan_poin' => 'Berhasil',
                    'status'         => 'Lunas',
                    'kode'           => $kode,
                    'invoice_url'    => 'Free Trial',
                    'invoice_id'     => 'Free Trial',
                    'invoice_status' => 'Free Trial',
                    'expired_at'     => null,
                    'invoice_received'  => 'Free Trial',
                    'invoice_sent'      => 'Free Trial',
                    'paid_at'           => null,
                    'layanan_berakhir'  => date('Y-m-d H:i:s', strtotime('+1 year')),
                ];

                $this->base_model->insert($data);
                $id_transaksi_terakhir = $this->base_model->insertID();

                $perusahaan = model('Users')->where('id', $id_perusahaan)->first();
                $data = [
                    'poin'                   => $perusahaan['poin'] + $paket_langganan['poin'],
                    'poin_masuk'             => $perusahaan['poin_masuk'] + $paket_langganan['poin'],
                    'id_transaksi_langganan' => $id_transaksi_terakhir,
                    'nama_paket'             => $paket_langganan['nama_paket'],
                    'layanan_mulai'          => date('Y-m-d H:i:s'),
                    'layanan_berakhir'       => date('Y-m-d H:i:s', strtotime('+1 year')),
                    'bonus_free_trial_at'    => date('Y-m-d H:i:s'),
                ];
                model('Users')->update($perusahaan['id'], $data);

                return redirect()->to(base_url() . 'perusahaan/transaksi-langganan/detail?code=' . $kode)
                ->with('message',
                "<script>
                    Swal.fire({
                    icon: 'success',
                    title: 'Free Trial telah diaktifkan.',
                    showConfirmButton: false,
                    timer: 2500,
                    timerProgressBar: true,
                    })
                </script>");
            }
        }

        // hentikan proses jika terlalu cepat melakukan transaksi kurang dari 1 menit
        $cek_log = model('TransaksiLogs')->where('id_perusahaan', $id_perusahaan)->orderBy('id DESC')->first();
        if ($cek_log) {
            $created_at_timestamp = strtotime($cek_log['created_at']);
            $now_timestamp = time();
            $time_difference = $now_timestamp - $created_at_timestamp;
            
            if ($time_difference <= 60) {
                return redirect()->to(base_url() . 'perusahaan/berlangganan')
                ->with('message',
                "<script>
                    Swal.fire({
                    icon: 'error',
                    title: 'Anda terlalu cepat melakukan transaksi. Silakan lakukan transaksi ".(60-$time_difference)." detik lagi.',
                    showConfirmButton: false,
                    timer: 2500,
                    timerProgressBar: true,
                    })
                </script>");
            }
        }

        $data = [
            'id_perusahaan'  => $id_perusahaan,
        ];
        model('TransaksiLogs')->insert($data);

        // proses payment gateway dimulai
        $invoice_sent = '{
            "external_id": "'. $kode . '",
            "amount": ' . $paket_langganan['harga_promo'] . ',
            "description": "Invoice Paket Layanan ' . $paket_langganan['nama_paket'] . ' #' . $kode . '",
            "invoice_duration": 86400,
            "customer": {
                "given_names": "' . $user_session['nama'] . '",
                "email": "' . $user_session['email'] . '",
                "mobile_number": "' . $user_session['no_ponsel'] . '",
                "addresses": [
                    {
                        "city": "' . $user_session['kota_perusahaan'] . '",
                        "country": "' . $user_session['negara_perusahaan'] . '",
                        "postal_code": "' . $user_session['kode_pos_perusahaan'] . '",
                        "state": "' . $user_session['alamat_perusahaan'] . '"
                    }
                ]
            },
            "customer_notification_preference": {
                "invoice_created": [
                    "whatsapp",
                    "email",
                    "viber"
                ],
                "invoice_reminder": [
                    "whatsapp",
                    "email",
                    "viber"
                ],
                "invoice_paid": [
                    "whatsapp",
                    "email",
                    "viber"
                ]
            },
            "success_redirect_url": "' . base_url() . 'perusahaan/transaksi-langganan/detail?code=' . $kode . '",
            "failure_redirect_url": "' . base_url() . 'perusahaan/transaksi-langganan/detail?code=' . $kode . '",
            "currency": "IDR"
        }';

        $api_key = 'xnd_development_PpGuPzQwPPOWAfP93FYXLZx9eR5oGYqijUFBfXGeuSS8zotffTFIiOwaJwE5vZ3:';
        $api_key_base64 = base64_encode($api_key);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.xendit.co/v2/invoices',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $invoice_sent,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Basic ' . $api_key_base64,
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response = json_decode($response, true);

        if (isset($response['id'])) {
            $data = [
                'id_perusahaan'  => $id_perusahaan,
                'id_paket'       => $id_paket,
                'nama_paket'     => $paket_langganan['nama_paket'],
                'harga_normal'   => $paket_langganan['harga_normal'],
                'harga_promo'    => $paket_langganan['harga_promo'],
                'label'          => $paket_langganan['label'],
                'deskripsi'      => $paket_langganan['deskripsi'],
                'poin'           => $paket_langganan['poin'],
                'status_pencairan_poin' => 'Belum Dicairkan',
                'status'         => 'Menunggu Pembayaran',
                'kode'           => $kode,
                'invoice_url'    => $response['invoice_url'],
                'invoice_id'     => $response['id'],
                'invoice_status' => $response['status'],
                'expired_at'     => $response['expiry_date'],
                'invoice_received'  => json_encode($response, true),
                'invoice_sent'      => json_encode($invoice_sent, true),
                'paid_at'           => null,
                'layanan_berakhir'  => date('Y-m-d H:i:s', strtotime('+1 year')),
            ];
    
            $this->base_model->insert($data);
            return redirect()->to(base_url() . 'perusahaan/transaksi-langganan/detail?code=' . $kode)
            ->with('message',
            "<script>
                Swal.fire({
                icon: 'success',
                title: 'Transaksi berhasil dilakukan. Segera lakukan pembayaran.',
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true,
                })
            </script>");
        } else {
            return redirect()->to($this->base_route)
            ->with('message',
            "<script>
                Swal.fire({
                icon: 'error',
                title: 'Transaksi tidak berhasil. Ulangi beberapa saat lagi.',
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true,
                })
            </script>");
        }
    }

    public function detail()
    {
        $kode = $this->request->getVar('code');
        $data = [
            'get_data'    => $this->base_route . '/get-data',
            'upload_path' => $this->upload_path,
            'base_route'  => $this->base_route,
            'title'       => 'Detail Transaksi Langganan',
            'transaksi_langganan' => model('TransaksiLangganan')->where('kode', $kode)->first(),
        ];

        $view['sidebar'] = view('dashboard/sidebar');
        $view['content'] = view($this->base_name . '/detail', $data);
        return view('dashboard/header', $view);
    }
}
