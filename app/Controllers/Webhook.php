<?php

namespace App\Controllers;

class Webhook extends BaseController
{
    public function xendit()
    {
        $json = file_get_contents('php://input');
        $response = json_decode($json, true);

        $data = [
            'input'      => json_encode($response, true),
            'invoice_id' => $response['id'] ?? '',
            'kode'       => $response['external_id'] ?? '',
        ];
        model('Webhook')->insert($data);
        
        if (isset($response['id'])) {
            $cek_transaksi = model('TransaksiLangganan')->where('invoice_id', $response['id'])->first();

            if ($cek_transaksi) {
                $api_key = 'xnd_development_PpGuPzQwPPOWAfP93FYXLZx9eR5oGYqijUFBfXGeuSS8zotffTFIiOwaJwE5vZ3:';
                $api_key_base64 = base64_encode($api_key);

                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://api.xendit.co/v2/invoices/' . $response['id'],
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_POSTFIELDS => '',
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json',
                        'Authorization: Basic ' . $api_key_base64,
                    ),
                ));
                $response = curl_exec($curl);
                curl_close($curl);

                $response = json_decode($response, true);

                $status = 'Menunggu Pembayaran';
                if ($response['status'] == 'PENDING') {
                    $status = 'Menunggu Pembayaran';
                } elseif ($response['status'] == 'PAID') {
                    $status = 'Lunas';
                } elseif ($response['status'] == 'SETTLED') {
                    $status = 'Lunas';
                } elseif ($response['status'] == 'EXPIRED') {
                    $status = 'Kedaluwarsa';
                }

                // simpan transaksi langganan
                $data = [
                    'status' => $status,
                    'invoice_status' => $response['status'],
                    'paid_at' => $response['paid_at'],
                ];
                model('TransaksiLangganan')->update($cek_transaksi['id'], $data);

                // tambah poin jika sudah terbayar
                if (in_array($response['status'], ['PAID', 'SETTLED'])) {
                    $transaksi_langganan = model('TransaksiLangganan')->where('invoice_id', $response['id'])->first();

                    if ($transaksi_langganan['status_pencairan_poin'] != 'Berhasil') {
                        model('TransaksiLangganan')->update($transaksi_langganan['id'], ['status_pencairan_poin' => 'Berhasil']);

                        $perusahaan = model('Users')->where('id', $transaksi_langganan['id_perusahaan'])->first();
                        $data = [
                            'poin' => $perusahaan['poin'] + $transaksi_langganan['poin'],
                        ];
                        model('Users')->update($perusahaan['id'], $data);
                    }
                }

                header('Content-Type: application/json; charset=utf-8');
                $html = array();
                $html['status'] = true;
                $html['code'] = 200;
                $html['data'] = json_encode($json, true);
                $html['msg'] = "Webhook xendit was successfully";
                echo json_encode($html, true);

            } else {
                header('Content-Type: application/json; charset=utf-8');
                $html = array();
                $html['status'] = false;
                $html['code'] = 200;
                $html['data'] = json_encode($json, true);
                $html['msg'] = "Transaction not found";
                echo json_encode($html, true);
            }
        } else {
            header('Content-Type: application/json; charset=utf-8');
            $html = array();
            $html['status'] = false;
            $html['code'] = 200;
            $html['data'] = json_encode($json, true);
            $html['msg'] = "Webhook xendit was unsuccessfully";
            echo json_encode($html, true);
        }
    }
}
