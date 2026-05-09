<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class EventAttendanceController extends Controller
{
    /**
     * Menampilkan halaman absensi peserta untuk suatu event.
     */
    public function edit(Event $event)
    {
        $participants = DB::table('event_user')
            ->join('users', 'event_user.user_id', '=', 'users.id')
            ->where('event_user.event_id', $event->id)
            ->select(
                'users.id',
                'users.name',
                'users.email',
                'event_user.attended'
            )
            ->orderBy('users.name')
            ->get();

        return Inertia::render('Event/Attendance', [
            'event' => [
                'id' => $event->id,
                'title' => $event->title,
                'date' => $event->date,
            ],
            'participants' => $participants,
        ]);
    }

    /**
     * Menyimpan status kehadiran peserta.
     */
    public function update(Request $request, Event $event)
    {
        $participantIds = $request->input('participants', []);

        // Reset semua peserta menjadi tidak hadir
        DB::table('event_user')
            ->where('event_id', $event->id)
            ->update([
                'attended' => 0,
                'updated_at' => now(),
            ]);

        // Set peserta yang dicentang menjadi hadir
        if (!empty($participantIds)) {
            DB::table('event_user')
                ->where('event_id', $event->id)
                ->whereIn('user_id', $participantIds)
                ->update([
                    'attended' => 1,
                    'updated_at' => now(),
                ]);
        }

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Absensi berhasil disimpan.');
    }
}