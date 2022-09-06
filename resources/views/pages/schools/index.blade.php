@extends('home')

@section('title', config('app.name') . ' - School list')

@section('styles')
    <link href="cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link href="{{ asset('assets/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('center')
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>{{ __('School list') }} </h3>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row" style="display: block;">

            <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                    <a href="{{ route('school_create') }}" class="btn btn-info float-end">
                        {{ __('New') }}
                    </a>
                    <div class="x_content">

                        @include('layouts.alerts._success')
                        {{-- <p>Add class <code>bulk_action</code> to table for bulk actions options on row select</p> --}}

                        <div class="table-responsive">
                            <table class="table datatables table-striped" id="schools">
                                {{-- <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Contact') }}</th>
                                        <th>{{ __('Chef') }}</th>
                                        <th>{{ __('Effective') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($schools as $school)
                                        <tr>
                                            <th scope="row">{{ $school->id }}</th>
                                            <td>{{ $school->name }}</td>
                                            <td>{{ $school->contact }}</td>
                                            <td>{{ $school->user->name }}</td>
                                            <td>{{ $school->students->count() }}</td>
                                            <td>@include('pages.schools._actions')</td>
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
            $('#schools').DataTable({
                "processing": true,
                "responsive": true,
                "initComplete": function(settings, json) {
                    $('#schools').show();
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
                    "title": "Nom",
                }, {
                    "data": "contact",
                    "name": "contact",
                    "title": "Contact",
                }, {
                    "data": "user",
                    "name": "user",
                    "title": "Director",
                    mRender: function(user) {
                        return user.name;
                    }
                }, {
                    "data": "students",
                    "name": "students",
                    "title": "Effective",
                    mRender: function(students) {
                        return students.length;
                    }
                }, {
                    "data": "action",
                    "name": "action",
                    "title": "Action",
                }],
                "language": {
                    "emptyTable": "No records found..."
                },
                "ajax": "{{ route('school_index') }}"
            });
        });
    </script>
@endsection
