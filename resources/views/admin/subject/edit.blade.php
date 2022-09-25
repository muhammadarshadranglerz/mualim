@extends('layouts.master')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('Edit Subject') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.subject.update', [$subject->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label class="required" for="name">Name</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name"
                        id="name" value="{{ $subject->name }}" required>
                    @if ($errors->has('name'))
                        <div class="txt-danger">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label class="required" for="thumbnail">Thumbnail</label>
                    <input accept=".png, .jpg, .jpeg" type="file"
                        class="form-control {{ $errors->has('thumbnail') ? 'is-invalid' : '' }}" type="text"
                        name="thumbnail" id="thumbnail">
                    @if ($errors->has('thumbnail'))
                        <div class="txt-danger">
                            {{ $errors->first('thumbnail') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label class="required" for="description">Description</label>
                    <input class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" type="text"
                        name="description" id="description" value="{{ $subject->description }}" required>
                    @if ($errors->has('description'))
                        <div class="txt-danger">
                            {{ $errors->first('description') }}
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
