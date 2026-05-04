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
        ]);

        $ids = [];

        foreach ($request->fields as $field) {

            // ❗ jangan skip field statis
            if (!isset($field['field_name']) && !isset($field['text'])) continue;

            // 🔥 UPDATE
            if (!empty($field['id'])) {

                $data = CertificateField::where('id', $field['id'])
                    ->where('certificate_template_id', $request->template_id)
                    ->first();

                if ($data) {
                    $data->update([
                        'field_name' => $field['field_name'] ?? null,
                        'text' => $field['text'] ?? null,
                        'x' => $field['x'] ?? 0,
                        'y' => $field['y'] ?? 0,
                        'font_size' => $field['fontSize'] ?? 24,
                        'font_color' => $field['fontColor'] ?? '#000000',
                        'font_weight' => $field['fontWeight'] ?? 'normal',
                    ]);
                } else {
                    $data = CertificateField::create([
                        'certificate_template_id' => $request->template_id,
                        'field_name' => $field['field_name'] ?? null,
                        'text' => $field['text'] ?? null,
                        'x' => $field['x'] ?? 0,
                        'y' => $field['y'] ?? 0,
                        'font_size' => $field['fontSize'] ?? 24,
                        'font_color' => $field['fontColor'] ?? '#000000',
                        'font_weight' => $field['fontWeight'] ?? 'normal',
                    ]);
                }

            } else {
                // 🔥 CREATE
                $data = CertificateField::create([
                    'certificate_template_id' => $request->template_id,
                    'field_name' => $field['field_name'] ?? null,
                    'text' => $field['text'] ?? null,
                    'x' => $field['x'] ?? 0,
                    'y' => $field['y'] ?? 0,
                    'font_size' => $field['fontSize'] ?? 24,
                    'font_color' => $field['fontColor'] ?? '#000000',
                    'font_weight' => $field['fontWeight'] ?? 'normal',
                ]);
            }

            $ids[] = $data->id;
        }

        // 🔥 HAPUS yang tidak ada di frontend
        CertificateField::where('certificate_template_id', $request->template_id)
            ->whereNotIn('id', $ids)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Field berhasil disimpan'
        ]);
    }
}