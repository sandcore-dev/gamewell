@extends('layouts.app')

@section('content')
    <nav class="nav">
        <div class="previous">
            <a href="{{ route('games.show', ['game' => $game]) }}">{{ $game->name }}</a>
        </div>
        @if ($status->is_ongoing)
            <div class="col">
                @unless($status->in_progress)
                    <form class="form-inline" action="{{ route('activities.store', ['game' => $game, 'level' => $level, 'status' => $status]) }}" method="post">
                        @csrf
                        <button class="btn start" type="submit">@lang('Start')</button>
                    </form>
                @else
                    <form class="form-inline" action="{{ route('activities.stop', ['game' => $game, 'level' => $level, 'status' => $status, 'activity' => $status->in_progress_activity]) }}" method="post">
                        @method('PUT')
                        @csrf
                        <button class="btn stop" type="submit">@lang('Stop')</button>
                    </form>
                @endunless
            </div>
        @endif
        <div class="next">
            <a href="{{ route('levels.show', ['game' => $game, 'level' => $level]) }}">{{ $level->name }}</a>
        </div>
    </nav>

    @if($alert)
        <div class="alert alert-warning">{{ $alert }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <a href="{{ route('statuses.edit', ['game' => $game, 'level' => $level, 'status' => $status]) }}">
                @lang('Attempt :attempt (:status)', ['attempt' => $status->attempt, 'status' => $status->status])
            </a>
            <span class="duration">{{ $status->formattedDuration }}</span>
        </div>
        <div class="card-body">

            @foreach($status->activities as $activity)
                <div class="activity @if($updated_activity_id === $activity->id) highlight @endif">
                    <div class="started-at">
                        <a href="{{ route('activities.edit', ['game' => $game, 'level' => $level, 'status' => $status, 'activity' => $activity]) }}">{{ $activity->formattedStartedAt }}</a>
                    </div>
                    <div class="stopped-at">
                        @if($activity->stopped_at)
                            <a href="{{ route('activities.edit', ['game' => $game, 'level' => $level, 'status' => $status, 'activity' => $activity]) }}">{{ $activity->formattedStoppedAt }}</a>
                        @else
                            <now format="{{ $activity->luxon_date_time_format }}"></now>
                        @endif
                    </div>
                    <div class="duration">
                        @if($activity->stopped_at)
                            {{ $activity->formattedDuration }}
                        @else
                            <duration start-time="{{ $activity->started_at }}"></duration>
                        @endif
                    </div>
                </div>
            @endforeach

        </div>
    </div>
@endsection
