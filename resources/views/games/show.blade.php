@extends('layouts.app')

@section('content')
    <nav class="nav">
        <div class="col">
            <a href="{{ route('levels.create', ['game' => $game]) }}">@lang('Add level')</a>
        </div>
    </nav>
    <div class="card">
        <div class="card-header">
            <a href="{{ route('games.edit', ['game' => $game]) }}">
                {{ $game->name }}
            </a>
            <span class="duration">{{ $game->formattedDuration }}</span>
        </div>
        <div class="card-body">
            @foreach($game->levels as $level)
                <div class="game">
                    <div class="name">
                        <a href="{{ route('levels.show', ['game' => $game, 'level' => $level]) }}">{{ $level->name }}</a>
                    </div>
                    <div class="col"></div>
                    <div class="duration">{{ $level->formattedDuration }}</div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
