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
                            <div class="game">
                                <div class="name">
                                    <a href="{{ route('statuses.show', ['game' => $activity->status->level->game, 'level' => $activity->status->level, 'status' => $activity->status]) }}">{{ $activity->status->level->game->name }}</a>
                                </div>
                                <div class="status">{{ $activity->status->name }}</div>
                                <div class="duration">{{ $activity->formattedDuration }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
@endsection
