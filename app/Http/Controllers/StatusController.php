<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Level;
use App\Models\Status;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StatusController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Game $game
     * @param Level $level
     * @return Renderable
     */
    public function create(Game $game, Level $level)
    {
        return view('statuses.create')->with([
            'game' => $game,
            'level' => $level,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Game $game
     * @param Level $level
     * @return RedirectResponse
     */
    public function store(Request $request, Game $game, Level $level)
    {
        $request->validate([
            'attempt' => ['required', 'numeric', 'min:1', Rule::unique('statuses', 'attempt')->where('level_id', $level->id)],
        ]);

        $status = $level->statuses()->create($request->only('attempt'));

        return redirect()->route('statuses.show', ['game' => $game, 'level' => $level, 'status' => $status]);
    }

    /**
     * Display the specified resource.
     *
     * @param Game $game
     * @param Level $level
     * @param Status $status
     * @return Renderable
     */
    public function show(Game $game, Level $level, Status $status)
    {
        return view('statuses.show')->with([
            'game' => $game,
            'level' => $level,
            'status' => $status,
            'updated_activity_id' => session('updated_activity_id'),
            'alert' => session('alert'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Game $game
     * @param Level $level
     * @param Status $status
     * @return Renderable
     */
    public function edit(Game $game, Level $level, Status $status)
    {
        $status->loadCount('activities');

        return view('statuses.edit')->with([
            'game' => $game,
            'level' => $level,
            'status' => $status,
            'options' => [
                'ongoing' => 'Ongoing',
                'finished' => 'Finished',
                'dropped' => 'Dropped',
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Game $game
     * @param Level $level
     * @param Status $status
     * @return RedirectResponse
     */
    public function update(Request $request, Game $game, Level $level, Status $status)
    {
        $request->validate([
            'attempt' => ['required', 'numeric', 'min:1', Rule::unique('statuses', 'attempt')->ignore($status->id)->where('level_id', $status->level_id)],
            'status' => ['required', 'string', 'in:ongoing,finished,dropped'],
        ]);

        $status->update($request->only('attempt', 'status'));

        return redirect()->route('statuses.show', ['game' => $game, 'level' => $level, 'status' => $status]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Game $game
     * @param Level $level
     * @param Status $status
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Game $game, Level $level, Status $status)
    {
        $status->delete();

        return redirect()->route('levels.show', ['game' => $game, 'level' => $level]);
    }
}
