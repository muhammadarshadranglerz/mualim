@extends('layouts.master')
@section('content')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-6">
            <a class="btn btn-success" href="{{ route('admin.chapter.create') }}">
                {{ trans('Add Chapter') }}
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
            {{ trans('Chapter') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-User">
                    <thead>
                        <tr>
                            <th> #</th>
                            <th> Subject Name</th>
                            <th> Chapter Name</th>
                            <th> Description</th>
                            <th> Details</th>
                            <th> Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($chapters as $key => $chapter)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $chapter->subject->name }}</td>
                                <td>{{ $chapter->name }}</td>
                                <td>{{ $chapter->description }}</td>
                                <td><a href="{{ route('admin.chapter.show', $chapter->id) }}">See More</a></td>
                                <td>
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.chapter.edit', $chapter->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                    <form action="{{ route('admin.chapter.destroy', $chapter->id) }}" method="POST"
                                        onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
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
