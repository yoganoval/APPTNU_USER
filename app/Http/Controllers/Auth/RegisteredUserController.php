<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Anggota;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|unique:users',
            'password' => 'required|confirmed|min:6',
            'nama_perpustakaan' => 'required',
        ]);

        // simpan user
        $user = User::create([
            'name' => $request->nama_perpustakaan,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('anggota');

        // upload file
        $logo = null;
        $surat = null;

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo')->store('logo', 'public');
        }

        if ($request->hasFile('surat')) {
            $surat = $request->file('surat')->store('surat', 'public');
        }

        // simpan anggota
        Anggota::create([
            'user_id' => $user->id,
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
            'logo' => $logo,
            'surat' => $surat,
        ]);

        // dd('MASUK ANGGOTA');

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
