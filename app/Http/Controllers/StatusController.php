<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Level;
use App\Models\Status;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class StatusController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Game $game, Level $level): Response
    {
        return Inertia::render('Status/Form', [
            'url' => URL::action([self::class, 'store'], [$game, $level]),
            'title-bar' => Lang::get('New status of :game - :level', [
                'game' => $game->name,
                'level' => $game->level,
            ]),
            'game' => $game->only(['name', 'slug']),
            'level' => $level->only(['id', 'name']),
            'buttonLabel' => Lang::get('Add'),
        ]);
    }

    public function store(Request $request, Game $game, Level $level): RedirectResponse
    {
        $validated = $request->validate(
            [
                'attempt' => [
                    'required',
                    'integer',
                    'min:1',
                    Rule::unique('statuses', 'attempt')
                        ->where('level_id', $level->id),
                ],
            ]
        );

        $status = $level->statuses()->create($validated);

        return Redirect::action(
            [self::class, 'show'],
            [
                'game' => $game,
                'level' => $level,
                'status' => $status,
            ]
        );
    }

    public function show(Request $request, Game $game, Level $level, Status $status): Response
    {
        return Inertia::render('Status/Show', [
            'game' => $game->only(['name', 'slug']),
            'level' => $level->only(['id', 'name']),
            'status' => $status->only(['id', 'attempt', 'status']),

            'activities' => $activities = $status->activities()
                ->orderBy('started_at')
                ->orderBy('stopped_at')
                ->get(),

            'ongoing-activity-id' => $activities->whereNull('stopped_at')->first()?->id ?? 0,
            'updated-activity-id' => $request->session()->get('updated_activity_id', 0),
        ]);
    }

    public function edit(Game $game, Level $level, Status $status): Response
    {
        return Inertia::render('Status/Form', [
            'method' => 'put',
            'url' => URL::action([self::class, 'update'], [$game, $level, $status]),
            'title-bar' => Lang::get(':game - :level', [
                'game' => $game->name,
                'level' => $level->name,
            ]),
            'game' => $game->only(['name', 'slug']),
            'level' => $level->only(['id', 'name']),
            ...$status->only(['attempt', 'status']),
            'buttonLabel' => Lang::get('Update'),
        ]);
    }

    public function update(Request $request, Game $game, Level $level, Status $status): RedirectResponse
    {
        $validated = $request->validate(
            [
                'attempt' => [
                    'required',
                    'numeric',
                    'min:1',
                    Rule::unique('statuses', 'attempt')->ignore($status->id)->where(
                        'level_id',
                        $status->level_id
                    ),
                ],
                'status' => [
                    'required',
                    'string',
                    'in:ongoing,finished,dropped',
                ],
            ]
        );

        $status->update($validated);

        return Redirect::action(
            [self::class, 'show'],
            [
                'game' => $game,
                'level' => $level,
                'status' => $status,
            ]
        );
    }

    public function destroy(Game $game, Level $level, Status $status): RedirectResponse
    {
        $status->delete();

        return Redirect::action(
            [LevelController::class, 'show'],
            [
                'game' => $game,
                'level' => $level,
            ]
        );
    }
}
