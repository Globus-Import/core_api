<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $addresses = $request->user()->addresses;
        return response()->json($addresses);
    }

    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'country' => 'required|string',
            'postal_code' => 'required|string',
            'is_primary' => 'boolean',
        ]);

        $address = $request->user()->addresses()->create($request->all());

        if ($request->is_primary) {
            $this->setPrimaryAddress($request->user(), $address->id);
        }

        return response()->json($address, 201);
    }

    public function update(Request $request, Address $address)
    {
        $this->authorize('update', $address);

        $request->validate([
            'address' => 'string',
            'city' => 'string',
            'state' => 'string',
            'country' => 'string',
            'postal_code' => 'string',
            'is_primary' => 'boolean',
        ]);

        $address->update($request->all());

        if ($request->is_primary) {
            $this->setPrimaryAddress($request->user(), $address->id);
        }

        return response()->json($address);
    }

    public function destroy(Address $address)
    {
        $this->authorize('delete', $address);

        $address->delete();

        return response()->json(null, 204);
    }

    public function setPrimary(Request $request, Address $address)
    {
        $this->authorize('update', $address);

        $this->setPrimaryAddress($request->user(), $address->id);

        return response()->json(['message' => 'Primary address set successfully']);
    }

    private function setPrimaryAddress($user, $addressId)
    {
        $user->addresses()->update(['is_primary' => false]);
        $user->addresses()->where('id', $addressId)->update(['is_primary' => true]);
    }
}
