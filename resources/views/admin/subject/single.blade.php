@extends('layouts.master')
@section('content')
    <div class="row justify-content-between">
        <div class="col-lg-4">
            <h1>Chapters</h1>
        </div>
        <div style="width: fit-content;">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                Add Chapter
            </button>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="container">
                <div class="text-center d-flex  flex-wrap">
                    @foreach ($chapters as $chapter)
                        <div class="col-12 col-md-6 col-lg-4 p-2">
                            <div class="d-flex flex-column h-100 justify-content-between  bg-gray-100">
                                <div class="p-3 bg-gray-400">
                                    <h6>{{ $chapter->name }}</h6>
                                </div>
                                <div class="p-3 bg-gray-100">{{ $chapter->description }}</div>
                                <div class="p-2 bg-gray-200 py-2">
                                    <a href="{{ route('admin.chapter.show', $chapter->id) }}" class="txt-dark m-0">
                                        View
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if (!$chapters->count())
                    <div class="muted">No Chapter Available</div>
                @endif
            </div>
        </div>
    </div>
    {{-- model --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                    <form method="POST" action="{{ route('admin.chapter.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="required" for="name">Name</label>
                            <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text"
                                name="name" id="name" value="{{ old('name', '') }}" required>
                            @if ($errors->has('name'))
                                <div class="txt-danger">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="required" for="name">Chapter No</label>
                            <input class="form-control {{ $errors->has('chapter_no') ? 'is-invalid' : '' }}" type="text"
                                name="chapter_no" id="chapter_no" value="{{ old('chapter_no', '') }}" required>
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
                        <div class="form-group">
                            <label class="required" for="title">Lecture Title</label>
                            <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text"
                                name="title" id="title" value="{{ old('title', '') }}" required>
                            @if ($errors->has('title'))
                                <div class="txt-danger">
                                    {{ $errors->first('title') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="required" for="note">Lecture Note</label>
                            <input class="form-control {{ $errors->has('note') ? 'is-invalid' : '' }}" type="text"
                                name="note" id="note" value="{{ old('note', '') }}" required>
                            @if ($errors->has('note'))
                                <div class="txt-danger">
                                    {{ $errors->first('note') }}
                                </div>
                            @endif
                        </div>
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
                                name="file" id="file">
                            @if ($errors->has('file'))
                                <div class="txt-danger">
                                    {{ $errors->first('file') }}
                                </div>
                            @endif
                        </div>
                        <input type="hidden" name="subject_id" value="{{ $subjectId }}">
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
@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).on('click', '.increment', function() {
        var id = $(this).attr('id');
        var id = parseInt(id)+1;
        $(this).addClass('d-none');
    //    var val = $('#video_no').val();
                    $('.vid-main').append(`
                    <a class=" increment float-right py-0 px-2 newinc"
                            style="border: none;color:white;background:black; border-radius:5px;cursor:pointer">+</a>
                    <div class="vid-child form-group py-3 px-2" style="background:rgb(248, 246, 246)">
                                <label class="required newlable" for="video"></label>
                                <input style="background: rgb(2248, 246, 246);border:1px solid" type="text"
                                    class="form-control" type="text" name="video[]" id="video">
                                
                            </div>
                        `);

                        $('.newinc').attr('id', id);
                        $('.newlable').html('Lecture Url');
                        $('.newlable').removeClass('newlable');
               
    });
</script>