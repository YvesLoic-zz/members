<span>
    <a class="btn btn-info" href="{{ route('user_edit', ['id' => $user->id]) }}">
        <i class="fa fa-pencil-square"></i>
    </a>
    <a class="btn btn-info" href="{{ route('user_show', ['id' => $user->id]) }}">
        <i class="fa fa-eye"></i>
    </a>
</span>
