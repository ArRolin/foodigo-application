<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    use HasFactory;

    protected $fillable = ['slug', 'status'];

    protected $appends = ['name'];

    protected $hidden = ['front_translate'];

    public function translate()
    {
        return $this->belongsTo(DocumentTypeTranslation::class, 'id', 'document_type_id')
                    ->where('lang_code', admin_lang());
    }

    public function front_translate()
    {
        return $this->belongsTo(DocumentTypeTranslation::class, 'id', 'document_type_id')
                    ->where('lang_code', front_lang());
    }

    public function getNameAttribute()
    {
        return $this->front_translate?->name;
    }

    public function translations()
    {
        return $this->hasMany(DocumentTypeTranslation::class, 'document_type_id');
    }
}

