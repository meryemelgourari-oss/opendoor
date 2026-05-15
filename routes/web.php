<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\AdmineController;
use App\Http\Controllers\RessourceController;
use App\Http\Controllers\ReclamationController;

/*
|--------------------------------------------------------------------------
| 1. Routes Publiques (Visiteurs)
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// Pages statiques
Route::view('/a-propos', 'about')->name('about');
Route::view('/services', 'services')->name('services');
Route::view('/mentions-legales', 'legal')->name('legal');
Route::view('/contact', 'contact')->name('contact');

// Annonces (Consultation)
Route::prefix('annonces')->name('properties.')->group(function () {
    Route::get('/', [PropertyController::class, 'index'])->name('index');
    Route::get('/autour-de-moi', [PropertyController::class, 'nearby'])->name('nearby');
    Route::get('/analyse-du-marche', [PropertyController::class, 'analytics'])->name('analytics');
    Route::get('/{property}', [PropertyController::class, 'show'])->name('show');
});

// Interactions Publiques
Route::post('/annonces/{property}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::post('/annonces/{property}/contact', [MessageController::class, 'store'])->name('messages.store');
Route::post('/testimonials', [TestimonialController::class, 'store'])->name('testimonials.store');

/*
|--------------------------------------------------------------------------
| 2. Routes Authentifiées (Utilisateurs connectés)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard & Messages
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
        Route::get('/mes-annonces', [DashboardController::class, 'myProperties'])->name('my-properties');
        Route::get('/commentaires', [CommentController::class, 'dashboardIndex'])->name('comments');
    });

    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');

    // Gestion des Annonces (CRUD)
    Route::resource('user/annonces', PropertyController::class)
        ->except(['index', 'show'])
        ->parameters(['annonces' => 'property'])
        ->names([
            'create'  => 'properties.create',
            'store'   => 'properties.store',
            'edit'    => 'properties.edit',
            'update'  => 'properties.update',
            'destroy' => 'properties.destroy',
        ]);

    Route::patch('/properties/{property}/status', [PropertyController::class, 'updateStatus'])->name('properties.update-status');
    Route::delete('/ressources/{id}', [RessourceController::class, 'destroy'])->name('ressources.destroy');

    // Commentaires
    Route::patch('/commentaires/{comment}/approve', [CommentController::class, 'approve'])->name('comments.approve');
    Route::delete('/commentaires/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Réclamations
    Route::get('/mes-reclamations', [DashboardController::class, 'myReclamations'])->name('reclamations.index');
    Route::get('/reclamations/nouvelle', [ReclamationController::class, 'create'])->name('reclamations.create');
    Route::post('/reclamations', [ReclamationController::class, 'store'])->name('reclamations.store');
    Route::delete('/reclamations/{reclamation}', [ReclamationController::class, 'destroy'])->name('reclamations.destroy');

    // Profil (Breeze)
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });
});

/*
|--------------------------------------------------------------------------
| 3. Routes Administrateur
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| 3. Routes Administrateur
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard principal
    Route::get('/', [AdmineController::class, 'index'])->name('dashboard');

    // Gestion des Utilisateurs
    Route::prefix('utilisateurs')->name('users.')->group(function () {
        Route::get('/', [AdmineController::class, 'index'])->name('index');
        Route::post('/', [AdmineController::class, 'storeUser'])->name('store');
        Route::put('/{user}', [AdmineController::class, 'updateUser'])->name('update');
        Route::delete('/{user}', [AdmineController::class, 'destroyUser'])->name('destroy');
        Route::patch('/{user}/toggle', [AdmineController::class, 'toggle'])->name('toggle');
    });

    // Gestion des Annonces (Modération et Edition Admin)
    Route::prefix('annonces')->name('properties.')->group(function () {
        Route::get('/', [AdmineController::class, 'index'])->name('index');
        Route::patch('/{property}/moderate', [AdmineController::class, 'moderate'])->name('moderate');
       // Creation d'une annonce via l'interface Admin
        Route::get('/creer', [AdmineController::class, 'createProperty'])->name('create');
        Route::post('/', [AdmineController::class, 'storeProperty'])->name('store');
        // Edition d'une annonce via l'interface Admin
        Route::get('/{property}/edit', [AdmineController::class, 'editProperty'])->name('edit');
        Route::put('/{property}', [AdmineController::class, 'updateProperty'])->name('update');
        
        Route::delete('/{property}', [AdmineController::class, 'destroyProperty'])->name('destroy');
    });

    // Témoignages & Réclamations
    Route::patch('/testimonials/{testimonial}', [TestimonialController::class, 'update'])->name('testimonials.update');
    Route::delete('/testimonials/{testimonial}', [TestimonialController::class, 'destroy'])->name('testimonials.destroy');
    Route::patch('/reclamations/{reclamation}', [ReclamationController::class, 'update'])->name('reclamations.update');

    // API Statistiques
    Route::get('/stats/views', [AdmineController::class, 'getViewsStats'])->name('stats.views');
});
require __DIR__ . '/auth.php';
