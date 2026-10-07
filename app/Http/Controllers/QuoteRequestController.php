<?php

namespace App\Http\Controllers;

use App\Models\QuoteRequest;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminQuoteNotification;
use App\Mail\CustomerQuoteAcknowledgment;

class QuoteRequestController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'service' => 'nullable|string|max:255',
            'message' => 'nullable|string',
            'captcha_answer' => 'required|numeric',
            'captcha_expected' => 'required|numeric',
        ]);

        if ((int)$validated['captcha_answer'] !== (int)$validated['captcha_expected']) {
            return back()->withErrors(['captcha_answer' => 'Incorrect math answer. Please try again.']);
        }

        $quote = QuoteRequest::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'company' => $validated['company'],
            'service' => $validated['service'],
            'message' => $validated['message'],
            'status' => 'pending',
        ]);

        // Fetch admin email from settings, or fallback
        $adminEmail = Setting::where('key', 'contact_email')->value('value') ?? 'sales@dignitytraders.com';

        try {
            Mail::to($adminEmail)->send(new AdminQuoteNotification($quote));
            Mail::to($quote->email)->send(new CustomerQuoteAcknowledgment($quote));
        } catch (\Exception $e) {
            // Log or ignore email failure so we don't break the user experience
        }

        return back()->with('success', 'Your quote request has been sent successfully. We will get back to you shortly.');
    }
}
