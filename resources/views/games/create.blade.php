@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">@lang('Add game')</div>
        <div class="card-body">
            <form action="{{ route('games.store') }}" method="POST">
                @csrf

                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror @error('slug') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="off" autofocus>

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

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
                            {{ __('Add') }}
                        </button>

                        <a class="btn btn-secondary" href="{{ route('games.index') }}">@lang('Cancel')</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
