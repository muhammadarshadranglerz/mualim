@extends('layouts.master')
@section('content')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12  mb-5">
            <a class="btn btn-success" href="{{ route('admin.chapter.create') }}">
                {{ trans('Add Chapter') }}
            </a>
        </div>
    </div>
    
    <div class="row">
        @foreach ($chapters as $chapter)
            <div class="col-1 col-md-2 col-lg-3 gap-2 text-center">
                <h4 class="bg-facebook p-3">
                    {{ $chapter->name }}
                </h4>
                <p>
                    {{ $chapter->description }}
                </p>
                {{-- @dd($chapter->id) --}}
                <div class="bg-github">
                    <a href="{{ route('admin.chapter.show', $chapter->id) }}" class="txt-white">
                        View
                    </a>
                </div>
            </div>
        @endforeach
        @if (!$chapters->count())
            <div class="muted">No Chapter Available</div>
        @endif
    </div>
@endsection
