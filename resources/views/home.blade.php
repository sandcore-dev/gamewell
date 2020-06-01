@extends('layouts.app')

@section('content')
            <nav class="nav">
                @if($beforeYear && $beforeWeek)
                    <div class="previous">
                        <a href="{{ route('week', ['year' => $beforeYear, 'week' => $beforeWeek]) }}">&laquo; @lang('Week :week, :year', ['year' => $beforeYear, 'week' => $beforeWeek])</a>
                    </div>
                @endif
                @if($afterYear && $afterWeek)
                    <div class="next">
                        <a href="{{ route('week', ['year' => $afterYear, 'week' => $afterWeek]) }}">@lang('Week :week, :year', ['year' => $afterYear, 'week' => $afterWeek]) &raquo;</a>
                    </div>
                @endif
            </nav>

            @foreach($groupedActivities as $date => $activities)
                <div class="card">
                    <div class="card-header">{{ $date }}</div>
                    <div class="card-body">
                        @foreach($activities as $activity)
                            <div class="activity">
                                <div class="col-auto p-0 pr-1 game-name">
                                    <a href="#">{{ $activity->status->level->game->name }}</a>
                                </div>
                                <div class="status">{{ $activity->status->name }}</div>
                                <div class="col-auto p-0 duration">{{ $activity->formattedDuration }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
@endsection
