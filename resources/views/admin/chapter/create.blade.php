@extends('layouts.master')
@section('content')
    @if ($subjects->count())
        <div class="card">
            <div class="card-header">
                {{ trans('Create Chapter') }}
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('admin.chapter.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="submittedFromEdit" value="1">
                    <div class="form-group">
                        <label class="required" for="subject-id">Subject</label>
                        <select class="form-control" id="subject-id" name="subject_id">
                            <option selected disabled>Select Subject</option>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                            @endforeach
                        </select>

                        @error('subject_id')
                            <div class="txt-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="required" for="name">Name</label>
                        <input class="form-control" type="text" name="name" id="name"
                            value="{{ old('name', '') }}" required>
                        @if ($errors->has('name'))
                            <div class="txt-danger">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="required" for="chapter-no">Chapter No.</label>
                        <input type="number" class="form-control {{ $errors->has('chapter_no') ? 'is-invalid' : '' }}"
                            type="text" name="chapter_no" id="chapter-no" value="{{ old('chapter_no', '') }}" required>
                        @if ($errors->has('chapter_no'))
                            <div class="txt-danger">
                                {{ $errors->first('chapter_no') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="required" for="description">Description</label>
                        <input class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" type="text"
                            name="description" id="description" value="{{ old('description', '') }}" required>
                        @if ($errors->has('description'))
                            <div class="txt-danger">
                                {{ $errors->first('description') }}
                            </div>
                        @endif
                    </div>
                    <div class="vid-main">
                        <a id="1" class="increment float-right py-0 px-2"
                            style="border: none;color:white;background:black; border-radius:5px;cursor:pointer">+</a>
                        <div class="vid-child form-group py-3 px-2" style="background:rgb(248, 246, 246)">
                            <label class="required" for="video">Lecture 1 URL</label>
                            <input style="background: rgb(2248, 246, 246);border:1px solid" type="text"
                                class="form-control" type="url" name="video[]" id="video">
                            @if ($errors->has('video'))
                                <div class="txt-danger">
                                    {{ $errors->first('video') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="required" for="file">Lecture Attachments</label>
                        <input type="file" accept="application/pdf"
                            class="form-control {{ $errors->has('file') ? 'is-invalid' : '' }}" type="text"
                            name="file[]" id="file" multiple>
                        @if ($errors->has('file'))
                            <div class="txt-danger">
                                {{ $errors->first('file') }}
                            </div>
                        @endif
                    </div>
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="form-group">
                        <button class="btn btn-danger" type="submit">
                            {{ trans('global.save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @else
        First add a subject
    @endif
@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
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
