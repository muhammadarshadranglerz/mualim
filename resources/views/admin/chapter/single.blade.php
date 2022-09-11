@extends('layouts.master')

@section('title')
    Chapter Details
    {{-- {{ $title }} --}}
@endsection


@section('content')
    <div class="container-fluid">
        <h3>Chapter Details</h3>
        <div class="container-fluid">
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
                                    <div class="align-self-center card-img mw-100 p-3"
                                        style="font-size:7rem;width: fit-content;">
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
                                <p class="card-text"><small
                                        class="text-muted">{{ $chapter->created_at->diffForHumans() }}</small></p>

                                {{-- <a href="#" class="btn btn-primary">Edit</a> --}}
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection
