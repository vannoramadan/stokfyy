<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AttributeController extends Controller
{
    public function index()
    {
        $attributes = Attribute::latest()->paginate(10);
        return view('products.attributes.index', compact('attributes'));
    }

    public function create()
    {
        return view('products.attributes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:attributes',
            'values' => 'nullable|string',
            'status' => 'boolean',
        ]);

        // Convert comma-separated values to array
        if ($request->has('values')) {
            $values = array_map('trim', explode(',', $request->values));
            $validated['values'] = json_encode($values);
        }

        $validated['status'] = $request->has('status');

        Attribute::create($validated);

        return redirect()->route('attributes.index')->with('success', 'Attribute created successfully.');
    }

    public function edit(Attribute $attribute)
    {
        // Decode JSON values to comma-separated string
        $attribute->values = $attribute->values ? implode(', ', json_decode($attribute->values, true)) : '';
        return view('products.attributes.edit', compact('attribute'));
    }

    public function update(Request $request, Attribute $attribute)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:attributes,name,' . $attribute->id,
            'values' => 'nullable|string',
            'status' => 'boolean',
        ]);

        // Convert comma-separated values to array
        if ($request->has('values')) {
            $values = array_map('trim', explode(',', $request->values));
            $validated['values'] = json_encode($values);
        } else {
            $validated['values'] = null;
        }

        $validated['status'] = $request->has('status');

        $attribute->update($validated);

        return redirect()->route('attributes.index')->with('success', 'Attribute updated successfully.');
    }

    public function destroy(Attribute $attribute)
    {
        // Check if attribute is used by any products
        if ($attribute->products()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete attribute that is assigned to products.');
        }

        $attribute->delete();
        return redirect()->route('attributes.index')->with('success', 'Attribute deleted successfully.');
    }
}
