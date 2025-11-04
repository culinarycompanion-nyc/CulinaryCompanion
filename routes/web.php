<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\ContactFormController;
use App\Models\HomepageVisit;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $today = Carbon::today();

    $visit = HomepageVisit::firstOrCreate(
        ['visit_date' => $today],
        ['visit_count' => 0]
    );

    $visit->increment('visit_count');

    return view('home');
});

Route::get('/blogs', function () {
    return view('blogs');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/contact', [ContactFormController::class, 'contact']);
Route::post('/contact/submit', [ContactFormController::class, 'submit']);



Route::post('/selections', [AppController::class, 'selections']);

Route::get('/restaurants', [AppController::class, 'restaurants']);

Route::get('/restaurant/{restaurant}', [AppController::class, 'restaurant']);


Route::get('/redirect/{url}', [AppController::class, 'redirect'])->where('url', '.*');




Route::get('/password', function () {
    return view('site-password');
});

Route::post('/password', function (\Illuminate\Http\Request $request) {
    $correctPassword = 'F00dF0r3v3ry0n3!#?3@rly@cc3ss%&='; // Change this to your desired password

    if ($request->input('password') === $correctPassword) {
        $request->session()->put('site_access_granted', true);
        return redirect('/');
    }

    return back()->withErrors(['password' => 'Incorrect password']);
});



Route::get('/accept-terms', function () {
    return view('accept-terms');
});

Route::post('/accept-terms', function (\Illuminate\Http\Request $request) {
    $request->session()->put('terms_accepted', true);
    return redirect('/');
});
