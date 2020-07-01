@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">@lang('Status of :game', ['game' => $game->name])</div>
        <div class="card-header">{{ $status->name }}</div>
        <div class="card-body">
            <form action="{{ route('statuses.update', ['game' => $game, 'level' => $level, 'status' => $status]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group row">
                    <label for="attempt" class="col-md-4 col-form-label text-md-right">{{ __('Attempt') }}</label>

                    <div class="col-md-6">
                        <input id="attempt" type="number" class="form-control @error('attempt') is-invalid @enderror" name="attempt" value="{{ old('attempt', $status->attempt) }}" required autocomplete="off" autofocus min="1">

                        @error('attempt')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">{{ __('Status') }}</label>

                    <div class="col-md-6">
                        <div class="btn-group btn-group-toggle @error('status') is-invalid @enderror" data-toggle="buttons">
                            @foreach ($options as $value => $label)
                                <label class="btn btn-{{ $value }} @if(old('status', $status->status) === $value) active @endif">
                                    <input type="radio" name="status" value="{{ $value }}" @if(old('status', $status->status) === $value) checked @endif> @lang($label)
                                </label>
                            @endforeach
                        </div>

                        @error('status')
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

                        <a class="btn btn-secondary" href="{{ route('statuses.show', ['game' => $game, 'level' => $level, 'status' => $status]) }}">@lang('Cancel')</a>

                        @if(!$status->activities_count)
                            <form class="form-inline" action="{{ route('statuses.destroy', ['game' => $game, 'level' => $level, 'status' => $status]) }}" method="POST">
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
