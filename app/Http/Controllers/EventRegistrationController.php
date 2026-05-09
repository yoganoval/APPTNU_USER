<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // ← Tambahkan ini
use Carbon\Carbon; // ← Tambahkan ini jika menggunakan Carbon
use Inertia\Inertia;

class EventRegistrationController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $events = Event::latest()
            ->get()
            ->map(function ($event) use ($userId) {
                $registration = DB::table('event_user')
                    ->where('event_id', $event->id)
                    ->where('user_id', $userId)
                    ->first();

                $isRegistrationOpen = Carbon::parse($event->date)
                    ->startOfDay()
                    ->gte(now()->startOfDay());

                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'description' => $event->description,
                    'date' => $event->date,
                    'is_registered' => $registration !== null,
                    'attended' => $registration?->attended ?? 0,
                    'is_registration_open' => $isRegistrationOpen,
                ];
            });

        return Inertia::render('Event/PublicIndex', [
            'events' => $events,
        ]);
    }

    public function store(Event $event)
    {
        // Cek apakah tanggal event sudah lewat
        if (Carbon::parse($event->date)->startOfDay()->lt(now()->startOfDay())) {
            return back()->with('error', 'Pendaftaran event sudah ditutup.');
        }

        $userId = auth()->id();

        DB::table('event_user')->updateOrInsert(
            [
                'event_id' => $event->id,
                'user_id' => $userId,
            ],
            [
                'attended' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        return back()->with('success', 'Berhasil mendaftar event.');
    }
}