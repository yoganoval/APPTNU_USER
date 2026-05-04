<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CertificateField;

class CertificateFieldController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'template_id' => 'required|exists:certificate_templates,id',
            'fields' => 'required|array',
            'fields.*.field_name' => 'nullable|in:nama,event,tanggal,nomor',
        ]);

        $ids = [];

        foreach ($request->fields as $field) {

            $data = CertificateField::updateOrCreate(
                [
                    'id' => $field['id'] ?? null
                ],
                [
                    'certificate_template_id' => $request->template_id,
                    'field_name' => $field['field_name'] ?? null,
                    'text' => $field['text'] ?? null,
                    'type' => isset($field['field_name']) ? 'dynamic' : 'static',
                    'x' => $field['x'] ?? 0,
                    'y' => $field['y'] ?? 0,
                    'font_size' => $field['fontSize'] ?? 24,
                    'font_color' => $field['fontColor'] ?? '#000000',
                    'font_weight' => $field['fontWeight'] ?? 'normal',
                ]
            );

            $ids[] = $data->id;
        }

        // hapus field yang tidak ada lagi
        CertificateField::where('certificate_template_id', $request->template_id)
            ->whereNotIn('id', $ids)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Field berhasil disimpan'
        ]);
    }
}