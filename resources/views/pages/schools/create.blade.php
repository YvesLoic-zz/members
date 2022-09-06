@extends('home')

@section('title', config('app.name') . ' - New school')

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

            @if (count($errors) > 0)
                @include('layouts.alerts._error')
            @endif

            {!! form($form) !!}
        </div>
    </div>
@endsection
