<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable|\Illuminate\Http\RedirectResponse
     */
    public function index(Request $request)
    {
        try {
            $date = Activity::user($request->user())->orderBy('started_at', 'desc')->firstOrFail()->started_at;
        } catch (ModelNotFoundException $e) {
            $date = Carbon::now();
        }

        return redirect()->route('week', ['year' => $date->isoWeekYear, 'week' => $date->isoWeek]);
    }

    /**
     * @param Request $request
     * @param int $year
     * @param int $week
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function week(Request $request, int $year, int $week)
    {
        $groupedActivities = Activity::with('status.level.game')->user($request->user())->yearWeek($year, $week)->get()->groupBy('formatted_date');

        $thisWeek = Carbon::now()->isoWeekYear($year)->isoWeek($week);

        try {
            $beforeActivity = Activity::user($request->user())->where('started_at', '<', $thisWeek->startOfWeek())->latest('started_at')->firstOrFail();
            $beforeYear = $beforeActivity->started_at->isoWeekYear;
            $beforeWeek = $beforeActivity->started_at->isoWeek;
        } catch(ModelNotFoundException $e) {
            $beforeYear = null;
            $beforeWeek = null;
        }

        try {
            $afterActivity = Activity::user($request->user())->where('started_at', '>', $thisWeek->endOfWeek())->oldest('started_at')->firstOrFail();
            $afterYear = $afterActivity->started_at->isoWeekYear;
            $afterWeek = $afterActivity->started_at->isoWeek;
        } catch (ModelNotFoundException $e) {
            $afterYear = null;
            $afterWeek = null;
        }

//        dd($afterYear);

        return view('home')->with([
            'groupedActivities' => $groupedActivities,
            'beforeYear' => $beforeYear,
            'beforeWeek' => $beforeWeek,
            'afterYear' => $afterYear,
            'afterWeek' => $afterWeek,
        ]);
    }
}
