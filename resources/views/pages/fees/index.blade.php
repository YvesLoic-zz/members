@extends('home')

@section('title', config('app.name') . ' - Students list')

@section('styles')
    <link href="cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link href="{{ asset('assets/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('center')
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>
                    {{ __('Students list for') }} {{ $school->name }}
                </h3>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row" style="display: block;">

            <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                    <a href="{{ route('student_create', $school->id) }}" class="btn btn-info float-end">
                        {{ __('New single student') }}
                    </a>
                    <a href="{{ route('student_export', $school->id) }}" class="btn btn-primary">
                        <i class="fa fa-data"></i>
                        {{ __('Export') }}
                    </a>
                    <div class="x_content">

                        @include('layouts.alerts._success')
                        {{-- <p>Add class <code>bulk_action</code> to table for bulk actions options on row select</p> --}}

                        <div class="table-responsive">
                            <table class="table datatables table-striped" id="students"></table>
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

            $('#students').DataTable({
                "processing": true,
                "responsive": true,
                "initComplete": function(sttings, json) {
                    $('#students').show();
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
                    "data": "matricule",
                    "name": "matricule",
                    "title": "Matricule",
                }, {
                    "data": "first_name",
                    "name": "first_name",
                    "title": "FirstName",
                }, {
                    "data": "last_name",
                    "name": "last_name",
                    "title": "LastName",
                }, {
                    "data": "class",
                    "name": "class",
                    "title": "Class",
                }, {
                    "data": "birthday",
                    "name": "birthday",
                    "title": "Birthday",
                }, {
                    "data": "birthplace",
                    "name": "birthplace",
                    "title": "Birthplace",
                }, {
                    "data": "sex",
                    "name": "sex",
                    "title": "Sex",
                    mRender: function(sex) {
                        return sex == 'M' ? '<p>Male</p>' : '<p>Non</p>';
                    }
                }, {
                    "data": "action",
                    "name": "action",
                    "title": "Action",
                }],
                "language": {
                    "emptyTable": "No records found..."
                },
                "ajax": "{{ route('student_index', ['id' => $school->id]) }}"
            });
        });
    </script>
@endsection
