<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CompareController;
use App\Models\Products_category;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [MainController::class, 'index']);

Route::get('/contacts/', [PageController::class, 'contacts']);

Route::group(
    [
        'prefix' => 'catalog',
        'as' => 'catalog.',
        'namespace' => 'catalog',
    ],
    function () {
        Route::get('/search/', [CatalogController::class, 'search'])->name("Catalog.search");

        Route::get('/{slug}/', [CatalogController::class, 'category'])->name("Catalog.category");
        Route::get('/{slug}/{product}.html', [CatalogController::class, 'detail'])->name("Catalog.detail");
    }
);

Route::get('/compare/', [CompareController::class, 'index'])->name("Compare.index");

Route::group(
    [
        'prefix' => 'ajax',
        'as' => 'ajax.',
        'namespace' => 'ajax',
    ],
    function () {
        Route::get('/', [AjaxController::class, 'index'])->name("Ajax.index");

        Route::post('/catalog/', [AjaxController::class, 'catalog'])->name("Ajax.catalog");

        Route::post('/search/', [AjaxController::class, 'search'])->name("Ajax.search");
        Route::post('/search-load/', [AjaxController::class, 'searchLoad'])->name("Ajax.searchLoad");

        Route::post('/filter/', [AjaxController::class, 'filter'])->name("Ajax.filter");

        Route::post('/compare/toggle/', [AjaxController::class, 'compareToggle'])->name("Ajax.compareToggle");
        Route::post('/compare/clear/',  [AjaxController::class, 'compareClear'] )->name("Ajax.compareClear" );
    }
);



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
