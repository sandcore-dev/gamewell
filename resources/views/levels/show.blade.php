@extends('layouts.app')

@section('content')
    <nav class="nav">
        <div class="col">
            <a href="{{ route('games.show', ['game' => $game]) }}">{{ $game->name }}</a>
        </div>
    </nav>
    <div class="card">
        <div class="card-header">
            {{ $level->name }}
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
