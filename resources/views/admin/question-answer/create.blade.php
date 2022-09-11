@extends('layouts.master')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('Create Subject') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.subject.store') }}" enctype="multipart/form-data">
                @csrf
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
                    <label class="required" for="thumbnail">Thumbnail</label>
                    <input type="file" class="form-control {{ $errors->has('thumbnail') ? 'is-invalid' : '' }}" type="text"
                        name="thumbnail" id="thumbnail" required>
                    @if ($errors->has('thumbnail'))
                        <div class="invalid-feedback">
                            {{ $errors->first('thumbnail') }}
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
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
