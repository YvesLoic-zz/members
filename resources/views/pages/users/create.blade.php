@extends('home')

@section('title', config('app.name') . ' - New user')

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

            @if (count($errors) > 0)
                @include('layouts.alerts._error')
            @endif

            {!! form($form) !!}
        </div>
    </div>
@endsection
