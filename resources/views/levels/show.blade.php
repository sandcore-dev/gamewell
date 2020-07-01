@extends('layouts.app')

@section('content')
    <nav class="nav">
        <div class="previous">
            <a href="{{ route('games.show', ['game' => $game]) }}">{{ $game->name }}</a>
        </div>
        <div class="next">
            <a href="{{ route('statuses.create', ['game' => $game, 'level' => $level]) }}">Add status</a>
        </div>
    </nav>
    <div class="card">
        <div class="card-header">
            <a href="{{ route('levels.edit', ['game' => $game, 'level' => $level]) }}">
                {{ $level->name }}
            </a>
            <span class="duration">{{ $level->formattedDuration }}</span>
        </div>
        <div class="card-body">

            @foreach($level->statuses as $status)
                <div class="game">
                    <div class="name">
                        <a href="{{ route('statuses.show', ['game' => $game, 'level' => $level, 'status' => $status]) }}">@lang('Attempt :attempt', ['attempt' => $status->attempt])</a>
                    </div>
                    <div class="status">{{ $status->status }}</div>
                    <div class="duration">{{ $status->formattedDuration }}</div>
                </div>
            @endforeach

        </div>
    </div>
@endsection
