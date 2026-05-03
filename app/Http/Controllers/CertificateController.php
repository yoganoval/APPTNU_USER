<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Certificate;
use App\Models\CertificateTemplate;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificateController extends Controller
{
    // 📌 DOWNLOAD CERTIFICATE
    public function download($eventId)
    {
        $user = auth()->user();
        $event = Event::findOrFail($eventId);

        // cek peserta
        $isParticipant = $event->users()
            ->where('user_id', $user->id)
            ->wherePivot('attended', true)
            ->exists();

        if (!$isParticipant) {
            abort(403, 'Tidak berhak mendapatkan sertifikat');
        }

        // ambil template (sementara 1 template)
        $template = CertificateTemplate::with('fields')->first();

        if (!$template) {
            abort(404, 'Template tidak ditemukan');
        }

        $certificateNumber = 'CERT-' . $event->id . '-' . $user->id;

        // simpan record (opsional)
        Certificate::updateOrCreate(
            [
                'user_id' => $user->id,
                'event_id' => $event->id,
            ],
            [
                'certificate_number' => $certificateNumber,
                'issued_at' => now(),
            ]
        );

        $pdf = Pdf::loadView('certificates.dynamic', [
            'user' => $user,
            'event' => $event,
            'template' => $template,
            'number' => $certificateNumber
        ])->setPaper([0, 0, $template->width, $template->height]);

        return $pdf->download('certificate.pdf');
    }
}