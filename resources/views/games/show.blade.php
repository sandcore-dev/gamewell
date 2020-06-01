@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            {{ $game->name }}
            <span class="duration">{{ $game->formattedDuration }}</span>
        </div>
        <div class="card-body">
            @foreach($game->levels as $level)
                <div class="game">
                    <div class="name">
                        <a href="#">{{ $level->name }}</a>
                    </div>
                    <div class="col"></div>
                    <div class="duration">{{ $level->formattedDuration }}</div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
