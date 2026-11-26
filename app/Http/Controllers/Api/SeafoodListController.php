<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\SeafoodList;
use Illuminate\Http\Request;

class SeafoodListController extends Controller
{
    public function index(Request $request)
    {
        $query = SeafoodList::with('restaurant')->where('user_id', auth()->id());

        if ($request->filled('restaurant_id')) {
            $query->where('restaurant_id', $request->restaurant_id);
        }

        return response()->json(['data' => $query->latest()->get()]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'title' => 'required|string|max:255',
            'main_ingredient' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'image_url' => 'nullable|string',
        ]);

        // Pastikan restaurant_id milik user yang sedang login
        Restaurant::where('user_id', auth()->id())->findOrFail($validated['restaurant_id']);

        $item = SeafoodList::create([
            'user_id' => auth()->id(),
            'restaurant_id' => $validated['restaurant_id'],
            'title' => $validated['title'],
            'main_ingredient' => $validated['main_ingredient'],
            'notes' => $validated['notes'] ?? '',
            'image_url' => $validated['image_url'] ?? '',
        ]);

        return response()->json([
            'message' => 'Menu seafood berhasil disimpan',
            'data' => $item->load('restaurant'),
        ], 201);
    }

    public function show($id)
    {
        $item = SeafoodList::with('restaurant')->where('user_id', auth()->id())->findOrFail($id);
        return response()->json(['data' => $item]);
    }

    public function update(Request $request, $id)
    {
        $item = SeafoodList::where('user_id', auth()->id())->findOrFail($id);

        $validated = $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'title' => 'required|string|max:255',
            'main_ingredient' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'image_url' => 'nullable|string',
        ]);

        Restaurant::where('user_id', auth()->id())->findOrFail($validated['restaurant_id']);

        $item->update($validated);

        return response()->json([
            'message' => 'Menu seafood berhasil diperbarui',
            'data' => $item->load('restaurant'),
        ]);
    }

    public function destroy($id)
    {
        $item = SeafoodList::where('user_id', auth()->id())->findOrFail($id);
        $item->delete();
        return response()->json(['message' => 'Menu seafood berhasil dihapus']);
    }
}