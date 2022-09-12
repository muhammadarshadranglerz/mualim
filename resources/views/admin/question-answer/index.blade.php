@extends('layouts.master')
@section('content')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-6">
            <a class="btn btn-success d-none" href="{{ route('admin.question-answer.create') }}">
                {{ trans('Add Question') }}
            </a>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                Add Question
            </button>
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
                            <th> Question</th>
                            <th> Description</th>
                            <th> View</th>
                            <th> Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($questions as $question)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $question->question }}</td>
                                <td>{{ $question->details }}</td>
                                <td><a href="{{ route('admin.question-answer.show', $question->id) }}">View</a></td>
                                <td>
                                    <a class="btn btn-xs btn-info"
                                        href="{{ route('admin.question-answer.edit', $question->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                    <form action="{{ route('admin.question-answer.destroy', $question->id) }}"
                                        method="POST" style="display: inline-block;">
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


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Question</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- ... --}}
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
                            <input class="form-control {{ $errors->has('first_option') ? 'is-invalid' : '' }}"
                                type="text" name="first_option" id="first-option" value="{{ old('first_option', '') }}"
                                required>
                            @if ($errors->has('first_option'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('first_option') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-6">
                            <label class="required" for="second-option">Option B</label>
                            <input class="form-control {{ $errors->has('second_option') ? 'is-invalid' : '' }}"
                                type="text" name="second_option" id="second-option"
                                value="{{ old('second_option', '') }}" required>
                            @if ($errors->has('second_option'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('second_option') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-6">
                            <label class="required" for="third-option">Option C</label>
                            <input class="form-control {{ $errors->has('third_option') ? 'is-invalid' : '' }}"
                                type="text" name="third_option" id="third-option"
                                value="{{ old('third_option', '') }}" required>
                            @if ($errors->has('third_option'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('third_option') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-6">
                            <label class="required" for="fourth-option">Option D</label>
                            <input class="form-control {{ $errors->has('fourth_option') ? 'is-invalid' : '' }}"
                                type="text" name="fourth_option" id="fourth-option"
                                value="{{ old('fourth_option', '') }}" required>
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

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
                </form>

            </div>
        </div>
    </div>
@endsection
