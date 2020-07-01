@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">{{ $game->name }}</div>
        <div class="card-body">
            <form action="{{ route('games.update', ['game' => $game]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $game->name) }}" required autocomplete="off" autofocus>

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="slug" class="col-md-4 col-form-label text-md-right">{{ __('Slug') }}</label>

                    <div class="col-md-6">
                        <input id="slug" type="text" class="form-control @error('slug') is-invalid @enderror" name="slug" value="{{ old('slug', $game->slug) }}" required autocomplete="off" autofocus>

                        @error('slug')
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

                        <a class="btn btn-secondary" href="{{ route('games.show', ['game' => $game]) }}">@lang('Cancel')</a>

                        @if(!$game->levels_count)
                            <form class="form-inline" action="{{ route('games.destroy', ['game' => $game]) }}" method="POST">
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
