<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Game;
use App\Models\Level;
use App\Models\Status;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Inertia\Inertia;
use Inertia\Response;

class ActivityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Game $game, Level $level, Status $status): RedirectResponse
    {
        $activity = $status->activities()->create();

        return Redirect::action(
            [StatusController::class, 'show'],
            [
                'game' => $game,
                'level' => $level,
                'status' => $status,
            ]
        )->with('updated_activity_id', $activity->id);
    }

    public function edit(Game $game, Level $level, Status $status, Activity $activity): Response
    {
        return Inertia::render('Activity/Form', [
            'title-bar' => Lang::get('Activity of :game - :level - Attempt :attempt', [
                'game' => $game->name,
                'level' => $level->name,
                'attempt' => $status->attempt,
            ]),

            'url' => URL::action(
                [self::class, 'update'],
                [
                    'game' => $game,
                    'level' => $level,
                    'status' => $status,
                    'activity' => $activity,
                ]
            ),
            'cancelUrl' => URL::action(
                [StatusController::class, 'show'],
                [
                    'game' => $game,
                    'level' => $level,
                    'status' => $status,
                ]
            ),

            'started_at' => $activity->started_at->toDateTimeString(),
            'stopped_at' => $activity->stopped_at->toDateTimeString(),
        ]);
    }

    public function update(
        Request $request,
        Game $game,
        Level $level,
        Status $status,
        Activity $activity
    ): RedirectResponse {
        $validated = $request->validate(
            [
                'started_at' => [
                    'required',
                    'string',
                    'date_format:Y-m-d H:i:s',
                ],
                'stopped_at' => [
                    'required',
                    'string',
                    'date_format:Y-m-d H:i:s',
                ],
            ]
        );

        $activity->update($validated);

        return Redirect::action(
            [StatusController::class, 'show'],
            [
                'game' => $game,
                'level' => $level,
                'status' => $status,
            ]
        )->with('updated_activity_id', $activity->id);
    }

    public function stop(Game $game, Level $level, Status $status, Activity $activity, Carbon $now): RedirectResponse
    {
        if ($activity->stopped_at !== null) {
            return Redirect::back()
                ->with(
                    [
                        'alert' => Lang::get('This activity is already stopped.'),
                        'updated_activity_id' => $activity->id,
                    ]
                );
        }

        $activity->stopped_at = $now;
        $activity->save();

        return Redirect::back()
            ->with('updated_activity_id', $activity->id);
    }

    public function destroy(Game $game, Level $level, Status $status, Activity $activity): RedirectResponse
    {
        $activity->delete();

        return Redirect::action(
            [StatusController::class, 'show'],
            [
                'game' => $game,
                'level' => $level,
                'status' => $status,
            ]
        );
    }
}
