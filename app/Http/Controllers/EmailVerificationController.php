<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EmailVerificationController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function notice(): View
    {
        return view('auth.verify-email');
    }

    /**
     * Mark the authenticated user's email address as verified.
     */
    public function verify(EmailVerificationRequest $request): RedirectResponse
    {
        $request->fulfill();

        return redirect()->route('profile')->with('success', 'Email berhasil diverifikasi! 🎉');
    }

    /**
     * Send a new email verification notification.
     */
    public function send(Request $request)
    {
        try {
            // Check if user is already verified
            if ($request->user()->hasVerifiedEmail()) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'Email sudah terverifikasi sebelumnya.'
                    ], 200);
                }
                return back()->with('info', 'Email sudah terverifikasi sebelumnya.');
            }

            // Send the verification notification
            $request->user()->sendEmailVerificationNotification();

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Link verifikasi telah dikirim ke email Anda! Silakan cek inbox dan spam folder.'
                ], 200);
            }

            return back()->with('success', 'Link verifikasi telah dikirim ke email Anda! 📧');
            
        } catch (\Illuminate\Http\Exceptions\ThrottleRequestsException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Terlalu banyak permintaan. Silakan tunggu beberapa saat sebelum mencoba lagi.'
                ], 429);
            }
            return back()->with('error', 'Terlalu banyak permintaan. Silakan tunggu beberapa saat.');
            
        } catch (\Exception $e) {
            \Log::error('Email verification send failed: ' . $e->getMessage(), [
                'user_id' => $request->user()->id,
                'error' => $e->getTraceAsString()
            ]);
            
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Terjadi kesalahan saat mengirim email verifikasi. Silakan coba lagi.'
                ], 500);
            }
            
            return back()->with('error', 'Terjadi kesalahan saat mengirim email verifikasi. Silakan coba lagi.');
        }
    }
}
