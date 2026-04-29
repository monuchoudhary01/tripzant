<?php

namespace App\Http\Controllers\Dev;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SmtpTestController extends Controller
{
    /**
     * Show the SMTP test page.
     * Only accessible in local/dev environment.
     */
    public function show()
    {
        if (!in_array(app()->environment(), ['local', 'development'])) {
            abort(403, 'This endpoint is only available in local/development environment.');
        }
        return view('dev.smtp-test');
    }

    /**
     * Send a test email and return JSON result.
     */
    public function send(Request $request)
    {
        if (!in_array(app()->environment(), ['local', 'development'])) {
            return response()->json(['success' => false, 'message' => 'Not available in production.'], 403);
        }

        $request->validate([
            'to'      => 'required|email',
            'subject' => 'nullable|string|max:255',
            'body'    => 'nullable|string|max:2000',
        ]);

        $to      = $request->input('to');
        $subject = $request->input('subject', 'Tripzant SMTP Test');
        $body    = $request->input('body', 'This is a test email from Tripzant.');

        try {
            Mail::html(
                "<div style='font-family:sans-serif;padding:30px;'>"
                . "<h2 style='color:#005eb8;'>📧 Tripzant SMTP Test</h2>"
                . "<p style='color:#333;'>" . nl2br(htmlspecialchars($body)) . "</p>"
                . "<hr style='border:1px solid #eee;margin:20px 0;'>"
                . "<small style='color:#999;'>Sent from Tripzant Dev SMTP Tester · " . now() . "</small>"
                . "</div>",
                function ($message) use ($to, $subject) {
                    $message->to($to)
                            ->subject($subject)
                            ->from(
                                config('mail.from.address', 'admin@easitripbooking.com'),
                                config('mail.from.name', 'Tripzant')
                            );
                }
            );

            return response()->json([
                'success' => true,
                'message' => "Mail sent to {$to} via " . config('mail.mailers.smtp.host') . ':' . config('mail.mailers.smtp.port') . "\nUsing: " . config('mail.from.address'),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
