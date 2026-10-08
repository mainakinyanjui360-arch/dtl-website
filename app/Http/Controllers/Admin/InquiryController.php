<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Mail;

class InquiryController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/InquiriesIndex', [
            'inquiries' => Inquiry::latest()->get()
        ]);
    }

    public function reply(Request $request, Inquiry $inquiry)
    {
        $request->validate([
            'reply_message' => 'required|string',
            'attachment' => 'nullable|file|max:10240' // max 10MB
        ]);

        $file = $request->file('attachment');
        
        try {
            Mail::to($inquiry->email)->send(
                new \App\Mail\InquiryReplyEmail($inquiry, $request->input('reply_message'), $file ? $file->getRealPath() : null, $file ? $file->getClientOriginalName() : null)
            );

            // Update status
            $inquiry->update(['status' => 'replied']);

            return back()->with('success', 'Reply sent successfully to ' . $inquiry->email);
        } catch (\Exception $e) {
            return back()->withErrors(['reply_message' => 'Failed to send email. Error: ' . $e->getMessage()]);
        }
    }

    public function destroy(Inquiry $inquiry)
    {
        if (!auth()->user()->hasPermission('delete_quotes')) {
            return back()->with('error', 'You do not have permission to delete inquiries.');
        }

        $inquiry->delete();
        return back()->with('success', 'Inquiry deleted successfully.');
    }
}
