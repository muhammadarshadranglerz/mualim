@extends('layouts.master')
@section('content')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-6">
            <a class="btn btn-success" href="{{ route('admin.subject.create') }}">
                {{ trans('Add Subject') }}
            </a>
        </div>
        <div class="col-lg-6">
            @if (session()->has('success'))
                <div class="text-success">
                    {{ session()->get('success') }}
                </div>
            @endif
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            {{ trans('Subjects') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-User">
                    <thead>
                        <tr>
                            <th> #</th>
                            <th> Name</th>
                            <th> Thumbnail</th>
                            <th> Description</th>
                            <th> Chapters</th>
                            <th> Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subjects as $key => $subject)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $subject->name }}</td>
                                <td><img class="img-thumbnail" src="{{ asset($subject->thumbnail) }}"
                                        alt="{{ $subject->name }}" width="50"></td>
                                <td>{{ $subject->description }}</td>
                                <td><a href="{{ route('admin.subject.show', $subject->id) }}">View</a></td>
                                <td>
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.subject.edit', $subject->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                    <form action="{{ route('admin.subject.destroy', $subject->id) }}" method="POST"
                                        style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger"
                                            value="{{ trans('global.delete') }}">
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
