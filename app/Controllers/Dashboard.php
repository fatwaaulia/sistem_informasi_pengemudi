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
            $view['content'] = view('dashboard/started', $data);
        }
        $view['sidebar'] = view('dashboard/sidebar', $data);
        return view('dashboard/header', $view);
    }
}
