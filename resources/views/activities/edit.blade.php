@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">@lang('Activity of :game', ['game' => $game->name])</div>
        <div class="card-header">{{ $status->name }}</div>
        <div class="card-body">
            <form action="{{ route('activities.update', ['game' => $game, 'level' => $level, 'status' => $status, 'activity' => $activity]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group row">
                    <label for="started_at" class="col-md-4 col-form-label text-md-right">{{ __('Activity started at') }}</label>

                    <div class="col-md-6">
                        <input id="started_at" type="text" class="form-control @error('started_at') is-invalid @enderror" name="started_at" value="{{ old('started_at', $activity->started_at) }}" required autocomplete="off" autofocus maxlength="19">

                        @error('started_at')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="started_at" class="col-md-4 col-form-label text-md-right">{{ __('Activity stopped at') }}</label>

                    <div class="col-md-6">
                        <input id="stopped_at" type="text" class="form-control @error('stopped_at') is-invalid @enderror" name="stopped_at" value="{{ old('stopped_at', $activity->stopped_at) }}" required autocomplete="off" maxlength="19">

                        @error('stopped_at')
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

                        @if($activity->started_at->diffInHours() < 12)
                            <button form="delete_activity" class="btn btn-danger float-right" type="submit">@lang('Delete')</button>
                        @endif
                    </div>
                </div>
            </form>
            @if($activity->started_at->diffInHours() < 12)
                <form id="delete_activity" class="form-inline" action="{{ route('activities.destroy', ['game' => $game, 'level' => $level, 'status' => $status, 'activity' => $activity]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                </form>
            @endif
        </div>
    </div>
@endsection
