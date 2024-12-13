<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\WordController;
use App\Models\Answer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'login-register');

Route::middleware('auth')->group(function () {
    // Route::get('random', [WordController::class, 'random'])->name('random');
    // Route::get('random-words', [WordController::class, 'randomWords'])->name('random-words');

    Route::get('leitner', [WordController::class, 'leitner'])->name('leitner');
    Route::get('leitner-words', [WordController::class, 'leitnerWords'])->name('leitner-words');
    Route::get('increase-leitner-words', [WordController::class, 'oldLeitners'])->name('old-leitner-words');
    Route::get('newKnown', [WordController::class, 'newKnown'])->name('newKnown');
    Route::get('newLearned', [WordController::class, 'newLearned'])->name('newLearned');

    Route::get('learned', [WordController::class, 'learned'])->name('learned');
    Route::get('known', [WordController::class, 'known'])->name('known');
    Route::get('change-day/{user}', [WordController::class, 'changeDay'])->name('change-day');
});

Route::get('login-register', [UserController::class, 'loginRegisterForm'])->name('login-register-from');
Route::post('register', [UserController::class, 'registerRequest'])->name('register-request');
Route::post('login', [UserController::class, 'loginRequest'])->name('login-request');
Route::get('/login/{id}', function ($id) {
    Auth::loginUsingId($id);
    return redirect()->route('leitner');
});

Route::get('test', function () {
    $words = Answer::whereIn('value', [30, 16, 8, 4, 2])->with('word')->get();

    return response()->json($words, 200);

});

// Route::get('/test', function () {
//     $file = File::get(storage_path('app/words/data.json'));
//     $json = json_decode($file, JSON_UNESCAPED_UNICODE);

//     $json = collect($json)->slice(304);
//     foreach ($json as $item) {
//         $url = 'https://api.dictionaryapi.dev/api/v2/entries/en/' . $item['words'];

//         $audios = [];
//         try {
//             $response = Http::withHeaders(['content-type' => 'application/json'])
//                 ->get($url);

//             if ($response->successful()) {
//                 $responseData = $response->json();
//                 if (!empty($responseData)) {
//                     $data = $responseData[0];
//                     foreach ($data['phonetics'] as $phonetic) {
//                         $audios[] = $phonetic['audio'];
//                     }
//                 }
//             }

//         } catch (Exception $e) {
//             $audios = [];
//         }

//         Word::create([
//             'name' => $item['words'],
//             'source' => $item['source'],
//             'synonym' => $item['defination'],
//             'examples' => $item['exp'],
//             'audios' => $audios,
//         ]);
//     }
// });