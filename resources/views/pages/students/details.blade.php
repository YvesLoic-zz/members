@extends('home')

@section('title', config('app.name') . ' - Student details')

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
            <div class="row">
                <div class="col-lg-6 col-md-6 label">{{ __('Matricule') }}</div>
                <div class="col-lg-6 col-md-6">{{ $student->matricule }}</div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 label">{{ __('FirstaName') }}</div>
                <div class="col-lg-6 col-md-6">{{ $student->first_name }}</div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 label">{{ __('LastaName') }}</div>
                <div class="col-lg-6 col-md-6">{{ $student->last_name }}</div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 label">{{ __('Class') }}</div>
                <div class="col-lg-6 col-md-6">{{ $student->class }}</div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 label">{{ __('Birthday') }}</div>
                <div class="col-lg-6 col-md-6">{{ $student->birthday }}</div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 label">{{ __('Birthplace') }}</div>
                <div class="col-lg-6 col-md-6">{{ $student->birthplace }}</div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 label">{{ __('Sex') }}</div>
                <div class="col-lg-6 col-md-6">
                    @if ($student->sex == 'M')
                        {{ __('Male') }}
                    @else
                        {{ __('Female') }}
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 label">{{ __('School name') }}</div>
                <div class="col-lg-6 col-md-6">{{ $student->school->name }}</div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 label">{{ __('Student status') }}</div>
                <div class="col-lg-6 col-md-6">
                    @if (!empty($student->deleted_at))
                        <span class="badge bg-danger">{{ __('Student deleted at') }}
                            {{ $student->deleted_at->format('j F, Y H:i') }}</span>
                    @else
                        <span class="badge bg-success" style="color: white">{{ __('Available') }}</span>
                    @endif
                </div>
            </div>
            @if (Auth::user()->rule == 'admin' ||
                (Auth::user()->rule == 'director' && Auth::user()->id == $student->school->user_id))
                <div class="row">
                    <div class="col-lg-6 col-md-6 label">{{ __('Delete this student?') }}</div>
                    <div class="col-lg-6 col-md-6">
                        <form action="{{ route('student_delete', ['id' => $student->id]) }}" method="DELETE">
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
