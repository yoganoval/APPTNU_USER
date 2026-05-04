<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CertificateField extends Model
{
    protected $fillable = [
        'certificate_template_id',
        'field_name',
        'text', // ✅ WAJIB
        'x',
        'y',
        'font_size',
        'font_color',
        'font_weight',
    ];

    public function template()
    {
        return $this->belongsTo(CertificateTemplate::class, 'certificate_template_id');
    }
}