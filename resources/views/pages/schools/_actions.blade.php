<span>
    <a class="btn btn-info" href="{{ route('school_edit', ['id' => $school->id]) }}">
        <i class="fa fa-pencil-square"></i>
    </a>
    <a class="btn btn-info" href="{{ route('school_show', ['id' => $school->id]) }}">
        <i class="fa fa-eye"></i>
    </a>
    <a class="btn btn-info" href="{{ route('student_create', ['id' => $school->id]) }}">
        <i class="fa fa-user"></i>
    </a>
    <a class="btn btn-info" href="{{ route('student_index', ['id' => $school->id]) }}">
        <i class="fa fa-list"></i>
    </a>
</span>
