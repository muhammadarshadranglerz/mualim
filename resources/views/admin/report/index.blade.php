@extends('layouts.master')
@section('content')
    @can('user_create')
        <div style="margin-bottom: 10px;" class="row">
            {{-- <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.users.create') }}">
                    {{ trans('Add User') }}
                </a>
            </div> --}}
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('Report') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-User">
                    <thead>
                        <tr>
                            <th> #</th>
                            <th> Name</th>
                            <th> Email</th>
                            <th> CNIC</th>
                            <th> Subject</th>
                            <th> Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $key => $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">

                                        <div>
                                            <a class="btn btn-xs btn-info" href="{{ route('admin.report.edit') }}">
                                                {{ trans('global.edit') }}
                                            </a>
                                        </div>
                                        <div>
                                            <form action="{{ route('admin.report.destroy') }}" class="m-0" method="POST"
                                                style="display: inline-block;">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <button type="submit" class="btn btn-xs btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
