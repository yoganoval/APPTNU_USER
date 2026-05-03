<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CertificateTemplate;

class CertificateTemplateController extends Controller
{
    // 📌 LIST TEMPLATE
    public function index()
    {
        return inertia('Admin/CertificateTemplates', [
            'templates' => \App\Models\CertificateTemplate::all()
        ]);
    }

    public function create()
    {
        return inertia('Admin/CertificateTemplates/Create');
    }

    // 📌 STORE TEMPLATE
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'background' => 'required|image'
        ]);

        $path = $request->file('background')->store('certificates', 'public');

        CertificateTemplate::create([
            'name' => $request->name,
            'background' => $path
        ]);

        return redirect()->route('admin.certificate.templates.index');
    }

    // 📌 SHOW TEMPLATE DETAIL
    public function show($id)
    {
        $template = \App\Models\CertificateTemplate::with('fields')->findOrFail($id);

        return inertia('Admin/CertificateEditor', [
            'template' => $template
        ]);
    }
}