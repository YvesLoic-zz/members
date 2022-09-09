@extends('home')

@section('title', config('app.name') . ' - New paiement')

@section('center')
    <div class="card">
        <div class="card-body">

            @include('layouts.alerts._error')

            <h3>{{ __('Create paiement for') }} {{ $student->first_name }} {{ $student->last_name }}</h3>

            {!! form($form) !!}

        </div>
    </div>
@endsection
