<?php

namespace App\Http\Controllers;

use App\Game;
use App\Level;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LevelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Game $game
     * @param Level $level
     * @return Renderable
     */
    public function show(Game $game, Level $level)
    {
        return view('levels.show')->with([
            'game' => $game,
            'level' => $level,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Game $game
     * @param Level $level
     * @return Renderable
     */
    public function edit(Game $game, Level $level)
    {
        return view('levels.edit')->with([
            'game' => $game,
            'level' => $level,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Game $game
     * @param Level $level
     * @return RedirectResponse
     */
    public function update(Request $request, Game $game, Level $level)
    {
        $request->validate([
            'name' => ['required', 'string', Rule::unique('levels', 'name')->ignore($level->id)->where('game_id', $level->game_id)],
            'order' => ['required', 'numeric', 'min:0', 'max:255'],
        ]);

        $level->update($request->only('name', 'order'));

        return redirect()->route('levels.show', ['game' => $game, 'level' => $level]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Level $level
     * @return \Illuminate\Http\Response
     */
    public function destroy(Level $level)
    {
        //
    }
}
