@extends('layouts.master')

@section('content')

@if ($chapters->count())



    <div class="card">

        <div class="card-header">

            {{ trans('Add MCQs') }}

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

                        <div class="txt-danger">

                            {{ $errors->first('correct') }}

                        </div>

                    @endif

                </div>

                <div class="form-group">

                    <label class="required" for="question">Question</label>

                    <input class="form-control {{ $errors->has('question') ? 'is-invalid' : '' }}" type="text"

                        name="question" id="question" value="{{ old('question', '') }}" required>

                    @if ($errors->has('question'))

                        <div class="txt-danger">

                            {{ $errors->first('question') }}

                        </div>

                    @endif

                </div>

                <div class="form-group">

                    <label  for="details">Details</label>

                    <input class="form-control {{ $errors->has('details') ? 'is-invalid' : '' }}" type="text"

                        name="details" id="details" value="{{ old('details', '') }}" >

                    @if ($errors->has('details'))

                        <div class="txt-danger">

                            {{ $errors->first('details') }}

                        </div>

                    @endif

                </div>

                <div class="form-group col-6">

                    <label  for="first-option">Option A</label>

                    <input class="form-control {{ $errors->has('first_option') ? 'is-invalid' : '' }}" type="text"

                        name="first_option" id="first-option" value="{{ old('first_option', '') }}" >

                    @if ($errors->has('first_option'))

                        <div class="txt-danger">

                            {{ $errors->first('first_option') }}

                        </div>

                    @endif

                </div>

                <div class="form-group col-6">

                    <label  for="second-option">Option B</label>

                    <input class="form-control {{ $errors->has('second_option') ? 'is-invalid' : '' }}" type="text"

                        name="second_option" id="second-option" value="{{ old('second_option', '') }}" >

                    @if ($errors->has('second_option'))

                        <div class="txt-danger">

                            {{ $errors->first('second_option') }}

                        </div>

                    @endif

                </div>

                <div class="form-group col-6">

                    <label  for="third-option">Option C</label>

                    <input class="form-control {{ $errors->has('third_option') ? 'is-invalid' : '' }}" type="text"

                        name="third_option" id="third-option" value="{{ old('third_option', '') }}" >

                    @if ($errors->has('third_option'))

                        <div class="txt-danger">

                            {{ $errors->first('third_option') }}

                        </div>

                    @endif

                </div>

                <div class="form-group col-6">

                    <label  for="fourth-option">Option D</label>

                    <input class="form-control {{ $errors->has('fourth_option') ? 'is-invalid' : '' }}" type="text"

                        name="fourth_option" id="fourth-option" value="{{ old('fourth_option', '') }}" >

                    @if ($errors->has('fourth_option'))

                        <div class="txt-danger">

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

                        <div class="txt-danger">

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

    @else

    Chapter in not Available.(first add a chapter to add a qustion)

@endif

@endsection

