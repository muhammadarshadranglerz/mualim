@extends('layouts.master')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('Create Chapter') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.chapter.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="submittedFromEdit" value="1">
                <div class="form-group">
                    <label class="required" for="name">Name</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name"
                        id="name" value="{{ old('name', '') }}" required>
                    @if ($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label class="required" for="description">Description</label>
                    <input class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" type="text"
                        name="description" id="description" value="{{ old('description', '') }}" required>
                    @if ($errors->has('description'))
                        <div class="invalid-feedback">
                            {{ $errors->first('description') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label class="required" for="title">Lecture Title</label>
                    <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text"
                        name="title" id="title" value="{{ old('title', '') }}" required>
                    @if ($errors->has('title'))
                        <div class="invalid-feedback">
                            {{ $errors->first('title') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label class="required" for="note">Lecture Note</label>
                    <input class="form-control {{ $errors->has('note') ? 'is-invalid' : '' }}" type="text"
                        name="note" id="note" value="{{ old('note', '') }}" required>
                    @if ($errors->has('note'))
                        <div class="invalid-feedback">
                            {{ $errors->first('note') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label class="required" for="video">Lecture Video</label>
                    <input type="file" accept="video/*"
                        class="form-control {{ $errors->has('video') ? 'is-invalid' : '' }}" type="text" name="video"
                        id="video">
                    @if ($errors->has('video'))
                        <div class="invalid-feedback">
                            {{ $errors->first('video') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label class="required" for="file">Lecture Attachments</label>
                    <input type="file"
                        accept=".pdf,ppt,pptx,.doc,.docx,.png, .jpg, .jpeg,.doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                        class="form-control {{ $errors->has('file') ? 'is-invalid' : '' }}" type="text" name="file"
                        id="file">
                    @if ($errors->has('file'))
                        <div class="invalid-feedback">
                            {{ $errors->first('file') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label class="required" for="subject-id">Subject</label>
                    <select class="form-control" id="subject-id" name="subject_id">
                        <option selected disabled>Select Subject</option>
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('subject_id'))
                        <div class="invalid-feedback">
                            {{ $errors->first('subject_id') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
