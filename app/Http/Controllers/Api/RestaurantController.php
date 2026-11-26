<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function index()
    {
        $data = Restaurant::where('user_id', auth()->id())->latest()->get();
        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate(['name' => 'required|string|max:255']);
        $item = Restaurant::create([
            'user_id' => auth()->id(),
            'name' => $validated['name'],
        ]);
        return response()->json(['message' => 'Tempat berhasil ditambahkan', 'data' => $item], 201);
    }

    public function show($id)
    {
        $item = Restaurant::where('user_id', auth()->id())->findOrFail($id);
        return response()->json(['data' => $item]);
    }

    public function update(Request $request, $id)
    {
        $item = Restaurant::where('user_id', auth()->id())->findOrFail($id);
        $validated = $request->validate(['name' => 'required|string|max:255']);
        $item->update($validated);
        return response()->json(['message' => 'Tempat berhasil diperbarui', 'data' => $item]);
    }

    public function destroy($id)
    {
        $item = Restaurant::where('user_id', auth()->id())->findOrFail($id);
        $item->delete();
        return response()->json(['message' => 'Tempat berhasil dihapus']);
    }
}