@extends('layouts.master')

@section('title')
    Chapter Details
    {{-- {{ $title }} --}}
@endsection


@section('content')
    {{-- @if ($errors->any())
        {{ implode('', $errors->all('<div>:message</div>')) }}
    @endif --}}
    <div class="container">
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
        <div class="col-12">
            <div class="card">
                <div class="card-body bg-light txt-dark">
                    <h1 class="card-title">{{ $chapter->name }}</h1>
                    <p class="card-text">{{ $chapter->description }}</p>
                    <p class="card-text"><small class="text-muted">{{ $chapter->created_at->diffForHumans() }}</small>
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 d-flex">
                <button type="button" class="btn btn-primary ms-auto" data-toggle="modal" data-target="#second-model">
                    Add Lecture
                </button>
            </div>
        </div>
        {{-- ------------------------------- --}}
        @if ($chapter->content)
            {{-- video --}}
            <div class="row learning-block rounded p-3 my-2 mx-1 bg-white">
                @foreach ($chapter->content as $content)
                    @if ($content->video)
                        <div class="blog-single col-6">
                            <div class="blog-box blog-details">
                                <div class="card">
                                    <div class="card-body">
                                        @if ($content->video)
                                            @php
                                                $vid = str_replace('www.youtube.com/', 'www.youtube.com/embed/', $content->video);
                                            @endphp
                                            <iframe class="img-fluid w-100" src="{{ $vid }}">
                                            </iframe>
                                        @endif
                                    </div>
                                    <div class="m-auto mb-2">
                                        <form action="{{ route('admin.chapter.content.distroy') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $content->id }}">
                                            <button type="submit" class="btn btn-danger btn-sm">delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            {{-- file --}}
            <div class="row learning-block rounded p-3 my-2 mx-1 bg-white">
                <div class="row">
                    @foreach ($chapter->content as $content)
                        @if ($content->file)
                            <div class="card col-2 mx-3" style="max-width: 540px;">
                                @php
                                    $attachmentExtension = strtoupper(pathinfo($content->file, PATHINFO_EXTENSION));
                                    $attachmentExtension = trim($attachmentExtension);
                                    $icon = '<i class="fa fa-file-pdf-o txt-danger"></i>';
                                @endphp
                                <div class="d-flex justify-content-center flex-column">
                                    <a target="_blank" href="{{ asset($content->file) }}">
                                        <div class="align-self-center card-img mw-100 p-3"
                                            style="font-size:7rem;width: fit-content;margin: auto;">
                                            {!! isset($icon) ? $icon : '' !!}
                                        </div>
                                    </a>
                                    <div class="mw-100 p-1 align-self-center text-secondary">
                                        @php
                                            $attachmentName = basename($content->file);
                                            $attachmentName = ltrim(substr($attachmentName, strpos($attachmentName, '_') + 1));
                                            $attachmentName = rtrim($attachmentName, '.' . pathinfo($content->file, PATHINFO_EXTENSION));
                                        @endphp
                                        {{ $attachmentName }}
                                    </div>
                                </div>
                                <div class="m-auto mb-2">
                                    <form action="{{ route('admin.chapter.content.distroy') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $content->id }}">
                                        <button type="submit" class="btn btn-danger btn-sm">delete</button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif

        {{-- ------------------------------- --}}

        <div class="card">
            <div class="card-header d-flex">
                <div class="col-6">
                    <h4>Quizzes</h4>
                </div>
                <div class="col-6 d-flex">
                    <button type="button" class="btn btn-primary ms-auto" data-toggle="modal" data-target="#exampleModal">
                        Add MCQs
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach ($questions as $question)
                        <div class="col-12">
                            <h3 class="py-3">{{ $loop->iteration . ' . ' . $question->question }}</h3>
                        </div>
                        <div
                            class="col-md-3 col-6 p-3 @php echo $question->correct == 1 ?'txt-primary font-weight-bold':''; @endphp">
                            A. {{ $question->first_option }}</div>
                        <div
                            class="col-md-3 col-6 p-3 @php echo $question->correct == 2 ?'txt-primary font-weight-bold':''; @endphp">
                            B. {{ $question->second_option }}</div>
                        <div
                            class="col-md-3 col-6 p-3 @php echo $question->correct == 3 ?'txt-primary font-weight-bold':''; @endphp">
                            C. {{ $question->third_option }}</div>
                        <div
                            class="col-md-3 col-6 p-3 @php echo $question->correct == 4 ?'txt-primary font-weight-bold':''; @endphp">
                            D. {{ $question->fourth_option }}</div>
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
                        <input type="hidden" name="chapter_id" value="{{ $chapter->id }}">
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
                            <label class="required" for="details">Details</label>
                            <input class="form-control {{ $errors->has('details') ? 'is-invalid' : '' }}" type="text"
                                name="details" id="details" value="{{ old('details', '') }}" required>
                            @if ($errors->has('details'))
                                <div class="txt-danger">
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
                                <div class="txt-danger">
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
                                <div class="txt-danger">
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
                                <div class="txt-danger">
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

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
                </form>

            </div>
        </div>
    </div>
    {{-- end model --}}
    {{-- second model --}}
    <div class="modal fade" id="second-model" tabindex="-1" role="dialog" aria-labelledby="second-model"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Chapter</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- ... --}}
                    <form method="POST" action="{{ route('admin.chapter.content.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="vid-main">
                            <a id="1" class="increment float-right py-0 px-2"
                                style="border: none;color:white;background:black; border-radius:5px;cursor:pointer">+</a>
                            <div class="vid-child form-group py-3 px-2" style="background:rgb(248, 246, 246)">
                                <label class="required" for="video">Lecture 1 URL</label>
                                <input style="background: rgb(2248, 246, 246);border:1px solid" type="text"
                                    class="form-control" type="text" name="video[]" id="video">
                                @if ($errors->has('video'))
                                    <div class="txt-danger">
                                        {{ $errors->first('video') }}
                                    </div>
                                @endif
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="required" for="file">Lecture Attachments</label>
                            <input type="file" accept=".pdf"
                                class="form-control {{ $errors->has('file') ? 'is-invalid' : '' }}" type="text"
                                name="file[]" id="file" multiple>
                            @if ($errors->has('file'))
                                <div class="txt-danger">
                                    {{ $errors->first('file') }}
                                </div>
                            @endif
                        </div>
                        <input type="hidden" name="chapter_id" value="{{ $chapter->id }}">
                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    {{-- end second model --}}
@endsection
@section('footer.script')
    <script>
        $(document).ready(function() {
            // $(".mtz-download-btn")
        })
        setTimeout(() => {
            $(".mtz-download-btn").removeClass("standart_position");
        }, 2000);
        $(document).on('click', '.increment', function() {
            var id = $(this).attr('id');
            var id = parseInt(id) + 1;
            $(this).addClass('d-none');
            //    var val = $('#video_no').val();
            $('.vid-main').append(`
                    <a class=" increment float-right py-0 px-2 newinc"
                            style="border: none;color:white;background:black; border-radius:5px;cursor:pointer">+</a>
                    <div class="vid-child form-group py-3 px-2" style="background:rgb(248, 246, 246)">
                                <label class="required newlable" for="video"></label>
                                <input style="background: rgb(2248, 246, 246);border:1px solid" type="text"
                                    class="form-control" type="url" name="video[]" id="video">
                                
                            </div>
                        `);

            $('.newinc').attr('id', id);
            var titleText = 'Lecture ' + id + ' URL';
            $('.newlable').html(titleText);
            $('.newlable').removeClass('newlable');

        });
    </script>
@endsection
