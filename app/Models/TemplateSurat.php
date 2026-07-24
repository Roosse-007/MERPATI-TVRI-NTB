<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TemplateSurat extends Model
{
    protected $table = 'template_surat';
protected $fillable = [

    'nama_template',

    'file_docx',

    'file_pdf',

    'file_template',

    'keterangan',

    'is_active',

];

    public function surat(): HasMany
    {
        return $this->hasMany(Surat::class);
    }
}