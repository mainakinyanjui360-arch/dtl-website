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
        return Inertia::render('Admin/SettingsIndex', [
            'settings' => Setting::all()
        ]);
    }

    public function update(Request $request)
    {
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
        \Illuminate\Support\Facades\Artisan::call('currency:update');
        return back()->with('success', 'Exchange rate synced successfully from the market.');
    }
}
