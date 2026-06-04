<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PublicEventController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('events.index'));

Route::get('/eventos', [PublicEventController::class, 'index'])->name('events.index');
Route::get('/eventos/{event:slug}', [PublicEventController::class, 'show'])->name('events.show');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        $user = auth()->user();
        return match($user->role) {
            'admin'     => redirect()->route('admin.dashboard'),
            'organizer' => redirect()->route('organizer.events.index'),
            default     => redirect()->route('attendee.registrations.index'),
        };
    })->name('dashboard');

    Route::middleware('role:attendee,admin,organizer')->prefix('mis-entradas')->name('attendee.registrations.')->group(function () {
        Route::get('/', [RegistrationController::class, 'index'])->name('index');
        Route::post('/', [RegistrationController::class, 'store'])->name('store');
        Route::patch('/{registration}/cancelar', [RegistrationController::class, 'cancel'])->name('cancel');
    });

    Route::middleware('role:organizer,admin')->prefix('organizador')->name('organizer.')->group(function () {
        Route::resource('events', EventController::class);
        Route::post('events/{event}/tickets', [TicketController::class, 'store'])->name('events.tickets.store');
        Route::delete('tickets/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy');
    });

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/categorias', [AdminController::class, 'categories'])->name('categories.index');
        Route::post('/categorias', [AdminController::class, 'storeCategory'])->name('categories.store');
        Route::delete('/categorias/{category}', [AdminController::class, 'destroyCategory'])->name('categories.destroy');
        Route::get('/usuarios', [AdminController::class, 'users'])->name('users.index');
        Route::patch('/usuarios/{user}/rol', [AdminController::class, 'updateRole'])->name('users.role');
        Route::get('/eventos', [AdminController::class, 'events'])->name('events.index');
        Route::patch('/eventos/{event}/toggle', [AdminController::class, 'toggleEvent'])->name('events.toggle');
    });
});

require __DIR__.'/auth.php';
