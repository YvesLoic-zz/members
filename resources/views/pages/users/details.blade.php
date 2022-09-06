@extends('home')

@section('title', config('app.name') . ' - User details')

@section('center')
    <div class="card">
        <div class="card-header">
            {{ __('User informations') }}
            @if (!empty($user) && !empty($user->deleted_at))
                <span class="badge bg-warning float-end">
                    {{ __('Deleted User') }}
                </span>
            @endif
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 col-md-6 label">{{ __('Name') }}</div>
                <div class="col-lg-6 col-md-6">{{ $user->name }}</div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 label">{{ __('Email') }}</div>
                <div class="col-lg-6 col-md-6">{{ $user->email }}</div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 label">{{ __('Rule') }}</div>
                <div class="col-lg-6 col-md-6">{{ $user->rule }}</div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 label">{{ __('User status') }}</div>
                <div class="col-lg-6 col-md-6">
                    @if (!empty($user->deleted_at))
                        <span class="badge bg-danger">{{ __('User deleted at') }}
                            {{ $user->deleted_at->format('j F, Y H:i') }}</span>
                    @else
                        <span class="badge bg-success" style="color: white">{{ __('Activated') }}</span>
                    @endif
                </div>
            </div>
            @if (Auth::user()->rule == 'admin' && Auth::user()->id !== $user->id)
                <div class="row">
                    <div class="col-lg-6 col-md-6 label">{{ __('Delete this account?') }}</div>
                    <div class="col-lg-6 col-md-6">
                        <form action="{{ route('user_delete', ['id' => $user->id]) }}" method="DELETE">
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
