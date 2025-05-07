<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request): RedirectResponse
    {
        $date = Activity::user($request->user())
            ->latest()
            ->first()
            ->started_at
            ?? Carbon::now();

        return Redirect::action(
            [self::class, 'week'],
            ['year' => $date->isoWeekYear, 'week' => $date->isoWeek]
        );
    }

    public function week(Request $request, int $year, int $week): Response
    {
        $activitiesByDay = Activity::user($request->user())
            ->select(
                [
                    'id',
                    'status_id',
                    'started_at',
                    'stopped_at',
                ]
            )
            ->yearWeek($year, $week)
            ->with(
                [
                    'status:id,level_id,attempt,duration',
                    'status.level:id,game_id,name',
                    'status.level.game:id,name,slug',
                ]
            )
            ->get()
            ->append('formatted_duration')
            ->groupBy('formatted_date');

        $thisWeek = Carbon::now()
            ->isoWeekYear($year)
            ->isoWeek($week);

        $beforeActivity = Activity::user($request->user())
            ->where('started_at', '<', $thisWeek->startOfWeek())
            ->latest('started_at')
            ->first();
        $beforeYear = $beforeActivity?->started_at->isoWeekYear;
        $beforeWeek = $beforeActivity?->started_at->isoWeek;

        $afterActivity = Activity::user($request->user())
            ->where('started_at', '>', $thisWeek->endOfWeek())
            ->oldest('started_at')
            ->first();
        $afterYear = $afterActivity?->started_at->isoWeekYear;
        $afterWeek = $afterActivity?->started_at->isoWeek;

        return Inertia::render('Home', [
            'activitiesByDay' => $activitiesByDay,

            'before' => $beforeActivity
                ? [
                    'link' => URL::action([self::class, 'week'], ['year' => $beforeYear, 'week' => $beforeWeek]),
                    'text' => Lang::get('Week :week, :year', ['year' => $beforeYear, 'week' => $beforeWeek]),
                ]
                : null,

            'after' => $afterActivity
                ? [
                    'link' => URL::action([self::class, 'week'], ['year' => $afterYear, 'week' => $afterWeek]),
                    'text' => Lang::get('Week :week, :year', ['year' => $afterYear, 'week' => $afterWeek]),
                ]
                : null,
        ]);
    }
}
