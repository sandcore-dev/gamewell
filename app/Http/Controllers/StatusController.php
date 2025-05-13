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
use Inertia\Inertia;
use Inertia\Response;

class StatusController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Game $game, Level $level)
    {
        return view('statuses.create')->with([
            'game' => $game,
            'level' => $level,
        ]);
    }

    public function store(Request $request, Game $game, Level $level)
    {
        $request->validate([
            'attempt' => ['required', 'numeric', 'min:1', Rule::unique('statuses', 'attempt')->where('level_id', $level->id)],
        ]);

        $status = $level->statuses()->create($request->only('attempt'));

        return redirect()->route('statuses.show', ['game' => $game, 'level' => $level, 'status' => $status]);
    }

    public function show(Game $game, Level $level, Status $status): Response
    {
        return Inertia::render('Status/Show', [
            'game' => $game->only(['name', 'slug']),
            'level' => $level->only(['id', 'name']),
            ...$status->only(['attempt', 'status']),
            'activities' => $status->activities()
                ->orderBy('started_at')
                ->orderBy('stopped_at')
                ->get(),
        ]);
    }

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

    public function update(Request $request, Game $game, Level $level, Status $status)
    {
        $request->validate([
            'attempt' => ['required', 'numeric', 'min:1', Rule::unique('statuses', 'attempt')->ignore($status->id)->where('level_id', $status->level_id)],
            'status' => ['required', 'string', 'in:ongoing,finished,dropped'],
        ]);

        $status->update($request->only('attempt', 'status'));

        return redirect()->route('statuses.show', ['game' => $game, 'level' => $level, 'status' => $status]);
    }

    public function destroy(Game $game, Level $level, Status $status)
    {
        $status->delete();

        return redirect()->route('levels.show', ['game' => $game, 'level' => $level]);
    }
}
