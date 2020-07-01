@extends('layouts.app')

@section('content')
    <nav class="nav">
        <div class="col">
            <a href="{{ route('games.create') }}">@lang('Add game')</a>
        </div>
    </nav>

    @foreach($groupedGames as $group => $games)
        <div class="card">
            <div class="card-header">{{ $group }}</div>
            <div class="card-body">
                @foreach($games as $game)
                    <div class="game">
                        <div class="name">
                            <a href="{{ route('games.show', ['game' => $game]) }}">{{ $game->name }}</a>
                        </div>
                        <div class="col"></div>
                        <div class="duration">{{ $game->formattedDuration }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
@endsection
