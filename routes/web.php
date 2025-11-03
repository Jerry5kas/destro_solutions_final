<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

// Language switching route
Route::get('/locale/{locale}', function (string $locale) {
    $supported = ['en', 'de'];
    if (!in_array($locale, $supported, true)) {
        abort(404);
    }
    session(['app_locale' => $locale]);
    app()->setLocale($locale);
    return redirect()->back();
})->name('locale.switch');
