<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    // 1. Menampilkan halaman daftar ruangan
    public function index()
    {
        $locations = Location::latest()->get();
        return view('location.index', compact('locations'));
    }

    // 2. Menyimpan ruangan baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:locations,name',
        ], [
            'name.unique' => 'Nama ruangan sudah ada!',
        ]);

        Location::create([
            'name' => $request->name
        ]);

        return redirect()->back()->with('success', 'Ruangan berhasil ditambahkan!');
    }

    // 3. Mengubah nama ruangan
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:locations,name,' . $id,
        ], [
            'name.unique' => 'Nama ruangan sudah ada!',
        ]);

        $location = Location::findOrFail($id);
        $location->update([
            'name' => $request->name
        ]);

        return redirect()->back()->with('success', 'Nama ruangan berhasil diubah!');
    }

    // 4. Menghapus ruangan
    public function destroy($id)
    {
        $location = Location::findOrFail($id);
        $location->delete();

        return redirect()->back()->with('success', 'Ruangan berhasil dihapus!');
    }
}