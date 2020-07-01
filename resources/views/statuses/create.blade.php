@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">@lang('New status of :game', ['game' => $game->name])</div>
        <div class="card-header">{{ $level->name }}</div>
        <div class="card-body">
            <form action="{{ route('statuses.store', ['game' => $game, 'level' => $level]) }}" method="POST">
                @csrf

                <div class="form-group row">
                    <label for="attempt" class="col-md-4 col-form-label text-md-right">{{ __('Attempt') }}</label>

                    <div class="col-md-6">
                        <input id="attempt" type="number" class="form-control @error('attempt') is-invalid @enderror" name="attempt" value="{{ old('attempt') }}" required autocomplete="off" autofocus min="1">

                        @error('attempt')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Add status') }}
                        </button>

                        <a class="btn btn-secondary" href="{{ route('levels.show', ['game' => $game, 'level' => $level]) }}">@lang('Cancel')</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
