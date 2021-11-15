<?php

namespace App\Http\Controllers\Front\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\Dashboard\Address\StoreAddressRequest;
use App\Http\Requests\Front\Dashboard\Address\UpdateAddressRequest;
use App\Models\Address;
use App\Models\Country;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Mockery\Matcher\HasValue;

class AddressController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return Inertia::render('Front/Dashboard/UserAddresses/Index', [
            'addresses' => $user->addresses()->with('country')->get()
        ]);
    }

    public function create()
    {
        return Inertia::render('Front/Dashboard/UserAddresses/Create', [
            'countries' => Country::all(),
        ]);
    }

    public function store(StoreAddressRequest $request)
    {
        $validated = $request->validated();

        $address = Address::create([
            'user_id' => auth()->id(),
            'country_id' => $validated['country'],
            'name' => $validated['name'],
            'address_1' => $validated['address_1'],
            'city' => $validated['city'],
            'postal_code' => $validated['postal_code'],
            'default' => false,
        ]);

        return redirect()->back()
            ->with('message', 'Address Added Successfully.');
    }

    public function edit($id)
    {
        return Inertia::render('Front/Dashboard/UserAddresses/Edit', [
            'address' => Address::findOrFail($id)->load('country'),
            'countries' => Country::all(),
        ]);
    }

    public function update(UpdateAddressRequest $request, $id)
    {
        $validated = $request->validated();

        $address = Address::findOrFail($id);

        $address->update([
            'name' => $validated['name'],
            'country_id' => $validated['country'],
            'address_1' => $validated['address_1'],
            'city' => $validated['city'],
            'postal_code' => $validated['postal_code'],
        ]);

        return redirect()->back()->with('message', 'Address Updated Succesfully.');
    }

    public function destroy($id)
    {
        $address = Address::findOrFail($id);

        $address->delete();

        return redirect()->back()
            ->with('message', 'Address Deleted Successfully.');
    }
}
