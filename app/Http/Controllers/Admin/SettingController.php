<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        if (!auth()->user()->hasPermission('manage_settings')) {
            return redirect('/shop/admin/products')->with('error', 'You do not have permission to manage settings.');
        }

        return Inertia::render('Admin/SettingsIndex', [
            'settings' => Setting::all()
        ]);
    }

    public function update(Request $request)
    {
        if (!auth()->user()->hasPermission('manage_settings')) {
            return back()->with('error', 'You do not have permission to manage settings.');
        }
        $validated = $request->validate([
            'settings' => 'required|array',
            'settings.*.key' => 'required|string',
            'settings.*.value' => 'nullable|string',
        ]);

        foreach ($validated['settings'] as $settingData) {
            Setting::set($settingData['key'], $settingData['value']);
        }

        return back()->with('success', 'Settings updated successfully.');
    }

    public function syncCurrency()
    {
        if (!auth()->user()->hasPermission('manage_settings')) {
            return back()->with('error', 'You do not have permission to sync currency.');
        }

        \Illuminate\Support\Facades\Artisan::call('currency:update');
        return back()->with('success', 'Exchange rate synced successfully from the market.');
    }
}
