<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VehicleType;
use App\Models\VehicleTypeTranslation;
use Illuminate\Http\Request;
use Modules\Language\App\Models\Language;
use Str;

class VehicleTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vehicle_types = VehicleType::with('translate')->latest()->get();
        return view('admin.vehicle_type.index', compact('vehicle_types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.vehicle_type.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:vehicle_types,slug|max:255',
        ]);

        $vehicle_type = new VehicleType();
        $vehicle_type->slug = $request->slug;
        $vehicle_type->status = $request->status ? 'enable' : 'disable';
        $vehicle_type->save();

        // Create translations for all languages
        $languages = Language::all();
        foreach ($languages as $language) {
            $translation = new VehicleTypeTranslation();
            $translation->vehicle_type_id = $vehicle_type->id;
            $translation->lang_code = $language->lang_code;
            $translation->name = $request->name;
            $translation->save();
        }

        $notify_message = trans('translate.Created Successfully');
        $notify_message = ['message' => $notify_message, 'alert-type' => 'success'];
        return redirect()->route('admin.vehicle-type.edit', ['vehicle_type' => $vehicle_type->id, 'lang_code' => admin_lang()])
            ->with($notify_message);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $vehicle_type = VehicleType::findOrFail($id);
        $vehicle_type_translate = VehicleTypeTranslation::where([
            'vehicle_type_id' => $id,
            'lang_code' => $request->lang_code
        ])->first();

        $language_list = Language::all();

        return view('admin.vehicle_type.edit', compact('vehicle_type', 'vehicle_type_translate', 'language_list'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $vehicle_type = VehicleType::findOrFail($id);

        if ($request->lang_code == admin_lang()) {
            $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:vehicle_types,slug,' . $id,
            ]);

            $vehicle_type->slug = $request->slug;
            $vehicle_type->status = $request->status ? 'enable' : 'disable';
            $vehicle_type->save();
        }

        // Update translation
        $translation = VehicleTypeTranslation::where([
            'vehicle_type_id' => $id,
            'lang_code' => $request->lang_code
        ])->first();

        if ($translation) {
            $translation->name = $request->name;
            $translation->save();
        }

        $notify_message = trans('translate.Updated Successfully');
        $notify_message = ['message' => $notify_message, 'alert-type' => 'success'];
        return redirect()->back()->with($notify_message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $vehicle_type = VehicleType::findOrFail($id);
        $vehicle_type->delete();

        $notify_message = trans('translate.Deleted Successfully');
        $notify_message = ['message' => $notify_message, 'alert-type' => 'success'];
        return redirect()->route('admin.vehicle-type.index')->with($notify_message);
    }
}

