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

class ActivityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Game $game
     * @param Level $level
     * @param Status $status
     * @return RedirectResponse
     */
    public function store(Game $game, Level $level, Status $status)
    {
        $activity = $status->activities()->create();

        return redirect()
            ->route('statuses.show', ['game' => $game, 'level' => $level, 'status' => $status])
            ->with('updated_activity_id', $activity->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Game $game
     * @param Level $level
     * @param Status $status
     * @param Activity $activity
     * @return Renderable
     */
    public function edit(Game $game, Level $level, Status $status, Activity $activity): Renderable
    {
        return view('activities.edit')->with([
            'game' => $game,
            'level' => $level,
            'status' => $status,
            'activity' => $activity,
        ]);
    }

    /**
     * @param Game $game
     * @param Level $level
     * @param Status $status
     * @param Activity $activity
     * @param Carbon $now
     * @return RedirectResponse
     */
    public function stop(Game $game, Level $level, Status $status, Activity $activity, Carbon $now)
    {
        if ($activity->stopped_at !== null) {
            return redirect()
                ->back()
                ->with([
                    'alert' => __('This activity is already stopped.'),
                    'updated_activity_id' => $activity->id,
                ]);
        }

        $activity->stopped_at = $now;
        $activity->save();

        return redirect()
            ->back()
            ->with('updated_activity_id', $activity->id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Game $game
     * @param Level $level
     * @param Status $status
     * @param Activity $activity
     * @return RedirectResponse
     */
    public function update(Request $request, Game $game, Level $level, Status $status, Activity $activity)
    {
        $request->validate([
            'started_at' => ['required', 'string', 'date_format:Y-m-d H:i:s'],
            'stopped_at' => ['required', 'string', 'date_format:Y-m-d H:i:s'],
        ]);

        $activity->update($request->only('started_at', 'stopped_at'));

        return redirect()
            ->route('statuses.show', ['game' => $game, 'level' => $level, 'status' => $status])
            ->with('updated_activity_id', $activity->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Game $game
     * @param Level $level
     * @param Status $status
     * @param Activity $activity
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Game $game, Level $level, Status $status, Activity $activity)
    {
        $activity->delete();

        return redirect()->route('statuses.show', ['game' => $game, 'level' => $level, 'status' => $status]);
    }
}
