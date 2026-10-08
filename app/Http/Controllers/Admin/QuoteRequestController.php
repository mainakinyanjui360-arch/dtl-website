<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuoteRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QuoteRequestController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/QuotesIndex', [
            'quotes' => QuoteRequest::latest()->get()
        ]);
    }

    public function destroy(QuoteRequest $quote)
    {
        if (!auth()->user()->hasPermission('delete_quotes')) {
            return back()->with('error', 'You do not have permission to delete quote requests.');
        }

        $quote->delete();
        return back()->with('success', 'Quote request deleted successfully.');
    }

    public function send(Request $request, QuoteRequest $quote)
    {
        $request->validate([
            'pdf' => 'required|file|mimes:pdf|max:10240' // max 10MB
        ]);

        $file = $request->file('pdf');
        
        try {
            \Illuminate\Support\Facades\Mail::to($quote->email)->send(
                new \App\Mail\QuoteProposalEmail($quote, $file->getRealPath(), $file->getClientOriginalName())
            );

            // Update status
            $quote->update(['status' => 'sent']);

            return back()->with('success', 'Quotation sent successfully to ' . $quote->email);
        } catch (\Exception $e) {
            return back()->withErrors(['pdf' => 'Failed to send email. Error: ' . $e->getMessage()]);
        }
    }
}
