<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CertificateTemplate extends Model
{
    protected $fillable = [
        'name',
        'background_image',
        'width',
        'height',
    ];

    public function fields()
    {
        return $this->hasMany(CertificateField::class);
    }
}