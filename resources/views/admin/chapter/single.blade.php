@extends('layouts.master')

@section('title')
    Chapter Details
    {{-- {{ $title }} --}}
@endsection


@section('content')
    <div class="row">
        <div class="col-lg-6">
            <h3>Chapter Details</h3>
        </div>
        <div class="col-lg-6 row justify-content-end">
            <form action="{{ route('admin.chapter.destroy', $chapter->id) }}" method="POST"
                onsubmit="return confirm('{{ trans('global.areYouSure') }}');" class="me-3" style="width:fit-content;">
                <a class="btn btn btn-info" href="{{ route('admin.chapter.edit', $chapter->id) }}">
                    {{ trans('global.edit') }}
                </a>
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="submit" class="btn btn btn-danger" value="{{ trans('global.delete') }}">
            </form>
        </div>
    </div>
    <div class="row learning-block">
        <div class="col-12 xl-50 box-col-12">
            <div class="blog-single">
                <div class="blog-box blog-details">
                    @php
                        $content = $chapter->content->first();
                    @endphp
                    <div class="card">
                        <div class="card-body">
                            @if ($content->video)
                                <video class="img-fluid w-100" controls="controls" src="{{ asset($content->video) }}">
                                    Your browser does not support the HTML5 Video element.
                                </video>
                            @endif
                        </div>
                        <h3 class=" ms-4">{{ $content->title }}</h3>
                        <p class=" ms-4">{{ $content->note }}</p>
                    </div>
                </div>
            </div>
        </div>
        @if ($content->file)
            @php
                $attachmentExtension = strtoupper(pathinfo($content->file, PATHINFO_EXTENSION));
                $attachmentExtension = trim($attachmentExtension);
                
                if (in_array($attachmentExtension, ['JPEG', 'PNG', 'GIF', 'TIFF', 'AI'])) {
                    $icon = '<i class="fa fa-file-image-o txt-success">
                            <i class="fa fa-download" aria-hidden="true"></i>
                            </i>';
                } elseif (in_array($attachmentExtension, ['MP4', 'MOV', 'WMV', 'AVI', 'AVCHD', 'FLV', 'F4V', 'SWF', 'MKV', 'WEBM'])) {
                    $icon = '<i class="fa fas fa-video txt-primary"></i>';
                } elseif (in_array($attachmentExtension, ['7Z', 'RAR', 'ZIP'])) {
                    $icon = '<i class="fa fa-file-archive-o txt-secondary"></i>';
                } elseif (in_array($attachmentExtension, ['TXT', 'DOC', 'DOCX', 'PPT', 'PPTX'])) {
                    $icon = '<i class="fa fa-file-text-o txt-fb"></i>';
                } elseif (in_array($attachmentExtension, ['PDF'])) {
                    $icon = '<i class="fa fa-file-pdf-o txt-danger"></i>';
                } elseif (in_array($attachmentExtension, ['HTML', 'HTM'])) {
                    $icon = '<i class="fa-brands fa-chrome txt-google-plus"></i>';
                } elseif (in_array($attachmentExtension, ['XLS', 'XLSX'])) {
                    $icon = '<i class="fa fa-file-excel-o txt-primary"></i>';
                } elseif (in_array($attachmentExtension, ['CSV'])) {
                    $icon = '<i class="fa-solid fa-file-csv txt-success"></i>';
                } elseif (in_array($attachmentExtension, ['TXT'])) {
                    $icon = '<i class="fa-solid fa-file-csv txt-light"></i>';
                } else {
                    $icon = '<i class="fa-solid fa-solid fa-file txt-info"></i>';
                }
            @endphp
            <div class="col-md-6 col-12">
                <div class="card" style="max-width: 540px;">
                    <div class="row">
                        <div class="col-md-4 d-flex justify-content-center flex-column">
                            <div class="align-self-center card-img mw-100 p-3" style="font-size:7rem;width: fit-content;">
                                {!! isset($icon) ? $icon : '' !!}
                            </div>
                            <div class="mw-100 p-1 align-self-center text-secondary">
                                @php
                                    $attachmentName = basename($content->file);
                                    $attachmentName = ltrim(substr($attachmentName, strpos($attachmentName, '_') + 1));
                                    $attachmentName = rtrim($attachmentName, '.' . pathinfo($content->file, PATHINFO_EXTENSION));
                                @endphp
                                {{ $attachmentName }}
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">{{ $chapter->name }}</h5>
                                <p class="card-text">{{ $chapter->description }}</p>
                                <p class="card-text"><small
                                        class="text-muted">{{ $chapter->created_at->diffForHumans() }}</small></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="col-md-6 col-12">
                <div class="card">
                    <div class="card-header bg-gray-300">
                        Chapter:
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $chapter->name }}</h5>
                        <p class="card-text">{{ $chapter->description }}</p>
                        <p class="card-text"><small class="text-muted">{{ $chapter->created_at->diffForHumans() }}</small>
                        </p>

                    </div>
                </div>

            </div>
        @endif
        <div class="card">
            <div class="card-header d-flex">
                <div class="col-6">
                    <h4>Quizzes</h4>
                </div>
                <div class="col-6 d-flex">
                    <button type="button" class="btn btn-primary ms-auto" data-toggle="modal" data-target="#exampleModal">
                        Add Question
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach ($questions as $question)
                        <div class="col-12">
                            <h3 class="py-3">Q. {{ $question->question }}</h3>
                        </div>
                        <div class="col-md-3 col-6 p-3">A. {{ $question->first_option }}</div>
                        <div class="col-md-3 col-6 p-3">B. {{ $question->second_option }}</div>
                        <div class="col-md-3 col-6 p-3">C. {{ $question->third_option }}</div>
                        <div class="col-md-3 col-6 p-3">D. {{ $question->fourth_option }}</div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    </div>
    {{-- model --}}
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
                                type="text" name="first_option" id="first-option"
                                value="{{ old('first_option', '') }}" required>
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
