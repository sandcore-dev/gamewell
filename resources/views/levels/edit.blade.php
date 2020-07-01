@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">@lang('Level of :game', ['game' => $game->name])</div>
        <div class="card-header">{{ $level->name }}</div>
        <div class="card-body">
            <form action="{{ route('levels.update', ['game' => $game, 'level' => $level]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $level->name) }}" required autocomplete="off" autofocus>

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="order" class="col-md-4 col-form-label text-md-right">{{ __('order') }}</label>

                    <div class="col-md-6">
                        <input id="order" type="number" class="form-control @error('order') is-invalid @enderror" name="order" value="{{ old('order', $level->order) }}" required min="0" max="255">

                        @error('order')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Update') }}
                        </button>

                        <a class="btn btn-secondary" href="{{ route('levels.show', ['game' => $game, 'level' => $level]) }}">@lang('Cancel')</a>

                        @if(!$level->statuses_count)
                            <form class="form-inline" action="{{ route('levels.destroy', ['game' => $game, 'level' => $level]) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger float-right" type="submit">@lang('Delete')</button>
                            </form>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
