<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\ProcurementCard;

class ProcurementCardController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/ProcurementCardsIndex', [
            'cards' => ProcurementCard::orderBy('sort_order')->get()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'tagline' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:5120',
            'brands' => 'nullable|string',
            'is_active' => 'boolean',
            'sort_order' => 'integer'
        ]);

        $brandsArray = $request->filled('brands') 
            ? array_map('trim', explode(',', $request->brands)) 
            : [];

        $card = new ProcurementCard();
        $card->title = $validated['title'];
        $card->tagline = $validated['tagline'];
        $card->description = $validated['description'];
        $card->brands = $brandsArray;
        $card->is_active = $request->boolean('is_active', true);
        $card->sort_order = $request->input('sort_order', 0);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('hardware', 'public');
            $card->image = '/storage/' . $path;
        }

        $card->save();

        return back()->with('success', 'Card created successfully.');
    }

    public function update(Request $request, ProcurementCard $procurement_card)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'tagline' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:5120',
            'brands' => 'nullable|string',
            'is_active' => 'boolean',
            'sort_order' => 'integer'
        ]);

        $brandsArray = $request->filled('brands') 
            ? array_map('trim', explode(',', $request->brands)) 
            : [];

        $procurement_card->title = $validated['title'];
        $procurement_card->tagline = $validated['tagline'];
        $procurement_card->description = $validated['description'];
        $procurement_card->brands = $brandsArray;
        $procurement_card->is_active = $request->boolean('is_active', true);
        $procurement_card->sort_order = $request->input('sort_order', 0);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('hardware', 'public');
            $procurement_card->image = '/storage/' . $path;
        }

        $procurement_card->save();

        return back()->with('success', 'Card updated successfully.');
    }

    public function destroy(ProcurementCard $procurement_card)
    {
        $procurement_card->delete();
        return back()->with('success', 'Card deleted successfully.');
    }
}
