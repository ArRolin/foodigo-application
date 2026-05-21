<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocumentType;
use App\Models\DocumentTypeTranslation;
use Illuminate\Http\Request;
use Modules\Language\App\Models\Language;
use Str;

class DocumentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $document_types = DocumentType::with('translate')->latest()->get();
        return view('admin.document_type.index', compact('document_types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.document_type.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:document_types,slug|max:255',
        ]);

        $document_type = new DocumentType();
        $document_type->slug = $request->slug;
        $document_type->status = $request->status ? 'enable' : 'disable';
        $document_type->save();

        // Create translations for all languages
        $languages = Language::all();
        foreach ($languages as $language) {
            $translation = new DocumentTypeTranslation();
            $translation->document_type_id = $document_type->id;
            $translation->lang_code = $language->lang_code;
            $translation->name = $request->name;
            $translation->save();
        }

        $notify_message = trans('translate.Created Successfully');
        $notify_message = ['message' => $notify_message, 'alert-type' => 'success'];
        return redirect()->route('admin.document-type.edit', ['document_type' => $document_type->id, 'lang_code' => admin_lang()])
            ->with($notify_message);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $document_type = DocumentType::findOrFail($id);
        $document_type_translate = DocumentTypeTranslation::where([
            'document_type_id' => $id,
            'lang_code' => $request->lang_code
        ])->first();

        $language_list = Language::all();

        return view('admin.document_type.edit', compact('document_type', 'document_type_translate', 'language_list'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $document_type = DocumentType::findOrFail($id);

        if ($request->lang_code == admin_lang()) {
            $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:document_types,slug,' . $id,
            ]);

            $document_type->slug = $request->slug;
            $document_type->status = $request->status ? 'enable' : 'disable';
            $document_type->save();
        }

        // Update translation
        $translation = DocumentTypeTranslation::where([
            'document_type_id' => $id,
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
        $document_type = DocumentType::findOrFail($id);
        $document_type->delete();

        $notify_message = trans('translate.Deleted Successfully');
        $notify_message = ['message' => $notify_message, 'alert-type' => 'success'];
        return redirect()->route('admin.document-type.index')->with($notify_message);
    }
}

