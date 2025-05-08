<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class GameController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): Response
    {
        return Inertia::render('Game/Index', [
            'gamesByFirstLetter' => Game::query()
                ->select(
                    [
                        'id',
                        'name',
                        'slug',
                        'duration',
                    ]
                )
                ->get()
                ->groupBy('first_letter'),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Game/Form', [
            'url' => URL::action([self::class, 'store']),
            'title-bar' => Lang::get('Add game'),
            'button-label' => Lang::get('Add'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->merge(
            [
                'slug' => Str::slug($request->input('name')),
            ]
        );

        $validated = $request->validate(
            [
                'name' => ['required', 'string', Rule::unique('games', 'name')],
                'slug' => ['required', 'string', Rule::unique('games', 'slug')],
            ]
        );

        $game = $request->user()
            ->games()
            ->create($validated);

        return Redirect::action([self::class, 'show'], ['game' => $game]);
    }

    public function show(Game $game): Response
    {
        return Inertia::render('Game/Show', [
            'title' => $game->name,
            'slug' => $game->slug,
            'duration' => $game->duration,
            'levels' => $game->levels()
                ->select(
                    [
                        'id',
                        'game_id',
                        'name',
                        'duration',
                    ]
                )
                ->with('game:id,slug')
                ->orderBy('order')
                ->get(),
        ]);
    }

    public function edit(Game $game): Response
    {
        return Inertia::render('Game/Form', [
            'method' => 'put',
            'url' => URL::action([self::class, 'update'], $game),
            'title-bar' => $game->name,
            'button-label' => Lang::get('Update'),
            'name' => $game->name,
            'slug' => $game->slug,
        ]);
    }

    public function update(Request $request, Game $game): RedirectResponse
    {
        $validated = $request->validate(
            [
                'name' => ['required', 'string', Rule::unique('games', 'name')->ignoreModel($game)],
                'slug' => ['required', 'string', Rule::unique('games', 'slug')->ignoreModel($game)],
            ]
        );

        $game->update($validated);

        return Redirect::action([self::class, 'show'], ['game' => $game]);
    }

    public function destroy(Game $game): RedirectResponse
    {
        $game->delete();

        return Redirect::action([self::class, 'index']);
    }
}
