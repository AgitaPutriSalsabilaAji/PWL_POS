@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <a class="btn btn-primary" href="{{ url('lastsport/create') }}">TasksMe</a>
        </div>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <table class="table table-bordered table-striped table-hover table-sm" id="table_lastsport">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Node lastsport</th>
                    <th>Num lastsport</th>
                    <th>Axis</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

@section('scripts')
<script>
    $(document).ready(function() {
        var table = $('#table_lastsport').DataTable({
            serverSide: true,
            ajax: {
                url: "{{ url('lastsport/list') }}",
                type: "POST"
            },
            columns: [
                {
                    data: "DT_RowIndex",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "lastsport_body",
                    className: "",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "lastsport_name",
                    className: "",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "nixi",
                    className: "",
                    orderable: false,
                    searchable: false
                }
            ]
        });
    });
</script>
@endsection