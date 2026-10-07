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

        // Format cart into message
        $message = "SHOPPING CART QUOTE REQUEST\n";
        $message .= "===========================\n\n";
        
        $message .= "SHIPPING ADDRESS:\n";
        $message .= $validated['address'] . "\n\n";
        
        $message .= "ITEMS:\n";
        
        $totalUsd = 0;
        foreach ($validated['cart'] as $item) {
            $price = floatval($item['price'] ?? 0);
            $qty = intval($item['quantity'] ?? 1);
            $subtotal = $price * $qty;
            $totalUsd += $subtotal;
            
            $message .= "Item: " . ($item['name'] ?? 'Unknown') . "\n";
            $message .= "Qty: " . $qty . "\n";
            $message .= "Price: $" . number_format($price, 2) . "\n";
            $message .= "Subtotal: $" . number_format($subtotal, 2) . "\n";
            $message .= "---------------------------\n";
        }
        
        $message .= "\nESTIMATED TOTAL: $" . number_format($totalUsd, 2) . "\n";
        
        if (!empty($validated['notes'])) {
            $message .= "\nADDITIONAL NOTES:\n" . $validated['notes'];
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

        return redirect()->route('shop')->with('success', 'Your quote request has been submitted successfully. We will email you a formal proposal shortly.');
    }
}
