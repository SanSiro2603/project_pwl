<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Studio;

class StudioController extends Controller
{
    public function index()
    {
        // Menampilkan semua studio aktif
        $studios = Studio::where('is_active', true)->get();

        return view('customer.studios.index', compact('studios'));
    }

    public function show($id)
    {
        // Menampilkan detail satu studio
        $studio = Studio::with('schedules')->findOrFail($id);

        return view('customer.studios.show', compact('studio'));
    }
}
