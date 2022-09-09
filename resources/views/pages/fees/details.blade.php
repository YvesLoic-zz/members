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
            <form action="{{ route('student_paid', ['id'=>$school->id]) }}" method="post">
                @csrf
                
            </form>
        </div>
    </div>
@endsection
