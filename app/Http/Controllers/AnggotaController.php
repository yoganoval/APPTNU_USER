<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AnggotaController extends Controller
{
    public function index()
    {
        $anggota = Anggota::latest()->get();

        return Inertia::render('Anggota/Index', [
            'anggota' => $anggota
        ]);
    }

    public function create()
    {
        return Inertia::render('Anggota/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'wilayah' => 'required',
            'jenis_perpustakaan' => 'required',
            'nama_perpustakaan' => 'required',
            'alamat' => 'required',
        ]);

        Anggota::create([
            'user_id' => auth()->id(),
            'wilayah' => $request->wilayah,
            'jenis_perpustakaan' => $request->jenis_perpustakaan,
            'id_anggota' => $request->id_anggota,
            'nama_perguruan_tinggi' => $request->nama_perguruan_tinggi,
            'nama_perpustakaan' => $request->nama_perpustakaan,
            'alamat' => $request->alamat,
            'email_perpustakaan' => $request->email_perpustakaan,
            'telp' => $request->telp,
            'fax' => $request->fax,
            'nama_kepala' => $request->nama_kepala,
            'email_kepala' => $request->email_kepala,
            'wa_kepala' => $request->wa_kepala,
            'nama_pic' => $request->nama_pic,
            'wa_pic' => $request->wa_pic,
            'website' => $request->website,
            'repository' => $request->repository,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'instagram' => $request->instagram,
            'blog' => $request->blog,
        ]);

        return redirect()->route('anggota.index');
    }

    public function edit(Anggota $anggota)
    {
        return Inertia::render('Anggota/Edit', [
            'anggota' => $anggota
        ]);
    }

    public function update(Request $request, Anggota $anggota)
    {
        $anggota->update($request->all());

        return redirect()->route('anggota.index');
    }

    public function destroy(Anggota $anggota)
    {
        $anggota->delete();

        return back();
    }
}