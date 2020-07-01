@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">@lang('New level of :game', ['game' => $game->name])</div>
        <div class="card-body">
            <form action="{{ route('levels.store', ['game' => $game]) }}" method="POST">
                @csrf

                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="off" autofocus>

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
                        <input id="order" type="number" class="form-control @error('order') is-invalid @enderror" name="order" value="{{ old('order') }}" required min="0" max="255">

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
                            {{ __('Add level') }}
                        </button>

                        <a class="btn btn-secondary" href="{{ route('games.show', ['game' => $game]) }}">@lang('Cancel')</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
