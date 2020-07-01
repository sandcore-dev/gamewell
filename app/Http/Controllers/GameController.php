<?php

namespace App\Http\Controllers;

use App\Game;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class GameController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index()
    {
        $groupedGames = Game::all()->groupBy(function (Game $game) {
            $firstLetter = substr($game->slug, 0, 1);
            return is_numeric($firstLetter) ? '#' : strtoupper($firstLetter);
        });

        return view('games.index')->with('groupedGames', $groupedGames);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Renderable
     */
    public function create()
    {
        return view('games.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $request->merge([
            'slug' => Str::slug($request->input('name')),
        ]);

        $request->validate([
            'name' => ['required', 'string', 'unique:games,name'],
            'slug' => ['required', 'string', 'unique:games,slug'],
        ]);

        $game = $request->user()->games()->create($request->only('name', 'slug'));

        return redirect()->route('games.show', ['game' => $game]);
    }

    /**
     * Display the specified resource.
     *
     * @param Game $game
     * @return Renderable
     */
    public function show(Game $game)
    {
        return view('games.show')->with('game', $game);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Game $game
     * @return Renderable
     */
    public function edit(Game $game)
    {
        $game->loadCount('levels');

        return view('games.edit')->with([
            'game' => $game,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Game $game
     * @return RedirectResponse
     */
    public function update(Request $request, Game $game)
    {
        $request->validate([
            'name' => ['required', 'string', Rule::unique('games', 'name')->ignoreModel($game)],
            'slug' => ['required', 'string', Rule::unique('games', 'slug')->ignoreModel($game)],
        ]);

        $game->update($request->only('name', 'slug'));

        return redirect()->route('games.show', ['game' => $game]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Game $game
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Game $game)
    {
        $game->delete();

        return redirect()->route('games.index');
    }
}
