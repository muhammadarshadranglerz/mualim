@extends('layouts.master')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('Edit Chapter') }}
        </div>
        @if ($errors->any())
            {{ implode('', $errors->all('<div>:message</div>')) }}
        @endif
        <div class="card-body">
            <form method="POST" action="{{ route('admin.chapter.update', [$chapter->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label class="required" for="name">Name</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name"
                        id="name" value="{{ $chapter->name }}" required>
                    @if ($errors->has('name'))
                        <div class="txt-danger">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label class="required" for="chapter-no">Chapter No</label>
                    <input type="number" class="form-control {{ $errors->has('chapter_no') ? 'is-invalid' : '' }}"
                        name="chapter_no" id="chapter-no" value="{{ $chapter->chapter_no }}" required>
                    @if ($errors->has('chapter_no'))
                        <div class="txt-danger">
                            {{ $errors->first('chapter_no') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label class="required" for="description">Description</label>
                    <input class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" type="text"
                        name="description" id="description" value="{{ $chapter->description }}" required>
                    @if ($errors->has('description'))
                        <div class="txt-danger">
                            {{ $errors->first('description') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label class="required" for="subject-id">Subject</label>
                    <select class="form-control" id="subject-id" name="subject_id">
                        <option selected disabled>Select Subject</option>
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}" @if ($chapter->subject_id == $subject->id) selected @endif>
                                {{ $subject->name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('subject_id'))
                        <div class="txt-danger">
                            {{ $errors->first('subject_id') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.update') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
