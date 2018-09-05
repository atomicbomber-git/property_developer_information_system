<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\VendorContactPerson as ContactPerson;
use Illuminate\Validation\Rule;
use App\Vendor;
use DB;
use URL;

class VendorContactPersonController extends Controller
{
    public function create(Vendor $vendor)
    {
        $data = $this->validate(request(), [
            'contact_people' => 'required|array',
            'contact_people.*.name' => 'required|string',
            'contact_people.*.phone' => 'required|string'
        ]);

        foreach ($data['contact_people'] as $contact_person) {
            $contact_person['vendor_id'] = $vendor->id;
            ContactPerson::create($contact_person);
        }

        session()->flash('message.success', __('messages.create.success'));

        return [
            'status' => 'success',
            'redirect' => URL::previous()
        ];
    }

    public function update(Vendor $vendor)
    {
        $vendor_contact_people_ids = $vendor->contact_people()
            ->select('id')->pluck('id');

        $data = $this->validate(request(), [
            'contact_people' => 'required|array',
            'contact_people.*.id' => ['required', Rule::in($vendor_contact_people_ids)],
            'contact_people.*.name' => 'required|string',
            'contact_people.*.phone' => 'required|string'
        ]);

        DB::transaction(function() use($data) {
            foreach ($data['contact_people'] as $contact_person) {
                ContactPerson::where('id', $contact_person['id'])
                    ->update([
                        'name' => $contact_person['name'],
                        'phone' => $contact_person['phone']
                    ]);
            }
        });

        return back()
            ->with('message.success', __('messages.update.success'));
    }

    public function delete(Vendor $vendor, ContactPerson $contact_person)
    {
        $contact_person->delete();
        return back()
            ->with('message.success', __('messages.delete.success'));
    }
}
