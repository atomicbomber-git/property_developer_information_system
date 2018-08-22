<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vendor;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::all();

        return view('vendor.index', [
            'vendors' => $vendors
        ]);
    }

    public function create()
    {
        return view('vendor.create');
    }

    public function processCreate()
    {
        $data = $this->validate(request(), [
            'name' => 'required|string',
            'address' => 'nullable|string',
            'contact_person' => 'nullable|string',
            'contact_person_phone' => 'nullable|string'
        ]);

        Vendor::create($data);

        return redirect()
            ->route('vendor.index')
            ->with('message.success', 'Data berhasil ditambahkan.');
    }

    public function update(Vendor $vendor)
    {
        return view('vendor.update', [
            'vendor' => $vendor
        ]);
    }

    public function processUpdate(Vendor $vendor)
    {
        $data = $this->validate(request(), [
            'name' => 'required|string',
            'address' => 'nullable|string',
            'contact_person' => 'nullable|string',
            'contact_person_phone' => 'nullable|string'
        ]);

        $vendor->update($data);
        
        return redirect()
            ->route('vendor.index')
            ->with('message.success', 'Data berhasil diperbarui.');
    }

    public function delete(Vendor $vendor)
    {
        $vendor->delete();
        return back()
            ->with('message.success', 'Data berhasil dihapus.');
    }
}
