@extends('home')

@section('title', config('app.name') . ' - Users')

@section('styles')
    <link href="cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link href="{{ asset('assets/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('center')
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>{{ __('Users list') }} </h3>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row" style="display: block;">

            <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                    <a href="{{ route('user_create') }}" class="btn btn-info float-end">
                        {{ __('New') }}
                    </a>
                    <div class="x_content">

                        @include('layouts.alerts._success')
                        {{-- <p>Add class <code>bulk_action</code> to table for bulk actions options on row select</p> --}}

                        <div class="table-responsive">
                            <table class="table datatables table-striped" id="users">
                                {{-- <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Username') }}</th>
                                        <th>{{ __('E-amil address') }}</th>
                                        <th>{{ __('Rule') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <th scope="row">{{ $user->id }}</th>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->rule }}</td>
                                            <td>@include('pages.users._actions')</td>
                                        </tr>
                                    @endforeach
                                </tbody> --}}
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#users').DataTable({
                "processing": true,
                "responsive": true,
                "initComplete": function(sttings, json) {
                    $('#users').show();
                },
                "serverSide": true,
                "select": true,
                "dataSrc": "tableData",
                "bDestroy": true,
                "columns": [{
                    "data": "id",
                    "name": "id",
                    "title": "Identifiant",
                }, {
                    "data": "name",
                    "name": "name",
                    "title": "Username",
                }, {
                    "data": "email",
                    "name": "email",
                    "title": "Email",
                }, {
                    "data": "rule",
                    "name": "rule",
                    "title": "Rule",
                }, {
                    "data": "deleted_at",
                    "name": "deleted_at",
                    "title": "Statut du compte",
                    mRender: function(status) {
                        if (status !== null) {
                            return '<span class="badge bg-danger">Supprimé</span>';
                        } else {
                            return '<span class="badge bg-success">Actif</span>';
                        }
                    }
                }, {
                    "data": "action",
                    "name": "action",
                    "title": "Action",
                }],
                "language": {
                    "emptyTable": "No records found..."
                },
                "ajax": "{{ route('user_index') }}"
            });
        });
    </script>
@endsection
