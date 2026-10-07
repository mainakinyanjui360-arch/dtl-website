<?php

namespace App\Http\Controllers;

use App\Models\QuoteRequest;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminQuoteNotification;
use App\Mail\CustomerQuoteAcknowledgment;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function checkout()
    {
        return Inertia::render('Checkout');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'company' => 'nullable|string|max:255',
            'address' => 'required|string',
            'cart' => 'required|array',
            'notes' => 'nullable|string',
        ]);

        // Format cart into an HTML table message
        $message = "<h3>Shopping Cart Quote Request</h3>";
        $message .= "<p><strong>Shipping Address:</strong><br>" . nl2br(e($validated['address'])) . "</p>";
        
        $message .= "<table border='1' cellpadding='10' cellspacing='0' style='width: 100%; border-collapse: collapse; border-color: #cbd5e1; text-align: left;'>";
        $message .= "<tr style='background-color: #f8fafc;'><th>Item</th><th>Qty</th><th>Unit Price</th><th>Subtotal</th></tr>";
        
        $totalUsd = 0;
        foreach ($validated['cart'] as $item) {
            $price = floatval($item['price'] ?? 0);
            $qty = intval($item['quantity'] ?? 1);
            $subtotal = $price * $qty;
            $totalUsd += $subtotal;
            
            $message .= "<tr>";
            $message .= "<td>" . e($item['name'] ?? 'Unknown') . "</td>";
            $message .= "<td>" . $qty . "</td>";
            $message .= "<td>$" . number_format($price, 2) . "</td>";
            $message .= "<td>$" . number_format($subtotal, 2) . "</td>";
            $message .= "</tr>";
        }
        
        $message .= "<tr style='background-color: #f1f5f9; font-weight: bold;'>";
        $message .= "<td colspan='3' style='text-align: right;'>Estimated Total:</td>";
        $message .= "<td>$" . number_format($totalUsd, 2) . "</td>";
        $message .= "</tr>";
        $message .= "</table>";
        
        if (!empty($validated['notes'])) {
            $message .= "<h4>Additional Notes:</h4>";
            $message .= "<p>" . nl2br(e($validated['notes'])) . "</p>";
        }

        $quote = QuoteRequest::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'company' => $validated['company'] ?? 'N/A',
            'service' => 'Cart Checkout Quote',
            'message' => $message,
            'status' => 'pending',
        ]);

        $adminEmail = Setting::where('key', 'contact_email')->value('value') ?? 'sales@dignitytraders.com';

        try {
            Mail::to($adminEmail)->send(new AdminQuoteNotification($quote));
            Mail::to($quote->email)->send(new CustomerQuoteAcknowledgment($quote));
        } catch (\Exception $e) {
            // Ignore email failure for user flow
        }

        return back()->with('success', 'Your quote request has been submitted successfully. We will email you a formal proposal shortly.');
    }
}
