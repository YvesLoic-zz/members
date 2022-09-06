@extends('home')

@section('title', config('app.name') . ' - New student')

@section('center')
    <div class="card">
        <div class="card-header">
            {{ __('Student informations') }}
            @if (!empty($student) && !empty($student->deleted_at))
                <span class="badge bg-warning float-end">
                    {{ __('Deleted Student') }}
                </span>
            @endif
        </div>
        <div class="card-body">

            @if (count($errors) > 0)
                @include('layouts.alerts._error')
            @endif

            <form action="{{ route('student_bulkStore', ['id' => $school->id]) }}" method="post" enctype="multipart/form-data"
                id="form">
                @csrf
                <fieldset form="form">
                    <legend>{{ __('Upload students data') }}</legend>
                    <input type="file" name="studFile" id="studFile" accept=".xlsx, .xls, .csv">
                    <button type="submit" class="btn btn-primary" id="upload">{{ __('Upload') }}</button>
                    <button type="reset" class="btn btn-danger">{{ __('Reset') }}</button>
                </fieldset>
            </form>

            <hr size="15">
            <h3>{{ __('Create single student') }}</h3>

            {!! form($form) !!}

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#upload').attr('disabled', true);
            $('#studFile').on('change', function(params) {
                console.log('deux', params);
                $('#upload').attr('disabled', false);
            });
        });
    </script>
@endsection
