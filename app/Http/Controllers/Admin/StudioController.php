<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Studio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudioController extends Controller
{
    public function index()
    {
        $studios = Studio::latest()->paginate(10);
        return view('admin.studios.index', compact('studios'));
    }

    public function create()
    {
        return view('admin.studios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'facilities' => 'required|array',
            'price_per_hour' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('studios', 'public');
        }

        Studio::create([
            'name' => $request->name,
            'description' => $request->description,
            'facilities' => $request->facilities,
            'price_per_hour' => $request->price_per_hour,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.studios.index')
                        ->with('success', 'Studio berhasil ditambahkan');
    }

    public function edit(Studio $studio)
    {
        return view('admin.studios.edit', compact('studio'));
    }

    public function update(Request $request, Studio $studio)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'facilities' => 'required|array',
            'price_per_hour' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = $studio->image;
        if ($request->hasFile('image')) {
            if ($studio->image) {
                Storage::disk('public')->delete($studio->image);
            }
            $imagePath = $request->file('image')->store('studios', 'public');
        }

        $studio->update([
            'name' => $request->name,
            'description' => $request->description,
            'facilities' => $request->facilities,
            'price_per_hour' => $request->price_per_hour,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.studios.index')
                        ->with('success', 'Studio berhasil diupdate');
    }

    public function destroy(Studio $studio)
    {
        if ($studio->image) {
            Storage::disk('public')->delete($studio->image);
        }
        
        $studio->delete();

        return redirect()->route('admin.studios.index')
                        ->with('success', 'Studio berhasil dihapus');
    }
}
