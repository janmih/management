<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AutorisationAbsenceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MissionController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PersonnelController;
use App\Http\Controllers\CongeCumuleController;
use App\Http\Controllers\CongePriseController;
use App\Http\Controllers\ReposMedicalController;
use App\Http\Controllers\CotisationSocialController;
use App\Http\Controllers\DemandeArticleController;
use App\Http\Controllers\EtatStockController;
use App\Http\Controllers\ModelHasRoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SortieArticleController;
use App\Http\Controllers\StockServiceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::view('about', 'about')->name('about');

    Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');

    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::view('exportheader', 'exportheader')->name('exportheader');

    Route::group(['middleware' => ['can:services.manage']], function () {
        Route::resource('services', ServiceController::class)->except(['create', 'show']);
    });
    Route::group(['middleware' => ['can:personnels.manage']], function () {
        Route::resource('personnels', PersonnelController::class)->except(['create', 'show']);
        Route::resource('conge-cumules', CongeCumuleController::class)->except(['create', 'show']);
        Route::resource('repos-medicals', ReposMedicalController::class)->except(['create', 'show']);
        Route::resource('missions', MissionController::class)->except(['create', 'show']);
        Route::resource('cotisation-socials', CotisationSocialController::class)->except(['create', 'show', 'edit', 'store', 'update', 'destroy']);
        Route::post('cotisations/{cotisation}', [CotisationSocialController::class, 'payerCotisation']);
        // routes/web.php
        Route::resource('conge-prises', CongePriseController::class)->except(['create', 'show']);
        Route::get('/get-annee/{personnelId}', [CongePriseController::class, 'getYears']);
        Route::get('/get-conge-restants/{personnelId}/{annee}', [CongePriseController::class, 'getCongeRestante']);
        Route::resource('autorisation-absences', AutorisationAbsenceController::class)->except(['create', 'show']);
        Route::get('/get-autorisation-restants/{personnelId}/{annee}', [AutorisationAbsenceController::class, 'getAutorisationRestants']);
        Route::get('/valide-autorisation/{autirisationId}/{status}', [AutorisationAbsenceController::class, 'changerStatutAutorisation']);
        Route::resource('stock-services', StockServiceController::class)->except(['create', 'show']);
        Route::post('/stock-services/import', [StockServiceController::class, 'importFile'])->name('stock-services.import');
        Route::resource('/articles', ArticleController::class)->except(['create', 'show']);
        Route::post('/articles/import', [ArticleController::class, 'importArticle'])->name('article.import');
        Route::resource('/etat-stocks', EtatStockController::class)->only('index');
        Route::resource('/demande-articles', DemandeArticleController::class)->only('index');
        Route::get('/demande-articles/ajouter', [DemandeArticleController::class, 'ajouter']);
        Route::resource('/sortie-articles', SortieArticleController::class)->only('index');
        Route::get('/liste-bons', [DemandeArticleController::class, 'listeBons'])->name('liste-bons.index');
        Route::get('/liste-article-bons/{personnel_id}', [DemandeArticleController::class, 'listeArticleBons'])->name('liste-article-bons.index');
        Route::get('/demande-valide/{id}', [DemandeArticleController::class, 'valide'])->name('demande-valider.index');
        Route::get('/demande-refuse/{id}', [DemandeArticleController::class, 'refus'])->name('demande-refuser.index');
        Route::get('/notify', [DemandeArticleController::class, "notify"])->name('notify.index');
        Route::view('/mails', 'mails.index');
        Route::resource('/roles', RoleController::class)->only(['index', 'store']);
        Route::resource('/permissions', PermissionController::class)->only(['index', 'store']);
        Route::resource('/model-has-roles', ModelHasRoleController::class)->only(['index', 'store']);
    });
});
