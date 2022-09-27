@extends('layouts.master')
@section('content')
    <div class="row justify-content-between">
        <div class="col-lg-4">
            <h1>Chapters</h1>
        </div>
        <div style="width: fit-content;">

            <a href="{{ route('admin.chapter.create') }}" class="btn btn-primary">
                Add Chapter
            </a>

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
                                    class="form-control" type="text" name="video[]" id="video">
                                
                            </div>
                        `);

        $('.newinc').attr('id', id);
        $('.newlable').html('Lecture Url');
        $('.newlable').removeClass('newlable');

    });
</script>
