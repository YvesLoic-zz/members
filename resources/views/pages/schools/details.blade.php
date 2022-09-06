@extends('home')

@section('title', config('app.name') . ' - School details')

@section('center')
    <div class="card">
        <div class="card-header">
            {{ __('School informations') }}
            @if (!empty($school) && !empty($school->deleted_at))
                <span class="badge bg-warning float-end">
                    {{ __('Deleted School') }}
                </span>
            @endif
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 col-md-6 label">{{ __('Name') }}</div>
                <div class="col-lg-6 col-md-6">{{ $school->name }}</div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 label">{{ __('Contact') }}</div>
                <div class="col-lg-6 col-md-6">{{ $school->contact }}</div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 label">{{ __('Chef') }}</div>
                <div class="col-lg-6 col-md-6">{{ $school->user->name }}</div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 label">{{ __('Description') }}</div>
                <div class="col-lg-6 col-md-6">{{ $school->description }}</div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 label">{{ __('School status') }}</div>
                <div class="col-lg-6 col-md-6">
                    @if (!empty($user->deleted_at))
                        <span class="badge bg-danger">{{ __('School deleted at') }}
                            {{ $user->deleted_at->format('j F, Y H:i') }}</span>
                    @else
                        <span class="badge bg-success" style="color: white">{{ __('Available') }}</span>
                    @endif
                </div>
            </div>
            @if (Auth::user()->rule == 'admin')
                <div class="row">
                    <div class="col-lg-6 col-md-6 label">{{ __('Delete this school?') }}</div>
                    <div class="col-lg-6 col-md-6">
                        <form action="{{ route('school_delete', ['id' => $school->id]) }}" method="DELETE">
                            @csrf
                            <button class="btn btn-default float-end" type="submit">
                                <i class="bi bi-trash-fill" style="color: red;"></i>
                                <span style="color: red;">{{ __('Delete') }}</span>
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
