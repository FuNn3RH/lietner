<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\User;
use App\Models\Word;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WordController extends Controller {
    public function random() {
        return view('words.random');
    }

    public function randomWords(Word $word) {
        $words = $word->with(['answers' => function ($query) {
            $query->with('user')
                ->where('user_id', Auth::user()->id);

        }])->inRandomOrder()
            ->take(20)->get();

        return response()->json($words, 200);
    }

    public function learned(Request $request, Answer $answer) {
        if (!isset($request->word_id) && empty($request->word_id)) {
            return response()->json("Not Found", 404);
        }

        $request->validate([
            'word_id' => ['numeric'],
        ]);

        $newAnswer = $answer->where('word_id', $request->word_id)
            ->where('user_id', Auth::user()->id)
            ->first();

        $newValue = 0;
        if (!$newAnswer) {

            $answer->create([
                'user_id' => Auth::user()->id,
                'word_id' => $request->word_id,
                'value' => -1,
            ]);

            $newValue = -1;
        } else {
            if ($newAnswer->value >= 0) {
                $newAnswer->update([
                    'value' => -1,
                ]);
                $newValue = -1;
            } else {
                $newAnswer->update([
                    'value' => $newAnswer->value - 1,
                ]);
                $newValue = $newAnswer->value;
            }

        }

        return response()->json(['New Value is ' . $newValue], 200);
    }

    public function known(Request $request, Answer $answer) {
        if (!isset($request->word_id) && empty($request->word_id)) {
            return response()->json("Not Found", 404);
        }

        $request->validate([
            'word_id' => ['numeric'],
        ]);

        $newAnswer = $answer->where('word_id', $request->word_id)
            ->where('user_id', Auth::user()->id)
            ->first();

        $newValue = 0;
        if (!$newAnswer) {

            $answer->create([
                'user_id' => Auth::user()->id,
                'word_id' => $request->word_id,
                'value' => 1,
            ]);

            $newValue = 1;
        } else {

            if ($newAnswer->value <= 0) {

                $newAnswer->update([
                    'value' => 1,
                ]);
                $newValue = 1;
            } else {

                $newAnswer->update([
                    'value' => $newAnswer->value + 1,
                ]);

                $newValue = $newAnswer->value;

            }

        }

        return response()->json(['New Value is ' . $newValue], 200);

    }

    public function leitner() {
        $incTime = Carbon::parse(Auth::user()->last_inc)->format('Y-m-d');
        $today = Carbon::parse(Carbon::now()->subDay())->format('Y-m-d');

        return view('words.leitner', compact('incTime', 'today'));
    }

    public function leitnerWords(Word $word, Answer $answer) {

        $user = User::find(Auth::user()->id);

        if (!$user->last_inc) {
            $user->last_inc = Carbon::now();
            $user->save();
        }

        $words = $word->whereHas('answers', function ($query) {
            $query->where('value', -1)
                ->where('user_id', Auth::user()->id);
        })->with(['answers' => function ($query) {
            $query->where('value', -1)
                ->where('user_id', Auth::user()->id);
        }])->get();

        if (count($words) < 10) {
            $newWords = $word->whereDoesntHave('answers', function ($query) {
                $query->where('user_id', Auth::id());
            })->limit(5)
                ->get();
        }

        $words = array_merge($words->toArray(), $newWords->toArray());

        return response()->json($words, 200);
    }

    public function newKnown(Request $request, Answer $answer) {
        if (!isset($request->word_id) && empty($request->word_id)) {
            return response()->json("Not Found", 404);
        }

        $request->validate([
            'word_id' => ['numeric'],
        ]);

        $newAnswer = $answer->where('word_id', $request->word_id)
            ->where('user_id', Auth::user()->id)
            ->first();

        $value = 0;
        if ($newAnswer) {

            $newAnswer->update([
                'value' => 1,
            ]);

            $value = 1;
        } else {
            $answer->create([
                'word_id' => $request->word_id,
                'user_id' => Auth::user()->id,
                'value' => 100,
            ]);

            $value = 100;
        }

        return response()->json("will update to $value", 200);

    }

    public function newLearned(Request $request, Answer $answer) {
        if (!isset($request->word_id) && empty($request->word_id)) {
            return response()->json("Not Found", 404);
        }

        $request->validate([
            'word_id' => ['numeric'],
        ]);

        $answer->updateOrCreate([
            'user_id' => Auth::user()->id,
            'word_id' => $request->word_id,
        ], [
            'value' => 1,
        ]);

        return response()->json("will update to 1", 200);

    }

    public function oldLeitners() {
        $incTime = Carbon::parse(Auth::user()->last_inc)->format('Y-m-d');
        $today = Carbon::parse(Carbon::now()->subDay())->format('Y-m-d');

        if ($incTime < $today || Auth::user()->last_inc == null) {
            Answer::where('user_id', Auth::user()->id)
                ->where('value', '>', 0)
                ->increment('value', 1);

            $user = User::find(Auth::user()->id);
            $user->last_inc = Carbon::now();
            $user->save();

        }

        $words = Answer::whereIn('value', [30, 16, 8, 4, 2])->with('word')->get();
        if (!$words->isEmpty()) {
            return response()->json($words, 200);
        }

        return response()->json(status: 404);
    }

}
