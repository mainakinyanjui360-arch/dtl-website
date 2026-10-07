<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class InquiryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'department' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'message' => 'required|string',
            'captcha_answer' => 'required|numeric',
            'captcha_expected' => 'required|numeric',
        ]);

        if ((int)$validated['captcha_answer'] !== (int)$validated['captcha_expected']) {
            return back()->withErrors(['captcha_answer' => 'Incorrect math answer. Please try again.']);
        }

        $inquiry = Inquiry::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $request->input('department', 'General Inquiry'),
            'message' => "Phone: " . $request->input('phone', 'N/A') . "\nCompany: " . $request->input('company', 'N/A') . "\n\nMessage:\n" . $validated['message'],
            'status' => 'new',
        ]);

        $adminEmail = \App\Models\Setting::where('key', 'contact_email')->value('value') ?? 'sales@dignitytraders.com';

        try {
            Mail::to($adminEmail)->send(new \App\Mail\AdminInquiryNotification($inquiry));
        } catch (\Exception $e) {
            // Ignore email failure for user
        }

        return back()->with('success', 'Your inquiry has been sent successfully. We will get back to you shortly.');
    }
}
