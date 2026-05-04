<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'description',
        'date',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('attended');
    }
    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }


}