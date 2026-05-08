<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\CertificateTemplateController;
use App\Http\Controllers\CertificateFieldController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\EventController;


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
| PUBLIC DOWNLOAD CERTIFICATE
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
        | CERTIFICATE TEMPLATE
        |------------------------------------------
        */

        Route::get('/certificate-templates', [CertificateTemplateController::class, 'index'])
            ->name('certificate.templates.index')
            ->middleware('permission:certificate.template.view');

        Route::get('/certificate-templates/create', [CertificateTemplateController::class, 'create'])
            ->name('certificate.templates.create')
            ->middleware('permission:certificate.template.create');

        Route::post('/certificate-templates', [CertificateTemplateController::class, 'store'])
            ->name('certificate.templates.store')
            ->middleware('permission:certificate.template.create');

        Route::get('/certificate-templates/{id}', [CertificateTemplateController::class, 'show'])
            ->name('certificate.templates.show')
            ->middleware('permission:certificate.template.view');
        // Route::get('/certificate-template/{id}/edit',[CertificateTemplateController::class, 'edit'])
        // ->name('certificate-template.edit');

        /*
        |------------------------------------------
        | CERTIFICATE EDITOR (Canvas)
        |------------------------------------------
        */

        Route::get('/certificate-editor/{id}', [CertificateTemplateController::class, 'show'])
            ->name('certificate.editor')
            ->middleware('permission:certificate.template.view');


        /*
        |------------------------------------------
        | CERTIFICATE FIELD (Drag Position)
        |------------------------------------------
        */

        Route::post('/certificate-fields', [CertificateFieldController::class, 'store'])
            ->name('certificate.fields.store')
            ->middleware('permission:certificate.edit');


        /*
        |------------------------------------------
        | CERTIFICATE GENERATE & DOWNLOAD
        |------------------------------------------
        */

        Route::get('/certificates', [CertificateController::class, 'index'])
            ->name('certificates.index')
            ->middleware('permission:certificate.generate');

        Route::get('/certificates/{id}', [CertificateController::class, 'show'])
            ->name('certificates.show')
            ->middleware('permissions:certivicate.index');


        Route::get('/certificates/download/{event}', [CertificateController::class, 'download'])
            ->name('certificates.download')
            ->middleware('permission:certificate.generate');

        Route::post('/events/{id}/generate-certificate', [CertificateController::class, 'generate'])
            ->name('certificates.generate')
            ->middleware('permission:certificate.generate');


            // Route::post('/events/{event}/generate-certificates',[CertificateController::class, 'generate']
            // )->name('admin.certificates.generate');
        /*
        |------------------------------------------
        | RBAC (USER / ROLE / PERMISSION)
        |------------------------------------------
        */

        Route::resource('users', UserController::class)
            ->middleware('permission:user.view');

        Route::resource('roles', RoleController::class)
            ->middleware('permission:role.view');

        Route::resource('permissions', PermissionController::class)
            ->middleware('permission:permission.view');



        Route::resource('events', EventController::class)
        ->middleware('permission:event.view');

});

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';