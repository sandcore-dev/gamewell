<?php

namespace App\Http\Controllers;

use App\Game;
use App\Level;
use App\Status;
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
     * @param  \Illuminate\Http\Request  $request
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
     * @param \App\Status $status
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
     * @param \App\Status $status
     * @return Renderable
     */
    public function edit(Game $game, Level $level, Status $status)
    {
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
     * @param \Illuminate\Http\Request $request
     * @param Game $game
     * @param Level $level
     * @param \App\Status $status
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
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function destroy(Status $status)
    {
        //
    }
}
