<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Certificate;
use App\Models\CertificateTemplate;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificateController extends Controller
{
    // 📄 LIST EVENT (halaman certificates)
    public function index()
    {
        $events = Event::all(); // bisa nanti difilter

        return inertia('Certificate/Index', [
            'events' => $events
        ]);
    }

    // 📥 DOWNLOAD CERTIFICATE
    public function download($eventId)
    {
        $user = auth()->user();
        $event = Event::findOrFail($eventId);

        // ✅ cek apakah user ikut & hadir
        $isParticipant = $event->users()
            ->where('user_id', $user->id)
            ->wherePivot('attended', true)
            ->exists();

        if (!$isParticipant) {
            abort(403, 'Tidak berhak mendapatkan sertifikat');
        }

        // ✅ ambil template + field
        $template = CertificateTemplate::with('fields')->first();

        if (!$template) {
            abort(404, 'Template tidak ditemukan');
        }

        // ✅ nomor sertifikat
        $certificateNumber = 'CERT-' . $event->id . '-' . $user->id;

        // ✅ simpan ke database
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

        // 🔥 DATA DINAMIS (INI YANG PENTING)
        $data = [
            'name'   => optional($user->anggota)->nama_perpustakaan ?? $user->email,
            'event'  => $event->title,
            'number' => $certificateNumber,
            'date'   => now()->format('d M Y'),
        ];

        // ✅ GENERATE PDF
        $pdf = Pdf::loadView('certificates.dynamic', [
            'template' => $template,
            'fields' => $template->fields,
            'data' => $data
        ])->setPaper([0, 0, $template->width, $template->height]);

        return $pdf->download('certificate.pdf');
    }
}