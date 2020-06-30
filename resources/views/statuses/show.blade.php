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
                <div class="game @if($updated_activity_id === $activity->id) highlight @endif">
                    <div class="col-5">
                        <a href="{{ route('activities.edit', ['game' => $game, 'level' => $level, 'status' => $status, 'activity' => $activity]) }}">{{ $activity->formattedStartedAt }}</a>
                    </div>
                    <div class="col-5">
                        <a href="{{ route('activities.edit', ['game' => $game, 'level' => $level, 'status' => $status, 'activity' => $activity]) }}">{{ $activity->formattedStoppedAt }}</a>
                    </div>
                    <div class="col"></div>
                    <div class="duration">{{ $activity->formattedDuration }}</div>
                </div>
            @endforeach

        </div>
    </div>
@endsection
