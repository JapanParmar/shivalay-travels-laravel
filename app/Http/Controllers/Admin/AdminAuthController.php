<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use App\Services\TravelService;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    protected $travelService;

    public function __construct(TravelService $travelService)
    {
        $this->travelService = $travelService;
    }

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
            if ($matchedUser->status === 'inactive') {
                return redirect('/admin/login')->withErrors(['login' => 'Your account is deactivated.']);
            }

            if ($matchedUser->status === 'pending') {
                session(['otp_verify_email' => $matchedUser->email]);
                return redirect('/admin/verify-otp')->with('success', 'Please verify your email address with the OTP sent to you.');
            }

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

    public function showVerifyOtp()
    {
        if (!session()->has('otp_verify_email')) {
            return redirect('/admin/login');
        }
        return view('admin.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        if (!session()->has('otp_verify_email')) {
            return redirect('/admin/login');
        }

        $email = session('otp_verify_email');
        $otp = $request->input('otp');

        $user = AdminUser::where('email', $email)
            ->where('otp_code', $otp)
            ->where('otp_purpose', 'verify_email')
            ->first();

        if (!$user) {
            return redirect('/admin/verify-otp')->withErrors(['otp' => 'Invalid OTP code.']);
        }

        if (now()->gt($user->otp_expires_at)) {
            return redirect('/admin/verify-otp')->withErrors(['otp' => 'This OTP has expired. Please contact super admin.']);
        }

        // Activate user
        $user->update([
            'status' => 'active',
            'otp_code' => null,
            'otp_expires_at' => null,
            'otp_purpose' => null,
        ]);

        $this->travelService->syncToFallback();

        session()->forget('otp_verify_email');

        session([
            'admin_authenticated' => true,
            'admin_id' => $user->id,
            'admin_name' => $user->name,
            'admin_email' => $user->email,
            'admin_role' => $user->role,
        ]);

        return redirect('/admin/dashboard')->with('success', 'Email verified and logged in successfully!');
    }

    public function showForgotPassword()
    {
        return view('admin.forgot-password');
    }

    public function forgotPassword(Request $request)
    {
        $email = $request->input('email');
        $user = AdminUser::where('email', $email)->first();

        if (!$user) {
            return redirect('/admin/forgot-password')->withErrors(['email' => 'No account found with this email address.']);
        }

        $otp = strval(rand(100000, 999999));
        $expiresAt = now()->addMinutes(15);

        $user->update([
            'otp_code' => $otp,
            'otp_expires_at' => $expiresAt,
            'otp_purpose' => 'reset_password',
        ]);

        $this->travelService->syncToFallback();

        $settings = $this->travelService->getSettings();
        $businessName = $settings['businessName'] ?? 'Shivalay Travels';

        try {
            \Illuminate\Support\Facades\Mail::send([], [], function ($message) use ($email, $user, $otp, $businessName) {
                $htmlContent = "
                    <div style=\"font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e0e0e0; border-radius: 8px;\">
                        <h2 style=\"color: #ff0000; border-bottom: 2px solid #ff0000; padding-bottom: 10px;\">Reset Your Password - {$businessName}</h2>
                        <p>Hello <strong>{$user->name}</strong>,</p>
                        <p>You requested to reset your password on the <strong>{$businessName}</strong> Admin Portal.</p>
                        <p>Please use the following OTP (One-Time Password) code to proceed with resetting your password:</p>
                        <div style=\"background: #f4f4f4; padding: 15px; text-align: center; font-size: 24px; font-weight: bold; letter-spacing: 4px; color: #ff0000; border-radius: 6px; margin: 20px 0;\">
                            {$otp}
                        </div>
                        <p style=\"font-size: 13px; color: #666;\">This OTP is valid for 15 minutes. If you did not request this password reset, please ignore this email.</p>
                        <hr style=\"border: none; border-top: 1px solid #eee; margin-top: 30px;\" />
                        <p style=\"font-size: 14px; font-weight: bold; color: #ff0000;\">{$businessName}</p>
                    </div>
                ";
                $message->to($email)
                    ->subject("Password Reset OTP - {$businessName}")
                    ->html($htmlContent);
            });
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Failed to send password reset OTP: " . $e->getMessage());
        }

        session(['otp_reset_email' => $email]);

        return redirect('/admin/reset-password')->with('success', 'Password reset OTP has been sent to your email.');
    }

    public function showResetPassword()
    {
        if (!session()->has('otp_reset_email')) {
            return redirect('/admin/forgot-password');
        }
        return view('admin.reset-password');
    }

    public function resetPassword(Request $request)
    {
        if (!session()->has('otp_reset_email')) {
            return redirect('/admin/forgot-password');
        }

        $email = session('otp_reset_email');
        $otp = $request->input('otp');
        $password = $request->input('password');
        $passwordConfirm = $request->input('password_confirmation');

        if ($password !== $passwordConfirm) {
            return redirect('/admin/reset-password')->withErrors(['password' => 'Passwords do not match.']);
        }

        $user = AdminUser::where('email', $email)
            ->where('otp_code', $otp)
            ->where('otp_purpose', 'reset_password')
            ->first();

        if (!$user) {
            return redirect('/admin/reset-password')->withErrors(['otp' => 'Invalid OTP code.']);
        }

        if (now()->gt($user->otp_expires_at)) {
            return redirect('/admin/reset-password')->withErrors(['otp' => 'This OTP has expired. Please generate a new one.']);
        }

        // Reset password
        $user->update([
            'password' => $password,
            'otp_code' => null,
            'otp_expires_at' => null,
            'otp_purpose' => null,
        ]);

        $this->travelService->syncToFallback();

        session()->forget('otp_reset_email');

        return redirect('/admin/login')->with('success', 'Password reset successfully. You can now log in.');
    }

    public function logout()
    {
        session()->forget(['admin_authenticated', 'admin_id', 'admin_name', 'admin_email', 'admin_role']);
        return redirect('/admin/login');
    }
}
