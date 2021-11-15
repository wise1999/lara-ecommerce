<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreShippingMethodRequest;
use App\Http\Requests\UpdateShippingMethodRequest;
use App\Models\ShippingMethod;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShippingMethodController extends Controller
{
    public function index() {
        $shippings = ShippingMethod::get();

        return Inertia::render('Admin/ShippingMethods/Index', [
            'shippings' => ShippingMethod::all()->map(function ($shipping) {
                return [
                    'id' => $shipping->id,
                    'name' => $shipping->name,
                    'price' => $shipping->formattedPrice,
                ];
            })
        ]);
    }

    public function create() {
        return Inertia::render('Admin/ShippingMethods/Create');
    }

    public function store(StoreShippingMethodRequest $request) {
        $validated = $request->validated();

        ShippingMethod::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
        ]);

        return redirect()->route('shipping-methods.index')
        ->with('message', 'Shipping Method Added Successfully.');
    }

    public function edit($id) {
        $shipping = ShippingMethod::findOrFail($id);

        return Inertia::render('Admin/ShippingMethods/Edit', [
            'shipping' => [
                'id' => $shipping->id,
                'name' => $shipping->name,
                'price' => $shipping->price->amount(),
            ],
        ]);
    }

    public function update(UpdateShippingMethodRequest $request, $id) {
        $validated = $request->validated();

        $shipping = ShippingMethod::findOrFail($id);

        $shipping->update([
            'name' => $validated['name'],
            'price' => $validated['price'],
        ]);

        return redirect()->back()
        ->with('message', 'Shipping Method Updated Successfully.');
    }

    public function destroy($id) {
        $shipping = ShippingMethod::findOrFail($id);
        $shipping->delete();
        return redirect()->route('shipping-methods.index')
        ->with('message', 'Shipping Method Deleted Successfully.');
    }
}
