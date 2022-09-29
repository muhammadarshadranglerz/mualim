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
                            <th> Chapter</th>
                            <th> Obtain%</th>
                            <th> Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $key => $user)
                        @php
                            $status = \App\Models\Status::with('subject','chapter')->where('teacher_id',$user->id)->first();
                            $percentage = \App\Models\Score::where('teacher_id',$user->id)->avg('score');
                            // dd($status);
                        @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email ?? ''}}</td>
                                <td>{{$user->cnic}}</td>
                                <td>{{$status->subject->name ?? ''}}</td>
                                <td>{{$status->chapter->name ?? ''}}</td>
                                <td>{{$percentage ?? '0'}}%</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">

                                        <div>
                                            <a class="btn btn-xs btn-primary @if (empty($percentage))
                                                disabled
                                            @endif" href="{{ route('admin.report.edit', $user->id) }}">certificate</a>
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
