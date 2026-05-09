<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EventController extends Controller
{
    /* =========================
       INDEX
    ========================= */
    public function index()
    {
        $events = Event::latest()->get();

        return Inertia::render('Event/Index', [
            'events' => $events
        ]);
    }

    /* =========================
       CREATE
    ========================= */
    public function create()
    {
        return Inertia::render('Event/Create');
    }

    /* =========================
       STORE
    ========================= */
    public function store(Request $request)
    {
        // Sesuaikan dengan field pada model:
        // protected $fillable = ['title', 'description', 'date'];

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
        ]);

        Event::create($validated);

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event berhasil dibuat');
    }

    /* =========================
       EDIT
    ========================= */
    public function edit($id)
    {
        $event = Event::findOrFail($id);

        return Inertia::render('Event/Edit', [
            'event' => $event
        ]);
    }

    /* =========================
       UPDATE
    ========================= */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
        ]);

        $event = Event::findOrFail($id);
        $event->update($validated);

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event berhasil diupdate');
    }

    /* =========================
       DELETE
    ========================= */
    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event berhasil dihapus');
    }
}