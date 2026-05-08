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
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'date' => 'required|date',
            'location' => 'required',
        ]);

        Event::create([
            'name' => $request->name,
            'description' => $request->description,
            'date' => $request->date,
            'location' => $request->location,
        ]);

        return redirect()
            ->route('events.index')
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
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'date' => 'required|date',
            'location' => 'required',
        ]);

        $event = Event::findOrFail($id);

        $event->update([
            'name' => $request->name,
            'description' => $request->description,
            'date' => $request->date,
            'location' => $request->location,
        ]);

        return redirect()
            ->route('events.index')
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
            ->route('events.index')
            ->with('success', 'Event berhasil dihapus');
    }
}