<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CertificateField;

class CertificateFieldController extends Controller
{
    // 📌 SAVE FIELD POSITIONS
    public function store(Request $request)
    {
        \App\Models\CertificateField::updateOrCreate(
            [
                'certificate_template_id' => $request->certificate_template_id,
                'field_name' => $request->field_name,
            ],
            [
                'x' => $request->x,
                'y' => $request->y,
                'font_size' => $request->font_size,
            ]
        );

        return response()->json(['success' => true]);
    }
}