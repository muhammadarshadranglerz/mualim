@extends('layouts.master')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('Edit Chapter') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.chapter.update", [$chapter->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">Name</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ $chapter->name }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label class="required" for="title">Title</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ $chapter->title }}" required>
                @if($errors->has('title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label class="required" for="course">Course</label>
                <input class="form-control {{ $errors->has('course') ? 'is-invalid' : '' }}" type="text" name="course" id="course" value="{{ $chapter->course }}" required>
                @if($errors->has('course'))
                    <div class="invalid-feedback">
                        {{ $errors->first('course') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label class="required" for="description">Description</label>
                <input class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" type="text" name="description" id="description" value="{{ $chapter->description }}" required>
                @if($errors->has('description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('description') }}
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
