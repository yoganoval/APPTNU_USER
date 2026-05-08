<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Certificate;
use App\Models\CertificateTemplate;
use Inertia\Inertia;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = Certificate::with([
            'user',
            'event',
            'template'
            ])->latest()->get();
            
            // dd($certificates);
        return Inertia::render('Certificate/Index', [
            'certificates' => $certificates
        ]);
    }

    public function show($id)
    {
        $certificate = Certificate::with([
            'user',
            'event',
            'template.fields'
        ])->findOrFail($id);

        return Inertia::render('Certificate/Show', [
            'certificate' => $certificate
        ]);
    }

    // public function generate($eventId)
    // {
    //     $event = Event::with('users')->findOrFail($eventId);

    //     if ($event->users->isEmpty()) {
    //         return back()->with('error', 'Tidak ada peserta');
    //     }

    //     $template = CertificateTemplate::first();

    //     if (!$template) {
    //         return back()->with('error', 'Template belum tersedia');
    //     }

    //     foreach ($event->users as $user) {

    //         $exists = Certificate::where('user_id', $user->id)
    //             ->where('event_id', $event->id)
    //             ->exists();

    //         if ($exists) continue;

    //         Certificate::create([
    //             'user_id' => $user->id,
    //             'event_id' => $event->id,
    //             'certificate_template_id' => $template->id,
    //         ]);
    //     }

    //     return back()->with('success', 'Sertifikat berhasil digenerate');
    // }

    public function generate($eventId)
    {
        $event = Event::with('users')->findOrFail($eventId);

        if ($event->users->isEmpty()) {
            return back()->with(
                'error',
                'Tidak ada peserta'
            );
        }

        $template = CertificateTemplate::first();

        if (!$template) {
            return back()->with(
                'error',
                'Template belum tersedia'
            );
        }

        foreach ($event->users as $user) {

            $exists = Certificate::where(
                'user_id',
                $user->id
            )
            ->where('event_id', $event->id)
            ->exists();

            if ($exists) continue;

            Certificate::create([
                'user_id' => $user->id,

                'event_id' => $event->id,

                'certificate_template_id'
                    => $template->id,
            ]);
        }

        return back()->with(
            'success',
            'Sertifikat berhasil digenerate'
        );
    }
}