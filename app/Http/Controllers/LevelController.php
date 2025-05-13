<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Level;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class LevelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Game $game): Response
    {
        return Inertia::render('Level/Form', [
            'url' => URL::action([self::class, 'store'], $game),
            'title-bar' => Lang::get('New level of :game', ['game' => $game->name]),
            'button-label' => Lang::get('Add'),
            'game' => $game->slug,
        ]);
    }

    public function store(Request $request, Game $game): RedirectResponse
    {
        $validated = $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    Rule::unique('levels', 'name')
                        ->where('game_id', $game->id),
                ],
                'order' => [
                    'required',
                    'integer',
                    'min:0',
                    'max:255',
                ],
            ]
        );

        $level = $game->levels()->create($validated);

        return Redirect::action([self::class, 'show'], ['game' => $game, 'level' => $level]);
    }

    public function show(Game $game, Level $level): Response
    {
        return Inertia::render('Level/Show', [
            'game' => [
                'name' => $game->name,
                'slug' => $game->slug,
            ],
            'level' => $level->id,
            'name' => $level->name,
            'duration' => $level->duration,
            'statuses' => $level->statuses()
                ->select('id', 'attempt', 'status', 'duration')
                ->orderBy('id')
                ->get(),
        ]);
    }

    public function edit(Game $game, Level $level): Response
    {
        return Inertia::render('Level/Form', [
            'method' => 'put',
            'url' => URL::action([self::class, 'update'], [$game, $level]),
            'title-bar' => Lang::get(
                'Level of :game: :level',
                [
                    'game' => $game->name,
                    'level' => $level->name,
                ]
            ),
            'button-label' => Lang::get('Update'),
            'game' => $game->slug,
            ...$level->only(['name', 'order']),
        ]);
    }

    public function update(Request $request, Game $game, Level $level): RedirectResponse
    {
        $validated = $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    Rule::unique('levels', 'name')
                        ->ignore($level->id)
                        ->where('game_id', $level->game_id),
                ],
                'order' => [
                    'required',
                    'integer',
                    'min:0',
                    'max:255',
                ],
            ]
        );

        $level->update($validated);

        return Redirect::action([self::class, 'show'], ['game' => $game, 'level' => $level]);
    }

    public function destroy(Game $game, Level $level): RedirectResponse
    {
        $level->delete();

        return Redirect::action([GameController::class, 'show'], ['game' => $game]);
    }
}
