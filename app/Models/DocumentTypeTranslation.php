<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentTypeTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['document_type_id', 'lang_code', 'name'];

    public function documentType()
    {
        return $this->belongsTo(DocumentType::class);
    }
}

