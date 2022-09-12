@extends('layouts.master')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('Add Question') }}
        </div>
        <div class="card-body ">
            <form method="POST" class="row" action="{{ route('admin.question-answer.store') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="required" for="chapter-id">Chapter</label>
                    <select class="form-control" name="chapter_id" id="chapter-id">
                        <option value="" selected disabled>Select Chapter</option>
                        @foreach ($chapters as $chapter)
                            <option value="{{ $chapter->id }}" @if (old('chapter_id') == $chapter->id) selected @endif>
                                {{ $chapter->name }}</option>
                        @endforeach

                    </select>
                    @if ($errors->has('correct'))
                        <div class="invalid-feedback">
                            {{ $errors->first('correct') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label class="required" for="question">Question</label>
                    <input class="form-control {{ $errors->has('question') ? 'is-invalid' : '' }}" type="text"
                        name="question" id="question" value="{{ old('question', '') }}" required>
                    @if ($errors->has('question'))
                        <div class="invalid-feedback">
                            {{ $errors->first('question') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label class="required" for="details">Details</label>
                    <input class="form-control {{ $errors->has('details') ? 'is-invalid' : '' }}" type="text"
                        name="details" id="details" value="{{ old('details', '') }}" required>
                    @if ($errors->has('details'))
                        <div class="invalid-feedback">
                            {{ $errors->first('details') }}
                        </div>
                    @endif
                </div>
                <div class="form-group col-6">
                    <label class="required" for="first-option">Option A</label>
                    <input class="form-control {{ $errors->has('first_option') ? 'is-invalid' : '' }}" type="text"
                        name="first_option" id="first-option" value="{{ old('first_option', '') }}" required>
                    @if ($errors->has('first_option'))
                        <div class="invalid-feedback">
                            {{ $errors->first('first_option') }}
                        </div>
                    @endif
                </div>
                <div class="form-group col-6">
                    <label class="required" for="second-option">Option B</label>
                    <input class="form-control {{ $errors->has('second_option') ? 'is-invalid' : '' }}" type="text"
                        name="second_option" id="second-option" value="{{ old('second_option', '') }}" required>
                    @if ($errors->has('second_option'))
                        <div class="invalid-feedback">
                            {{ $errors->first('second_option') }}
                        </div>
                    @endif
                </div>
                <div class="form-group col-6">
                    <label class="required" for="third-option">Option C</label>
                    <input class="form-control {{ $errors->has('third_option') ? 'is-invalid' : '' }}" type="text"
                        name="third_option" id="third-option" value="{{ old('third_option', '') }}" required>
                    @if ($errors->has('third_option'))
                        <div class="invalid-feedback">
                            {{ $errors->first('third_option') }}
                        </div>
                    @endif
                </div>
                <div class="form-group col-6">
                    <label class="required" for="fourth-option">Option D</label>
                    <input class="form-control {{ $errors->has('fourth_option') ? 'is-invalid' : '' }}" type="text"
                        name="fourth_option" id="fourth-option" value="{{ old('fourth_option', '') }}" required>
                    @if ($errors->has('fourth_option'))
                        <div class="invalid-feedback">
                            {{ $errors->first('fourth_option') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label class="required" for="correct">Correct Option</label>
                    <select class="form-control" name="correct" id="correct">
                        <option value="" selected disabled>Select Correct Option</option>
                        <option value="1" @if (old('correct') == 1) selected @endif>A</option>
                        <option value="2" @if (old('correct') == 2) selected @endif>B</option>
                        <option value="3" @if (old('correct') == 3) selected @endif>C</option>
                        <option value="4" @if (old('correct') == 4) selected @endif>D</option>
                    </select>
                    @if ($errors->has('correct'))
                        <div class="invalid-feedback">
                            {{ $errors->first('correct') }}
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
