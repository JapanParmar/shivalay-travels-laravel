<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        if (session()->has('admin_authenticated')) {
            return redirect('/admin/dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $matchedUser = AdminUser::where('email', $email)->where('password', $password)->first();

        if ($matchedUser) {
            session([
                'admin_authenticated' => true,
                'admin_id' => $matchedUser->id,
                'admin_name' => $matchedUser->name,
                'admin_email' => $matchedUser->email,
                'admin_role' => $matchedUser->role,
            ]);
            return redirect('/admin/dashboard');
        }

        return redirect('/admin/login')->withErrors(['login' => 'Invalid email or password.']);
    }

    public function logout()
    {
        session()->forget(['admin_authenticated', 'admin_id', 'admin_name', 'admin_email', 'admin_role']);
        return redirect('/admin/login');
    }
}
