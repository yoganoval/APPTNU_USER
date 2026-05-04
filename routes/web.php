<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;

// 🔥 TAMBAHKAN INI (biar tidak error class not found)
use App\Http\Controllers\CertificateTemplateController;
use App\Http\Controllers\CertificateFieldController;
use App\Http\Controllers\CertificateController;

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| USER DOWNLOAD CERTIFICATE (PUBLIC / AUTH OPTIONAL)
|--------------------------------------------------------------------------
*/

Route::get('/certificate/{event}/download', [CertificateController::class, 'download'])
    ->name('certificate.download');

/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        /*
        |------------------------------------------
        | CERTIFICATE SYSTEM
        |------------------------------------------
        */

        // TEMPLATE
        Route::get('/certificate-templates', [CertificateTemplateController::class, 'index'])
            ->name('certificate.templates.index');

        Route::post('/certificate-templates', [CertificateTemplateController::class, 'store'])
            ->name('certificate.templates.store');

        Route::get('/certificate-templates/create', [CertificateTemplateController::class, 'create'])
            ->name('certificate.templates.create');
        Route::get('/certificate-templates/{id}', [CertificateTemplateController::class, 'show'])
            ->name('certificate.templates.show');

        // FIELD POSITION
        Route::post('/certificate-fields', [CertificateFieldController::class, 'store'])
            ->name('certificate.fields.store');

        // EDITOR (🔥 FIXED — NO DOUBLE /admin)
        Route::get('/certificate-editor/{id}', [CertificateTemplateController::class, 'show'])
            ->name('certificate.editor');

        Route::get('/certificates', [CertificateController::class, 'index'])
            ->name('certificates.index');


        // 🔹 FIELD (yang tadi kamu buat)
        Route::post('/certificate-fields', [CertificateFieldController::class, 'store'])
            ->middleware('permission:certificate.edit');

        // 🔹 GENERATE
        Route::get('/certificates', [CertificateController::class, 'index'])
            ->name('certificates.index')
            ->middleware('permission:certificate.generate');

        Route::get('/certificates/download/{event}', [CertificateController::class, 'download'])
            ->name('certificates.download')
            ->middleware('permission:certificate.generate');



        /*
        |------------------------------------------
        | RBAC (USER / ROLE / PERMISSION)
        |------------------------------------------
        */

        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);

});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';