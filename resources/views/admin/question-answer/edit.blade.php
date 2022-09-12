@extends('layouts.master')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('Update MCQs') }}
        </div>
        <div class="card-body ">
            <form method="POST" class="row" action="{{ route('admin.question-answer.update', $question->id) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label class="required" for="question">Question</label>
                    <input class="form-control {{ $errors->has('question') ? 'is-invalid' : '' }}" type="text"
                        name="question" id="question" value="{{ $question->question }}" required>
                    @if ($errors->has('question'))
                        <div class="invalid-feedback">
                            {{ $errors->first('question') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label class="required" for="details">Details</label>
                    <input class="form-control {{ $errors->has('details') ? 'is-invalid' : '' }}" type="text"
                        name="details" id="details" value="{{ $question->details }}" required>
                    @if ($errors->has('details'))
                        <div class="invalid-feedback">
                            {{ $errors->first('details') }}
                        </div>
                    @endif
                </div>
                <div class="form-group col-6">
                    <label class="required" for="first-option">Option A</label>
                    <input class="form-control {{ $errors->has('first_option') ? 'is-invalid' : '' }}" type="text"
                        name="first_option" id="first-option" value="{{ $question->first_option }}" required>
                    @if ($errors->has('first_option'))
                        <div class="invalid-feedback">
                            {{ $errors->first('first_option') }}
                        </div>
                    @endif
                </div>
                <div class="form-group col-6">
                    <label class="required" for="second-option">Option B</label>
                    <input class="form-control {{ $errors->has('second_option') ? 'is-invalid' : '' }}" type="text"
                        name="second_option" id="second-option" value="{{ $question->second_option }}" required>
                    @if ($errors->has('second_option'))
                        <div class="invalid-feedback">
                            {{ $errors->first('second_option') }}
                        </div>
                    @endif
                </div>
                <div class="form-group col-6">
                    <label class="required" for="third-option">Option C</label>
                    <input class="form-control {{ $errors->has('third_option') ? 'is-invalid' : '' }}" type="text"
                        name="third_option" id="third-option" value="{{ $question->third_option }}" required>
                    @if ($errors->has('third_option'))
                        <div class="invalid-feedback">
                            {{ $errors->first('third_option') }}
                        </div>
                    @endif
                </div>
                <div class="form-group col-6">
                    <label class="required" for="fourth-option">Option D</label>
                    <input class="form-control {{ $errors->has('fourth_option') ? 'is-invalid' : '' }}" type="text"
                        name="fourth_option" id="fourth-option" value="{{ $question->fourth_option }}" required>
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
                        <option value="1" @if ($question->correct == 1) selected @endif>A</option>
                        <option value="2" @if ($question->correct == 2) selected @endif>B</option>
                        <option value="3" @if ($question->correct == 3) selected @endif>C</option>
                        <option value="4" @if ($question->correct == 4) selected @endif>D</option>
                    </select>
                    @if ($errors->has('correct'))
                        <div class="invalid-feedback">
                            {{ $errors->first('correct') }}
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
